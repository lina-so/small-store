<?php

namespace App\Http\Controllers\Payment;

use Stripe\Stripe;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaymentController extends Controller
{

    /************************************************************************/
    public function index(Request $request)
    {
        return redirect()->route('handle');
    }

    /************************************************************************/
    public function handle()
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        $paymentIntent = $this->createPaymentIntent($stripe);
        $clientSecret =  $paymentIntent->client_secret;
        $paymentIntentId = $paymentIntent->id;


        return view('checkout.checkout',compact('clientSecret','paymentIntentId'));

    }
    /************************************************************************/
    public function createPaymentIntent($stripe)
    {
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => 2005,
            'currency' => 'eur',
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
        ]);
        return $paymentIntent;

    }
    /************************************************************************/
    public function success(Request $request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $paymentIntentId = $request->input('payment_intent');
        $paymentIntent = $stripe->paymentIntents->retrieve($paymentIntentId);

        $amount = $paymentIntent->amount;
        $currency = $paymentIntent->currency;
        $transactionId = $paymentIntent->id;

        $this->storeInPaymentTable($amount ,$currency,$transactionId);


        return view('checkout.success');
    }
    /************************************************************************/
    public function storeInPaymentTable($amount ,$currency,$transactionId)
    {
        Payment::forceCreate([
            'amount' => $this->calculateOrderAmount($this->getOrdersIds()),
            'currency' => $currency,
            'order_id' => implode(',', $this->getOrdersIds()),
            'payment_id' => $transactionId,
        ]);
    }
    /************************************************************************/

    public function getOrdersIds()
    {
        $mergedOrdersIds = $this->getAllOrders();

        $this->changeOrderStatusToPaid($mergedOrdersIds);

        return $mergedOrdersIds;

    }
    /************************************************************************/
    public function getAllOrders()
    {
        $user = auth('sanctum')->user();
        if($user)
        {
            $ordersBelongsId = $user->ordersBelongsId()
            ->where('status', 'waiting')
            ->pluck('id')
            ->toArray();
        }
        // $ordersBelongsIpAddress = $user->ordersBelongsIpAddress()->where('status', 'waiting')
            // ->pluck('id')
            // ->toArray();
        $ordersBelongsIpAddress = Order::where('ip_address', request()->ip())
                                   ->where('status', 'waiting')
                                   ->pluck('id')
                                   ->toArray();

        // $mergedOrdersIds = array_merge($ordersBelongsIpAddress, $ordersBelongsId);
        $mergedOrdersIds = array_merge($ordersBelongsIpAddress);

        return $mergedOrdersIds;
    }
    /************************************************************************/

    public function calculateOrderAmount(array $orderIds): int
    {
        if (empty($orderIds)) {
            return 0;
        }

        return Order::whereIn('id', $orderIds)
            ->with('product')
            ->get()
            ->sum(function ($order) {
                return $order->product->price * $order->quantity;
            });
    }
    /************************************************************************/

    public function changeOrderStatusToPaid($mergedOrdersIds)
    {
        foreach($mergedOrdersIds as $orderId)
        {
            $order = Order::findOrFail($orderId);
            $order->status = 'paid';
            $order->save();
        }
    }

}

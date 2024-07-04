<?php

namespace App\Services\order;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Order\OrderRequest;
use App\Http\Requests\Order\getOrdersRequest;
use Illuminate\Validation\ValidationException;
use App\Events\Order\SendOrderDetailsToAdminEvent;

class OrderService
{
    use ApiResponseTrait;
    protected $authUser;

    public function __construct(getOrdersRequest $authUser)
    {
        $this->authUser = $authUser;
    }

    /********************************************************************************************/

    public function get($request)
    {
        $status = $request->status;
        ($this->authUser->authenticated()) ? $query = Order::query()->authUser() : $query = Order::query()->nonAuthUser();

        if ($status) {
            $query->where('status', $status);
        }

        $orders = $query->get();
        $groupedOrders = $orders->groupBy('status')->toArray();
        return $groupedOrders;

    }

/********************************************************************************************/

    public function create($request)
    {
        $requestData = $request->validated();

        return DB::transaction(function () use ($requestData) {
            $quantity =$requestData['quantity'];

            $oldOrder = $this->getOrder($requestData);

            $order = $this->createOrUpdate($oldOrder,$quantity,$requestData);

            $this->changeProductQuantityOrError('decrement',$requestData['product_id'],$quantity);

            event(new SendOrderDetailsToAdminEvent($order));

            return $order;
        });
    }
    /********************************************************************************************/

    public function update($request,$id)
    {
        $requestData = $request->validated();
        return DB::transaction(function () use ($requestData, $id) {
            $quantity =$requestData['quantity'];

            $order = Order::where('id',$id)->whereStatus('waiting')->first();

            if($order)
            {
                $this->changeProductQuantityOrError('decrement',$requestData['product_id'],$quantity);
                $this->changeProductQuantityOrError('increment',$order->product_id,$order->quantity);
                // $order->update(Arr::except($requestData,'status'));

                $order->update($requestData);

            }

            return $order;
        });
    }
    /********************************************************************************************/

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {

            $order = Order::findOrFail($id);
            if($order->status == 'waiting') {
                $this->changeProductQuantityOrError('increment',$order->product_id,$order->quantity);
            }
            $order->delete();
        });
    }
    /********************************************************************************************/
    public function show($order,$request)
    {
        return $order;
    }
    /********************************************************************************************/
    public function changeProductQuantityOrError($method , $id=null , $quantity)
    {
        $product = Product::where('id',$id);
        if($method == 'decrement')
        {
            $product ? $product->decrement('quantity',$quantity) : throw ValidationException::withMessages([
                'product' => 'product not found.']);
        }else{
            $product ? $product->increment('quantity',$quantity) : throw ValidationException::withMessages([
                'product' => 'product not found.']);
        }

    }
    /********************************************************************************************/
    public function getOrder($request)
    {
        if($this->authUser->authenticated())
        {
            $order = Order::authUser()
            ->where('product_id',$request['product_id'])->whereStatus('waiting')->first();
        }else
        {
            $order = Order::nonAuthUser()
            ->where('product_id',$request['product_id'])->whereStatus('waiting')->first();
        }
        return $order;
    }
    /********************************************************************************************/

    public function createOrUpdate($order,$quantity,$requestData)
    {
        $order ? $order->increment('quantity',$quantity) : $order = Order::create($requestData) ;
        return $order;
    }

}


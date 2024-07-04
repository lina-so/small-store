<?php

namespace App\Http\Controllers\Order;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Services\order\OrderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Order\OrderRequest;
use App\Http\Requests\Order\ShowOrderRequest;

class OrderController extends Controller
{

    //$this->authorize('view', User::class);
    use ApiResponseTrait;

    public $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;

    }
/*************************************************************************/

    public function index(Request $request)
    {
        $this->authorize('viewAny', Order::class);

        // if (Gate::allows('view-order')) {
        //     abort(403, 'Unauthorized');
        // }


        $orders = $this->orderService->get($request);
        return $this->apiSuccess('All orders',$orders, 200);
    }

/*************************************************************************/

    public function store(OrderRequest $request)
    {
        $order = $this->orderService->create($request);
        return $this->apiSuccess('order created',$order, 201);
    }

/*************************************************************************/

    public function show(Order $order,ShowOrderRequest $request)
    {
        $this->authorize('view', $order);

        $order = $this->orderService->show($order,$request);
        return $this->apiSuccess('order retrieved',$order, 200);
    }

/*************************************************************************/

    public function update(OrderRequest $request, string $id)
    {
        $order = Order::findOrFail($id);
        $this->authorize('update',$order);

        $order = $this->orderService->update($request,$id);
        return $this->apiSuccess('order quantity updated',$order, 201);
    }

/*************************************************************************/

    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        $this->authorize('delete', $order);

        $order = $this->orderService->delete($id);
        return $this->apiSuccess('order deleted',$order, 201);
    }
}

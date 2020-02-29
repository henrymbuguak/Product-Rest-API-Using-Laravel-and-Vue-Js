<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;

class OrderController extends BaseController
{
    /**
     * Show list of order number
     * @return JsonResponse
     */

    public function index()
    {
        $orders = Order::all();

        return $this->sendResponse($orders->toArray(), 'Orders retrieved successfully.');
    }

    /**
     * Store new orders
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'order_number' => 'required',
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $order = Order::create($input);
        return $this->sendResponse($order->toArray(), 'Order created successfully!');
    }

    /**
     * Show a specific order
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $order = Order::find($id);

        if (is_null($order)) {
            return $this->sendError('Order not found.');
        }
        return $this->sendResponse($order->toArray(), 'Order retrieved successfully');
    }

    /**
     * Update a specific order
     * @param int $id
     * @return JsonResponse
     */

    public function update(Request $request, Order $order)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'order_number' => 'required',
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $order->order_number = $input['order_number'];
        $order->save();
        return $this->sendResponse($order->toArray(), 'Order updated successfully!');
    }

    /**
     * Delete a specific order
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */

    public function destroy(Order $order)
    {
        $order->delete();
        return $this->sendResponse($order->toArray(), 'Order deleted successfully');
    }
}

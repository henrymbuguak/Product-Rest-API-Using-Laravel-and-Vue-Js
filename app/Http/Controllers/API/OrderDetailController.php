<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\OrderDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;

class OrderDetailController extends BaseController
{
    /**
     * List order detail
     * @return JsonResponse
     */
    public function index()
    {
        $orderDetails = OrderDetail::all();
        return $this->sendResponse($orderDetails->toArray(), 'Order details retrieved successfully');
    }

    /**
     * Store new order details
     * @return JsonResponse
     */

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'order_id' => 'required',
            'product_id' => 'required'
        ]);

        if ($validator->fails()){
            return $this->sendError('Validation error', $validator->errors());
        }

        $order_detail = OrderDetail::create($input);
        return $this->sendResponse($order_detail->toArray(), 'Order detail  created successfully');
    }

    /**
     * Display a specific order detail
     * @param int $id
     * @return JsonResponse
     *
     */

    public function show($id)
    {
        $order_detail = OrderDetail::find($id);

        if (is_null($order_detail)){
            return $this->sendError('Order detail not found');
        }
        return $this->sendResponse($order_detail->toArray(), 'Order detail retrieved successfully');
    }

    /**
     * update specific order detail
     * @param int $id
     * @return JsonResponse
     */

    public function update(Request $request, OrderDetail $orderDetail)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'order_id' => 'required',
            'product_id' => 'required'
        ]);

        if ($validator->fails()){
            return $this->sendError('Validation error', $validator->errors());
        }
        $orderDetail->order_id = $input['order_id'];
        $orderDetail->product_id = $input['product_id'];
        $orderDetail->save();

        return $this->sendResponse($orderDetail->toArray(), 'Order detail updated successfully');
    }

    /**
     * Delete a specific resource
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(OrderDetail $orderDetail)
    {
        $orderDetail->delete();
        return $this->sendResponse($orderDetail->toArray(), 'Order detail deleted successfully.');
    }
}

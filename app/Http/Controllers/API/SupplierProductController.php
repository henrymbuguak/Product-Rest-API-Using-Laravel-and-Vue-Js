<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\SupplierProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;

class SupplierProductController extends BaseController
{
    /**
     * List product suppliers
     * @return JsonResponse
     */
    public function index()
    {
        $supplier_products = SupplierProduct::all();
        return $this->sendResponse($supplier_products->toArray(), 'Supplier products retrieved successfully.');
    }

    /**
     * Store product supplier
     * @param Request $request
     * @return JsonResponse
     */

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'supplier_id' => 'required',
            'product_id' => 'required'
        ]);

        if ($validator->fails()){
            return $this->sendError('Validation error', $validator->errors());
        }

        $supplier_product = SupplierProduct::create($input);
        return $this->sendResponse($supplier_product->toArray(), 'Supplier product created successfully');

    }

    /**
     * Show specific Supplier product
     * @param int $id
     * @return JsonResponse
     */

    public function show($id)
    {
        $supplier_product = SupplierProduct::find($id);

        if (is_null($supplier_product))
        {
            return $this->sendError('Supplier product not found');
        }
        return $this->sendResponse($supplier_product->toArray(), 'Supplier product retrieved successfully.');
    }

    /**
     * Update supplier product
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */

    public function update(Request $request, SupplierProduct $supplierProduct)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'supplier_id' => 'required',
            'product_id' => 'required'
        ]);

        if ($validator->fails()){
            return $this->sendError('Validation error', $validator->errors());
        }

        $supplierProduct->supplier_id = $input['supplier_id'];
        $supplierProduct->product_id = $input['product_id'];
        $supplierProduct->save();

        return $this->sendResponse($supplierProduct->toArray(), 'Supplier product updated successfully');

    }

    /**
     * Delete specific supplier product
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(SupplierProduct $supplierProduct)
    {
        $supplierProduct->delete();
        return $this->sendResponse($supplierProduct->toArray(), 'Supplier product deleted successfully');
    }
}

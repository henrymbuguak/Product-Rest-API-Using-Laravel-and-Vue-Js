<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Supplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;

class SupplierController extends BaseController
{
    /**
     * Display list of suppliers
     * @return JsonResponse
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return $this->sendResponse($suppliers->toArray(), 'Supplier retrieved successfully.');
    }

    /**
     * Store new supplier in the database
     * @param Request $request
     * @return JsonResponse
     */

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required'
        ]);

        if ($validator->fails()){
            return $this->sendError('Validation Error',  $validator->errors());
        }
        $supplier = Supplier::create($input);

        return $this->sendResponse($supplier->toArray(), 'Supplier created succesufully');
    }

    /**
     * Display a specific supplier
     * @param int $id
     * @return JsonResponse
     */

    public function show($id)
    {
        $supplier = Supplier::find($id);

        if (is_null($supplier)) {
            return $this->sendError('Supplier not found.');
        }
        return $this->sendResponse($supplier->toArray(), 'Supplier retrieved successfully');
    }


    /**
     * Update Supplier
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request, Supplier $supplier)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required'
        ]);

        if ($validator->fails()){
            return $this->sendError('Validation Error',  $validator->errors());
        }

        $supplier->name = $input['name'];
        $supplier->save();

        return $this->sendResponse($supplier->toArray(), 'Supplier updated successfully!');

    }

    /**
     * Delete a specific supplier
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return $this->sendResponse($supplier->toArray(), 'Supplier deleted successfully');
    }

}

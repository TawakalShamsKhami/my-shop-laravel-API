<?php

namespace App\Http\Controllers;

use App\Models\BusinessType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\BusinessTypeResource;
use App\Helpers\ApiResponse;



class BusinessTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return ApiResponse::success(BusinessTypeResource::collection(BusinessType::all()));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $validator = Validator::make($request->all(), [
        'name' => 'required|string|unique:business_types,name',
        // 'status' => 'required|boolean',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);
    }

    $businessType = new BusinessType();
    $businessType->name = $request->name;
    $businessType->status = $request->status;
    $businessType->created_by = $request->created_by;
    $businessType->save();

    return ApiResponse::success($businessType);
    }

    /**
     * Display the specified resource.
     */
    public function show(BusinessType $businessType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BusinessType $businessType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BusinessType $businessType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BusinessType $businessType)
    {
        //
    }
}

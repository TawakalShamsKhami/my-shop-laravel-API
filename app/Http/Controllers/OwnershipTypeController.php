<?php

namespace App\Http\Controllers;
use App\Helpers\ApiResponse;
use App\Http\Resources\OwnershipTypeResource;
use App\Models\OwnershipType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OwnershipTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ApiResponse::success(OwnershipTypeResource::collection(OwnershipType::all()));
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
        'name' => 'required|string|unique:ownership_types,name',
        // 'status' => 'required|boolean',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);
    }

    $ownershipType = new OwnershipType();
    $ownershipType->name = $request->name;
    $ownershipType->status = $request->status;
    $ownershipType->created_by = $request->created_by;
    $ownershipType->save();

    return ApiResponse::success($ownershipType);
      
    }

    /**
     * Display the specified resource.
     */
    public function show(OwnershipType $ownershipType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OwnershipType $ownershipType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OwnershipType $ownershipType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OwnershipType $ownershipType)
    {
        //
    }
}

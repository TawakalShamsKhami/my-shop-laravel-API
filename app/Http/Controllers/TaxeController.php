<?php

namespace App\Http\Controllers;

use App\Models\Taxe;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TaxeResource;

class TaxeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ApiResponse::success(TaxeResource::collection(Taxe::all()));
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
        'name' => 'required|string|unique:taxes,name',
        'created_by' => 'required',
        // 'status' => 'required|string|in:Active,Inactive'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);
    }

    $taxe = new Taxe();
    $taxe->name = $request->name;
    $taxe->created_by = $request->created_by;
    $taxe->save();

    return ApiResponse::success($taxe);
    }

    /**
     * Display the specified resource.
     */
    public function show(Taxe $taxe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Taxe $taxe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Taxe $taxe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Taxe $taxe)
    {
        //
    }
}

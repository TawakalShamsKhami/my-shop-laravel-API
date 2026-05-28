<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyOwnershipType;
use App\Models\CompanyTaxe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CompanyRequest;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiResponse;
use App\Http\Resources\CompanyResource;


class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ApiResponse::success(CompanyResource::collection(Company::all()));

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


public function store(CompanyRequest $request)
{
    try {

        if (Company::where('licence_number', $request->licence_number)->exists()) {
            return ApiResponse::error(400, 'Licence number imeshatumika');
        }

        if (Company::where('tin_number', $request->tin_number)->exists()) {
            return ApiResponse::error(400, 'TIN number imeshatumika');
        }

        if (Company::where('phone', $request->phone)->exists()) {
            return ApiResponse::error(400, 'Phone number imeshatumika');
        }

        if (Company::where('email', $request->email)->exists()) {
            return ApiResponse::error(400, 'Email imeshatumika');
        }

        return DB::transaction(function () use ($request) {

            $data = $request->validated();

            $company = Company::create([
                'name' => $data['name'],
                'address' => $data['address'],
                'status' => $data['status'] ?? true,
                'licence_number' => $data['licence_number'],
                'tin_number' => $data['tin_number'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'created_by' => null
            ]);


         // Save company ownership type
            CompanyOwnershipType::create([
                'company_id' => $company->id,
                'owner_ship_type_id' => $data['owner_ship_type_id'],
                'status' => true,
                'created_by' => null
            ]);


         // Save company taxe 
            CompanyTaxe::create([
                'company_id' => $company->id,
                'tax_id' => $data['tax_id'],
                'status' => true,
            ]);


            return response()->json([
                'status' => true,
                'message' => 'Company created successfully',
                'data' => $company
            ], 201);

        });

    } catch (UniqueConstraintViolationException $exception) {

        return ApiResponse::error(
            400,
            'Phone number exists',
            'PHONE_NUMBER_USED'
        );

    } catch (\Exception $exception) {

        return response()->json([
            'status' => false,
            'message' => $exception->getMessage()
        ], 500);
    }
}
    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        //
    }
}

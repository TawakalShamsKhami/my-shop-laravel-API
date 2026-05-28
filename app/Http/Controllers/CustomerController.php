<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Resources\CustomerResource;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
         $customer = Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'company_id' => $request->company_id,
            'created_by' =>'admin',

        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Customer created successfully',
            'data' => new CustomerResource($customer)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }

    public function search(Request $request)
{
    $companyId = $request->company_id;
    $name = trim($request->name ?? '');

    $customers = Customer::select(
            'id',
            'name',
            'phone'
        )
        ->where('company_id', $companyId)

        ->when(!empty($name), function ($query) use ($name) {
            $query->where(
                'name',
                'ILIKE',
                "%{$name}%"
            );
        })

        ->orderBy('id', 'ASC')
        ->get();

    return response()->json([
        'status' => 'success',
        'data' => $customers
    ]);
}

//     public function search(Request $request)
// {
//     $companyId = $request->company_id;
//     $name = $request->name;

//     $customers = Customer::select(
//             'id',
//             'name',
//             'company_id'
//         )
//         ->where('company_id', $companyId)
//         ->when($name, function ($query) use ($name) {
//             $query->where(
//                 'name',
//                 'ILIKE', // PostgreSQL
//                 "%{$name}%"
//             );
//         })
//         ->orderBy('id','ASC')
//         ->get();

//     return response()->json([
//         'status' => 'success',
//         'data' => $customers
//     ]);
// }
}

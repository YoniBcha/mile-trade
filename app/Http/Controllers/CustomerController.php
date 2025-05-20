<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Support\Facades\File;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        return view('customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $customer = new Customer();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = '/uploads/' . $image->store('', 'public');
            $customer->image = $fileName;
        }


        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->about = $request->about;
        $customer->birth_date = $request->birth_date;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->bank_account_number = $request->bank_account_number;
        $customer->save();
        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('customer.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        // dd($customer);
        return view('customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        if ($request->hasFile('image')) {

            File::delete(public_path($customer->image));
            $image = $request->file('image');
            $fileName = '/uploads/' . $image->store('', 'public');
            $customer->image = $fileName;
        }

        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->about = $request->about;
        $customer->birth_date = $request->birth_date;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->bank_account_number = $request->bank_account_number;
        $customer->update();
        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}

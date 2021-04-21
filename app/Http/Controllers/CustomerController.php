<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cst = new Customer();
        $cst->name = $request->name;
        $cst->save();
        $categories = $request->categories;
        $nCat = count($categories);
        for($i = 0; $i < $nCat; $i++) {

            $custCatData = ['customer_id' => $cst->id, 'category_name' => $categories[$i], 'created_at' => now(), 'updated_at' => now()];

            \DB::table('customer_categories')->insert($custCatData);
        }

        return response()->json(['customer_id' => $cst->id], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {

    }
}

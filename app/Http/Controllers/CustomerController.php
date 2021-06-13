<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     *
     */
    protected function validator(Request $request)
    {
        //Antes de inserir ou alterar os dados, é importante validá-los,
        //principalmente se a API for pública
        $validator = Validator::make($request->only(['name', 'categories']), [
            'name'         => ['required', 'string', 'max:120'],
            'categories.*' => ['required', 'string', 'max:50'],
        ]);

        //Se a entrada não for perfeita...
        if ($validator->fails()) {
            //...retorna todas as mensagens de erro, além do código 422 (Unprocessable Entity)
            return response(
                implode(';', call_user_func_array('array_merge', $validator->errors()->getMessages())),
                422
            );
        }

        return null;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Antes de tudo, valida o request
        if ($res = $this->validator($request)) {
            return $res;
        };

        //Inserção do customer e suas categorias
        $cst = Customer::novo($request->only(['name', 'categories']));

        //Retorna o ID do model e o código 201 (created)
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
        //Antes de tudo, valida o request
        if ($res = $this->validator($request)) {
            return $res;
        };

        $customer->atualiza($request->only(['name', 'categories']));

        return response('OK', 200);
    }
}

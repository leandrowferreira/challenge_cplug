<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class CryptoController extends Controller
{
    //Tokens válidos
    protected $tokens = [
        'BCH',   'BTC',   'CAIFT',  'CHZ',
        'ETH',   'GALFT', 'IMOB01', 'JUVFT',
        'LINK',  'LTC',   'OGFT',   'PAXG',
        'PSGFT', 'USDC',  'WBX',    'XRP'
    ];

    public function validator(Request $request)
    {
        //Validação de entrada
        $validator = Validator::make($request->only(['quantidade', 'dataCompra', 'dataVenda']), [
            'quantidade' => ['required', 'numeric', 'min:0'],
            'dataCompra' => ['required', 'date_format:Y-m-d'],
            'dataVenda'  => ['required', 'date_format:Y-m-d', 'after_or_equal:dataCompra'],
        ]);

        //Se a entrada não for perfeita...
        if ($validator->fails()) {
            //...retorna todas as mensagens de erro, além do código 422 (Unprocessable Entity)
            return response(
                implode(';', call_user_func_array('array_merge', $validator->errors()->getMessages())),
                422
            );
        }
    }

    public function crypto(Request $request, $token)
    {
        //Antes de tudo, valida o request
        if ($res = $this->validator($request)) {
            return $res;
        };

        //Verifica se o token é válido
        if (!in_array($token, $this->tokens)) {
            return response('Invalid token: ' . $token, 422);
        }

        //Monta variáveis
        $endpoint   = "https://www.mercadobitcoin.net/api/{$token}/day-summary/";
        $dataCompra = str_replace('-', '/', $request->dataCompra);
        $dataVenda  = str_replace('-', '/', $request->dataVenda);
        $quantidade = $request->quantidade;

        //Chamada do valor de compra
        try {
            $result = Http::get($endpoint . $dataCompra);
        } catch (Exception $e) {
            return response(json_encode($e->getMessage(), true), 500);
        }

        if ($result->status() != 200) {
            return response($result->body(), $result->status());
        }

        $valorCompra = json_decode($result->body(), true)['avg_price'] * $quantidade;

        //Chamada do valor de venda
        try {
            $result = Http::get($endpoint . $dataVenda);
        } catch (Exception $e) {
            return response(json_encode($e->getMessage(), true), 500);
        }

        if ($result->status() != 200) {
            return response($result->body(), $result->status());
        }

        $valorVenda = json_decode($result->body(), true)['avg_price'] * $quantidade;

        //Montagem do resultado
        $result = [
            'valor_da_compra'   => round($valorCompra, 2),
            'valor_da_venda'    => round($valorVenda, 2),
            'lucro'             => round($valorVenda - $valorCompra, 2),
            'lucro_percentual'  => round(($valorVenda - $valorCompra) / $valorCompra * 100, 2),
            'intervalo_em_dias' => Carbon::create($request->dataCompra)->diffInDays(Carbon::create($request->dataVenda)),
        ];

        return response()->json($result, 200);
    }
}

<?php

namespace App\Http\Controllers;

class PaymentController extends Controller
{
    /**
     * Retorna o numero de parcelas
     *
     * @param float $value Valor total
     * @param float $amount Numero de parcelas
     * 
     * @return array
     */
    public function calculate($value, $amount)
    {
        return [
            'value' => (float) $value,
            'amount' => (int) $amount,
            'installments' => $this->getInstallments($value, $amount),
        ];
    }

    private function getInstallments($value, $amount)
    {
        $installments = []; 
        for($i = 0; $i < $amount; $i++) {
            $installments[] = [
                'order' => $i+1,
                'value' => round($value / $amount, 2)
            ];
        }

        return $installments;
    }

}

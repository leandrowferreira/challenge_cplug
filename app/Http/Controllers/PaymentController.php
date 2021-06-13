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
            'value'        => (float) $value,
            'amount'       => (int) $amount,
            'installments' => $this->getInstallments($value, $amount),
        ];
    }

    private function getInstallments($value, $amount)
    {
        $newInstallments = [];
        for ($i = $amount - 1, $t = 0; $i >= 0; $i--, $t += round($value / $amount, 2)) {
            $newInstallments[$i] = [
                'order' => $i + 1,
                'value' => $i ? round($value / $amount, 2) : round($value - $t, 2)
            ];
        }

        return $newInstallments;
    }
}

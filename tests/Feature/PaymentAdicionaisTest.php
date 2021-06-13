<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentAdicionaisTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_more_calculate()
    {
        $response = $this->get('/api/payment/calculate/200/6');

        $response->assertStatus(200)->assertJson([
            'value'        => 200,
            'amount'       => 6,
            'installments' => [
                [
                    'order' => 1,
                    'value' => 33.35
                ],
                [
                    'order' => 2,
                    'value' => 33.33
                ],
                [
                    'order' => 3,
                    'value' => 33.33
                ],
                [
                    'order' => 4,
                    'value' => 33.33
                ],
                [
                    'order' => 5,
                    'value' => 33.33
                ],
                [
                    'order' => 6,
                    'value' => 33.33
                ]
            ]
        ]);
    }
}

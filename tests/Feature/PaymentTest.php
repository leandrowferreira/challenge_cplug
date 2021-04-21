<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_calculate()
    {
        $response = $this->get('/api/payment/calculate/100/3');

        $response->assertStatus(200)->assertJson([
            'value' => 100,
            'amount' => 3,
            'installments' => [
                [
                    'order' => 1,
                    'value' => 33.34
                ],
                [
                    'order' => 2,
                    'value' => 33.33
                ],
                [
                    'order' => 3,
                    'value' => 33.33
                ]
            ]
        ]);
    }
}

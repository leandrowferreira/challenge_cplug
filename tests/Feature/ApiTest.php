<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_psgft_250()
    {
        $response = $this->post('/api/crypto/PSGFT', [
            'quantidade' => 250,
            'dataCompra' => '2021-02-01',
            'dataVenda' => '2021-04-18',
        ]);

        $response->assertStatus(200)->assertJson([
            'valor_da_compra' => 10513.88,
            'valor_da_venda' => 46656.85,
            'lucro' => 36142.97,
            'lucro_percentual' => 343.76,
            'intervalo_em_dias' => 76
        ]);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use WithFaker;

    /**
     * Cria um cliente novo
     *
     * @return void
     */
    public function test_store()
    {
        $response = $this->post('/api/customer', [
            'name' => $this->faker->name(),
            'categories' => ['Ouro','Prata','Diamante']
        ]);

        $response->assertStatus(201);
    }

    /**
     * Atualiza os dados do cliente
     *
     * @return void
     */
    public function test_update()
    {
        $newName = $this->faker->name();

        //novo cliente
        $customer = Customer::factory()->create();

        //associa algumas categorias ao cliente
        \DB::table('customer_categories')->insert([
            ['customer_id' => $customer->id, 'category_name' => 'Ouro'],
            ['customer_id' => $customer->id, 'category_name' => 'Prata'],
            ['customer_id' => $customer->id, 'category_name' => 'Diamante'],
        ]);

        //atualiza o nome e as categorias o cliente
        $response = $this->put("/api/customer/{$customer->id}", [
            'name' => $newName,
            'categories' => ['Prata','Diamante','Esmeralda','Platina']
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('customers', ['id' => $customer->id,'name' => $newName]);

        $this->assertDatabaseMissing('customer_categories', ['customer_id' => $customer->id, 'category_name' => 'Ouro']);

        $this->assertDatabaseHas('customer_categories', ['customer_id' => $customer->id, 'category_name' => 'Prata']);
        $this->assertDatabaseHas('customer_categories', ['customer_id' => $customer->id, 'category_name' => 'Diamante']);
        $this->assertDatabaseHas('customer_categories', ['customer_id' => $customer->id, 'category_name' => 'Esmeralda']);
        $this->assertDatabaseHas('customer_categories', ['customer_id' => $customer->id, 'category_name' => 'Platina']);
    }
}

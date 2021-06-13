<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class CustomerAdicionaisTest extends TestCase
{
    use WithFaker;

    public function test_store_error()
    {
        $response = $this->post('/api/customer', [
            'name'       => Str::random(121),
            'categories' => [Str::random(51), 'Prata', 'Diamante']
        ]);

        $response->assertStatus(422);

        $response = $this->post('/api/customer', [
            'name'       => $this->faker->name(),
            'categories' => [Str::random(51), 'Prata', 'Diamante']
        ]);

        $response->assertStatus(422);
    }

    public function test_new_update()
    {
        $newName = $this->faker->name();

        //novo cliente
        $customer = Customer::factory()->create();
        $oldName  = $customer->name;

        //Associa algumas categorias ao cliente
        foreach (['Ouro', 'Prata', 'Diamante'] as $categoryName) {
            $category = Category::where('name', $categoryName)->first() ??
                        Category::create(['name' => $categoryName]);
            $customer->categories()->attach($category->id);
        }

        //O banco AINDA TEM o usuário com o nome antigo
        $this->assertDatabaseHas('customers', ['id' => $customer->id, 'name' => $oldName]);

        //atualiza o nome e as categorias o cliente
        $response = $this->put("/api/customer/{$customer->id}", [
            'name'       => $newName,
            'categories' => ['Prata', 'Diamante', 'Esmeralda', 'Platina']
        ]);

        //Status de update ok
        $response->assertStatus(200);

        //O banco tem o usuário com o novo nome
        $this->assertDatabaseHas('customers', ['id' => $customer->id, 'name' => $newName]);

        //O banco NÃO TEM MAIS o usuário com o nome antigo
        $this->assertDatabaseMissing('customers', ['id' => $customer->id, 'name' => $oldName]);

        $this->assertDatabaseMissing('category_customer', [
            'customer_id' => $customer->id,
            'category_id' => Category::where('name', 'ouro')->First()->id
        ]);

        foreach (['Prata', 'Diamante', 'Esmeralda', 'Platina'] as $categoryName) {
            $this->assertDatabaseHas('category_customer', [
                'customer_id' => $customer->id,
                'category_id' => Category::where('name', $categoryName)->First()->id
            ]);
        }
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = ['name'];

    public static function novo($data)
    {
        // Cria o model Customer
        $newCustomer = Customer::create(['name' => $data['name']]);

        // Associa as categorias (criando-as, se necessário)
        foreach ($data['categories'] as $categoryName) {
            $category = Category::where('name', $categoryName)->first() ??
                        Category::create(['name' => $categoryName]);

            $newCustomer->categories()->attach($category->id);

            // O CÓDIGO A PARTIR DESTA LINHA MANTÉM O LEGADO!
            // É necessário manter a tabela original 'customer_categories'
            // atualizada.
            // Porém, recomendo que esta tabela seja eliminada em favor de
            // um relacionamento n-n categories-customers, como proposto.
            //
            // Para mais informações, veja o arquivo README.md.
            DB::table('customer_categories')->insert([
                'customer_id'   => $newCustomer->id,
                'category_name' => $categoryName,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ]);
        }

        return $newCustomer;
    }

    public function atualiza($data)
    {
        // Atualiza os dados possíveis (neste caso, somente 'name')
        $this->update(['name' => $data['name']]);

        // Sync das categorias
        $ids = [];

        foreach ($data['categories'] as $categoryName) {
            $category = Category::where('name', $categoryName)->first() ??
                        Category::create(['name' => $categoryName]);

            $ids[] = $category->id;
        }

        $this->categories()->sync($ids);

        // O CÓDIGO A PARTIR DESTA LINHA MANTÉM O LEGADO!
        // Para ter o teste inicial proposto completado, é necessário
        // manter a tabela original 'customer_categories' atualizada.
        // Porém, recomendo que esta tabela seja eliminada em favor de
        // um relacionamento n-n categories-customers, como proposto.
        //
        // Para mais informações, veja o arquivo README.md.
        DB::table('customer_categories')->where('customer_id', $this->id)->delete();
        foreach ($data['categories'] as $categoryName) {
            DB::table('customer_categories')->insert([
                'customer_id'   => $this->id,
                'category_name' => $categoryName,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ]);
        }
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}

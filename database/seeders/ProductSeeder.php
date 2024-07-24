<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Maatwebsite\Excel\Facades\Excel;
use App\Models\Products;
use App\Models\Specifications;
use App\Models\SubCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use SoDe\Extend\Text;

class ProductSeeder extends Seeder
{
    use Importable;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new class implements ToModel
        {
            public function model(array $row)
            {
                if (!is_numeric($row[0])) return null;

                $category = Category::updateOrCreate(['name' => $row[1]], [
                    'name' => $row[1],
                    'slug' => str_replace(' ', '-', strtolower($row[1])),
                    'url_image' => 'images/img/',
                    'name_image' => 'noimagen.jpg'
                ]);

                if ($row[2] == '') $subcategory = new SubCategory();
                else {
                    $subcategory = SubCategory::updateOrCreate(['name' => $row[2]], [
                        'category_id' => $category->id,
                        'name' => $row[2],
                        'slug' => str_replace(' ', '-', strtolower($row[2])),
                        'status' => true,
                        'visible' => true
                    ]);
                }

                $sku = Text::fillStart($row[0], '0', 6);
                $product = Products::updateOrCreate(['sku' => $sku], [
                    'producto' => $row[7],
                    'color' => $row[8],
                    'sku' => $sku,
                    'categoria_id' => $category->id,
                    'subcategory_id' => $subcategory->id,
                    'precio' => $row[5],
                    'stock' => is_numeric($row[6]) ? $row[6] : 0,
                    'imagen' => 'images/img/noimagen.jpg',
                    'imagen_ambiente' => 'images/img/noimagen.jpg',
                    'status' => true,
                    'visible' => true
                ]);

                if ($row[3] != '') Specifications::create([
                    'product_id' => $product->id,
                    'tittle' => 'Medida',
                    'specifications' => $row[3],
                    'status' => true,
                    'visible' => true
                ]);

                if ($row[4] != '') Specifications::create([
                    'product_id' => $product->id,
                    'tittle' => 'Sale por',
                    'specifications' => $row[4],
                    'status' => true,
                    'visible' => true
                ]);
            }
        }, 'storage/app/utils/Products.xlsx');
    }
}

<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Exception;
use Illuminate\Database\Seeder;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class SubCategorySeeder extends Seeder
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

                SubCategory::updateOrCreate(['name' => $row[2]], [
                    'category_id' => $category->id,
                    'name' => $row[2],
                    'slug' => str_replace(' ', '-', strtolower($row[2])),
                    'status' => true,
                    'visible' => true
                ]);
            }
        }, 'storage/app/utils/SubCategories.xlsx');
    }
}

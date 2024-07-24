<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Category;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class CategorySeeder extends Seeder
{
    use Importable;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Normal
        // $cat = ['Wall Panel', 'Marmol UV', 'Piso Click SPC', 'Piedra PU'];
        // for ($i = 0; $i < 4; $i++) {
        //     Category::create([
        //         'name' => $cat[$i],
        //         'description' => 'Aquí va la descripción de la categoria '.$cat[$i],
        //         'status' => 1,
        //         'visible' => 1,
        //     ]);
        // }

        // Excel
        Excel::import(new class implements ToModel
        {
            public function model(array $row)
            {
                if (!is_numeric($row[0])) return null;
                Category::updateOrCreate([
                    'name' => $row[1]
                ], [
                    'name' => $row[1],
                    'slug' => str_replace(' ', '-', strtolower($row[1])),
                    'description' => $row[3],
                    'url_image' => $row[4] ? $row[4] : 'images/img/',
                    'name_image' => $row[5] ? $row[5] : 'noimagen.jpg',
                    'destacar' => $row[6],
                    'fit' => $row[11]
                ]);
            }
        }, 'storage/app/utils/Categories.xlsx');
    }
}

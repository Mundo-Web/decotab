<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Facades\Excel;

class StatusSeeder extends Seeder
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

                Status::updateOrCreate([
                    'id' => $row[0]
                ], [
                    'name' => $row[1],
                    'description' => $row[2]
                ]);
            }
        }, 'storage/app/utils/Statuses.xlsx');
    }
}

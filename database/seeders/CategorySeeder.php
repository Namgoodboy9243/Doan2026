<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['id' => 1, 'name' => 'Laptop Gaming', 'status' => 1],
            ['id' => 2, 'name' => 'Laptop Văn Phòng', 'status' => 1],
            ['id' => 3, 'name' => 'Laptop Đồ Họa', 'status' => 1],
            ['id' => 4, 'name' => 'MacBook & Surface', 'status' => 1],
            ['id' => 5, 'name' => 'Laptop Sinh Viên', 'status' => 1],
            ['id' => 6, 'name' => 'Phụ kiện Laptop', 'status' => 1],
        ];

        foreach ($categories as $cat) {
            DB::table('categories')->updateOrInsert(
                ['id' => $cat['id']],
                [
                    'name' => $cat['name'],
                    'status' => $cat['status'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }
}

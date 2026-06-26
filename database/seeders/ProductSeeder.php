<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'id' => 2,
                'name' => 'Laptop ASUS ROG Strix Scar 16',
                'price' => 70990000,
                'sale_price' => 68990000,
                'image' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?auto=format&fit=crop&w=300&h=300',
                'category_id' => 1,
                'status' => 1,
                'description' => 'Laptop Gaming đỉnh cao, Core i9-14900HX, RTX 4080, Màn hình OLED 240Hz.'
            ],
            [
                'id' => 3,
                'name' => 'Laptop Lenovo Legion 5 Pro',
                'price' => 39990000,
                'sale_price' => 38490000,
                'image' => 'https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?auto=format&fit=crop&w=300&h=300',
                'category_id' => 3,
                'status' => 1,
                'description' => 'Laptop Đồ Họa và Gaming tối ưu, AMD Ryzen 7 7745HX, RTX 4060, RAM 16GB, 240Hz.'
            ],
            [
                'id' => 4,
                'name' => 'Laptop Dell XPS 15 9530',
                'price' => 55990000,
                'sale_price' => 52990000,
                'image' => 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?auto=format&fit=crop&w=300&h=300',
                'category_id' => 2,
                'status' => 1,
                'description' => 'Laptop văn phòng cao cấp, Intel Core i7-13700H, RTX 4050, Màn hình OLED Touch siêu nét.'
            ],
            [
                'id' => 5,
                'name' => 'MacBook Pro 14 M3 Max',
                'price' => 89990000,
                'sale_price' => 79990000,
                'image' => 'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?auto=format&fit=crop&w=300&h=300',
                'category_id' => 4,
                'status' => 1,
                'description' => 'MacBook Pro cấu hình cực khủng, M3 Max 14-Core CPU, 30-Core GPU, RAM 36GB, 1TB SSD.'
            ],
            [
                'id' => 6,
                'name' => 'Laptop HP Envy 16',
                'price' => 44990000,
                'sale_price' => 42680000,
                'image' => 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?auto=format&fit=crop&w=300&h=300',
                'category_id' => 2,
                'status' => 1,
                'description' => 'Laptop HP Envy sang trọng, Core i9-13900H, RTX 4060, RAM 16GB, Màn 2K Touch.'
            ],
            [
                'id' => 7,
                'name' => 'Laptop Lenovo ThinkPad X1 Carbon Gen 11',
                'price' => 48990000,
                'sale_price' => 46980000,
                'image' => 'https://images.unsplash.com/photo-1618424181497-157f25b6ddd5?auto=format&fit=crop&w=300&h=300',
                'category_id' => 2,
                'status' => 1,
                'description' => 'Laptop doanh nhân siêu mỏng nhẹ, Core i7-1355U, RAM 32GB, SSD 1TB.'
            ],
            [
                'id' => 8,
                'name' => 'MacBook Air 13 M3',
                'price' => 30990000,
                'sale_price' => 28480000,
                'image' => 'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?auto=format&fit=crop&w=300&h=300',
                'category_id' => 4,
                'status' => 1,
                'description' => 'MacBook Air siêu gọn nhẹ chip M3 thế hệ mới, 8-Core CPU, 8-Core GPU, 8GB RAM, 256GB SSD.'
            ]
        ];

        foreach ($products as $p) {
            DB::table('products')->updateOrInsert(
                ['id' => $p['id']],
                [
                    'name' => $p['name'],
                    'price' => $p['price'],
                    'sale_price' => $p['sale_price'],
                    'image' => $p['image'],
                    'category_id' => $p['category_id'],
                    'status' => $p['status'],
                    'description' => $p['description'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }

        // Add variants for each product
        $variants = [
            ['id' => 3, 'product_id' => 2, 'sku' => 'ASUS-ROG-SCAR16-I9-32-1TB', 'cpu' => 'Core i9-14900HX', 'ram' => '32GB', 'storage' => '1TB SSD', 'color' => 'Black', 'price' => 68990000, 'stock' => 10],
            ['id' => 4, 'product_id' => 3, 'sku' => 'LEGION5PRO-R7-16-512', 'cpu' => 'Ryzen 7 7745HX', 'ram' => '16GB', 'storage' => '512GB SSD', 'color' => 'Grey', 'price' => 38490000, 'stock' => 15],
            ['id' => 5, 'product_id' => 4, 'sku' => 'DELL-XPS15-I7-16-512', 'cpu' => 'Core i7-13700H', 'ram' => '16GB', 'storage' => '512GB SSD', 'color' => 'Silver', 'price' => 52990000, 'stock' => 5],
            ['id' => 6, 'product_id' => 5, 'sku' => 'MAC-PRO14-M3MAX-36-1T', 'cpu' => 'M3 Max', 'ram' => '36GB', 'storage' => '1TB SSD', 'color' => 'Space Black', 'price' => 79990000, 'stock' => 8],
            ['id' => 7, 'product_id' => 6, 'sku' => 'HP-ENVY16-I9-16-1T', 'cpu' => 'Core i9-13900H', 'ram' => '16GB', 'storage' => '1TB SSD', 'color' => 'Silver', 'price' => 42680000, 'stock' => 12],
            ['id' => 8, 'product_id' => 7, 'sku' => 'THINKPAD-X1-I7-32-1T', 'cpu' => 'Core i7-1355U', 'ram' => '32GB', 'storage' => '1TB SSD', 'color' => 'Black', 'price' => 46980000, 'stock' => 7],
            ['id' => 9, 'product_id' => 8, 'sku' => 'MAC-AIR13-M3-8-256', 'cpu' => 'M3', 'ram' => '8GB', 'storage' => '256GB SSD', 'color' => 'Starlight', 'price' => 28480000, 'stock' => 20]
        ];

        foreach ($variants as $v) {
            DB::table('product_variants')->updateOrInsert(
                ['id' => $v['id']],
                [
                    'product_id' => $v['product_id'],
                    'sku' => $v['sku'],
                    'cpu' => $v['cpu'],
                    'ram' => $v['ram'],
                    'storage' => $v['storage'],
                    'color' => $v['color'],
                    'price' => $v['price'],
                    'stock' => $v['stock'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }
}

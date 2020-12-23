<?php

use Illuminate\Database\Seeder;
use App\Category;

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
            'Makanan', 'Service Elektronik', 'Tukang Kebun', 'Kebersihan', 'Perawat Anak', 'Asisten Kesehatan', 'Konstruksi Bangunan'
        ];

        foreach($categories as $category){
            Category::create([
                'name' => $category,
            ]);
        }
    }
}

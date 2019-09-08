<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * @var \App\Models\Category
     */
    private $category;

    /**
     * BeneficiosSeeder constructor.
     * @param \App\Models\Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data() as $data) {
            $this->category->create($data);
        }
    }

    /**
     * @return array
     */
    private function data(){
        return [
            [
                'name' => 'Geral', // 1
            ],
            [
                'name' => 'Educação', // 2
            ],
            [
                'name' => 'Economia', // 3
            ],
            [
                'name' => 'Governo', // 4
            ],
            [
                'name' => 'Negócios',  // 5
            ]
        ];
    }
}

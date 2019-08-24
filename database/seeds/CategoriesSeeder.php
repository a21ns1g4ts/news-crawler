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
                'name' => 'Impostos', // 2
            ],
            [
                'name' => 'Educação', // 3
            ],
            [
                'name' => 'Economia', // 4
            ],
            [
                'name' => 'Governo', // 5
            ],
            [
                'name' => 'Política', // 6
            ],
            [
                'name' => 'Cursos', // 7
            ],
            [
                'name' => 'Eventos',  // 8
            ]
        ];
    }
}

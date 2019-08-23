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
                'name' => 'Desconhecida', // 1
            ],
            [
                'name' => 'Geral', // 2
            ],
            [
                'name' => 'Impostos', // 3
            ],
            [
                'name' => 'Tributos', // 4
            ],
            [
                'name' => 'Esporte', // 5
            ],
            [
                'name' => 'Saúde', // 6
            ],
            [
                'name' => 'Educação', // 7
            ],
            [
                'name' => 'Economia', // 8
            ],
            [
                'name' => 'Governo', // 9
            ],
            [
                'name' => 'Política', // 10
            ],
            [
                'name' => 'Gastronomia', // 11
            ],
            [
                'name' => 'Turismo', // 12
            ],
            [
                'name' => 'Inclusão Social', // 13
            ],
            [
                'name' => 'Eventos',  // 14
            ]
        ];
    }
}

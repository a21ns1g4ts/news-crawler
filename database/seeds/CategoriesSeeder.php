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
                'name' => 'Desconhecida',
            ],
            [
                'name' => 'Geral',
            ],
            [
                'name' => 'Impostos',
            ],
            [
                'name' => 'Tributos',
            ],
            [
                'name' => 'Esporte',
            ],
            [
                'name' => 'Saúde',
            ],
            [
                'name' => 'Educação',
            ],
            [
                'name' => 'Economia',
            ],
            [
                'name' => 'Política',
            ],
            [
                'name' => 'Gastronomia',
            ],
            [
                'name' => 'Turismo',
            ],
            [
                'name' => 'Inclusão Social',
            ],
            [
                'name' => 'Eventos',
            ]
        ];
    }
}

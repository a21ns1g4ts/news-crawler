<?php

use App\Models\Source;
use Illuminate\Database\Seeder;

/**
 * Class SourcesSeeder
 */
class SourcesSeeder extends Seeder
{
    /**
     * @var \App\Models\Source
     */
    private $source;

    /**
     * BeneficiosSeeder constructor.
     * @param \App\Models\Source $source
     */
    public function __construct(Source $source)
    {
        $this->source = $source;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data() as $data) {
            $robots = $data['robots'];
            unset($data['robots']);

            $source = $this->source->create($data);
            $source->robots()->createMany($robots);
        }
    }

    /**
     * @return array
     */
    private function data()
    {
        return [
            [
                'name' => 'SENAC',
                'description' => 'Notícias SENAC-PA',
                'url' => 'https://www.pa.senac.br/noticias',
                'robots' =>
                    [
                        [
                            'function' => 'copiar_noticias_recentes',
                            'model' => 'App\Robots\SenacNewsRobot'
                        ]
                    ]

            ],
            [
                'name' => 'FIEPA',
                'description' => 'Notícias FIEPA-PA',
                'url' => 'http://www.fiepa.org.br/noticias',
                'robots' =>
                    [
                        [
                            'function' => 'copiar_noticias_recentes',
                            'model' => 'App\Robots\FiepaNewsRobot'
                        ]
                    ]

            ],
        ];

    }
}

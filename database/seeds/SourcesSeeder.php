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
            [
                'name' => 'AGENCIA_PARA',
                'description' => 'Notícias AGENCIA_PARA',
                'url' => 'https://agenciapara.com.br/noticias.asp',
                'robots' =>
                    [
                        [
                            'function' => 'copiar_noticias_recentes',
                            'model' => 'App\Robots\AgenciaParaNewsRobot'
                        ]
                    ]

            ],
            [
                'name' => 'SENAI',
                'description' => 'Notícias SENAI-PA',
                'url' => 'https://www.senaipa.org.br/noticias',
                'robots' =>
                    [
                        [
                            'function' => 'copiar_noticias_recentes',
                            'model' => 'App\Robots\SenaiNewsRobot'
                        ]
                    ]

            ],
            [
                'name' => 'BRASIL',
                'description' => 'Notícias BRASIL-GOV',
                'url' => 'https://www.gov.br/pt-br/noticias/ultimas-noticias',
                'robots' =>
                    [
                        [
                            'function' => 'copiar_noticias_recentes',
                            'model' => 'App\Robots\BrasilNewsRobot'
                        ]
                    ]

            ],
            [
                'name' => 'CAMARA_BRASIL',
                'description' => 'Notícias CAMARA_BRASIL-GOV',
                'url' => 'https://www.camara.leg.br/noticias/rss/ultimas-noticias',
                'robots' =>
                    [
                        [
                            'function' => 'copiar_noticias_recentes',
                            'model' => 'App\Robots\CamaraBrasilNewsRobot'
                        ]
                    ]

            ],
            [
                'name' => 'SENADO_BRASIL',
                'description' => 'Notícias SENADO_BRASIL-GOV',
                'url' => 'https://www12.senado.leg.br/noticias',
                'robots' =>
                    [
                        [
                            'function' => 'copiar_noticias_recentes',
                            'model' => 'App\Robots\SenadoBrasilNewsRobot'
                        ]
                    ]

            ],
        ];

    }
}

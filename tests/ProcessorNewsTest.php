<?php


use App\Discoverers\DiscoveryAylienCategory;

class ProcessorNewsTest extends TestCase
{

    static $content = 'Jovens em situação de vulnerabilidade social têm a oportunidade 
     de participar do programa jovem aprendiz com a parceria mediada pelo Senac.Confira
     todas as fotos na Galeria O Senac Pará, através de seu Núcleo de Educação Profissional
     em Marabá (NEP Marabá), está recebendo a primeira turma de jovens aprendizes contratados
     por meio da Aprendizagem na forma alternativa. O formato…';

    public function testProcessNews(){

        $source =  \App\Models\Source::query()->first();
        $robot =  app($source->robots[0]->model);
        $process =  new \App\Processors\ProcessorNews($robot, $source);

        try{
            $process->handle();
        }catch (\Exception $exception){
            $this->throwException($exception);
        }

        $this->assertTrue(TRUE);
    }
}

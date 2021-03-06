<?php


use App\Discoverers\DiscoveryAylienCategory;

/**
 * Class DiscoveryAylienCategoryTest
 */
class DiscoveryAylienCategoryTest extends TestCase
{

    /**
     * Text to analyze
     *
     * @var string
     */
    static $content = 'Jovens em situação de vulnerabilidade social têm a oportunidade 
     de participar do programa jovem aprendiz com a parceria mediada pelo Senac.Confira
     todas as fotos na Galeria O Senac Pará, através de seu Núcleo de Educação Profissional
     em Marabá (NEP Marabá), está recebendo a primeira turma de jovens aprendizes contratados
     por meio da Aprendizagem na forma alternativa. O formato…';

    /**
     * Test discovery
     *
     * @param void
     */
    public function testDiscoveryCategory(){
        $discovery =  new DiscoveryAylienCategory(self::$content);
        $discovery->detect();
        $category = $discovery->getCategory();
        $this->assertStringContainsString($category , 'Educação');
    }
}

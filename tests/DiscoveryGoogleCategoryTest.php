<?php

use App\Discoverers\DiscoveryGoogleCategory;

/**
 * Class DiscoveryGoogleCategoryTest
 */
class DiscoveryGoogleCategoryTest extends TestCase
{

    /**
     * Text to analyze
     *
     * @var string
     */
    static $content = 'O Senac (Serviço Nacional de Aprendizagem Comercial), através da Rede Senac EAD, está com inscrições abertas para o processo seletivo de Graduação a distância. No Pará, os cursos contam com cinco polos de apoio às atividades: Santarém, Parauapebas, Castanhal, Belém e Marabá.Portfólio reúne cursos nas áreas de comércio, educação,…';

    /**
     * Test discovery
     *
     * @throws \Google\ApiCore\ApiException
     * @throws \Google\ApiCore\ValidationException
     */
    public function testDiscoveryCategory(){
        $text = self::$content;
        $discovery =  new DiscoveryGoogleCategory($text);
        $discovery->detect();
        $category = $discovery->getCategory();
        $this->assertStringContainsString($category , 'Economia');
    }
}

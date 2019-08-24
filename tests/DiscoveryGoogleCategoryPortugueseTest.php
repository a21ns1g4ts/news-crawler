
<?php

use Google\Cloud\Language\V1beta2\Document;
use Google\Cloud\Language\V1beta2\Document\Type;
use Google\Cloud\Language\V1beta2\LanguageServiceClient;

/**
 * Class DiscoveryGoogleCategoryPortugueseTest
 */
class DiscoveryGoogleCategoryPortugueseTest extends TestCase
{

    /**
     * @var string
     */
    static $content = 'No primeiro momento em que a informação foi passada, em uma entrevista 
     dos ministros Fernando Azevedo e Silva (Defesa) e Ricardo Salles (Meio Ambiente), quatro estados
     haviam confirmado o pedido. Mais tarde, o governo anunciou também as solicitações do Acre e do Mato Grosso.';

    /**
     * @throws \Google\ApiCore\ApiException
     */
    public function testDiscoveryCategory(){

        $projectId = 'janela-news';

        if (str_word_count(self::$content) < 20) {
            printf('20+ words are required to classify text.' . PHP_EOL);
            return;
        }

        try {
            $languageServiceClient = new LanguageServiceClient(['projectId' => $projectId]);
            $document = new Document();
            $document->setContent(self::$content)->setType(Type::PLAIN_TEXT);
            $response = $languageServiceClient->classifyText($document);
            $categories = $response->getCategories();
            foreach ($categories as $category) {
                $this->assertStringContainsString('/News/Politics', $category->getName(), $category->getName());
                echo $category->getName();
            }
        } catch (\Google\ApiCore\ValidationException $e) {
        } finally {
            if (!empty($languageServiceClient)) {
                $languageServiceClient->close();
            }
        }
    }
}

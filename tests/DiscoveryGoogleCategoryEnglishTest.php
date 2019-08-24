
<?php

use Google\Cloud\Language\V1beta2\Document;
use Google\Cloud\Language\V1beta2\Document\Type;
use Google\Cloud\Language\V1beta2\LanguageServiceClient;

/**
 * Class DiscoveryGoogleCategoryEnglishTest
 */
class DiscoveryGoogleCategoryEnglishTest extends TestCase
{

    /**
     * @var string
     */
    static $content = 'BIARRITZ, France — President Trump asserted on Saturday that he has
     the authority to make good on his threat to force all American businesses to leave China,
      citing a national security law that has been used mainly to target terrorists, 
      drug traffickers and pariah states like Iran, Syria and North Korea.';

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

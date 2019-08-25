<?php

namespace App\Discoverers;

use App\Models\Category;
use Google\Cloud\Language\V1beta2\Document;
use Google\Cloud\Language\V1beta2\LanguageServiceClient;

/**
 * Class DiscoveryGoogleCategory
 * @package App\Discoverers
 */
class DiscoveryGoogleCategory implements DiscoveryContract, DiscoveryCategoryContract
{

    /**
     * The content to analyze
     *
     * @var string
     */
    private $content;

    /**
     * @var LanguageServiceClient
     */
    private $service;

    /**
     * @var array
     */
    private $categories =[];

    /**
     * @var null
     */
    private $category = null;

    /**
     * DiscoveryGoogleCategory constructor
     *
     * @param $content
     */
    public function __construct($content){
        $this->content = $content;
        return $this;
    }

    /**
     * Detect the property of content
     *
     * @return void
     * @throws \Google\ApiCore\ApiException
     * @throws \Google\ApiCore\ValidationException
     */
    public function detect()
    {
        putenv("GOOGLE_APPLICATION_CREDENTIALS=".env('GOOGLE_APPLICATION_CREDENTIALS'));

        $this->service = new LanguageServiceClient(['projectId' => 'janela-news']);

        $this->categories = Category::all('name')->pluck('name');

        try {
            $languageServiceClient = new LanguageServiceClient(['projectId' => 'janela-news']);
            $document = new Document();
            $document->setContent(preg_replace('/[^a-zA-Z]/', '', $this->content))->setType(2);
            $response = $languageServiceClient->analyzeEntities($document, []);
            $entities = $response->getEntities();
            $categoriesCandidates = [];
            foreach ($entities as $entity) {
                $categoriesCandidates[] = $this->categories[$entity->getType()];
            }
        } finally {
            $languageServiceClient->close();
        }

        $this->category = $categoriesCandidates[0];
    }

    /**
     * Get the category
     *
     * @return string|null
     */
    public function getCategory()
    {
        return $this->category;
    }
}

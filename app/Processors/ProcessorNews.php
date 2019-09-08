<?php

namespace App\Processors;

use App\Discoverers\DiscoveryCategoryContract;
use App\Http\ClientCrawler;
use App\Models\Category;
use App\Models\Source;
use App\Robots\RobotContract;
use App\Repositories\ArticleRepository;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class ProcessorNews
 *
 * @package App\Processors
 */
class ProcessorNews implements ProcessorContract
{
    /**
     * @var Source
     */
    private $source;

    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * @var RobotContract
     */
    private $robot;

    /**
     * @var ClientCrawler
     */
    private $client;

    /**
     * @var LogProccessRobot
     */
    private $logger;

    /**
     * ProcessorNews constructor
     *
     * @param RobotContract $robot
     * @param $source
     */
    public function __construct(RobotContract $robot, Source $source)
    {
        $this->client = new ClientCrawler($source->url);
        $this->robot = $robot;
        $this->source = $source;
        $this->articleRepository = app(ArticleRepository::class);
        $this->logger = new LogProccessRobot($robot, $source);

    }

    /**
     * Start the robot
     *
     * @return void
     */
    public function handle()
    {
        $this->logger->init();

        try {
            $html = $this->client->request('', 'GET')->getBody()->getContents();
            $articles = $this->robot->scan($html);
            $this->syncData($articles);
        } catch (GuzzleException $e) {
            $this->logger->fail($e);
            new \Exception($e->getMessage(), $e->getCode());
        }

        $this->logger->final();
    }

    /**
     * @param array $article
     * @return mixed|void
     */
    public function syncData(array $article)
    {
        collect($article)->map(function ($article) {

            $textToScan = isset($article['content']) ? $article['content'] : $article['description'];

            $article['category'] = $this->getCategory($textToScan, $article['url']);

            $this->articleRepository->sync($article, $this->source);
        });
    }

    /**
     * @param $content
     * @param $url
     * @return string
     */
    private function getCategory($content, $url)
    {

        $article = $this->articleRepository->getByUrl($url);

        if (!$article){
            $discovery = app(DiscoveryCategoryContract::class, ['content' => $content]);
            $discovery->detect();
            $category = $discovery->getCategory();
        }

        if (!isset($article->category) && isset($category)){
            $category = Category::getByName($category);
        }

        if (!isset($category)){
            $category = Category::getByName('Geral');
        }

        return $category;
    }

}

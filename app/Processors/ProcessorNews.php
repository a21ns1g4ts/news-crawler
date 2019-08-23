<?php

namespace App\Processors;

use App\Discoverers\DiscoveryCategory;
use App\Discoverers\DiscoveryCategoryContract;
use App\Discoverers\DiscoveryContract;
use App\Http\ClientCrawler;
use App\Models\Category;
use App\Models\Source;
use App\Robots\RobotContract;
use App\Repositories\ArticleRepository;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

/**
 * Class ProcessorNews
 * @package App\Processors
 */
class ProcessorNews implements ProcessorContract
{
    /**
     * @var Source
     */
    private $source;

    /**
     * @var \Laravel\Lumen\Application|mixed
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
    public function start()
    {
        $this->logger->init();

        try {
            $html = $this->client->request('', 'GET')->getBody()->getContents();
            $articles = $this->robot->scan($html);
            $this->syncObjects($articles);
        } catch (GuzzleException $e) {
            $this->logger->fail($e);
            new \Exception($e->getMessage(), $e->getCode());
        }

        $this->logger->final();
    }

    /**
     * @param array $data
     * @return mixed|void
     */
    public function syncObjects(array $data)
    {
        collect($data)->map(function ($data) {

            $textToScan = isset($data['content']) ? $data['content'] : $data['description'];

            $data['category'] = $this->getCategory($textToScan, $data['url']);

            $this->articleRepository->sync($data, $this->source);
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
        }else{
            $category = $article->cateogory;
        }

        if ($category){
            $category = Category::getByName($category);
        }

        if (!$category){
            $category = Category::getByName('Desconhecida');
        }

        return $category;
    }

}

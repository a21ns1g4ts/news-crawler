<?php

namespace App\Processors;

use App\Discoverers\DiscoveryCategory;
use App\Http\ClientCrawler;
use App\Models\Category;
use App\Models\Source;
use App\Robots\RobotContract;
use App\Repositories\ArticleRepository;
use GuzzleHttp\Exception\GuzzleException;

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

            $category = Category::getByName($data['category']);

            if (!$category){
                $textToScan = isset($data['content']) ? $data['content'] : $data['description'];
                $categoryName = $this->getCategory($textToScan);
                $category = Category::firstOrCreate('name' , ['name' => $categoryName]);
            }

            $data['category'] =  $category;

            $this->articleRepository->sync($data, $this->source);
        });
    }

    /**
     * @param $content
     * @return Category|\Illuminate\Database\Eloquent\Model|object|null
     */
    private function getCategory($content)
    {
        $discovery = new DiscoveryCategory($content);

        $category = $discovery->detect();

        if (!$category){
            $category = Category::getByName('Desconhecida');
        }

        return $category;
    }

}

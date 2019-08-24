<?php

namespace App\Http\Controllers;

use App\Http\ClientCrawler;
use App\Models\Category;
use App\Repositories\ArticleRepository;
use App\Robots\RobotAbstract;
use phpDocumentor\Reflection\DocBlock\Tags\Source;

/**
 * Class SourceController
 *
 * @package App\Http\Controllers
 */
class SourceController extends Controller
{

    /**
     * @var \Laravel\Lumen\Application|mixed
     */
    private  $articleRepository;

    /**
     * SourceController constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return
     */
    public function index($name){

        $source = \App\Models\Source::getByName($name);
        $client = new ClientCrawler($source->url);
        $robot  = app($source->robots[0]->model);
        $html = $client->request('', 'GET')->getBody()->getContents();
        $articles = $robot->scan($html);
        return $articles;
    }

}

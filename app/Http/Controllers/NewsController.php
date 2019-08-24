<?php

namespace App\Http\Controllers;

use App\Http\Transformers\ArticlesTransform;
use App\Http\Transformers\CategoryTransform;
use App\Models\Category;
use App\Repositories\ArticleRepository;

/**
 * Class NewsController
 *
 * @package App\Http\Controllers
 */
class NewsController extends Controller
{

    /**
     * @var \Laravel\Lumen\Application|mixed
     */
    private  $articleRepository;

    /**
     * NewsController constructor.
     */
    public function __construct()
    {
        $this->articleRepository = app(ArticleRepository::class);
    }

    /**
     * @return CategoryTransform
     */
    public function categories(){
        return new CategoryTransform(Category::all());
    }

    /**
     * @return ArticlesTransform
     */
    public function articles(){

        $category = isset($_GET['category']) ? $_GET['category'] :  'Desconhecida';
        $articles = $this->articleRepository->getByCategory($category);

        return new ArticlesTransform($articles);
    }

}

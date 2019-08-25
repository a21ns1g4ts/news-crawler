<?php

namespace App\Repositories;

use App\Models\Article;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ArticleRepository
 * @package App\Repositories
 */
class ArticleRepository
{
    /**
     * @var Article
     */
    private $model;

    /**
     * ArticleRepository constructor.
     * @param Article $model
     */
    public function __construct(Article $model)
    {
        $this->model = $model;
    }

    /**
     * @param $data
     * @param $source
     * @return Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function sync(&$data, $source){

        $article = $this->model->getByUrl($data['url']);

        $category = $data['category'];

        unset($data['category']);

        $data['category_id'] = $category->id;
        $data['source_id'] = $source->id;

        if (!$article){
           $article = $this->model->create($data);
        }

        return $article;
    }


    /**
     * @param $category
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getByCategory($category)
    {
        $category = Category::getByName($category);

        return $this->model
            ->newQuery()
            ->when(!isset($category->name) , function (Builder $query) use ($category){
                return $query->where('title' , '=' , 'a$');
            })
            ->when(isset($category->name) , function (Builder $query) use ($category){
                return $query->whereHas('category' , function (Builder $query) use ($category){
                    return $query->where('categories.name' , '=' , $category->name);
                });
                })->get()->take(8);
    }

    /**
     * @param $url
     * @return Builder|\Illuminate\Database\Eloquent\Model|object
     */
    public function getByUrl($url){
        return $this->model
            ->newQuery()
            ->where('url' , '=' , $url)->first();
    }
}

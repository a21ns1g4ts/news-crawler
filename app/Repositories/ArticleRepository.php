<?php

namespace App\Repositories;

use App\Models\Article;

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
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getByCategory($category, $perPage = 30){
        return $this->model
            ->newQuery()
            ->whereHas('category' , function (Builder $query) use ($category){
                return $query->where('category.name' , '=' , $category);
            })
            ->paginate($perPage);
    }
}

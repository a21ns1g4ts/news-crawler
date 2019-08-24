<?php


namespace App\Http\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticlesTransform extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $articles = $this->collection->map(function ($obj){
            return [
                'title' => $obj->title,
                'description' =>  $obj->description,
                'author' =>  $obj->author,
                'url' =>  $obj->url,
                'urlToImage' => $obj->url_to_image,
                'publishedAt' => $obj->created_at,
                'content' => $obj->content ? $obj->content : $obj->description
            ];
        });

        return [
            'totalResults' => $this->collection->count(),
            'articles' => $articles
        ];
    }
}

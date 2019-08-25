<?php

namespace App\Robots;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class SenacNewsRobot
 *
 * @package App\Robots
 */
class SenacNewsRobot extends RobotAbstract implements RobotContract
{

    /**
     * @var string
     */
    public $function = 'copiar_noticias_recentes';

    /**
     * Scan html content
     *
     * @param $html
     * @return array
     */
    public function scan($html){

        $crawler = new Crawler($html);

        $crawler = $crawler->filter('.clearfix.media');

        $articles = $crawler
           ->each(function (Crawler $node) {
                return [
                    'title' => $node->filter('li .media-body h3')->first()->text(),
                    'url' => $node->filter('li .media-body h3 a')->first()->attr('href'),
                    'url_to_image' => $node->filter('li figure a img')->first()->attr('src'),
                    'description' => $node->filter('li .media-body p')->first()->text(),
                    'category' => Str::title($node->filter('li .media-body span a')->first()->text()),
                    'created_at' => Carbon::make($node->filter('li .media-body span span meta')->first()->attr('content'))->format('Y-m-d h:i:s')
                ];
           });

        return $articles;
    }
}

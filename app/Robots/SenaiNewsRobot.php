<?php

namespace App\Robots;

use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class SenaiNewsRobot
 *
 * @package App\Robots
 */
class SenaiNewsRobot extends RobotAbstract implements RobotContract
{

    /**
     * Name of robot function
     *
     * @var string
     */
    public $function = 'copiar_noticias_recentes';

    /**
     * Scan the given string
     *
     * @param $html
     * @return array
     */
    public function scan($html)
    {
        $crawler = new Crawler($html);

        $crawler = $crawler->filter('.box2.box33');

        $articles = $crawler
            ->each(function (Crawler $node) {
                return [
                    'title' => $node->filter('article header a h1')->first()->text(),
                    'url' => $node->filter('article header a')->first()->attr('href'),
                    'url_to_image' => $node->filter('article .photo a img')->first()->attr('src'),
                    'description' => $node->filter('article footer p')->first()->text(),
                    'category' => Str::title($node->filter('article header p')->first()->text()),
                ];
            });

        return $articles;
    }
}

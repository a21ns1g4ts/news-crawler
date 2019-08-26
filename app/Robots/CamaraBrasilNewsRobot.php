<?php

namespace App\Robots;

use Carbon\Carbon;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class CamaraBrasilNewsRobot
 *
 * @package App\Robots
 */
class CamaraBrasilNewsRobot extends RobotAbstract implements RobotContract
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

        $crawler = $crawler->filterXPath('//rss/channel//item');

        $articles = $crawler
            ->each(function (Crawler $node) {

                $description =  $node->filter('description')->count() > 0 ?  $node->filter('description')->first()->text() : '';

                return [
                    'title' => $node->filter('title')->first()->text(),
                    'url' => str_replace('www.camara.leg.br','', $node->filter('link')->first()->text()),
                    'url_to_image' => '',
                    'description' => $description,
                    'content' => strip_tags($node->filter('content|encoded')->first()->text()),
                    'created_at' => Carbon::make($node->filter('pubDate')->first()->text())->format('Y-m-d h:i:s'),
                ];

            });

        return $articles;
    }
}

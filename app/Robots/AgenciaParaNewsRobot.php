<?php

namespace App\Robots;

use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class AgenciaParaNewsRobot
 *
 * @package App\Robots
 */
class AgenciaParaNewsRobot extends RobotAbstract implements RobotContract
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

        $crawler = $crawler->filter('.col-sem-margem2');

        $articles = $crawler
            ->each(function (Crawler $node) {

                $url = $node->filter('img')->first()->count() === 1 ? 'https://agenciapara.com.br/' . $node->filter('img')->first()->attr('src') : null;

                return [
                    'title' => $node->filter('h4')->first()->text(),
                    'url' => 'https://agenciapara.com.br' . $node->filter('a')->first()->attr('href'),
                    'url_to_image' => $url,
                    'description' => $node->filter('h6')->first()->text(),
                    'category' => Str::title($node->filter('h5')->first()->text()),
                ];
            });

        return $articles;
    }
}

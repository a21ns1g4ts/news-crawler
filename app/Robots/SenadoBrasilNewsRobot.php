<?php

namespace App\Robots;

use Carbon\Carbon;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class SenadoBrasilNewsRobot
 *
 * @package App\Robots
 */
class SenadoBrasilNewsRobot extends RobotAbstract implements RobotContract
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

        $crawler = $crawler->filter('.Manchete--cultural');

        $baseUrl = 'https://www12.senado.leg.br';

        $articles = $crawler
           ->each(function (Crawler $node) use ($baseUrl){

               $date = explode('/' ,$node->filter('a')->first()->attr('href'));
               $date = Carbon::create($date[3] ,$date[4], $date[5])->format('Y-m-d h:i:s');

               return [
                    'title' => $node->filter('.Media-body a span')->first()->text(),
                    'url' => $baseUrl . $node->filter('a')->first()->attr('href'),
                    'url_to_image' => $baseUrl . $node->filter('a img')->first()->attr('src'),
                    'description' => $node->filter('.Manchete-descricao p')->first()->text(),
                    'created_at' => $date
                ];
           });

        return $articles;
    }
}

<?php

namespace App\Robots;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class BrasilNewsRobot
 *
 * @package App\Robots
 */
class BrasilNewsRobot extends RobotAbstract implements RobotContract
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

        $crawler = $crawler->filter('article');

        $articles = $crawler
            ->each(function (Crawler $node) {

                $url = $node->filter('img')->first()->count() === 1 ? $node->filter('img')->first()->attr('src') : null;

                $hour = explode('h' , Str::slug($node->filter('.documentByLine .summary-view-icon')->eq(1)->text()));
                $hour = Carbon::createFromFormat(  'H:m'  , $hour[0]. ':' .$hour[0] )->format('H:m:s');
                $date = Carbon::createFromFormat('dmY' , Str::slug($node->filter('.documentByLine .summary-view-icon')->first()->text()))->format('Y-m-d');

                return [
                    'title' => $node->filter('h2 a')->first()->text(),
                    'url' => $node->filter('a')->first()->attr('href'),
                    'url_to_image' =>$url,
                    'description' => $node->filter('.tileBody .description')->first()->text(),
                    'category' => Str::title($node->filter('span')->first()->text()),
                    'created_at' => "$date $hour"
                ];

            });

        return $articles;
    }
}

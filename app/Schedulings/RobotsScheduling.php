<?php

namespace App\Schedulings;

use App\Jobs\ScanNewsJob;
use App\Queues\NewsQueue;
use Illuminate\Console\Scheduling\Schedule;

/**
 * Class RobotsScheduling
 *
 * @package App\Schedulings
 */
class RobotsScheduling
{
    /**
     * Time to robots sleep
     *
     * @var mixed
     */
    private static $timeToWake;

    /**
     * Time to wake up robots
     * @var mixed
     */
    private static $timeToSleep;

    /**
     * Delay between robots request
     *
     * @var String
     */
    private static $delay;

    /**
     * Method calling when delay equals one
     *
     * @var string
     */
    private static $ONE_MINUTE_METHOD = 'everyMinute';

    /**
     * Method calling when delay equals five
     *
     * @var string
     */
    private static $FIVE_MINUTES_METHOD = 'everyFiveMinutes';

    /**
     * Method calling when delay equals teen
     *
     * @var string
     */
    private static $TEN_MINUTES_METHOD = 'everyTenMinutes';

    /**
     * Method calling when delay equals fifteen
     *
     * @var string
     */
    private static $FIFTEN_MINUTES_METHOD = 'everyFifteenMinutes';

    /**
     * Method calling when delay equals thirty
     *
     * @var string
     */
    private static $THIRTY_MINUTES_METHOD = 'everyThirtyMinutes';

    /**
     * Method calling when delay equals one
     *
     * @var string
     */
    private static $SIXTY_MINUTES_METHOD = 'hourly';

    /**
     * The delay between scaners requests
     *
     * @var string
     */
    private static $DELAY_METHOD;

    /**
     * Define the robots schedule
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    public static function schedule(Schedule $schedule)
    {
        self::setOptions();

        $schedule->job(new ScanNewsJob(new NewsQueue()))
            ->between(self::$timeToWake, self::$timeToSleep)
            ->{ self::$DELAY_METHOD }();
    }

    /**
     * Get options from env
     * to can set correctly delay method
     *
     * @param void
     */
    private static function setOptions(){

        self::$timeToWake = env('ROBOTS_TIME_TO_WAKE' , '0:00');
        self::$timeToSleep = env('ROBOTS_TIME_TO_SLEEP' , '12:59');
        self::$delay = env('ROBOTS_DELAY' , 1);

        switch (self::$delay){
            case 5:
                self::$DELAY_METHOD = self::$FIVE_MINUTES_METHOD;
                break;
            case 10:
                self::$DELAY_METHOD = self::$TEN_MINUTES_METHOD;
                break;
            case 15:
                self::$DELAY_METHOD = self::$FIFTEN_MINUTES_METHOD;
                break;
            case 30:
                self::$DELAY_METHOD = self::$THIRTY_MINUTES_METHOD;
                break;
            case 60:
                self::$DELAY_METHOD = self::$SIXTY_MINUTES_METHOD;
                break;
            default:
                self::$DELAY_METHOD = self::$ONE_MINUTE_METHOD;
                break;
        }
    }


}

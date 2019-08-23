<?php

namespace App\Processors;

use App\Models\Source;
use App\Robots\RobotContract;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

/**
 * Class LogProccessRobot
 * @package App\Processors
 */
class LogProccessRobot
{
    /**
     * @var RobotContract
     */
    private  $robot;

    /**
     * @var Source
     */
    private $source;

    /**
     * LogProccessRobot constructor
     *
     * @param $robot
     * @param $source
     */
    public function __construct(RobotContract $robot, Source $source)
    {
        $this->robot = $robot;
        $this->source = $source;
    }

    /**
     * Log the robot start
     *
     * @param void
     */
    public function init(){
        Log::info(
            'start robot: ' . get_class($this->robot) .
            ' function: ' . $this->robot->getFunction() .
            ' into ' . 'source: ' . ($this->source->name)
        );
    }

    /**
     * Log the robot end
     *
     * @param void
     */
    public function final(){
        Log::info(
            'end robot: ' . get_class($this->robot) .
            ' function: ' . $this->robot->getFunction() .
            ' into ' . 'source: ' . ($this->source->name)
        );
    }

    /**
     * Log the robot fail
     *
     * @param GuzzleException $exception
     */
    public function fail(GuzzleException $exception){
        Log::error(
            'the robot: ' . get_class($this->robot) .
            'has an error:' . $exception->getMessage() .
            ' function: ' . $this->robot->getFunction() .
            ' into ' . 'source: ' . ($this->source->name)
        );
    }

}

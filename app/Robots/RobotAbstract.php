<?php

namespace App\Robots;

/**
 * Class RobotAbstract
 *
 * @package App\Robots
 */
class RobotAbstract
{
    /**
     * Name robot function
     *
     * @var string
     */
    public $function = 'copiar_noticias_recentes';

    /**
     * Get the robot function name
     *
     * @return string
     */
    public function getFunction(): string
    {
        return $this->function;
    }
}

<?php
namespace Controllers;

class Route extends \Slim\Route
{
    public function __construct($pattern = null, $callable = null)
    {
        if (!empty($pattern)) {
            $this->setPattern($pattern);
        }

        if (!empty($callable)) {
            $this->setCallable($callable);
        }

        $this->setConditions(self::getDefaultConditions());
    }
}

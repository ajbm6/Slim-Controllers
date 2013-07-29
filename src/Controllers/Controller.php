<?php
namespace Controllers;

class Controller
{
    private $route;
    private $routeName;

    public function __construct(\Slim\Route $route)
    {
        $this->route = $route;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function getRouteName()
    {
        return $this->routeName;
    }

    public function bind($routeName)
    {
        $this->routeName = $routeName;
        $this->route->setPattern($routeName);

        return $this;
    }

    public function __call($method, $arguments)
    {
        if (!method_exists($this->route, $method)) {
            throw new \BadMethodCallException(sprintf('Method "%s::%s" does not exist.', get_class($this->route), $method));
        }

        call_user_func_array(array($this->route, $method), $arguments);

        return $this;
    }

    public function generateRouteName($prefix)
    {
        $routeName = $prefix.$this->route->getPattern();
        $routeName = str_replace(array('|', '-'), '/', $routeName);
        $routeName = preg_replace('/[^a-z0-9A-Z_()+:\/.]+/', '', $routeName);

        return $routeName;
    }
}

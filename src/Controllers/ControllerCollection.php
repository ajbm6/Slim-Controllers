<?php
namespace Controllers;

class ControllerCollection
{
    protected $controllers = array();
    protected $defaultRoute;
    protected $defaultRouter;

    public function __construct(\Slim\Route $defaultRoute, \Slim\Router $defaultRouter)
    {
        $this->defaultRoute = $defaultRoute;
        $this->defaultRouter = $defaultRouter;
    }

    public function getControllers()
    {
        return $this->controllers;
    }

    public function match($args)
    {
        $pattern = array_shift($args);
        $to = array_pop($args);

        $route = clone $this->defaultRoute;
        $route->setPattern($pattern);
        $route->setCallable($to);

        if (count($args) > 0) {
            $route->setMiddleware($args);
        }

        $this->controllers[] = $controller = new Controller($route);

        return $controller;
    }

    public function map()
    {
        $args = func_get_args();
        return $this->match($args);
    }

    public function get()
    {
        $args = func_get_args();
        return $this->match($args)->via(\Slim\Http\Request::METHOD_GET, \Slim\Http\Request::METHOD_HEAD);
    }

    public function post()
    {
        $args = func_get_args();
        return $this->match($args)->via(\Slim\Http\Request::METHOD_POST);
    }

    public function put()
    {
        $args = func_get_args();
        return $this->match($args)->via(\Slim\Http\Request::METHOD_PUT);
    }

    public function patch()
    {
        $args = func_get_args();
        return $this->match($args)->via(\Slim\Http\Request::METHOD_PATCH);
    }

    public function delete()
    {
        $args = func_get_args();
        return $this->match($args)->via(\Slim\Http\Request::METHOD_DELETE);
    }

    public function options()
    {
        $args = func_get_args();
        return $this->match($args)->via(\Slim\Http\Request::METHOD_OPTIONS);
    }

    public function flush($prefix = '')
    {
        foreach ($this->controllers as $controller) {
            if (!$name = $controller->getRouteName()) {
                $name = $controller->generateRouteName($prefix);
                $controller->bind($name);
            }

            $this->defaultRouter->map($controller->getRoute());
        }
    }
}

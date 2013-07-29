<?php
namespace Controllers;

class Application extends \Slim\Slim
{
    public function __construct(array $userSettings = array())
    {
        parent::__construct($userSettings);

        $this->container->singleton('route', function () {
            return new Route();
        });

        $this->controller_factory = function ($c) {
            return new ControllerCollection($c['route'], $c['router']);
        };
    }

    public function mount()
    {
        $args = func_get_args();

        $prefix = '';
        $controller = $args[0];

        if (count($args) > 1) {
            $prefix = array_shift($args);
            $controller = array_pop($args);
        }

        $controller->flush($prefix);
    }

    public function getControllersRoutes()
    {
        $routes = array();
        $controllers = $this->controller_factory->getControllers();
        foreach ($controllers as $controller) {
            $routes[] = $controller->getRouteName();
        }

        return $routes;
    }
}

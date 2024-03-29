<?php
namespace App\Controller;

class Controller{

    private $twig;

    private $app;

    protected function render(string $view, array $variables = [])
    {

        $variables["debugTime"] = $this->getApp()->getDebugTime(); 
        echo $this->getTwig()->render(
            $view.'.twig',
            $variables
        );
    }

    private function getTwig()
    {
        if(is_null($this->twig)){
            $loader = new \Twig\Loader\FilesystemLoader(dirname(dirname(__dir__)).'/views/');
            $this->twig = new \Twig\Environment($loader);
        }
        return $this->twig;
    }

    protected function getApp()
    {
        if(is_null($this->app)){
            $this->app = \App\App::getInstance();
        }
        return $this->app;
    }

    protected function getRouter()
    {
            return $this->getApp()->getRouter();
    }

}
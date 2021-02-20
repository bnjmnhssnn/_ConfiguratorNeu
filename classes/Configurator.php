<?php
namespace Grav\Plugin\IServConfigurator;

use Grav\Common\Config\Config;
use Grav\Common\Session;

class Configurator
{
    protected $steps;
    protected $current = 0;

    public function __construct(Config $config, array $state_from_session = NULL)
    {
        if(!empty($state_from_session)) {
            $this->current = $state_from_session['current'];
        }

        $this->registerSteps([
            new Step\SchoolInfo($config),
            new Step\MainProduct($config)
        ]);
    }

    protected function registerSteps(array $steps)
    {
        foreach($steps as $step) {
            $this->steps[] = $step;
        }
    }

    public function outputCurrent()
    {
        $current_step = $this->steps[$this->current];
        return [
            'template' => $current_step->template,
            'title' => $current_step->title,
            'paragraph' => $current_step->paragraph
        ];
    }

    public function confirmNext() : bool
    {

    }



    public function back()
    {

    }

    public function ready()
    {

    }

    public function state()
    {
        return [
            'current' => $current
        ];
    }

}
<?php
namespace Grav\Plugin\IServConfigurator;

class Configurator
{
    protected $steps;
    protected $current = 0;
    protected $config = NULL;

    public function __construct(array $plugin_config, array $state_from_session = NULL)
    {
        if(!empty($state_from_session)) {
            $this->current = $state_from_session['current'];
        }

        $this->registerSteps([
            new Step\SchoolInfo($plugin_config),
            new Step\MainProduct($plugin_config)
        ]);

        $this->config = $plugin_config;
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
            'post_route' => $this->config['post_route'],
            'title' => $current_step->title,
            'paragraph' => $current_step->paragraph
        ];
    }

    public function confirmCurrentStep(array $post_vars) : bool
    {
        if($this->current < count($this->steps)) {
            $this->current++;
            return true;
        }
        if($this->current === count($this->steps)) {
            $this->ready = true;
            return true;
        }
    }



    public function back() : bool
    {
        $this->ready = false;
        if($this->current > 0) {
            $this->current--;
            return true;
        }
        return false;
    }

    public function ready()
    {

    }

    public function state()
    {
        return [
            'current' => $this->current
        ];
    }

}
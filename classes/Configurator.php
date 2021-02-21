<?php
namespace Grav\Plugin\IServConfigurator;

class Configurator
{
    protected $steps;
    protected $current = 0;
    protected $selection = [];
    protected $config = NULL;
    protected $ready = false;
    protected $error = NULL;

    public function __construct(array $plugin_config, array $state_from_session = NULL)
    {
        $this->current = $state_from_session['current'] ?? 0;
        $this->selection = $state_from_session['selection'] ?? [];
        $this->ready = $state_from_session['ready'] ?? false;
        $this->error = $state_from_session['error'] ?? NULL;
        $this->config = $plugin_config;

        $this->steps = [
            new Step\SchoolInfo($plugin_config, 0),
            new Step\MainProduct($plugin_config, 1),
            new Step\Backup($plugin_config, 2),
            new Step\Summary($plugin_config, 3)
        ];
        foreach($this->steps as $step) {
            $step->setup($this->selection);
        }
    }

    public function outputCurrent()
    {
        $current_step = $this->steps[$this->current];
        $current_step->setup($this->selection);
        $vars = $current_step->getVars();
        $vars['post_route'] = $this->config['post_route'];
        $vars['selection'] = print_r($this->selection, true);
        $vars['error'] = $this->error;
        $summary = new Summary($this->steps);
        $vars['summary'] = $summary->getVars($this->selection);

        $this->error = NULL;
        return $vars;
    }

    public function confirmCurrentStep(array $post_vars) : bool
    {
        $current_step = $this->steps[$this->current];
        if(!$current_step->confirm($post_vars, $this->selection)) {
            $this->error = $current_step->error ?? 'Generic error msg';
            return false;
        }
        $this->selection[$this->current] = $current_step->getInput();
        if($this->current < count($this->steps)) {
            $this->current++;
        } else {
            $this->ready = true;
        }
        return true;
    }

    public function back() : bool
    {
        $this->ready = false;
        if($this->current > 0) {
            unset($this->selection[$this->current]);
            unset($this->selection[$this->current - 1]);
            $this->current--;
            return true;
        }
        return false;
    }

    public function ready()
    {
        return $this->ready;
    }

    public function state()
    {
        return [
            'current' => $this->current,
            'selection' => $this->selection,
            'error' => $this->error,
            'ready' => $this->ready
        ];
    }

}
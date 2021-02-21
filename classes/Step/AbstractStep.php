<?php
namespace Grav\Plugin\IServConfigurator\Step;

class AbstractStep
{
    protected $vars = [];
    protected $user_input;
    protected $config;

    public function __construct(array $config, int $id)
    {
        $this->vars['step_id'] = $id;
        $this->config = $config;
    }
    
    public function getVars() : array
    {
        return $this->vars;
    }

    public function getInput() : array
    {
        return $this->user_input;
    }
}
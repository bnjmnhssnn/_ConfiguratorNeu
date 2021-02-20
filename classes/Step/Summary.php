<?php
namespace Grav\Plugin\IServConfigurator\Step;

use Grav\Plugin\IServConfigurator\ConfiguratorException;

class Summary implements StepInterface
{
    public $vars = [];

    public function __construct($id)
    {
        $this->vars['step_id'] = $id;
    }

    public function setup(array $config, array $current_selection) : void
    {
        $this->vars['template'] = 'step_summary';
        $this->vars['title'] = 'Zusammenfassung & bestätigen';//$config['step_backup_title'];
        $this->vars['paragraph'] = 'Lorem ispum dolor sit amet';//$config['step_backup_paragraph'];
    }

    public function confirm(array $post_vars, array $configurator_selection) : bool
    {
        if((int) $post_vars['step_id'] !== $this->vars['step_id']) {
            throw new ConfiguratorException(
                'Trying to confirm step ' . (int) $post_vars['step_id'] . ', but current step is ' . $this->vars['step_id']
            );
        }
        if(empty($post_vars['email'])) {
            $this->error = 'Missing required field \'email\''; 
            return false; 
        }
        if(empty($post_vars['name'])) {
            $this->error = 'Missing required field \'name\''; 
            return false; 
        }
        if(empty($post_vars['school_name'])) {
            $this->error = 'Missing required field \'school_name\''; 
            return false; 
        }
        $this->user_input = [
            'email' => $post_vars['email'],
            'name' => $post_vars['name'],
            'school_name' => $post_vars['school_name'],
        ];
        return true;
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
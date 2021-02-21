<?php
namespace Grav\Plugin\IServConfigurator\Step;

use Grav\Plugin\IServConfigurator\ConfiguratorException;
use Grav\Plugin\IServConfigurator\Helpers;


class Backup implements StepInterface
{
    public $vars = [];

    public function __construct($id)
    {
        $this->vars['step_id'] = $id;
    }

    public function setup(array $config, array $current_selection) : void
    {
        $this->vars['template'] = 'step_backup';
        $this->vars['title'] = $config['step_backup_title'];
        $this->vars['paragraph'] = $config['step_backup_paragraph'];

        $this->vars['input_backup'] = [
            'title' => $config['step_backup_options_label'],
            'options' => Helpers::applySwitches(
                $config['step_backup_options'],
                $current_selection
            )
        ];
    }

    public function confirm(array $post_vars, array $configurator_selection) : bool
    {
        if((int) $post_vars['step_id'] !== $this->vars['step_id']) {
            throw new ConfiguratorException(
                'Trying to confirm step ' . (int) $post_vars['step_id'] . ', but current step is ' . $this->vars['step_id']
            );
        }
        if(empty($post_vars['backup'])) {
            $this->error = 'Missing required field \'backup\''; 
            return false; 
        }
        $this->user_input = [
            'backup' => (int) $post_vars['backup']        
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
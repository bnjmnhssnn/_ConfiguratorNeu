<?php
namespace Grav\Plugin\IServConfigurator\Step;

use Grav\Plugin\IServConfigurator\ConfiguratorException;
use Grav\Plugin\IServConfigurator\Helpers;


class Backup extends AbstractStep implements StepInterface
{
    public function setup(array $current_selection) : void
    {
        $this->vars['template'] = 'step_backup';
        $this->vars['title'] = $this->config['step_backup_title'];
        $this->vars['paragraph'] = $this->config['step_backup_paragraph'];

        $this->vars['input_backup'] = [
            'title' => $this->config['step_backup_options_label'],
            'options' => Helpers::applySwitches(
                $this->config['step_backup_options'],
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
}
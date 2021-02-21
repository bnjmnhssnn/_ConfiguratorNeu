<?php
namespace Grav\Plugin\IServConfigurator\Step;

use Grav\Plugin\IServConfigurator\ConfiguratorException;

class Summary extends AbstractStep implements StepInterface
{
    public function setup(array $current_selection) : void
    {
        $this->vars['template'] = 'step_summary';
        $this->vars['title'] = $this->config['step_summary_title'];
        $this->vars['paragraph'] = $this->config['step_summary_paragraph'];
        $this->vars['email_label'] = $this->config['step_summary_email_label'];
        $this->vars['contact_label'] = $this->config['step_summary_contact_label'];
        $this->vars['schoolname_label'] = $this->config['step_summary_schoolname_label'];
        $this->vars['freetext_label'] = $this->config['step_summary_freetext_label'];  
    }

    public function confirm(array $post_vars, array $configurator_selection) : bool
    {
        if((int) $post_vars['step_id'] !== $this->vars['step_id']) {
            throw new ConfiguratorException(
                'Trying to confirm step ' . (int) $post_vars['step_id'] . ', but current step is ' . $this->vars['step_id']
            );
        }
        if(empty($post_vars['email'])) {
            $this->error = $this->config['step_summary_email_error'] ?? 'Missing required field \'email\''; 
            return false; 
        }
        if(empty($post_vars['contact'])) {
            $this->error = $this->config['step_summary_contact_error'] ?? 'Missing required field \'contact\''; 
            return false; 
        }
        if(empty($post_vars['school_name'])) {
            $this->error = $this->config['step_summary_schoolname_error'] ?? 'Missing required field \'school_name\''; 
            return false; 
        }
        $this->user_input = [
            'email' => $post_vars['email'],
            'contact' => $post_vars['contact'],
            'school_name' => $post_vars['school_name'],
            'free_text' => $post_vars['free_text'] ?? ''
        ];
        return true;
    }
}
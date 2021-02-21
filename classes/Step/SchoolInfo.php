<?php
namespace Grav\Plugin\IServConfigurator\Step;

use Grav\Plugin\IServConfigurator\ConfiguratorException;

class SchoolInfo extends AbstractStep implements StepInterface
{
    public function setup(array $current_selection) : void
    {
        $this->vars['template'] = 'step_school_info';
        $this->vars['title'] = $this->config['step_school_info_title'];
        $this->vars['paragraph'] = $this->config['step_school_info_paragraph'];

        $option_ids = array_map('trim', explode(',', $this->config['step_school_info_option_ids']));
        $this->vars['input_schooltype'] = [
            'title' => $this->config['step_school_info_schooltype_label'],
            'options' => array_filter(
                $this->config['step_school_info_options'],
                function($item) use ($option_ids) {
                    return in_array($item['id'], $option_ids);
                }
            )
        ];
        $this->vars['input_student_count'] = [
            'id' => 100,
            'label' => $this->config['step_school_info_student_count_label']
        ]; 
    }

    public function confirm(array $post_vars, array $configurator_selection) : bool
    {
        if((int) $post_vars['step_id'] !== $this->vars['step_id']) {
            throw new ConfiguratorException(
                'Trying to confirm step ' . (int) $post_vars['step_id'] . ', but current step is ' . $this->vars['step_id']
            );
        }
        if(empty($post_vars['schooltype'])) {
            $this->error = 'Missing required field \'schooltype\''; 
            return false; 
        }
        if(empty($post_vars['student_count'])) {
            $this->error = 'Missing required field \'student_count\''; 
            return false; 
        }
        $this->user_input = [
            'schooltype' => (int) $post_vars['schooltype'],
            'student_count' => (int) $post_vars['student_count']
        ];
        return true;
    }
}
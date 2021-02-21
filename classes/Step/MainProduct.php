<?php
namespace Grav\Plugin\IServConfigurator\Step;

use Grav\Plugin\IServConfigurator\ConfiguratorException;


class MainProduct implements StepInterface
{
    public $vars = [];

    public function __construct($id)
    {
        $this->vars['step_id'] = $id;
    }

    public function setup(array $config, array $current_selection) : void
    {
        $this->vars['template'] = 'step_main_product';
        $this->vars['title'] = $config['step_main_product_title'];
        $this->vars['paragraph'] = $config['step_main_product_paragraph'];

        $student_count = $current_selection[0]['student_count'] ?? NULL;

        // Hardware Optionen-->
        $hardware_ids = array_map('trim', explode(',', $config['step_main_product_hardware_ids']));
        $remove = (NULL !== $student_count && $student_count > 400) ? (NULL !== $student_count && $student_count > 1200) ? [4,5] : [4] : [];
        $hardware_ids = array_diff($hardware_ids, $remove ?? []); 
        $this->vars['input_hardware'] = [
            'title' => $config['step_main_product_hardware_label'],
            'options' => array_filter(
                $config['step_main_product_options'],
                function($item) use ($hardware_ids) {
                    return in_array($item['id'], $hardware_ids);
                }
            )
        ];

        // Cloud Optionen -->
        $cloud_ids = array_map('trim', explode(',', $config['step_main_product_cloud_ids']));
        $remove = (NULL !== $student_count && $student_count > 400) ? (NULL !== $student_count && $student_count > 1200) ? [7,8] : [7] : [];
        $cloud_ids = array_diff($cloud_ids, $remove ?? []); 
        $this->vars['input_cloud'] = [
            'title' => $config['step_main_product_cloud_label'],
            'options' => array_filter(
                $config['step_main_product_options'],
                function($item) use ($cloud_ids) {
                    return in_array($item['id'], $cloud_ids);
                }
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
        if(empty($post_vars['main_product'])) {
            $this->error = 'Missing required field \'main_product\''; 
            return false; 
        }
        $this->user_input = [
            'main_product' => (int) $post_vars['main_product']        
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
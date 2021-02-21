<?php
namespace Grav\Plugin\IServConfigurator\Step;

use Grav\Plugin\IServConfigurator\ConfiguratorException;

class MainProduct extends AbstractStep implements StepInterface
{
    public function setup(array $current_selection) : void
    {
        $this->vars['template'] = 'step_main_product';
        $this->vars['title'] = $this->config['step_main_product_title'];
        $this->vars['paragraph'] = $this->config['step_main_product_paragraph'];

        $student_count = $current_selection[0]['student_count'] ?? NULL;

        // Hardware Optionen-->
        $hardware_ids = array_map('trim', explode(',', $this->config['step_main_product_hardware_ids']));
        $remove = (NULL !== $student_count && $student_count > 400) ? (NULL !== $student_count && $student_count > 1200) ? [4,5] : [4] : [];
        $hardware_ids = array_diff($hardware_ids, $remove ?? []); 
        $this->vars['input_hardware'] = [
            'title' => $this->config['step_main_product_hardware_label'],
            'options' => array_filter(
                $this->config['step_main_product_options'],
                function($item) use ($hardware_ids) {
                    return in_array($item['id'], $hardware_ids);
                }
            )
        ];

        // Optionale Hardware Optionen-->
        $optional_hardware_ids = array_map('trim', explode(',', $this->config['step_main_product_optional_hardware_ids']));
        $this->vars['input_hardware_optional'] = [
            'title' => 'lorem ipsum',
            'options' => array_filter(
                $this->config['step_main_product_options'],
                function($item) use ($optional_hardware_ids) {
                    return in_array($item['id'], $optional_hardware_ids);
                }
            )
        ];

        // Cloud Optionen -->
        $cloud_ids = array_map('trim', explode(',', $this->config['step_main_product_cloud_ids']));
        $remove = (NULL !== $student_count && $student_count > 400) ? (NULL !== $student_count && $student_count > 1200) ? [7,8] : [7] : [];
        $cloud_ids = array_diff($cloud_ids, $remove ?? []); 
        $this->vars['input_cloud'] = [
            'title' => $this->config['step_main_product_cloud_label'],
            'options' => array_filter(
                $this->config['step_main_product_options'],
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
            $this->error = $this->config['step_main_product_error_1'] ?? 'Missing required field \'main_product\''; 
            return false; 
        }
        $this->user_input = [
            'main_product' => (int) $post_vars['main_product'],
            'main_product_optional' => (int) ($post_vars['main_product_optional'] ?? NULL)     
        ];
        return true;
    }
}
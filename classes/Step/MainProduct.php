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

        $this->vars['input_hardware'] = [
            'title' => 'Hardware Lösungen',
            'options' => [
                [
                    'id' => 1,
                    'name' => 'Portal-M',
                    'summary_name' => 'Server Hardware Portal-M',
                    'price' => 4595,
                    'price_info' => 'einmalig',
                    'price_class' => 1
                ],
                [
                    'id' => 2,
                    'name' => 'Portal-L',
                    'summary_name' => 'Server Hardware Portal-L',
                    'price' => 6595,
                    'price_info' => 'einmalig',
                    'price_class' => 1
                ],
                [
                    'id' => 3,
                    'name' => 'Portal-XL',
                    'summary_name' => 'Server Hardware Portal-XL',
                    'price' => 11595,
                    'price_info' => 'einmalig',
                    'price_class' => 1
                ]
            ]
        ];
        if($current_selection[0]['student_count'] > 400) {
            unset($this->vars['input_hardware']['options'][0]);
        }
        if($current_selection[0]['student_count'] > 1200) {
            unset($this->vars['input_hardware']['options'][0]);
        }

        $this->vars['input_cloud'] = [
            'title' => 'Cloud Lösungen',
            'options' => [
                [
                    'id' => 4,
                    'name' => 'Hosting-M',
                    'summary_name' => 'Cloud-IServ Hosting-M',
                    'price' => 250,
                    'price_info' => 'jährlich',
                    'price_class' => 2
                ],
                [
                    'id' => 4,
                    'name' => 'Hosting-L',
                    'summary_name' => 'Cloud-IServ Hosting-L',
                    'price' => 450,
                    'price_info' => 'jährlich',
                    'price_class' => 2
                ],
                [
                    'id' => 5,
                    'name' => 'Hosting-XL',
                    'summary_name' => 'Cloud-IServ Hosting-XL',
                    'price' => 800,
                    'price_info' => 'jährlich',
                    'price_class' => 2
                ],
            ]
        ];
        if($current_selection[0]['student_count'] > 400) {
            unset($this->vars['input_cloud']['options'][0]);
        }
        if($current_selection[0]['student_count'] > 1200) {
            unset($this->vars['input_cloud']['options'][0]);
        }
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
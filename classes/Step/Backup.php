<?php
namespace Grav\Plugin\IServConfigurator\Step;

use Grav\Plugin\IServConfigurator\ConfiguratorException;


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
        $this->vars['title'] = 'Backup Lösung wählen';//$config['step_backup_title'];
        $this->vars['paragraph'] = 'Lorem ispum dolor sit amet';//$config['step_backup_paragraph'];

        if(in_array($current_selection[1]['main_product'], [1,2])) {
            $this->vars['input_backup_hardware'] = [
                'id' => 1,
                'name' => 'Backup-L',
                'summary_name' => 'Backup Hardware Backup-L',
                'price' => 995,
                'price_info' => 'einmalig',
                'price_class' => 1
            ];

        } elseif(in_array($current_selection[1]['main_product'], [3])) {
          
            $this->vars['input_backup_hardware'] = [
                'id' => 1,
                'name' => 'Backup-XL',
                'summary_name' => 'Backup Hardware Backup-XL',
                'price' => 1395,
                'price_info' => 'einmalig',
                'price_class' => 1
            ];
        }
        
        $this->vars['input_backup_cloud'] = [
            'id' => 3,
            'name' => 'Cloud-Backup',
            'summary_name' => 'Cloud-Backup',
            'price' => [
                [
                    'value' => 200,
                    'price_info' => 'jährlich',
                    'price_class' => 1
                ],
                [
                    'value' => (in_array($current_selection[0]['schooltype'], [1,2])) ? 150 : 200,
                    'price_info' => 'jährlich',
                    'price_class' => 2
                ]
            ]
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
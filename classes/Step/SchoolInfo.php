<?php
namespace Grav\Plugin\IServConfigurator\Step;

use Grav\Plugin\IServConfigurator\ConfiguratorException;


class SchoolInfo implements StepInterface
{
    public $vars = [];

    public function __construct($id)
    {
        $this->vars['step_id'] = $id;
    }

    public function setup(array $config, array $current_selection) : void
    {
        $this->vars['template'] = 'step_school_info';
        $this->vars['title'] = $config['step_school_info_title'];
        $this->vars['paragraph'] = $config['step_school_info_paragraph'];

        $this->vars['input_schooltype'] = [
            'title' => 'Schulform wählen',
            'options' => [
                [
                    'id' => 1,
                    'name' => 'Grund- oder Förderschule',
                    'summary_name' => 'jährl. pro-Kopf-Gebühr für Grund- und Förderschulen',
                    'price' => 4,
                    'price_info' => 'pro SchülerIn und Jahr',
                    'price_class' => 3
                ],
                [
                    'id' => 2,
                    'name' => 'Weiterführende Schule',
                    'summary_name' => 'jährl. pro-Kopf-Gebühr für Weiterführende Schulen',
                    'price' => 5,
                    'price_info' => 'pro SchülerIn und Jahr',
                    'price_class' => 3
                ],
                [
                    'id' => 3,
                    'name' => 'Berufsschule',
                    'summary_name' => 'jährl. pro-Kopf-Gebühr für Berufsschulen',
                    'price' => 6,
                    'price_info' => 'pro SchülerIn und Jahr',
                    'price_class' => 3
                ]
            ]
        ];
        $this->vars['input_student_count'] = [
            'id' => 4,
            'title' => 'Wieviele Schüler besuchen Ihre Schule?'
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

    public function getVars() : array
    {
        return $this->vars;
    }

    public function getInput() : array
    {
        return $this->user_input;
    }
}
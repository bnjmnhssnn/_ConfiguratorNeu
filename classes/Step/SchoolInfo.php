<?php
namespace Grav\Plugin\IServConfigurator\Step;

class SchoolInfo implements StepInterface
{
    public function __construct(array $config)
    {
        $this->template = 'step_school_info';
        $this->title = $config['step_school_info_title'];
        $this->paragraph = $config['step_school_info_paragraph'];

    }

    public function getTemplate()
    {


    }


    public function get()
    {
       
    }    
}
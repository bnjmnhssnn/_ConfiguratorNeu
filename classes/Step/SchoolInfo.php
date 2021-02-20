<?php
namespace Grav\Plugin\IServConfigurator\Step;

use Grav\Common\Config\Config;

class SchoolInfo implements StepInterface
{
    public function __construct(Config $config)
    {
        $this->template = 'step_school_info';
        $data = $config->get('plugins.i-serv-configurator');
        $this->title = $data['step_school_info_title'];
        $this->paragraph = $data['step_school_info_paragraph'];

    }

    public function getTemplate()
    {


    }


    public function get()
    {
       
    }    
}
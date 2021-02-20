<?php
namespace Grav\Plugin\IServConfigurator\Step;

use Grav\Common\Config\Config;

class MainProduct implements StepInterface
{
    public function __construct(Config $config)
    {
        $this->template = 'step_main_product';
        $data = $config->get('plugins.i-serv-configurator');
        $this->title = $data['step_main_product_title'];
        $this->paragraph = $data['step_main_product_paragraph'];

    }

    public function getTemplate()
    {


    }


    public function get()
    {
       
    }    
}
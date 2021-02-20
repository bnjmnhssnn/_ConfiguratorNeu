<?php
namespace Grav\Plugin\IServConfigurator\Step;

class MainProduct implements StepInterface
{
    public function __construct(array $config)
    {
        $this->template = 'step_main_product';
        $this->title = $config['step_main_product_title'];
        $this->paragraph = $config['step_main_product_paragraph'];

    }

    public function getTemplate()
    {


    }


    public function get()
    {
       
    }    
}
<?php
namespace Grav\Plugin\IServConfigurator;

class Summary
{
    protected $configurator_steps;

    public function __construct(array $configurator_steps)
    {
        $this->configurator_steps = $configurator_steps;     
    }

    public function getVars(array $current_selection) : array
    {
        $summary_items = [];

        foreach($current_selection as $step_selection) {
           

            



        }

        $summary_items[] = [
            'name' => 'Grundgebühr pro Jahr',
            'price' => 250,
            'price_info' => 'jährlich',
            'price_class' => 2
        ];
        $summary_items[] = [
            'name' => 'Einrichtungspauschale',
            'price' => 500,
            'price_info' => 'einmalig',
            'price_class' => 1
        ];

    }



}
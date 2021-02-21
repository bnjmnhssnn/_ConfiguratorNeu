<?php
namespace Grav\Plugin\IServConfigurator\Step;

interface StepInterface
{
    public function __construct(array $config, int $id);    
    public function setup(array $current_selection) : void;
    public function confirm(array $post_vars, array $current_selection) : bool;
    public function getVars() : array;  
    public function getInput() : array;
}

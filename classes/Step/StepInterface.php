<?php
namespace Grav\Plugin\IServConfigurator\Step;

interface StepInterface
{
    public function __construct(int $id);    
    public function setup(array $config, array $current_selection) : void;
    public function confirm(array $post_vars, array $current_selection) : bool;
    public function getVars() : array;  
    public function getInput() : array;
}

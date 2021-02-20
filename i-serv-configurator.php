<?php
namespace Grav\Plugin;

use Composer\Autoload\ClassLoader;
use Grav\Common\Plugin;
use Grav\Plugin\IServConfigurator\Configurator;
use Grav\Plugin\IServConfigurator\ConfiguratorException;



/**
 * Class IServConfiguratorPlugin
 * @package Grav\Plugin
 */
class IServConfiguratorPlugin extends Plugin
{

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0]
        ];
    }

    /**
    * Composer autoload.
    *is
    * @return ClassLoader
    */
    public function autoload(): ClassLoader
    {
        return require __DIR__ . '/vendor/autoload.php';
    }

    public function onPluginsInitialized(): void
    {
        if ($this->isAdmin()) {
            return;
        }
        $config = $this->config();
        $uri = $this->grav['uri'];
        switch (ltrim($uri->getCurrentRoute(), '/')) {

            case $config['main_route']:
                $this->enable(
                    [
                        'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
                        'onTwigSiteVariables' => ['onTwigSiteVariables', 0],
                        'onPageInitialized' => ['onPageInitialized', 0],
                    ]   
                );
                break;   

            case $config['post_route']:
                $session = $this->grav['session'];
                $configurator = new Configurator(
                    $config,
                    $session->configurator   
                );
                if(isset($_POST['action_confirm'])) {
                    if($configurator->confirmCurrentStep($_POST)) {
                        $session->configurator = $configurator->state();
                        header("Location: /" . $config['main_route']);
                        exit;

                    } else {
                        echo 'Fehler';
                        exit;
                    }
                } elseif (isset($_POST['action_back'])) {
                    if($configurator->back()) {
                        $session->configurator = $configurator->state();
                        header("Location: /" . $config['main_route']);
                        exit;
                    } else {
                        throw new ConfiguratorException('Method ' . Configurator::class . '::back() returned false.');
                    }
                }   
            

            
        }
        

        $this->enable(
            [
                'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
                'onTwigSiteVariables' => ['onTwigSiteVariables', 0],
                'onPageInitialized' => ['onPageInitialized', 0],
            ]   
        );
    }


    public function onPageInitialized()
    {
      
    }


    /**
     * [onTwigTemplatePaths] Add twig paths to plugin templates.
     */
    public function onTwigTemplatePaths()
    {
        $twig = $this->grav['twig'];
        $twig->twig_paths[] = __DIR__ . '/templates';
    }

    /**
     * [onTwigSiteVariables] Set all twig variables for generating output.
     */
    public function onTwigSiteVariables()
    {
        $this->grav['assets']->addJs('plugin://i-serv-configurator/assets/configurator.js');
        $this->grav['assets']->addCss('plugin://i-serv-configurator/assets/configurator.css'); 

        $configurator = new Configurator(
            $this->config(), 
            $this->grav['session']->configurator
        );  

        $twig = $this->grav['twig'];
        $twig->twig_vars['configurator'] = $configurator->outputCurrent();   
    }
}
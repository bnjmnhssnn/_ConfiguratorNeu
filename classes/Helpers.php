<?php
namespace Grav\Plugin\IServConfigurator;

class Helpers
{
    public static function applySwitches(array $options, array $configurator_selection) : array
    {
        $switch_filter = self::getSwitchFilter($configurator_selection);
        // Artikel werden abhängig ein/oder ausgeblendet
        $options = array_values(array_filter(
            $options,
            $switch_filter
        ));
        // Preise werden abhängig ein/oder ausgeblendet
        return array_map(
            function($option) use ($switch_filter) {
                if(self::isComplexPrice($option['price'])) {
                    $option['price'] = array_values(array_filter(
                        $option['price'],
                        $switch_filter
                    ));
                }
                return $option;
            },
            $options
        );
    }

    public static function getSwitchFilter(array $configurator_selection) : \Closure
    {
        $selected_ids = [];
        // Filtere Nicht-ID-Werte (aktuell nur student_count)
        foreach($configurator_selection as $selection) {
            foreach($selection as $key => $value) {
                if(!in_array($key, ['student_count'])) {
                    $selected_ids[] = (int) $value;    
                }
            }
        } 
        return function(array $option) use ($selected_ids) {
            if (empty($selected_ids)) {
                return true;
            }
            if (isset($option['on_switch'])) {
                $type = 'on';
                $switch_value = $option['on_switch'];
            } elseif (isset($option['off_switch'])) {
                $type = 'off';
                $switch_value = $option['off_switch'];
            } else {
                return true;
            }
            if(is_string($switch_value)) {
                $switch_ids = array_map('intval', array_map('trim', explode(',', $switch_value)));
            } elseif (is_int($switch_value)) {
                $switch_ids = [$switch_value];  
            } else {
                throw new ConfiguratorException('Invalid switch value provided, must be either integer or comma-separated string.');
            }
            $intersection = array_intersect($selected_ids, $switch_ids);
            if($type === 'on') {
                return !empty($intersection);
            } elseif ($type === 'off') {
                return empty($intersection);   
            }
        };
    }

    public static function isComplexPrice(array $price) : bool
    {
        return (array_keys($price) === range(0, count($price) - 1));   
    }
}
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
        $lines = [
            [
                'name' => 'Grundgebühr (jährlich)',
                'price' => 250
            ],
            [
                'name' => 'Einrichtungspauschale (einmalig)',
                'price' => 500
            ]
        ];
        $total_first_year = 750;
        $total_yearly = 500;

        foreach($current_selection as $step_index => $step_state) {

            $step_data = $this->configurator_steps[$step_index]->getVars();

            switch($step_index) {

                // Schritt 1 Schultyp & Schüleranzahl
                case 0:
                    $option_id = $step_state['schooltype'];
                    $student_count = $step_state['student_count'];
                    $option = $this->optionById($step_data['input_schooltype']['options'], $option_id);
                    if(Helpers::isComplexPrice($option['price'])) {
                        throw new ConfiguratorException('Complex Prices are not supported by Schooltype step, yet.');
                    }
                    $price = $option['price']['value'] * $student_count;
                    $lines[] = [
                        'name' => sprintf($option['summary_name'], $student_count),
                        'price' => $price
                    ];
                    $total_first_year += $price;
                    $total_yearly += $price;
                    break;

                // Schritt 2 Hauptprodukt
                case 1:
                    $option_id = $step_state['main_product'];
                    try {
                        $options = [$this->optionById($step_data['input_hardware']['options'], $option_id)];
                        if(!empty($optional_id = $step_state['main_product_optional'])) {
                            $options[] = $this->optionById($step_data['input_hardware_optional']['options'], $optional_id);
                        }
                    } catch (ConfiguratorException $e) {
                        $options = [$this->optionById($step_data['input_cloud']['options'], $option_id)];
                    } 
                    
                    foreach($options as $option) {
                        $price = $option['price'];
                        if(Helpers::isComplexPrice($price)) {
                            throw new ConfiguratorException('Complex Prices are not supported by Main Product step, yet.');
                        }
                        $lines[] = [
                            'name' => $option['summary_name'],
                            'price' => $price['value']
                        ];
                        $total_first_year += $price['value']; 
                    }   
                    break;

                // Schritt 3 Backuplösung
                case 2:
                    $option_id = $step_state['backup'];
                    $option = $this->optionById($step_data['input_backup']['options'], $option_id);
                    $price = $option['price'];
                    if(Helpers::isComplexPrice($price)) {
                        foreach($price as $sub_price) {
                            $lines[] = [
                                'name' => $sub_price['summary_name'],
                                'price' => $sub_price['value']
                            ];
                            $total_first_year += $sub_price['value'];    
                            if ($sub_price['class'] === 2) {
                                $total_yearly += $sub_price['value'];
                            }
                        }
                    } else {
                        $lines[] = [
                            'name' => $option['summary_name'],
                            'price' => $price['value']
                        ];
                        $total_first_year += $price['value'];  
                        if ($price['class'] === 2) {
                            $total_yearly += $price['value'];
                        }
                    }
                    break;
                
                default:
                    throw new ConfiguratorException("No summary action defined for step index {$step_index}.");
            }
        }
        return [
            'lines' => $lines,
            'totals' => [
                [
                    'name' => 'Kosten im ersten Jahr',
                    'price' => $total_first_year
                ],
                [
                    'name' => 'jährl. Kosten Folgejahre',
                    'price' => $total_yearly
                ]
            ]
        ];
    }

    protected function optionById(array $options, $id)
    {
        foreach($options as $option) {
            if($id == $option['id']) {
                return $option;
            }
        }
        throw new ConfiguratorException("Option {$id} not found.");
    }

    





}
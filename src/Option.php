<?php

namespace Phals;

/**
 * Class Option
 * @package Phals
 */
class Option implements OptionInterface
{
    private $type;
    private $options;

    /**
     * Option constructor.
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;

        $this->type = Application::TYPE_NORMAL_CLASS;
        if($options['interface'])
        {
            $this->type = Application::TYPE_INTERFACE;
        } elseif ($options['abstract'])
        {
            $this->type = Application::TYPE_ABSTRACT_CLASS;
        }elseif($options['final'])
        {
            $this->type = Application::TYPE_FINAL_CLASS;
        }
    }

    /**
     * Check if the a specific option is set to true and the rest should be set to false
     * @param $name
     * @return bool
     */
    public function isTrue($name)
    {
        $hold = false;
        if($this->options[$name]) {
            $hold =  true;

            foreach ($this->options as $key => $value) {
                if ($value) {
                    $hold = false;
                }
            }
        }
        return $hold;
    }

    /**
     * @return int
     */
    public function getType(){
        return $this->type;
    }
}
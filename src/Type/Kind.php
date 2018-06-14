<?php

namespace Phals\Type;

/**
 * Class Kind
 * @package Phals\Type
 */
abstract class Kind
{
    protected $name;

    protected $namespace;

    protected $description;

    private static $templates = [
        NormalClass::class => 'normal_class.dist',
        InterfaceKind::class => 'interface.dist',
        AbstractClass::class => 'abstract_class.dist',
        FinalClass::class => 'final_class.dist'
    ];

    public function __construct(string $name, string $namespace = null, $description = null)
    {
        $this->name = $name;
        $this->namespace = $namespace;
        $this->description = $description;
    }

    /**
     * @return string
     */
    protected function setCode()
    {
        return strtr($this->getTemplate(), [
            '{{ class_name }}' => $this->name,
            '{{ namespace }}' => $this->namespace,
            '{{ description }}' => $this->description
        ]);
    }

    public function getSourceCode()
    {
        if ($this->description !== null) {
            $this->description = <<<DESCRIPTION
/**
*   $this->description
*/
DESCRIPTION;
        }


        $this->name = ucfirst($this->name);

        return $this->setCode();
    }

    protected function getTemplate()
    {
        $template = self::$templates[get_class($this)];
        return file_get_contents(__DIR__ . "/../templates/{$template}");
    }
}
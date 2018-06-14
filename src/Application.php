<?php


namespace Phals;

use Phals\Type\AbstractClass;
use Phals\Type\FinalClass;
use Phals\Type\InterfaceKind;
use Phals\Type\NormalClass;

/**
 * Class Application
 * @package Phals
 */
class Application
{
    const TYPE_NORMAL_CLASS = 1;
    const TYPE_FINAL_CLASS = 2;
    const TYPE_ABSTRACT_CLASS = 3;
    const TYPE_INTERFACE = 4;
    /** @var string */
    private $fully_qualified_name;
    /** @var string */
    private $class_name;
    /** @var string */
    private $package;
    /** @var  string */
    private $description;
    /** @var string */
    private $type;
    /** @var OptionInterface $option */
    private $option;

    /**
     * Application constructor.
     * @param string $fully_qualified_name
     * @param OptionInterface $option
     * @internal param array $options
     */
    public function __construct(string $fully_qualified_name,OptionInterface $option)
    {
        $this->fully_qualified_name = $fully_qualified_name;
        $this->extractNameAndNamespace($fully_qualified_name);
        $this->option = $option;
    }

    /**
     * @return mixed
     */
    public function getFullyQualifiedName()
    {
        return $this->fully_qualified_name;
    }

    /**
     * @param mixed $fully_qualified_name
     */
    public function setFullyQualifiedName($fully_qualified_name)
    {
        $this->fully_qualified_name = $fully_qualified_name;
    }

    /**
     * @return string
     */
    public function getSourceCode()
    {
        if($this->description !== null)
        {
            $this->description = <<<DESC
/**
* $this->description
*/
DESC;

        }

        if($this->option->getType() === self::TYPE_NORMAL_CLASS)
        {
            $normal_class =  new NormalClass($this->class_name,$this->package);
            return $normal_class->getSourceCode();
        }

        if($this->option->getType() === self::TYPE_INTERFACE)
        {
            $interface = new InterfaceKind($this->class_name,$this->package);
            return $interface->getSourceCode();
        }
        if($this->option->getType() ===  self::TYPE_ABSTRACT_CLASS)
        {
            $abstract = new AbstractClass($this->class_name,$this->package);
            return $abstract->getSourceCode();
        }
        if($this->option->getType() === self::TYPE_FINAL_CLASS)
        {
            $final = new FinalClass($this->class_name,$this->package);
            return $final->getSourceCode();
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Load template file
     * @return string
     */
    protected function loadTemplate(): string
    {
        return file_get_contents(__DIR__ . '/templates/class.php.dist');
    }

    /**
     * @param string $fully_qualified_name
     */
    protected function extractNameAndNamespace(string $fully_qualified_name): void
    {
        $location = explode("\\", $fully_qualified_name);
        $this->class_name = ucfirst($location[count($location) - 1]);
        $this->package = implode("\\", $location);
    }

}
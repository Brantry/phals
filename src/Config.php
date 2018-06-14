<?php


namespace Phals;
use Exception\AutoloadObjectNotFound;
use Phals\Exception\ComposerConfigNotFound;

/**
 * This class will load/extract the information needed from the composer.json
 * @package Phals
 * @author Denzyl Dick <denzyl@live.nl>
 */
class Config
{
    /**
     * @var array
     */
    private $autoload;
    /**
     * @var array
     */
    private $authors;
    /**
     * @var string
     */
    private $location;

    /**
     * Config constructor.
     * @param string $path
     * @param string $file
     * @throws \Exception
     */
    public function __construct($path = '/..', $file = 'composer.json')
    {
        if (file_exists("{$path}{$file}") === false) {
            throw new ComposerConfigNotFound("Composer configuration file doesn't exists in {$path}");
        }
        $this->location = $path . '/' . $file;
        $this->decodeConfiguration();
    }

    /**
     * @throws \Exception
     */
    private function decodeConfiguration()
    {
        $json = json_decode(file_get_contents($this->location), true);
        if (isset($json['authors'])) {
            $this->authors = $json['authors'];
        }
        if(isset($json['autoload']) === false)
        {
            throw new AutoloadObjectNotFound('You need to specify an autoload in your composer.json file');
        }
        $this->autoload = $json['autoload'];
    }

    /**
     * Get the name of the authors in the composer file
     * @return array
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * @return array
     */
    public function getAutoload()
    {
        return $this->autoload;
    }
}
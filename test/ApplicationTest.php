<?php

use Phals\Application;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    public function testClass()
    {
        $result = <<<RESULT
<?php

namespace App\Models\Car;

class Car{

}
RESULT;
        $option = new \Phals\Option(['interface' => false,'abstract'=>false,'final'=>false]);
        $template = new Application("App\\Models\\Car", $option);
        $this->assertEquals($result, $template->getSourceCode());
    }

    public function testInterface()
    {
        $result = <<<RESULT
<?php

namespace App\Models\Car;

interface Car{

}
RESULT;
        $option = new \Phals\Option(['interface' => true,'abstract'=>false,'final'=>false]);
        $template = new Application("App\\Models\\Car",$option );
        $this->assertEquals($result, $template->getSourceCode());
    }

    public function testDescription()
    {
        $description = "hello world";
        $result = <<<RESULT
<?php

namespace App\Models\Car;

interface Car{

}
RESULT;
        $option = new \Phals\Option(['interface' => true,'abstract'=>false,'final'=>false]);
        $template = new Application("App\\Models\\Car",$option );
        $template->setDescription($description);
        $this->assertEquals($result, $template->getSourceCode());
    }
}

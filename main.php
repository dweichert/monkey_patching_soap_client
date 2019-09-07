<?php

namespace MyApp;

class SoapClient extends \SoapClient
{

    public function __construct($wsdl, array $options = NULL)
    {
    }

    public function __soapCall($function_name, $arguments, $options = NULL, $input_headers = NULL, &$output_headers = NULL)
    {
        $obj = new \stdClass();
        $obj->AddResult = 4;

        return $obj;
    }
}

eval("namespace MyApp;" . file_get_contents(__DIR__ . "/Legacy/Foo.php", FALSE, NULL, 5));

$foo = new \MyApp\Foo();

echo $foo->soapFoo() . "\n";

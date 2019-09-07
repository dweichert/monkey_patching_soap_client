<?php

class Foo
{

    public function soapFoo()
    {
        $wsdl = __DIR__ . '/example.wsdl';

        $arrContextOptions = [
            "ssl" => [
                "verify_peer" => FALSE,
                "verify_peer_name" => FALSE,
                'crypto_method' => STREAM_CRYPTO_METHOD_TLS_CLIENT,
            ],
        ];

        $options = [
            'soap_version' => SOAP_1_2,
            'exceptions' => TRUE,
            'trace' => 1,
            'cache_wsdl' => WSDL_CACHE_NONE,
            'stream_context' => stream_context_create($arrContextOptions),
        ];

        $client = new SoapClient($wsdl, $options);
        $response = $client->__soapCall('Add', [
            'Add' => [
                'intA' => 1,
                'intB' => 2,
            ],
        ]);

        return (int) $response->AddResult;
    }
}

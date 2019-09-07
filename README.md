# Monkey patching PHP's SoapClient

This example shows how to replace an object instance for an instance of another class
at runtime in PHP, this is also called
"[monkey patching](https://en.wikipedia.org/wiki/Monkey_patch)".

This technique can be useful if you cannot or do not want to refactor the class you
want to test and it instantiates a dependency with *new*. A typical situation where
you would want to do this is testing of legacy code.

Since PHP does not allow redeclaring classes at runtime we resort to another option.
We do not load the class (which would then live in the global Namespace) using a
standard way (e.g. autoloader, require, ...), but instead declare the class inside
our (namespaced) file using the *eval* and *file_get_contents* functions: cutting off
the *<?php* declaration at the beginning of the legacy class's file and prepending
the namespace (see: [main.php](main.php) line 21). 

    eval("namespace MyApp;" . file_get_contents(__DIR__ . "/Legacy/Foo.php", FALSE, NULL, 5));
    
Since we declared a SoapClient class in our own namespace (see: lines 5-19 in
[main.php](main.php)), the instantiation of the SoapClient (see: line 26 of
[the legacy class](Legacy/Foo.php)) no longer creates an instance of the PHP standard
SOAP client, but an instance of *MyApp\SoapClient* because the instantiating code reads

    new SoapClient();
    
rather than

    new \SoapClient();
    
and thus we can overwrite any unwanted behaviour (such as making actual SOAP calls)
in our monkey patched SoapClient.

<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Commands Location
    |--------------------------------------------------------------------------
    |
    | Specify the base path for the commands used in the project.
    |
    */
    'command_namespace' => 'App\Commands',

    /*
    |--------------------------------------------------------------------------
    | Command Handlers Location
    |--------------------------------------------------------------------------
    |
    | Specify the base path for the command handlers used in the project.
    |
    */
    'handler_namespace' => 'App\Handlers\Commands',

    /*
    |--------------------------------------------------------------------------
    | Command Name Extractor
    |--------------------------------------------------------------------------
    |
    | Specify the command name extractor used in the project. It must implement
    | League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor interface.
    |
    */
    'extractor' => League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor::class,

    /*
    |--------------------------------------------------------------------------
    | Method Name Inflector
    |--------------------------------------------------------------------------
    |
    | Specify the method name inflector used in the project. It must implement
    | League\Tactician\Handler\MethodNameInflector\MethodNameInflector interface.
    |
    */
    'inflector' => League\Tactician\Handler\MethodNameInflector\HandleInflector::class,

    /*
    |--------------------------------------------------------------------------
    | Handler Locator
    |--------------------------------------------------------------------------
    |
    | Specify the locator for the handlers used in the project. It must
    | implement League\Tactician\Handler\Locator\HandlerLocator interface.
    |
    */
    'locator' => GearHub\Tactician\Locator::class,

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | Add desired middleware to the command bus. Execution will occur in
    | sequential order.
    |
    */
    'middleware' => [
        //App/Path/To/Your/Middleware,
        //or App/Path/To/Your/Middleware::class
    ]

];

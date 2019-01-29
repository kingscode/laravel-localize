<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Locale
    |--------------------------------------------------------------------------
    |
    | This option makes it so that "/en/home" is never shown but "/home" is.
    |
    */
    'default_locale'      => 'en',

    /*
    |--------------------------------------------------------------------------
    | Route options
    |--------------------------------------------------------------------------
    |
    | Route parameter key: the route parameter thus: "{locale}/home".
    | Route name prefix: the prefix for the route name thus: "localized.home".
    */
    'route_parameter_key' => 'locale',
    'route_name_prefix'   => 'localized',
];

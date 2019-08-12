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
    'default_locale'         => 'en',

    /*
    |--------------------------------------------------------------------------
    | Route options
    |--------------------------------------------------------------------------
    |
    | Route parameter key: the route parameter thus: "{locale}/home".
    |
    | Route name prefix: the prefix for the route name thus: "localized.home".
    |
    | Route forget parameter: whether the parameter should be forgotten
    |                         and thus not injected into the controller.
    |
    */
    'route_parameter_key'    => 'locale',
    'route_name_prefix'      => 'localized',
    'route_forget_parameter' => true,
	'route_prefix_options' 	 => ['nl', 'de'],
];

<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'admin' => [    
                      
        'user' => [
            'name' => 'User',
            'actions' => [
                'view' => 'admin/user',
            ],
            'icon' => 'ti-user'
        ],

        'image' => [
            'name' => 'Image',
            'actions' => [
                'view' => 'admin/image',
            ],
            'icon' => 'ti-gallery'
        ],
        

    ],

];

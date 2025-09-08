<?php

return [

    'pdf' => [
        'enabled' => true,
        'binary'  => env('WKHTMLTOPDF_BINARY', 'C:\\wkhtmltopdf\\bin\\wkhtmltopdf.exe'),
        'timeout' => false,
        'options' => [
            'enable-local-file-access' => true,
        ],
        'env'     => [],
    ],

    'image' => [
        'enabled' => true,
        'binary'  => env('WKHTMLTOIMAGE_BINARY', 'C:\\wkhtmltopdf\\bin\\wkhtmltoimage.exe'),
        'timeout' => false,
        'options' => [
            'enable-local-file-access' => true,
        ],
        'env'     => [],
    ],

];

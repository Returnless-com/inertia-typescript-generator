<?php

declare(strict_types=1);

return [

    /**
     * This is the root path of your typescript project.
     */
    'output_path' => resource_path('ts'),

    /**
     * This is the path where the generated typescript files will be stored.
     */
    'page_path' => 'Pages',

    /**
     * These are the commands that will be run after the typescript files are generated.
     */
    'after_generate' => [
        'prettier' => [
            '--write',
        ],
        'eslint' => [
            '--fix',
        ],
    ],

];

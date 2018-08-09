<?php

return [

    'default' => 'devserverweb',

    'subdomains' => [

        'parent' => [

            'features' => [
                'messages',
                'resources'
            ]
        ],
        'teacher' => [

            'features' => [
                'messages',
                'video-center',
                'instructional-design',
                'learning-modules',
                'resources'
            ]
        ],
        'master_teacher' => [

            'features' => [
                'messages',
                'video-center',
                'instructional-design',
                'learning-modules',
                'resources'
            ]
        ],
        'school_leader' => [

            'features' => [
                'messages',
                'video-center',
                'instructional-design',
                'learning-modules',
                'resources'
            ]
        ],
        'project_admin' => [

            'features' => [
                'messages',
                'video-center',
                'instructional-design',
                'learning-modules',
                'resources'
            ]
        ],
        'super_admin' => [

            'features' => [
                'messages',
                'video-center',
                'instructional-design',
                'learning-modules',
                'resources',
                'users'
            ]
        ]

    ]
];

<?php

return [
    [
        'name'     => 'Dashboard',
        'label'    => 'Dashboard',
        'icon'     => 'dashboard',
        'url'      => route('admin.dashboard'),
        'priority' => 0
    ],
    [
        'name'     => 'Content',
        'icon'     => 'cubes',
    ],
    [
        'name'     => 'Settings',
        'icon'     => 'cog',
        'children' => [
            [
                'name' => 'Information',
                'url'  => route('admin.information'),
                'icon' => 'info-circle',
            ]
        ]
    ],
    [
        'name'     => 'Multi-Level Dropdown',
        'icon'     => 'sitemap',
        'children' => [
            [
                'name' => 'Second Level Item',
                'url'  => route('admin.information')
            ],
            [
                'name' => 'Second Level Item',
                'url'  => route('admin.information')
            ],
            [
                'name' => 'Third Level',
                'children' => [
                    [
                        'name' => 'Third Level Item',
                        'url'  => route('admin.information')
                    ],
                    [
                        'name' => 'Third Level Item',
                        'url'  => route('admin.information')
                    ],
                    [
                        'name' => 'Third Level Item',
                        'url'  => route('admin.information')
                    ],
                ]
            ],
        ]
    ]
];
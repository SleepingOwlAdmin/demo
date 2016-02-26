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
        'name'     => 'Companies',
        'icon'     => 'cubes',
    ],
    [
        'name'     => 'Contacts',
        'icon'     => 'credit-card',
    ],
    [
        'name'     => 'Content',
        'icon'     => 'newspaper-o',
    ],
    [
        'name'     => 'Permissions',
        'icon'     => 'group',
    ],
    [
        'name'     => 'Settings',
        'icon'     => 'cog',
        'priority' => 400,
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
        'priority' => 500,
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
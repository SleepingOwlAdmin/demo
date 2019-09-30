<?php

/**
 * @var \SleepingOwl\Admin\Contracts\Navigation\NavigationInterface $navigation
 * @see http://sleepingowladmin.ru/docs/menu_configuration
 */

use SleepingOwl\Admin\Navigation\Page;

$navigation->setFromArray([
    [
        'title' => "Contacts",
        'icon' => 'fa fa-credit-card',
        'priority' =>'1000',
        'pages' => [
            (new Page(\App\Model\Contact::class))
                ->setIcon('fas fa-fax')
                ->setPriority(0),
            (new Page(\App\Model\Contact2::class))
                ->setIcon('fa fa-fax')
                ->setPriority(100),
            (new Page(\App\Model\Contact3::class))
                ->setIcon('fa fa-fax')
                ->setPriority(200),
            (new Page(\App\Model\Contact4::class))
                ->setIcon('fa fa-fax')
                ->setPriority(400),
        ]
    ],
    [
        'title' => "Content",
        'icon' => 'fas fa-newspaper',
        'priority' =>'1000',
        'pages' => [
            (new Page(\App\Model\News::class))
                ->setIcon('fas fa-newspaper')
                ->setPriority(0),
            (new Page(\App\Model\News2::class))
                ->setIcon('fas fa-newspaper')
                ->setPriority(10),
            (new Page(\App\Model\News3::class))
                ->setIcon('fas fa-newspaper')
                ->setPriority(20),
            (new Page(\App\Model\News4::class))
                ->setIcon('fas fa-newspaper')
                ->setPriority(30),
            (new Page(\App\Model\News5::class))
                ->setIcon('fas fa-newspaper')
                ->setPriority(40)
        ]
    ],
    [
        'title' => "Tabs Examples",
        'icon' => 'fas fa-newspaper',
        'priority' =>'1000',
        'id'=>'tabs-examples',

    ],

    [
        'title' => "Forms & Buttons",
        'icon' => 'fas fa-newspaper',
        'priority' =>'1001',
        'id'=>'forms-examples',
    ],
//    [
//        'title' => "JavaScript",
//        'icon' => 'glyphicon glyphicon-blackboard',
//        'priority' =>'1001',
//        'id'=>'javascript',
//        'badge' => new \SleepingOwl\Admin\Navigation\Badge('New')
//    ],

    [
        'title' => "DataTables",
        'icon' => 'far fa-newspaper',
        'priority' =>'1001',
        'id'=>'datatables',
        'badge' => new \SleepingOwl\Admin\Navigation\Badge('New')
    ],


    [
        'title' => 'Permissions',
        'icon' => 'fas fa-users-cog',
        'priority' =>'10000',
        'pages' => [
            (new Page(\App\User::class))
                ->setIcon('fas fa-users')
                ->setPriority(0),
            (new Page(\App\Role::class))
                ->setIcon('fas fa-user-shield')
                ->setPriority(100)
        ]
    ]
]);

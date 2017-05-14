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
                ->setIcon('fa fa-fax')
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
        'icon' => 'fa fa-newspaper-o',
        'priority' =>'1000',
        'pages' => [
            (new Page(\App\Model\News::class))
                ->setIcon('fa fa-newspaper-o')
                ->setPriority(0),
            (new Page(\App\Model\News2::class))
                ->setIcon('fa fa-newspaper-o')
                ->setPriority(10),
            (new Page(\App\Model\News3::class))
                ->setIcon('fa fa-newspaper-o')
                ->setPriority(20),
            (new Page(\App\Model\News4::class))
                ->setIcon('fa fa-newspaper-o')
                ->setPriority(30),
            (new Page(\App\Model\News5::class))
                ->setIcon('fa fa-newspaper-o')
                ->setPriority(40)
        ]
    ],
    [
        'title' => "Tabs Examples",
        'icon' => 'fa fa-newspaper-o',
        'priority' =>'1000',
        'id'=>'tabs-examples',

    ],

    [
        'title' => "Forms & Buttons",
        'icon' => 'fa fa-newspaper-o',
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
        'icon' => 'glyphicon glyphicon-blackboard',
        'priority' =>'1001',
        'id'=>'datatables',
        'badge' => new \SleepingOwl\Admin\Navigation\Badge('New')
    ],


    [
        'title' => 'Permissions',
        'icon' => 'fa fa-group',
        'priority' =>'10000',
        'pages' => [
            (new Page(\App\User::class))
                ->setIcon('fa fa-user')
                ->setPriority(0),
            (new Page(\App\Role::class))
                ->setIcon('fa fa-group')
                ->setPriority(100)
        ]
    ]
]);

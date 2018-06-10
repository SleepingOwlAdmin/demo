<?php

namespace Admin\Widgets;

use AdminTemplate;
use SleepingOwl\Admin\Widgets\Widget;

class NavigationNotifications extends Widget
{

    /**
     * @return string
     * @throws \Throwable
     */
    public function toHtml()
    {
        return view('admin::navigation.notifications', [
            'user' => auth()->user()
        ])->render();
    }

    /**
     * @return string|array
     */
    public function template()
    {
        return AdminTemplate::getViewPath('_partials.header');
    }

    /**
     * @return string
     */
    public function block()
    {
        return 'navbar.right';
    }
}
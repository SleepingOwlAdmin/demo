<?php

namespace App\Widgets;

use SleepingOwl\Admin\Widgets\Widget;

class NavigationUserBlock extends Widget
{

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return view('auth.partials.navbar_admin', [
            'user' => auth()->user()
        ]);
    }

    /**
     * @return string|array
     */
    public function template()
    {
        return \AdminTemplate::getViewPath('_partials.header');
    }

    /**
     * @return string
     */
    public function block()
    {
        return 'navbar.right';
    }
}
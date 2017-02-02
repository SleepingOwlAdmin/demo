<?php

namespace Admin\Widgets;

use AdminTemplate;
use SleepingOwl\Admin\Widgets\Widget;

class DashboardMap extends Widget
{

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return view('admin::dashboard');
    }

    /**
     * @return string|array
     */
    public function template()
    {
        return AdminTemplate::getViewPath('dashboard');
    }

    /**
     * @return string
     */
    public function block()
    {
        return 'block.top';
    }
}
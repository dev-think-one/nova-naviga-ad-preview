<?php

namespace NovaNavigaAdPreview;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class NovaNavigaAdPreview extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('nova-naviga-ad-preview', __DIR__.'/../dist/js/tool.js');
        Nova::style('nova-naviga-ad-preview', __DIR__.'/../dist/css/tool.css');
    }

    public function menu(Request $request)
    {
        return MenuSection::make('Naviga ad preview')
                          ->path('/nova-naviga-ad-preview')
                          ->icon('photograph');
    }
}

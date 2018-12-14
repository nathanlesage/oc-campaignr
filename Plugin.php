<?php namespace HendrikErz\Campaignr;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    /**
     * @var array Plugin dependencies
     */
    public $require = [ 'RainLab.Translate' ];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'hendrikerz.campaignr::lang.plugin.name',
            'description' => 'hendrikerz.campaignr::lang.plugin.description',
            'author'      => 'Hendrik Erz',
            'icon'        => 'icon-bullhorn'
        ];
    }

    public function registerComponents()
    {
      return [
        'HendrikErz\Campaignr\Components\Calendar' => 'campaignrCalendar',
        'HendrikErz\Campaignr\Components\EventComponent' => 'campaignrEvent',
        'Hendrikerz\Campaignr\Components\Upcoming' => 'campaignrUpcoming',
        'HendrikErz\Campaignr\Components\Ical' => 'campaignrIcal'
      ];
    }

    public function registerSettings()
    {
    }
}

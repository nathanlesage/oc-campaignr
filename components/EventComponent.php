<?php namespace HendrikErz\Campaignr\Components;

use HendrikErz\Campaignr\Models\Event;
use Cms\Classes\Page;

class EventComponent extends \Cms\Classes\ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'hendrikerz.campaignr::lang.components.event.name',
            'description' => 'hendrikerz.campaignr::lang.components.event.description'
        ];
    }

    public function defineProperties()
    {
        return [
          'eventSlug' => [
            'title'         => 'hendrikerz.campaignr::lang.components.event.slug_name',
            'description'   => 'hendrikerz.campaignr::lang.components.event.slug_description',
            'default'       => '{{ :slug }}',
            'type'          => 'string'
          ],
          'calendarPage' => [
              'title'       => 'hendrikerz.campaignr::lang.components.event.page_name',
              'description' => 'hendrikerz.campaignr::lang.components.event.page_description',
              'type'        => 'dropdown',
              'default'     => 'calendar'
          ],
          'icalPage' => [
              'title'       => 'hendrikerz.campaignr::lang.components.event.ical.page_name',
              'description' => 'hendrikerz.campaignr::lang.components.event.ical.page_description',
              'default'     => 'download/calendar',
              'type'        => 'dropdown'
          ],
          'icalPageSlug' => [
              'title'       => 'hendrikerz.campaignr::lang.components.event.ical.slug_name',
              'description' => 'hendrikerz.campaignr::lang.components.event.ical.slug_description',
              'default'     => ':slug',
              'type'        => 'string'
          ]
        ];
    }

    // Prepopulate the list of pages to link to
    public function getCalendarPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    // Prepopulate the list of pages to link to
    public function getIcalPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    // This array becomes available on the page as {{ component.event }}
    public function event()
    {
        return Event::where('slug', $this->property('eventSlug'))->get()->first();
    }


    /**
     * Inject the calendar LESS into the page style variable
     */
    public function onRun()
    {
        $this->addCss(['assets/css/event.less']);
    }
}

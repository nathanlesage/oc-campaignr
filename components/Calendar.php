<?php namespace HendrikErz\Campaignr\Components;

use HendrikErz\Campaignr\Models\Event;
use Cms\Classes\Page;

class Calendar extends \Cms\Classes\ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'hendrikerz.campaignr::lang.components.calendar.name',
            'description' => 'hendrikerz.campaignr::lang.components.calendar.description'
        ];
    }

    public function defineProperties()
    {
        return [
          'monthParam' => [
            'title'             => 'hendrikerz.campaignr::lang.components.calendar.month_name',
            'description'       => 'hendrikerz.campaignr::lang.components.calendar.month_description',
            'default'           => '{{ :month }}',
            'type'              => 'string'
          ],
          'yearParam' => [
            'title'             => 'hendrikerz.campaignr::lang.components.calendar.year_name',
            'description'       => 'hendrikerz.campaignr::lang.components.calendar.year_description',
            'default'           => '{{ :year }}',
            'type'              => 'string',
          ],
          'eventPage' => [
                'title'         => 'hendrikerz.campaignr::lang.components.calendar.page_name',
                'description'   => 'hendrikerz.campaignr::lang.components.calendar.page_description',
                'type'          => 'dropdown',
                'default'       => 'event'
          ],
          'eventSlug' => [
            'title'             => 'hendrikerz.campaignr::lang.components.calendar.slug_name',
            'description'       => 'hendrikerz.campaignr::lang.components.calendar.slug_description',
            'default'           => ':slug',
            'type'              => 'string',
          ],
          'icalPage' => [
              'title'           => 'hendrikerz.campaignr::lang.components.calendar.ical_name',
              'description'     => 'hendrikerz.campaignr::lang.components.calendar.ical_description',
              'default'         => 'download/calendar',
              'type'            => 'dropdown'
          ]
        ];
    }

    // Prepopulate the list of pages to link to
    public function getEventPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    // Prepopulate the list of pages to link to
    public function getIcalPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    // This array becomes available on the page as {{ component.events }}
    public function events()
    {
        // With the following filters, we may be able to reduce the load time of
        // this component.
        $month = ($this->property('monthParam')) ? $this->property('monthParam') : strtolower(date('F'));
        $year = ($this->property('yearParam')) ? $this->property('yearParam') : date('Y');

        // Make the variables available for the partials
        $this->page->campaignrMonth = $month;
        $this->page->campaignrYear = $year;

        return Event::all();
    }

    /**
     * Inject the calendar LESS into the page style variable
     */
    public function onRun()
    {
        $this->addCss(['assets/css/calendar.less']);
    }
}

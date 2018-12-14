<?php namespace HendrikErz\Campaignr\Components;

use HendrikErz\Campaignr\Models\Event;
use Cms\Classes\Page;
use Carbon\Carbon;

class Upcoming extends \Cms\Classes\ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'hendrikerz.campaignr::lang.components.upcoming.name',
            'description' => 'hendrikerz.campaignr::lang.components.upcoming.description'
        ];
    }

    public function defineProperties()
    {
        return [
          'sorting' => [
              'title' => 'hendrikerz.campaignr::lang.components.upcoming.sorting_title',
              'description' => 'hendrikerz.campaignr::lang.components.upcoming.sorting_description',
              'type' => 'checkbox',
              'default' => 'checked'
          ],
          'evtNumber' => [
            'title' => 'hendrikerz.campaignr::lang.components.upcoming.number_title',
            'description' => 'hendrikerz.campaignr::lang.components.upcoming.number_description',
            'default' => 3,
            'validationPattern' => '^[0-9]+$',
            'validationMessage' => 'hendrikerz.campaignr::lang.components.upcoming.number_validation'
          ],
          'eventPage' => [
              'title'         => 'hendrikerz.campaignr::lang.components.upcoming.page_title',
              'description'   => 'hendrikerz.campaignr::lang.components.upcoming.page_description',
              'type'          => 'dropdown',
              'default'       => 'event'
          ],
          'eventSlug' => [
              'title'             => 'hendrikerz.campaignr::lang.components.upcoming.slug_name',
              'description'       => 'hendrikerz.campaignr::lang.components.upcoming.slug_description',
              'default'           => ':slug',
              'type'              => 'string'
          ]
        ];
    }

    // Prepopulate the list of pages to link to
    public function getEventPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    // This array becomes available on the page as {{ component.events }}
    public function events()
    {
        $events = Event::all();
        $ret = [];

        // Only include those events that do occur in the future (either single
        // or repeating)
        foreach ($events as $event) {
          if ($event->getNextOccurrence()) {
            array_push($ret, $event);
          }
        }

        // Sort these ascending (next event on top)
        usort($ret, function ($a, $b) {
          $atime = Carbon::createFromFormat('Y-m-d H:i:s', $a->nextOccurrence);
          $btime = Carbon::createFromFormat('Y-m-d H:i:s', $b->nextOccurrence);
          if ($atime > $btime) {
            return 1;
          } elseif ($atime < $btime) {
            return -1;
          } else {
            return 0;
          }
        });

        // Now, before reversing the array, let's shrink the array to the
        // desired amount of events.
        if ($this->property('evtNumber') > 0 && $this->property('evtNumber') < sizeof($ret)) {
          $ret = array_slice($ret, 0, intval($this->property('evtNumber')));
        }

        // In case the user wants the array descending, we have to reverse the
        // array.
        if ($this->property('sorting') != '1') {
          $ret = array_reverse($ret);
        }

        return $ret;
    }
}

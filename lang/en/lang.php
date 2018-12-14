<?php
return [
    'plugin' => [
        'name' => 'Campaignr',
        'description' => 'Create and manage events, workshops, calls to action and campaigns.',
        'events' => 'All Events',
        'create' => 'Add Event',
        'calendar' => 'Calendar'
    ],
    'form' => [
      'close_confirm' => 'Do you really want to abort the event creation?'
    ],
    'fields' => [
        'tab_details' => 'Event Details',
        'tab_location' => 'Location',
        'name' => 'Event name',
        'slug' => 'Slug',
        'description' => 'Event description',
        'description_comment' => 'Add a short description for your event',
        'begins_at' => 'Event begins at',
        'ends_at' => 'Event ends at',
        'repeat' => 'Repeat event',
        'repeat_comment' => 'Check this switch, if this event is repetitive',
        'repeat_mode' => 'Every',
        'repeat_day' => 'Day',
        'repeat_week' => 'Week',
        'repeat_month' => 'Month',
        'repeat_year' => 'Year',
        'end_repeat' => 'Stop repeat on',
        'location' => [
            'street' => 'Street',
            'number' => 'House number',
            'zip' => 'ZIP Code',
            'city' => 'City',
            'country' => 'Country',
            'misc' => 'Additional Information',
            'misc_comment' => 'Additional information pertaining the location of the event.',
        ],
        'should_repeat' => 'Repeat?',
    ],
    'components' => [
        'calendar' => [
            'name' => 'Calendar',
            'description' => 'Displays a calendar for your events.',
            'month_name' => 'Month Param',
            'month_description' => 'The month URL parameter for the pagination',
            'year_name' => 'Year Param',
            'year_description' => 'The year URL parameter for the pagination',
            'page_name' => 'Event page',
            'page_description' => 'Which page should the events redirect to?',
            'slug_name' => 'Event slug',
            'slug_description' => 'The slug to be used on the event page to link to the events',
            'ical_name' => 'iCal Page',
            'ical_description' => 'Enter the link to the page containing the iCal component'
        ],
        'event' => [
            'name' => 'Event',
            'description' => 'Displays a single event.',
            'slug_name' => 'Event slug',
            'slug_description' => 'The slug to identify the event',
            'page_name' => 'Event page',
            'page_description' => 'Which page should the events redirect to?',
            'ical' => [
              'page_name' => 'iCal Page',
              'page_description' => 'Enter the link to the page containing the iCal component',
              'slug_name' => 'Event slug',
              'slug_description' => 'Enter the slug for referring to an event in your iCal component page'
            ]
        ],
        'upcoming' => [
            'name' => 'Upcoming events',
            'description' => 'Displays the next upcoming events.',
            'sorting_title' => 'Sort ascending',
            'sorting_description' => 'Uncheck to sort the events descending',
            'number_title' => 'Number of events',
            'number_description' => 'How many upcoming events should be displayed?',
            'number_validation' => 'Please insert a valid number',
            'page_title' => 'Event page',
            'page_description' => 'Which page should the events redirect to?',
            'slug_name' => 'Event slug',
            'slug_description' => 'The slug to be used on the event page to link to the events',
        ],
        'ical' => [
            'name' => 'iCal Export',
            'description' => 'Enables exporting of a single or all events to iCal.',
            'slug_name' => 'Event slug',
            'slug_description' => 'This slug is used both to limit export of this iCal to a single event and to link back to your events',
            'page_name' => 'Event page',
            'page_description' => 'The page used to display single events'
        ],
    ],
    'permissions' => [
        'tab' => 'Campaignr',
        'edit' => 'Allows editing of Campaignr events'
    ],
];

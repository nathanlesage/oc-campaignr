# Campaignr for October CMS

Engage with your fans or raise awareness for a cause with this plugin. Campaignr provides to your company the ability to create and manage events and campaigns to spread your ideas.

## Using Campaginr

To begin using this plugin, simply install it from the OctoberCMS marketplace. It requires the `rainlab.translate` plugin to make it easy for you to translate all messages. This makes it more comfortable to use this plugin without the need to override the default partials.

Then you'll need to set up your page to make the most of the plugin. To this end, Campaignr offers you four different components.

> **Note:** Please make sure to include the custom styles for the calendar into your `<head>`-tag. These styles provide basic functionality for the mobile-ready calendar. Simply include the `{% styles %}` Twig tag and include any custom styles afterwards to override certain parts of the included styling.

### Component: Calendar

This is the core component. It displays a calendar and your events in it. Just drag this component onto a page where you would like to display the calendar.

The following parts will be rendered within this plugin (using the `default.htm`):

- A heading displaying the current month and year.
- Two navigation buttons to let users navigate back and forth in time.
- A button to download your calendar in total.
- The calendar itself in tabular form, which is mobile ready by default.

It has some variables with which you can customise your calendar:

- `Month`: The parameter holding the month for the calendar.
- `Year`: The parameter holding the year for the calendar.
- `Event Page`: The page used to display single events.
- `Event Slug`: The slug name used to pass event slugs.
- `iCal Page`: Select the page where you've placed the iCal component.

### Component: Event

The event component just displays a single event with all associated information. It therefore resembles what blog posts would render as. The default component partial renders the following:

- The event name.
- The event time, based upon the repeating mode. It tries to intelligently guess how to present the data to the user (for instance, a weekly event will display its time in the following form: _Every Friday, 14:00 - 16:00 (until August 9, 2019)_)
- The event description.
- The location of the event, if there is information to display.

The event component can also be customised to a certain degree:

- `Event Slug`: The slug used to identify a single event.
- `Calendar Page`: The page where the Calendar resides to enable backlinking.
- `iCal Page`: The page where the iCal component is placed.
- `iCal Page Slug`: The slug used on the iCal page to identify a single event.

### Component: Upcoming

The "upcoming" component does what its name says: It displays a list (literally — nothing else!) of events that are up next (based on the current date as reference).

It can be customised with the following variables:

- `Sorting`: If checked, the next event will be on top, otherwise it will be at the bottom of the list.
- `Number of Events`: Limits the amount of event occurrences to this number. Set to 0 to disable filtering. _Note: No event will be present twice in this list, no matter how you set this limit._
- `Event Page`: The page where single events are displayed.
- `Event Slug`: The slug with which to identify the event.

### Component: iCal

The iCal component offers functionality to download either single events or your whole calendar in the popular `iCal`-format. It does not render anything but returns a file. Pass an event slug to this page to limit the resulting file to a single event, or nothing to export the whole calendar.

The resulting file will contain a single or all events with backlinks to your event page, i.e. users importing the file into their calendar will be able to visit your page by following the event links. Therefore, please make sure to select the correct page. Otherwise, users may face multiple 404-errors when visiting your site via events imported from this file.

Attributes:

- `Event Page`: The page where single events are displayed.
- `Event Slug`: The slug with which to identify the event.

## Customising the plugin

In case you want to customise the plugin further, here's a short reference to the API.

### Styling

The components use certain styles to ensure proper display. The calendar is almost exclusively styled to look like a table (it consists of `<div>`s to make it mobile ready). Everything in the calendar is namespaced to the table div: `div.campaignr-calendar`. You can style all parts of the calendar by referring to them by the respective classes that represent the tag names of a table:

- `.thead` encompasses the week days.
- `.tbody` encompasses the calendar table.
- `.tr` represents a row
- `.td` represents a column.
- `.day` represents the day number.
- `.events` contains all events.
- `.campaignr-small` is a helper class that styles things visible for mobile phones (breakpoint: 768px).
- `.campaignr-big` is a helper class that styles things for the desktop version.

### Overriding the partials

In case you decide to override the partials, here's everything you can access within your Twig templates:

- `this.page.campaignrYear` The current year (either pulled in via the slug or the current one). This variable only exists on pages with the Calendar component.
- `this.page.campaignrMonth` The current month (either pulled in via the slug or the current one). This variable only exists on pages with the Calendar component.
- `events` An array containing all events from the database.  This variable only exists on pages with the Calendar component or Upcoming component and contains either all or just the upcoming events.

The `events` themselves contain the following properties (single events are available to all components):

- `name` The event name.
- `slug` The event slug.
- `description` The event's description in Markdown (intended for use with the `|md`-filter).
- `time_begin` The start time of the event.
- `time_end` The end time of the event.
- `repeat_event` Indicates whether or not this event repeats.
- `repeat_mode` The repeating mode:
  - `1`: Daily
  - `2`: Weekly
  - `3`: Monthly
  - `4`: Yearly
- `end_repeat_on` Can be null. Indicates the last day where this event should re-occur.
- `dom` The day of month where this event occurs (1-31).
- `mon` The month where this event occurs (1-12).
- `year` The event's year.
- `dow` The event's day of week (1 = Monday, 7 = Sunday).
- `wom` The event's week within the month (1-4).
- `end_day` The event's ending day.
- `end_month` The event's ending month.
- `end_year` The event's ending year.
- `repeat_day` The event's last repetition's day.
- `repeat_month` The event's last repetition's month.
- `repeat_year` The event's last repetition's year.
- `location_street` The event's street.
- `location_number` Building number.
- `location_zip` Postcode.
- `location_city` City.
- `location_country` Country.
- `location_misc` Miscellaneous information (e.g. "The door is on the back of the house").

## License

This plugin is licensed under the GNU GPL v3 license.

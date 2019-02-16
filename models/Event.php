<?php namespace HendrikErz\Campaignr\Models;

use Model;
use Carbon\Carbon;

/**
 * Model
 */
class Event extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;
    use \October\Rain\Database\Traits\Sluggable;

    /**
     * @var array Generate slugs for these attributes.
     */
    protected $slugs = ['slug' => 'name'];

    /**
     * Only allow users with these permissions to edit the events.
     * @var array
     */
    public $requiredPermissions = ['campaignr.events.edit'];

    /**
     * @var array Values that should be automatically be converted to Carbon.
     */
    protected $dates = [
      'deleted_at',
      'created_at',
      'updated_at',
      'time_begin',
      'time_end',
      'end_repeat_on'
    ];

    /**
     * @var array Nullable attributes.
     */
    protected $nullable = [
      'repeat_day',
      'repeat_mon',
      'repeat_year',
      'end_repeat_on',
      'location_street',
      'location_number',
      'location_zip',
      'location_city',
      'location_country',
      'location_misc'
    ];

    /**
    * @var string The database table used by the model.
    */
    public $table = 'hendrikerz_campaignr_events';

    /**
    * @var array Validation rules
    */
    public $rules = [];

    /**
     * Holds the next occurrence of this event, if the function getNextOccurrence
     * has been called and has returned true.
     * @var string
     */
    public $nextOccurrence = null;

    /**
     * Needed for determining the next occurrence of weekly repeating events.
     * @var array
     */
    private $weekdays = [
      'monday',
      'tuesday',
      'wednesday',
      'thursday',
      'friday',
      'saturday',
      'sunday'
    ];

    /**
     * Validate the model before saving it.
     * @return Boolean Interrupt saving process if validation fails.
     */
    public function beforeValidate()
    {
      // Validate that time_end is always greater than time_begin
      if (Carbon::createFromFormat('Y-m-d H:i:s', $this->time_begin)
        > Carbon::createFromFormat('Y-m-d H:i:s', $this->time_end)) {
        return false;
      }
    }

    /**
     * Makes sure the slug is set and other fields are prepopulated.
     * @return void Does not return.
     */
    public function beforeSave()
    {
        // Force creation of a slug, thanks to Luke again:
        // https://octobercms.com/forum/post/generate-slug-from-two-form-fields
        if (empty($this->slug)) {
            unset($this->slug);
            $this->slugAttributes(); // Auto-generate a slug
        }

        // Make sure at least the default for repeat_mode is inserted.
        if (!$this->repeat_mode) {
          $this->repeat_mode = 2;
        }

        // October CMS uses this human-readable but programmatically weird
        // format for storing dates, so we have to transform it beforehand.
        // See https://octobercms.com/docs/database/mutators for the format.
        $evtBegin = Carbon::createFromFormat('Y-m-d H:i:s', $this->time_begin);
        $evtEnd   = Carbon::createFromFormat('Y-m-d H:i:s', $this->time_end);

        // If the user has given a date for ending the event, prepopulate the
        // respective cols in the row.
        if ($this->repeat_event && $this->end_repeat_on) {
          // Save information about the end repeating in the database
          $repeat = Carbon::createFromFormat('Y-m-d H:i:s', $this->end_repeat_on);
          $this->repeat_day = $repeat->day;
          $this->repeat_mon = $repeat->month;
          $this->repeat_year = $repeat->year;
        }

        // Now we need to store some information in the database for ease of
        // access inside the components and to prevent lags with huge databases.
        $this->dow = $evtBegin->dayOfWeekIso; // Day of week (1-7)
        $this->dom = $evtBegin->day; // Day of Month (1-31)
        $this->wom = $evtBegin->weekNumberInMonth; // Week of Month (1-4)
        $this->mon = $evtBegin->month; // Month (1-12)
        $this->year = $evtBegin->year;

        $this->end_day = $evtEnd->day;
        $this->end_mon = $evtEnd->month;
        $this->end_year = $evtEnd->year;
    }

    /**
     * Calculates the next occurrence and returns a Carbon.
     * @return Boolean Whether or not the event still occurs.
     */
    public function getNextOccurrence()
    {
        $now = Carbon::today();
        $end = Carbon::createFromFormat('Y-m-d H:i:s', $this->time_end);
        $beg = Carbon::createFromFormat('Y-m-d H:i:s', $this->time_begin);
        if ($end < $now && !$this->repeat_event) {
          return false; // This thing is over.
        }

        if (!$this->end_repeat_on) {
          // If the user left empty the date, assume he doesn't want the event
          // to end.
          $rep = Carbon::today()->addYears(2);
        } else {
          // Otherwise use the user defined end date.
          $rep = Carbon::createFromFormat('Y-m-d H:i:s', $this->end_repeat_on);
        }

        if ($rep < $now) {
            return false; // Repetition has already stopped
        }

        if ($beg > $now) {
          // No matter what, the "next" occurrence is the actual beginning of
          // the event.
          $this->nextOccurrence = $beg->copy();
          return true;
        }

        // Calculate the next occurrence.
        if (!$this->repeat_event) {
          // It's currently happening, so simply write the current time into the
          // variable
          $this->nextOccurrence = $beg->copy();
        } elseif ($this->repeat_mode == 1) {
          // Next occurrence is tomorrow
          $this->nextOccurrence = $now->copy()->addDays(1);
        } elseif ($this->repeat_mode == 2) {
          // Next occurrence is the next $this->dow, so build a new Carbon that
          // reflects this.
          $this->nextOccurrence = $now->copy()->modify('next ' . $this->weekdays[$this->dow - 1]);
        } elseif ($this->repeat_mode == 3) {
          // Next occurrence is next month. We need the correct week of month
          // and the correct day of this week.
          $this->nextOccurrence = Carbon::create($now->year, $now->month + 1, 1, 0, 0, 0)
          ->addWeeks($this->wom - 1) // Navigate to the correct week (1-based index)
          ->startOfWeek() // Move back to the start of the week
          ->addDays($this->dow - 1); // Add the appropriate amount of days (1-based index)
        } elseif ($this->repeat_mode == 4) {
          // Next occurrence is (probably) next year
          if ($this->mon > $now->month || ($this->mon == $now->month && $this->dom >= $now->day)) {
            $this->nextOccurrence = Carbon::create($now->year, $this->mon, $this->dom, 0, 0, 0);
          } else {
            $this->nextOccurrence = Carbon::create($now->year + 1, $this->mon, $this->dom, 0, 0, 0);
          }
        }

        // For Twig to access the variable we must convert it back to a string.
        $this->nextOccurrence = $this->nextOccurrence->toDateTimeString();

        return true;
    }
}

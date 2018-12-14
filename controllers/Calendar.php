<?php namespace HendrikErz\Campaignr\Controllers;

use Backend\Classes\Controller;
use System\Classes\CombineAssets;
use BackendMenu;
use HendrikErz\Campaignr\Models\Event;
use Carbon\Carbon;

class Calendar extends Controller
{
  public $requiredPermissions = [ 'campaignr.events.edit' ];

  /**
  * @var string HTML body tag class to remove the padding around the container
  */
  public $bodyClass = 'compact-container';

  public function __construct()
  {
    parent::__construct();
    // Mark the big "Campaignr" backend button as active while this controller
    // is active.
    BackendMenu::setContext('HendrikErz.Campaignr', 'main-menu-item');
  }

  public function index() {
    // Set the context
    BackendMenu::setContextSideMenu('event-calendar');

    // Inject the LESS
    $styles = [
      '/hendrikerz/campaignr/assets/css/calendar.less',
      '/hendrikerz/campaignr/assets/css/calendar_backend.less'
    ];
    $this->addCss(CombineAssets::combine($styles, plugins_path()));

    // Load the events and pass them to the page as $events
    $this->vars['events'] = Event::all();

    // Also send the month/year dates either from GET or the current date
    if (isset($_GET['year'])) {
      $this->vars['year'] = $_GET['year'];
    } else {
      $this->vars['year'] = Carbon::now()->year;
    }

    if (isset($_GET['month'])) {
      $this->vars['month'] = $_GET['month'];
    } else {
      $this->vars['month'] = Carbon::now()->month;
    }
  }
}

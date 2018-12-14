<?php namespace HendrikErz\Campaignr\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Events extends Controller
{
  public $implement = [
    'Backend\Behaviors\ListController',
    'Backend\Behaviors\FormController'
  ];

  public $listConfig = 'config_list.yaml';
  public $formConfig = 'config_form.yaml';

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

  public function create() {
    // Set the SideMenu context to mark the create button as active
    BackendMenu::setContextSideMenu('event-create');

    // This Javascript adds some classes to containers and performs otherwise
    // necessary stuff.
    $this->addJs('/plugins/hendrikerz/campaignr/assets/js/event-form.js');

    return $this->asExtension('FormController')->create();
  }

  public function update($recordId = null) {
    // This Javascript adds some classes to containers and performs otherwise
    // necessary stuff.
    $this->addJs('/plugins/hendrikerz/campaignr/assets/js/event-form.js');

    return $this->asExtension('FormController')->update($recordId);
  }
}

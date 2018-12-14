(function ($) {
  'use strict'

  $(document).ready(function () {
    // Apply the padded-pane class to the first and third tab (not the second
    // which is the description)
    $('#Form-secondaryTabs .tab-pane:not(:nth-child(2))').addClass('padded-pane')
  })
}(window.jQuery))

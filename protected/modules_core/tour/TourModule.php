<?php

/**
 * This module shows an introduction tour for new users
 *
 * @package humhub.modules_core.like
 * @since 0.5
 */
class TourModule extends HWebModule
{

    public $isCoreModule = true;

    /**
     * On Init
     *
     * @param type $event
     */
    public static function onTourWidgetInit($event)
    {
          $event->sender->addWidget('application.modules_core.tour.widgets.TourWidget', array(), array());
    }

}

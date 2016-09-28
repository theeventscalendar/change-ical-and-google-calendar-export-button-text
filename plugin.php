<?php
/**
 * Plugin Name: The Events Calendar Extension: Change iCal and Google Calendar Export Button Text
 * Description: Changes the text labels for Google Calendar and iCal buttons on a single event page.
 * Version: 1.0.0
 * Author: Modern Tribe, Inc.
 * Author URI: http://m.tri.be/1971
 * License: GPLv2 or later
 */

defined( 'WPINC' ) or die;

class Tribe__Extension__Change_iCal_and_Google_Calendar_Export_Button_Text {

    /**
     * The semantic version number of this extension; should always match the plugin header.
     */
    const VERSION = '1.0.0';

    /**
     * Each plugin required by this extension
     *
     * @var array Plugins are listed in 'main class' => 'minimum version #' format
     */
    public $plugins_required = array(
        'Tribe__Events__Main' => '4.2'
    );

    /**
     * The constructor; delays initializing the extension until all other plugins are loaded.
     */
    public function __construct() {
        add_action( 'plugins_loaded', array( $this, 'init' ), 100 );
    }

    /**
     * Extension hooks and initialization; exits if the extension is not authorized by Tribe Common to run.
     */
    public function init() {

        // Exit early if our framework is saying this extension should not run.
        if ( ! function_exists( 'tribe_register_plugin' ) || ! tribe_register_plugin( __FILE__, __CLASS__, self::VERSION, $this->plugins_required ) ) {
            return;
        }

        remove_action( 'tribe_events_single_event_after_the_content', array( 'Tribe__Events__iCal', 'single_event_links' ) );
        add_action( 'tribe_events_single_event_after_the_content', array( $this, 'customized_tribe_single_event_links' ) );
    }

    /**
     * Changes the text labels for Google Calendar and iCal buttons on a single event page.
     */
    public function customized_tribe_single_event_links() {
    
        if ( is_single() && post_password_required() ) {
            return;
        }

        echo '<div class="tribe-events-cal-links">';
        echo '<a class="tribe-events-gcal tribe-events-button" href="' . tribe_get_gcal_link() . '" title="' . __( 'Add to Google Calendar', 'tribe-events-calendar-pro' ) . '">+ Export the Map </a>';
        echo '<a class="tribe-events-ical tribe-events-button" href="' . tribe_get_single_ical_link() . '">+ Export to Calendar </a>';
        echo '</div><!-- .tribe-events-cal-links -->';
    }
}

new Tribe__Extension__Change_iCal_and_Google_Calendar_Export_Button_Text();

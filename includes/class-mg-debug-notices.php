<?php

class Mg_Debug_Notices {

    /**
     * A wrapper for all the notices.
     */
    public static function create_notice( $notice, $type = 'info', $inline = false, $alt = false, $dismissible = false ) {
    /**
    * Notice types:
    * error
    * warning
    * success
    * info
    */

        $inline = $inline ? ' inline' : '';
        $alt = $alt ? ' notice-alt' : '';
        $dismissible = $dismissible ? ' is-dismissible' : '';

        echo '<div class="notice notice-'.$type . $inline . $alt . $dismissible . '"><p>' . ucfirst($type) . ': ' . $notice . '</p></div>';
    }

}
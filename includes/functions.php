<?php

function mg_dump( $thing, ...$everything_else ) {
    $things = [ $thing ];

    if( count( $everything_else ) > 0 ) {
        $things = array_merge( $things, $everything_else );
    }
        
    do_action( 'mg_debug_dump', [ 'things' => $things ] );
}
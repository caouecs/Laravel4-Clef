<?php

/**
 * Clef.io logout
 */
Route::post('logout/clef', 'ClefController@logout');

/**
 * Connection by Clef.io
 */
Route::get('social/authentication/clef', 'ClefController@authentication');

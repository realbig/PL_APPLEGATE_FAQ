<?php
/**
 * Provides helper functions.
 *
 * @since      0.1.0
 *
 * @package    AGFAQ
 * @subpackage AGFAQ/core
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Returns the main plugin object
 *
 * @since 0.1.0
 *
 * @return AGFAQ
 */
function AGFAQ() {
	return AGFAQ::getInstance();
}
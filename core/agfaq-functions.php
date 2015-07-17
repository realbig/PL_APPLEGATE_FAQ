<?php
/**
 * Provides helper functions.
 *
 * @since      0.1.0
 *
 * @package    ApplegateFAQ
 * @subpackage ApplegateFAQ/core
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Returns the main plugin object
 *
 * @since 0.1.0
 *
 * @return APPLEGATE_FAQ
 */
function APPLEGATE_FAQ() {
	return APPLEGATE_FAQ::getInstance();
}
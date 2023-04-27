<?php
/**
 * Plugin Name:       WPForms Form Abandonment
 * Plugin URI:        https://wpforms.com
 * Description:       Form abandonment lead capture with WPForms.
 * Requires at least: 5.2
 * Requires PHP:      5.6
 * Author:            WPForms
 * Author URI:        https://wpforms.com
 * Version:           1.7.0
 * Text Domain:       wpforms-form-abandonment
 * Domain Path:       languages
 *
 * WPForms is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * WPForms is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WPForms. If not, see <https://www.gnu.org/licenses/>.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use WPFormsFormAbandonment\Migrations\Migrations;

// phpcs:disable WPForms.Comments.PHPDocDefine.MissPHPDoc
// Plugin version.
define( 'WPFORMS_FORM_ABANDONMENT_VERSION', '1.7.0' );
define( 'WPFORMS_FORM_ABANDONMENT_FILE', __FILE__ );
define( 'WPFORMS_FORM_ABANDONMENT_PATH', plugin_dir_path( WPFORMS_FORM_ABANDONMENT_FILE ) );
define( 'WPFORMS_FORM_ABANDONMENT_URL', plugin_dir_url( WPFORMS_FORM_ABANDONMENT_FILE ) );
// phpcs:enable WPForms.Comments.PHPDocDefine.MissPHPDoc

/**
 * Load the provider class.
 *
 * @since 1.5.0
 */
function wpforms_form_abandonment_load() {

	// Check requirements.
	if ( ! wpforms_form_abandonment_required() ) {
		return;
	}

	// Load the plugin.
	wpforms_form_abandonment();
}

add_action( 'wpforms_loaded', 'wpforms_form_abandonment_load' );

/**
 * Check addon requirements.
 *
 * @since 1.5.0
 */
function wpforms_form_abandonment_required() {

	if ( PHP_VERSION_ID < 50600 ) {
		add_action( 'admin_init', 'wpforms_form_abandonment_deactivate' );
		add_action( 'admin_notices', 'wpforms_form_abandonment_fail_php_version' );

		return false;
	}

	if ( ! function_exists( 'wpforms' ) || ! wpforms()->pro ) {
		return false;
	}

	if ( version_compare( wpforms()->version, '1.7.5.5', '<' ) ) {
		add_action( 'admin_init', 'wpforms_form_abandonment_deactivate' );
		add_action( 'admin_notices', 'wpforms_form_abandonment_fail_wpforms_version' );

		return false;
	}

	if ( ! function_exists( 'wpforms_get_license_type' ) || ! in_array( wpforms_get_license_type(), [ 'pro', 'elite', 'agency', 'ultimate' ], true ) ) {
		return false;
	}

	return true;
}

/**
 * Deactivate the plugin.
 *
 * @since 1.5.0
 */
function wpforms_form_abandonment_deactivate() {

	deactivate_plugins( plugin_basename( WPFORMS_FORM_ABANDONMENT_FILE ) );
}

/**
 * Admin notice for a minimum PHP version.
 *
 * @since 1.5.0
 */
function wpforms_form_abandonment_fail_php_version() {

	echo '<div class="notice notice-error"><p>';
	printf(
		wp_kses( /* translators: %s - WPForms.com documentation page URL. */
			__( 'The WPForms Form Abandonment plugin is not accepting payments anymore because your site is running an outdated version of PHP that is no longer supported and is not compatible with the plugin. <a href="%s" target="_blank" rel="noopener noreferrer">Read more</a> for additional information.', 'wpforms-form-abandonment' ),
			[
				'a' => [
					'href'   => [],
					'rel'    => [],
					'target' => [],
				],
			]
		),
		'https://wpforms.com/docs/supported-php-version/'
	);

	echo '</p></div>';

	// phpcs:disable WordPress.Security.NonceVerification.Recommended
	if ( isset( $_GET['activate'] ) ) {
		unset( $_GET['activate'] );
	}
	// phpcs:enable WordPress.Security.NonceVerification.Recommended
}

/**
 * Admin notice for minimum WPForms version.
 *
 * @since 1.5.0
 */
function wpforms_form_abandonment_fail_wpforms_version() {

	echo '<div class="notice notice-error"><p>';
	esc_html_e( 'The WPForms Form Abandonment plugin has been deactivated, because it requires WPForms v1.7.5.5 or later to work.', 'wpforms-form-abandonment' );
	echo '</p></div>';

	// phpcs:disable WordPress.Security.NonceVerification.Recommended
	if ( isset( $_GET['activate'] ) ) {
		unset( $_GET['activate'] );
	}
	// phpcs:enable WordPress.Security.NonceVerification.Recommended
}

/**
 * Load the main class.
 *
 * @since 1.0.0
 */
function wpforms_form_abandonment() {

	require_once __DIR__ . '/vendor/autoload.php';

	( new Migrations() )->init();

	require_once WPFORMS_FORM_ABANDONMENT_PATH . 'class-form-abandonment.php';
}

/**
 * Load the plugin updater.
 *
 * @since 1.0.0
 *
 * @param string $key WPForms license key.
 */
function wpforms_form_abandonment_updater( $key ) {

	new WPForms_Updater(
		[
			'plugin_name' => 'WPForms Form Abandonment',
			'plugin_slug' => 'wpforms-form-abandonment',
			'plugin_path' => plugin_basename( WPFORMS_FORM_ABANDONMENT_FILE ),
			'plugin_url'  => trailingslashit( WPFORMS_FORM_ABANDONMENT_URL ),
			'remote_url'  => WPFORMS_UPDATER_API,
			'version'     => WPFORMS_FORM_ABANDONMENT_VERSION,
			'key'         => $key,
		]
	);
}
add_action( 'wpforms_updater', 'wpforms_form_abandonment_updater' );

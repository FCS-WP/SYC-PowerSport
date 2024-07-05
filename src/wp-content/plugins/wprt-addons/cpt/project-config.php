<?php

// Set global var
global $agrikole_portfolio_config;

class WPEX_Portfolio_Config {

	// Get things started.
	public function __construct() {

		if ( is_admin() ) {
			add_action( 'admin_menu', array( $this, 'add_page' ) );
			add_action( 'admin_init', array( $this,'register_page_options' ) );
			add_action( 'admin_notices', array( $this, 'setting_notice' ) );
		}	
	}

	// Add sub menu page for the Portfolio Editor.
	public function add_page() {
		$agrikole_portfolio_editor = add_submenu_page(
			'edit.php?post_type=project',
			esc_html__( 'Post Type Editor', 'agrikole' ),
			esc_html__( 'Post Type Editor', 'agrikole' ),
			'administrator',
			'wpex-portfolio-editor',
			array( $this, 'create_admin_page' )
		);
		add_action( 'load-'. $agrikole_portfolio_editor, array( $this, 'flush_rewrite_rules' ) );
	}

	// Flush re-write rules
	public static function flush_rewrite_rules() {
		$screen = get_current_screen();
		if ( $screen->id == 'portfolio_page_wpex-portfolio-editor' ) {
			flush_rewrite_rules();
		}
	}

	// Function that will register the portfolio editor admin page.
	public function register_page_options() {
		register_setting( 'agrikole_portfolio_options', 'agrikole_portfolio_editor', array( $this, 'sanitize' ) );
	}

	// Displays saved message after settings are successfully saved
	public static function setting_notice() {
		settings_errors( 'agrikole_portfolio_editor_page_notices' );
	}

	// Sanitizes input and saves theme_mods.
	public static function sanitize( $options ) {

		// Save values to theme mod
		if ( ! empty ( $options ) ) {
			// Not checkboxes
			foreach( $options as $key => $value ) {
				if ( $value ) {
					set_theme_mod( $key, $value );
				} else {
					remove_theme_mod( $key );
				}
			}

			// Add notice
			add_settings_error(
				'agrikole_portfolio_editor_page_notices',
				esc_attr( 'settings_updated' ),
				esc_html__( 'Settings saved.', 'agrikole' ),
				'updated'
			);

		}

		// Lets delete the options as we are saving them into theme mods
		$options = '';
		return $options;
	}

	// Output for the actual Portfolio Editor admin page.
	public static function create_admin_page() {

		// Delete option as we are using theme_mods instead
		delete_option( 'agrikole_portfolio_editor' ); ?>

		<div class="wrap">
			<h2><?php esc_html_e( 'Post Type Editor', 'agrikole' ); ?></h2>
			<form method="post" action="options.php">
				<?php settings_fields( 'agrikole_portfolio_options' ); ?>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Main Page', 'agrikole' ); ?></th>
						<td><?php
						// Display dropdown of pages to select from
						wp_dropdown_pages( array(
							'echo'             => true,
							'selected'         => agrikole_get_mod( 'portfolio_page' ),
							'name'             => 'agrikole_portfolio_editor[portfolio_page]',
							'show_option_none' => esc_html__( 'None', 'agrikole' ),
							'exclude'          => get_option( 'page_for_posts' ),
						) ); ?><p class="description"><?php esc_html_e( 'Used for breadcrumbs.', 'agrikole' ); ?></p></td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
	<?php }
}
$agrikole_portfolio_config = new WPEX_Portfolio_Config;
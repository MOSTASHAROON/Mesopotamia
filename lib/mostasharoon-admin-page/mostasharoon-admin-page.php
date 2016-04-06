<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Create WordPress admin pages
 *
 * This class assume that it is put in the lib directory of your plugin and these is css and js folders contains its scripts
 */
class MOSTASHAROON_Admin_Page {

	public $page_title = 'Settings';
	public $text_domain = '';
	public $wrapper_id = 'mostasharoon-user-settings';
	public $container_class = 'mostasharoon-container';
	public $main_wrapper_class = 'MOSTASHAROON';
	public $form_class = 'mostasharoon-settings-form';
	public $save_button_wrapper_class = 'mostasharoon-save-settings-group';
	public $save_button_id = 'mostasharoon-save-settings';
	public $save_button_label = 'Save All Changes';
	public $tabs_headers = array();
	public $fields = array();
	public $active_tab;
	public $plugin_url;
	public $menu_slug;


	public function __construct() {
		return $this;
//		add_action( 'admin_menu', array( $this, 'add_admin_menu' ), 11 );
	}

	function add_sub_menu_page( $parent_slug, $capability, $menu_slug ) {

		$this->menu_slug = $menu_slug;

		$mostasharoon_settings_page_hook_suffix = add_submenu_page( $parent_slug, $this->page_title, $this->page_title, $capability, $menu_slug, array(
			$this,
			'render'
		) );

		add_action( 'admin_print_scripts-' . $mostasharoon_settings_page_hook_suffix, array(
			$this,
			'admin_scripts'
		) );

		return $this;
	}

	function addMenuPage( $capability, $menu_slug, $icon_url = '', $position = null ) {

		$this->menu_slug = $menu_slug;

		$mostasharoon_settings_page_hook_suffix = add_menu_page( $this->page_title, $this->page_title, $capability, $menu_slug, array(
			$this,
			'render'
		), $icon_url, $position );

		add_action( 'admin_print_scripts-' . $mostasharoon_settings_page_hook_suffix, array(
			$this,
			'admin_scripts'
		) );

		return $this;
	}

	function admin_scripts() {
		do_action( 'start_mostasharoon_enqueue', $this );
		do_action( $this->menu_slug . 'scripts', $this );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'mostasharoon-font-awesome', $this->plugin_url . 'lib/mostasharoon-admin-page/lib/font-awesome/css/font-awesome.min.css' );
		wp_enqueue_style( 'mostasharoon-bootstrap', $this->plugin_url . 'lib/mostasharoon-admin-page/lib/bootstrap/css/bootstrap.min.css' );
		wp_enqueue_style( 'mostasharoon-bootstrap-theme', $this->plugin_url . 'lib/mostasharoon-admin-page/lib/bootstrap/css/bootstrap-theme.min.css', array( 'mostasharoon-bootstrap' ) );
		wp_enqueue_style( 'mostasharoon-settings-css', $this->plugin_url . 'lib/mostasharoon-admin-page/css/mostasharoon.css', array(
			'mostasharoon-bootstrap-theme',
			'wp-color-picker',
			'mostasharoon-font-awesome'
		) );


		wp_enqueue_media();

		wp_enqueue_script( 'mostasharoon-bootstrap-js', $this->plugin_url . 'lib/mostasharoon-admin-page/lib/bootstrap/js/bootstrap.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'mostasharoon-setting-js', $this->plugin_url . 'lib/mostasharoon-admin-page/js/mostasharoon.js', array(
			'mostasharoon-bootstrap-js',
			'wp-color-picker'
		) );

		do_action( 'end_mostasharoon_enqueue', $this );
	}

	function admin_menu() {
		$mostasharoon_settings_page_hook_suffix = add_submenu_page( 'edit.php?post_type=mostasharoon_products', 'Settings', 'Settings', apply_filters( 'mostasharoon_settings_capability', 'manage_options' ), 'mostasharoon_settings', array(
			$this,
			'page'
		) );

		add_action( 'admin_print_scripts-' . $mostasharoon_settings_page_hook_suffix, array(
			$this,
			'admin_scripts'
		) );
	}


	function render() {
		?>
		<div class="container-fluid">
			<div class="<?php echo $this->main_wrapper_class; ?>">
				<div class="<?php echo $this->container_class; ?>">
					<div class="row">
						<h3><?php esc_html_e( $this->page_title, $this->text_domain ); ?></h3>
					</div>
					<form id="form-horizontal" class="<?php echo $this->form_class; ?>" role="form">
						<div class="row">
							<div class="col-xs-8">
								<div role="tabpanel">
									<!-- Nav tabs -->
									<ul class="nav nav-pills" role="tablist">
										<?php foreach ( $this->getTabsHeaders() as $id => $tab_header ) {
											$active = ( $id == $this->active_tab ) ? 'active' : ''; ?>
											<li role="presentation" class="<?php echo $active; ?>"><a
													href="#<?php echo $id; ?>" aria-controls="<?php echo $id; ?>"
													role="tab"
													data-toggle="tab"><?php esc_html_e( $tab_header, $this->text_domain ); ?></a>
											</li>
										<?php } ?>
									</ul>
									<!-- Tab panes -->
									<div class="tab-content">
										<?php foreach ( $this->getFields() as $id => $tab_fields ) {
											$active = ( $id == $this->active_tab ) ? 'active' : '';
											echo '<div role="tabpanel" class="tab-pane ' . $active . '" id="' . $id . '">';
											echo '<div class="panel panel-default">';
											echo '<div class="panel-body">';

											echo $this->field_renderer( $tab_fields );

											echo '</div>';
											echo '</div>';
											echo '</div>';
										} ?>
									</div>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="well">
									<div class="<?php echo $this->save_button_wrapper_class; ?>">
										<button type="button" id="<?php echo $this->save_button_id; ?>"
										        class="btn btn-primary mostasharoon-save-changes">
											<i class="fa fa-floppy-o"></i> <?php esc_html_e( $this->save_button_label, $this->text_domain ); ?>
										</button>
										<span class="mostasharoon-saving" style="display: none;">
								  Saving ...
								</span>
									</div>
								</div>
							</div>
						</div>
						<?php wp_nonce_field( 'mostasharoon_ap_nonce', 'mostasharoon_ap_nonce_field' ); ?>
					</form>
				</div>
			</div>
		</div>
		<?php
	}

	function field_renderer( $fields ) {
		$html = '';

		if ( is_array( $fields ) ) {

			foreach ( $fields as $field ) {
				//Capturing text between square brackets
				if ( isset( $field['name'] ) ) {
					preg_match( "/(.+)\[(.*?)\]/", $field['name'], $matches );
				}

				$val  = isset( $matches[1] ) ? $this->get_option( $matches[2], $matches[1], '' ) : '';
				$val  = ( $val ? $val : ( ( isset( $field['default'] ) && $field['default'] ) ? $field['default'] : '' ) );
				$help = ( isset( $field['help'] ) && ! empty( $field['help'] ) ) ? $field['help'] : '';
				switch ( $field['type'] ) {
					case 'password':
						$html .= '<div class="form-group clearfix">';
						$html .= '<label class="col-sm-5 control-label" for="' . $field['name'] . '">' . $field['label'] . '</label>';
						$html .= '<div class="col-sm-7">';
						$html .= '<input type="password" name="' . $field['name'] . '" value="' . $val . '" class="form-control" data-toggle="tooltip" data-placement="right" title="' . $help . '" id="' . $field['name'] . '" placeholder="">';
						$html .= '</div>';
						$html .= '</div>';
						break;

					case 'text':
						$html .= '<div class="form-group clearfix">';
						$html .= '<label class="col-sm-5 control-label" for="' . $field['name'] . '">' . $field['label'] . '</label>';

						$html .= '<div class="col-sm-7">';
						$html .= '<input type="text" name="' . $field['name'] . '" value="' . $val . '" class="form-control" data-toggle="tooltip" data-placement="right" title="' . $help . '" id="' . $field['name'] . '" placeholder="">';

						$html .= '</div>';
						$html .= '</div>';
						break;

					case 'email':
						$html .= '<div class="form-group clearfix">';
						$html .= '<label class="col-sm-5 control-label" for="' . $field['name'] . '">' . $field['label'] . '</label>';
						$html .= '<div class="col-sm-7">';
						$html .= '<input type="email" name="' . $field['name'] . '" value="' . $val . '" class="form-control" data-toggle="tooltip" data-placement="right" title="' . $help . '" id="' . $field['name'] . '" placeholder="">';
						$html .= '</div>';
						$html .= '</div>';
						break;

					case 'textarea':
						$html .= '<div class="form-group clearfix">';
						$html .= '<label class="col-sm-5 control-label" for="' . $field['name'] . '">' . $field['label'] . '</label>';
						$html .= '<div class="col-sm-7">';
						$html .= '<textarea name="' . $field['name'] . '" class="form-control" data-toggle="tooltip" data-placement="right" title="' . $help . '" id="' . $field['name'] . '" placeholder="" rows="10">' . $val . '</textarea>';
						$html .= '</div>';
						$html .= '</div>';
						break;

					case 'select':
						$html .= '<div class="form-group clearfix">';
						$html .= '<label class="col-sm-5 control-label" for="' . $field['name'] . '">' . $field['label'] . '</label>';
						$html .= '<div class="col-sm-7">';
						$html .= '<select class="form-control" name="' . $field['name'] . '" data-toggle="tooltip" data-placement="right" title="' . $help . '" id="' . $field['name'] . '">';
						foreach ( $field['options'] as $id => $title ) {
							$html .= '<option ' . selected( $val, $id, false ) . ' value="' . $id . '">' . $title . '</option>';
						}
						$html .= '</select>';
						$html .= '</div>';
						$html .= '</div>';
						break;

					case 'multi_select':
						$html .= '<div class="form-group clearfix">';
						$html .= '<label class="col-sm-5 control-label" for="' . $field['name'] . '">' . $field['label'] . '</label>';
						$html .= '<div class="col-sm-7">';
						$html .= '<select class="form-control" name="' . $field['name'] . '[]" data-toggle="tooltip" data-placement="right" title="' . $help . '" id="' . $field['name'] . '" multiple>';
						foreach ( $field['options'] as $id => $title ) {
							$selected = '';
							foreach ( $val as $single_val ) {
								if ( ! empty( $selected ) ) {
									continue;
								}
								$selected = selected( (int) $id, (int) $single_val, false );
							}
							$html .= '<option ' . $selected . ' value="' . $id . '">' . $title . '</option>';
						}
						$html .= '</select>';
						$html .= '</div>';
						$html .= '</div>';
						break;


					case 'radio':
						foreach ( $field['options'] as $id => $title ) {
							$html .= '<div class="radio">';
							$html .= '<label>';

							$html .= '<input type="radio" name="' . $field['name'] . '" data-toggle="tooltip" data-placement="right" title="' . $help . '" value="' . $id . '" ' . checked( $val, $id, false ) . '>';

							$html .= $title;
							$html .= '</label>';
							$html .= '</div>';
						}
						break;

					case 'radios':
						$html .= '<div class="form-group clearfix">';
						$html .= '<label class="col-sm-5 control-label" for="' . $field['name'] . '">' . $field['label'] . '</label>';
						$html .= '<div class="col-sm-7">';
						foreach ( $field['options'] as $id => $title ) {
							$html .= '<div class="radio">';
							$html .= '<label>';

							$html .= '<input type="radio" name="' . $field['name'] . '" id="' . $field['name'] . '" data-toggle="tooltip" data-placement="right" title="' . $help . '" value="' . $id . '" ' . checked( $val, $id, false ) . '>';

							$html .= $title;
							$html .= '</label>';
							$html .= '</div>';
						}
						$html .= '</div>';
						$html .= '</div>';
						break;

					case 'checkbox':
						$html .= '<div class="checkbox col-sm-7 col-sm-offset-5">';
						$html .= '<label>';
						$html .= '<input type="checkbox" name="' . $field['name'] . '" data-toggle="tooltip" data-placement="right" title="' . $help . '" value="yes" ' . checked( $val, 'yes', false ) . '>';
						$html .= $field['label'];
						$html .= '</label>';
						$html .= '</div>';
						break;

					case 'multi_check':
						$html .= '<div class="form-group clearfix">';
						$html .= '<label class="col-sm-5 control-label" for="' . $field['name'] . '">' . $field['label'] . '</label>';
						$html .= '<div class="col-sm-7">';

						foreach ( $field['options'] as $id => $title ) {

							$checked = '';
							if ( is_array( $val ) ) {
								foreach ( $val as $single_val ) {
									if ( ! empty( $checked ) ) {
										continue;
									}
									$checked = checked( $id, $single_val, false );
								}
							}

							$html .= '<div class="checkbox">';
							$html .= '<label>';
							$html .= '<input type="checkbox" name="' . $field['name'] . '[' . $id . ']" data-toggle="tooltip" data-placement="right" title="' . $help . '" value="' . $id . '" ' . $checked . '>';
							$html .= $title;
							$html .= '</label>';
							$html .= '</div>';

						}
						$html .= '</div>';
						$html .= '</div>';
						break;

					case 'color_picker':
						$html .= '<div class="form-group clearfix">';
						$html .= '<label class="col-sm-5 control-label" for="' . $field['name'] . '">' . $field['label'] . '</label>';
						$html .= '<div class="col-sm-7">';
						$html .= '<input type="text" name="' . $field['name'] . '" value="' . $val . '" class=" mostasharoon-color-field" data-toggle="tooltip" data-placement="right" title="' . $help . '" id="' . $field['name'] . '" placeholder="">';
						$html .= '</div>';
						$html .= '</div>';
						break;

					case 'media_uploader_image':
						$html .= '<div class="form-group clearfix mostasharoon-field">';
						$html .= '<label class="col-sm-5 control-label" for="' . $field['name'] . '">' . $field['label'] . '</label>';
						$html .= '<div class="col-sm-7">';
						$html .= '<button type="' . $field['button_type'] . '" data-toggle="tooltip" data-placement="right" title="' . $help . '" ' . ( isset( $field['attributes'] ) ? $field['attributes'] : '' ) . ' value="' . $field['value'] . '" class="mostasharoon-upload-file btn btn-default ' . ( isset( $field['classes'] ) ? $field['classes'] : '' ) . '">' . $field['value'] . '</button>';
						$html .= '<input type="hidden" name="' . $field['name'] . '" value="' . $val . '">';
						$html .= '<div class="img-wrap pull-right"  ' . ( $val ? '' : 'style="display: none;"' ) . '>';
						$html .= '<i class="fa fa-times-circle mostasharoon-remove-image" data-toggle="tooltip" data-placement="right" title="' . __( 'Remove', $this->text_domain ) . '"></i>';
						$html .= '<img src="' . wp_get_attachment_url( (int) $val ) . '">';
						$html .= '</div>';
						$html .= '</div>';
						$html .= '</div>';
						break;


					case 'input_group':
//						$html .= '<div class="field mostasharoon-field" ' . $help . '>';
//						$html .= '<label for="' . $field['name'] . '">' . $field['label'] . '</label>';
//						$html .= '<div class="ui fluid action input">';
//						$html .= '<input type="text" name="' . $field['name'] . '" value="' . get_option( 'admin_email' ) . '" id="' . $field['name'] . '" placeholder="">';
//						$html .= '<div class="ui button">' . $field['action'] . '</div>';
//						$html .= '</div>';
//						$html .= '</div>';

						$html .= '<div class="form-group clearfix">';
						$html .= '<label class="col-sm-5 control-label" for="' . $field['name'] . '">' . $field['label'] . '</label>';
						$html .= '<div class="col-sm-7">';
						$html .= '<div class="input-group">';
						$html .= '<input type="text" name="' . $field['name'] . '" class="form-control" data-toggle="tooltip" id="' . $field['name'] . '" value="' . get_option( 'admin_email' ) . '" data-placement="right" title="' . $help . '" placeholder="">';
						$html .= '<span class="input-group-btn">';
						$html .= '<button class="btn btn-default" type="button">' . $field['action'] . '</button>';
						$html .= '</span>';
						$html .= '</div><!-- /input-group -->';
						$html .= '</div>';
						$html .= '</div>';
						break;
					case 'file':
//						$html .= '<div class="field mostasharoon-field" ' . $help . '>';
//						$html .= '<label for="' . $field['name'] . '">' . $field['label'] . '</label>';
//						$html .= '<input type="file" name="' . $field['name'] . '" id="' . $field['name'] . '">';
//						$html .= '</div>';

						$html .= '<div class="form-group clearfix">';
						$html .= '<label class="col-sm-5 control-label" for="' . $field['name'] . '">' . $field['label'] . '</label>';
						$html .= '<div class="col-sm-7">';
						$html .= '<input type="file" name="' . $field['name'] . '" class="form-control" data-toggle="tooltip" data-placement="right" title="' . $help . '" id="' . $field['name'] . '" placeholder="">';
						$html .= '</div>';
						$html .= '</div>';
						break;

					case 'button':
						$html .= '<div class="form-group clearfix">';
						$html .= '<label class="col-sm-5 control-label" for="' . $field['name'] . '">' . $field['label'] . '</label>';
						$html .= '<div class="col-sm-7">';
						$html .= '<button type="' . $field['button_type'] . '" ' . ( isset( $field['attributes'] ) ? $field['attributes'] : '' ) . ' name="' . $field['name'] . '" data-toggle="tooltip" data-placement="right" title="' . $help . '" value="' . $field['value'] . '" class="btn btn-default ' . ( isset( $field['classes'] ) ? $field['classes'] : '' ) . '">' . $field['value'] . '</button>';
						$html .= '</div>';
						$html .= '</div>';
						break;

					case 'legend':
						$html .= '<legend>' . $field['label'] . '</legend>';
						break;
					case 'message':
						$html .= '<p class="bg-primary">' . $field['message'] . '</p>';
						break;

					case 'custom':
						//Incompatible with PHP7
//						$html .= $this->$field['custom_type']( $field, $val );
						$html .= call_user_func_array( $field['custom_type'], array( $field, $val ) );
						break;
					default:
						$html .= apply_filters( 'mostasharoon_settings_' . $field['type'] . '_field_renderer', $field, $val );
						break;
				}
			}
		}

		return $html = apply_filters( 'mostasharoon_settings_field_renderer_html', $html, $fields );
	}


	/**
	 * @param array $tabs_headers
	 *
	 * @return MOSTASHAROON_Admin_Page
	 */
	public function setTabsHeaders( $tabs_headers ) {
		$this->tabs_headers = $tabs_headers;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getTabsHeaders() {
		return $this->tabs_headers;
	}

	/**
	 * @param array $fields
	 *
	 * @return MOSTASHAROON_Admin_Page
	 */
	public function setFields( $fields ) {
		$this->fields = $fields;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getFields() {
		return $this->fields;
	}

	/**
	 * @param mixed $plugin_url
	 *
	 * @return MOSTASHAROON_Admin_Page
	 */
	public function setPluginUrl( $plugin_url ) {
		$this->plugin_url = trailingslashit( $plugin_url );

		return $this;
	}

	/**
	 * @param string $page_title
	 *
	 * @return MOSTASHAROON_Admin_Page
	 */
	public function setPageTitle( $page_title = 'Settings' ) {
		$this->page_title = $page_title;

		return $this;
	}

	/**
	 * @param string $text_domain
	 *
	 * @return MOSTASHAROON_Admin_Page
	 */
	public function setTextDomain( $text_domain = '' ) {
		$this->text_domain = $text_domain;

		return $this;
	}

	/**
	 * @param string $wrapper_id
	 *
	 * @return MOSTASHAROON_Admin_Page
	 */
	public function setWrapperId( $wrapper_id = 'mostasharoon-user-settings' ) {
		$this->wrapper_id = $wrapper_id;

		return $this;
	}

	/**
	 * @param string $container_class
	 *
	 * @return MOSTASHAROON_Admin_Page
	 */
	public function setContainerClass( $container_class = 'mostasharoon-container' ) {
		$this->container_class = $container_class;

		return $this;
	}

	/**
	 * @param string $main_wrapper_class
	 *
	 * @return MOSTASHAROON_Admin_Page
	 */
	public function setMainWrapperClass( $main_wrapper_class = 'MOSTASHAROON' ) {
		$this->main_wrapper_class = $main_wrapper_class;

		return $this;
	}

	/**
	 * @param string $form_class
	 *
	 * @return MOSTASHAROON_Admin_Page
	 */
	public function setFormClass( $form_class = 'mostasharoon-settings-form' ) {
		$this->form_class = $form_class;

		return $this;
	}

	/**
	 * @param string $save_button_wrapper_class
	 *
	 * @return MOSTASHAROON_Admin_Page
	 */
	public function setSaveButtonWrapperClass( $save_button_wrapper_class = 'mostasharoon-save-settings-group' ) {
		$this->save_button_wrapper_class = $save_button_wrapper_class;

		return $this;
	}

	/**
	 * @param string $save_button_id
	 *
	 * @return MOSTASHAROON_Admin_Page
	 */
	public function setSaveButtonId( $save_button_id = 'mostasharoon-save-settings' ) {
		$this->save_button_id = $save_button_id;

		return $this;
	}

	/**
	 * @param string $save_button_label
	 *
	 * @return MOSTASHAROON_Admin_Page
	 */
	public function setSaveButtonLabel( $save_button_label = 'Save All Changes' ) {
		$this->save_button_label = $save_button_label;

		return $this;
	}

	/**
	 * @param mixed $active_tab
	 *
	 * @return MOSTASHAROON_Admin_Page
	 */
	public function setActiveTab( $active_tab = '' ) {
		$this->active_tab = $active_tab;

		return $this;
	}

	private function get_option( $option, $section, $default = '' ) {
		$options = get_option( $section );

		if ( isset( $options[ $option ] ) ) {
			$returned_value = $options[ $option ];
		} else {
			$returned_value = $default;
		}

		$returned_value = apply_filters( 'mostasharoon_get_option', $returned_value, $option, $section, $default );

		return $returned_value;
	}
}

if ( ! function_exists( 'mostasharoon_save_settings' ) ) :
	function mostasharoon_save_settings() {
		if ( ! ( isset( $_REQUEST['mostasharoon_ap_nonce_field'] ) && wp_verify_nonce( $_REQUEST['mostasharoon_ap_nonce_field'], 'mostasharoon_ap_nonce' ) ) ) {
			wp_die( 'Security Check!' );
		}

		if ( ! current_user_can( apply_filters( 'mostasharoon_save_settings_capability', 'manage_options' ) ) ) {
			wp_die( 'Security Check!' );
		}

		do_action( 'mostasharoon_save_settings' );

		$response = array(
			'status' => true
		);

		$response = apply_filters( 'mostasharoon_response', $response );

		$json = json_encode( $response );

		//add our boundary, to make it easy in capturing it with regex in case we got unexpected result
		$json = '[mostasharoon_json]' . $json . '[/mostasharoon_json]';

		$json = apply_filters( 'mostasharoon_response_response', $json, $response );

		echo $json;
		exit;
	}
endif;
add_action( 'wp_ajax_mostasharoon_save_settings', 'mostasharoon_save_settings' );
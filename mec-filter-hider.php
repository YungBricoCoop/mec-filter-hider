<?php
/*
 * Plugin Name: M.E.C. Filter Hider
 * Plugin URI: https://github.com/YungBricoCoop/mec-filter-hider
 * Description: Hide some filters on the Modern Events Calendar plugin
 * Version: 1.1
 * Author: Elwan Mayencourt
 */


function mec_f_h_settings_init()
{
	$description = "Elements to hide";
	register_setting('mec_f_h', 'mec_f_h_settings');

	add_settings_section(
		'mec_f_h_section',
		__($description, 'mec_f_h'),
		'mec_f_h_section_cb',
		'mec_f_h'
	);

	add_settings_field(
		'mec_f_h_url_field',
		__('Url (must contains)', 'mec_f_h'),
		'mec_f_h_url_field_cb',
		'mec_f_h',
		'mec_f_h_section',
		[
			'label_for' => 'mec_f_h_url_field',
			'class' => 'mec_f_h_url_row',
			'mec_f_h_url_custom_data' => 'custom',
		]
	);

	add_settings_field(
		'mec_f_h_container_field',
		__('Container', 'mec_f_h'),
		'mec_f_h_container_field_cb',
		'mec_f_h',
		'mec_f_h_section',
		[
			'label_for' => 'mec_f_h_container_field',
			'class' => 'mec_f_h_container_row',
			'mec_f_h_container_custom_data' => 'custom',
		]
	);

	add_settings_field(
		'mec_f_h_field',
		__('Elements (separated by commas)', 'mec_f_h'),
		'mec_f_h_field_cb',
		'mec_f_h',
		'mec_f_h_section',
		[
			'label_for' => 'mec_f_h_field',
			'class' => 'mec_f_h_row',
			'mec_f_h_custom_data' => 'custom',
		]
	);
}

add_action('admin_init', 'mec_f_h_settings_init');

function mec_f_h_section_cb($args)
{
	$description = "The url defines the page where the filters are displayed.
	<b>Don't use the whole url</b> just use for exemple the page name like 'mec'</br>
	By default, the plugin displays all the filters.</br>
	If you want to hide only certain filters, just separate them with a <b>comma</b>.
	</br>For <b>id</b> use <b>#</b> (ex : #name_filter)
	</br>For <b>class</b> use <b>.</b> (ex : .name_filter)
	</br>For <b>custom attribut</b> use <b>attribut=</b>value (ex : data-filter=filter_name)
	</br>Complex JS Path can also be used";
?>
	<p id="<?php echo esc_attr($args['id']); ?>"><?php echo $description; ?></p>
<?php
}

function mec_f_h_url_field_cb( $args ) {
    $options = get_option( 'mec_f_h_settings' );
    $url = isset( $options['mec_f_h_url_field'] ) ? $options['mec_f_h_url_field'] : 'mec';
    ?>
    <input type="text" style="width: 400px;" id="<?php echo esc_attr( $args['label_for'] ); ?>" data-custom="<?php echo esc_attr( $args['mec_f_h_url_custom_data'] ); ?>" name="mec_f_h_settings[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo $url; ?>">
    <?php
}

function mec_f_h_container_field_cb( $args ) {
    $options = get_option( 'mec_f_h_settings' );
    $container = isset( $options['mec_f_h_container_field'] ) ? $options['mec_f_h_container_field'] : '#posts-filter > div.tablenav.top';
    ?>
    <input type="text" style="width: 400px;" id="<?php echo esc_attr( $args['label_for'] ); ?>" data-custom="<?php echo esc_attr( $args['mec_f_h_container_custom_data'] ); ?>" name="mec_f_h_settings[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo $container; ?>">
    <?php
}


function mec_f_h_field_cb($args)
{
	$options = get_option('mec_f_h_settings');
?>
	<input type="text" style="width: 400px;" id="<?php echo esc_attr($args['label_for']); ?>" data-custom="<?php echo esc_attr($args['mec_f_h_custom_data']); ?>" name="mec_f_h_settings[<?php echo esc_attr($args['label_for']); ?>]" value="<?php echo $options[$args['label_for']]; ?>">
<?php
}

function mec_f_h_options_page()
{
?>
	<form action="options.php" method="post">
		<h2><?php _e('MEC Filter Hider', 'mec_f_h'); ?></h2>
		<?php
		settings_fields('mec_f_h');
		do_settings_sections('mec_f_h');
		submit_button(__('Save', 'mec_f_h'));
		?>
	</form>
<?php
}

function mec_f_h_menu()
{
	add_options_page(
		__('MEC Filter Hider', 'mec_f_h'),
		__('MEC Filter Hider', 'mec_f_h'),
		'manage_options',
		'mec_f_h',
		'mec_f_h_options_page'
	);
}
add_action('admin_menu', 'mec_f_h_menu');

function mec_f_h_enqueue_scripts()
{
	$options = get_option('mec_f_h_settings');
	$url = $options['mec_f_h_url_field'];
	$container = $options['mec_f_h_container_field'];
	$elements = $options['mec_f_h_field'];
	wp_enqueue_script('mec_f_h_js', plugin_dir_url(__FILE__) . 'mec-f-h.js', array('jquery'), '1.0.0', true);
	wp_localize_script('mec_f_h_js', 'mec_f_h_vars', array(
		'url' => $url,
		'container' => $container,
		'elements' => $elements,
	));
}
add_action('admin_enqueue_scripts', 'mec_f_h_enqueue_scripts');

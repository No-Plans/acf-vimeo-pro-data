<?php

// exit if accessed directly
if (! defined('ABSPATH')) {
    exit;
}


// check if class already exists
if (!class_exists('acf_field_vimeo_pro_data')) :


class acf_field_vimeo_pro_data extends acf_field
{


    /*
    *  __construct
    *
    *  This function will setup the field type data
    *
    *  @type	function
    *  @date	5/03/2014
    *  @since	5.0.0
    *
    *  @param	n/a
    *  @return	n/a
    */

    public function __construct($settings)
    {

        /*
        *  name (string) Single word, no spaces. Underscores allowed
        */

        $this->name = 'vimeo_pro_data';


        /*
        *  label (string) Multiple words, can include spaces, visible when selecting a field type
        */

        $this->label = __('Vimeo Pro Data', 'acf-vimeo_pro_data');


        /*
        *  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
        */

        $this->category = 'basic';


        /*
        *  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
        */

        // $this->defaults = array(
        //     'font_size'	=> 14,
        // );


        /*
        *  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
        *  var message = acf._e('vimeo_pro_data', 'error');
        */

        $this->l10n = array(
            'error'	=> __('Error! Please enter a higher value', 'acf-vimeo_pro_data'),
        );


        /*
        *  settings (array) Store plugin settings (url, path, version) as a reference for later use with assets
        */

        $this->settings = $settings;


        // do not delete!
        parent::__construct();
    }


    /*
    *  render_field_settings()
    *
    *  Create extra settings for your field. These are visible when editing a field
    *
    *  @type	action
    *  @since	3.6
    *  @date	23/01/13
    *
    *  @param	$field (array) the $field being edited
    *  @return	n/a
    */

    public function render_field_settings($field)
    {

        /*
        *  acf_render_field_setting
        *
        *  This function will create a setting for your field. Simply pass the $field parameter and an array of field settings.
        *  The array of settings does not require a `value` or `prefix`; These settings are found from the $field array.
        *
        *  More than one setting can be added by copy/paste the above code.
        *  Please note that you must also have a matching $defaults value for the field name (font_size)
        */ 
    }



    /*
    *  render_field()
    *
    *  Create the HTML interface for your field
    *
    *  @param	$field (array) the $field being rendered
    *
    *  @type	action
    *  @since	3.6
    *  @date	23/01/13
    *
    *  @param	$field (array) the $field being edited
    *  @return	n/a
    */

    public function render_field($field)
    {


        /*
        *  Review the data of $field.
        *  This will show what data is available
        */

        // echo '<pre>';
            // print_r( $field );
        // echo '</pre>';


        /*
        *  Create a simple text input using the 'font_size' setting.
        */

        ?>
		<div class="acf-vimeo-pro-data">
			<div class="ui search">
				<input class="prompt" type="text" placeholder="Look up title..." autocomplete="on">
				<div class="results"></div>
			</div>
			<input type="hidden" placeholder="VIMEO ID" class="acf-vimeo-pro-data-input" />
			<div class="acf-vimeo-pro-data-display"></div>
			<div class="acf-vimeo-pro-data__buttons">
				<a class="button button-secondary button-small acf-vimeo-pro-data__refresh " href="javascript:void(0);">Refresh</a>&nbsp;
				<a class="button button-secondary button-small acf-vimeo-pro-data__clear" href="javascript:void(0);">Clear</a>
			</div>
			<input type="hidden" class="acf-vimeo-pro-data__hidden-input" name="<?php echo esc_attr($field['name']) ?>" value="<?php echo esc_attr($field['value']) ?>" />
			<div class="acf-vimeo-pro-data__message"></div>
		</div>
		<?php
    }

    public function getVimeoToken()
    {
        return get_field('acf_vimeo_auth_token', 'options');
    }


    /*
    *  input_admin_enqueue_scripts()
    *
    *  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
    *  Use this action to add CSS + JavaScript to assist your render_field() action.
    *
    *  @type	action (admin_enqueue_scripts)
    *  @since	3.6
    *  @date	23/01/13
    *
    *  @param	n/a
    *  @return	n/a
    */

    public function input_admin_enqueue_scripts()
    {

        // vars
        $url = $this->settings['url'];
        $version = $this->settings['version'];

        // register search plugin
        wp_register_script('acf-input-vimeo_pro_data--ui-search', "{$url}assets/search/search.js");
        wp_enqueue_script('acf-input-vimeo_pro_data--ui-search');
        wp_register_style('acf-input-vimeo_pro_data--ui-search', "{$url}assets/search/search.css");
        wp_enqueue_style('acf-input-vimeo_pro_data--ui-search');

        // register & include JS
        wp_register_script('acf-input-vimeo_pro_data--ui', "{$url}assets/js/input.js", array('acf-input'), $version);

        $client_vars = array(
        'vimeo_token' => $this -> getVimeoToken(),
        );
        wp_localize_script('acf-input-vimeo_pro_data--ui', 'server_vars', $client_vars);
        wp_enqueue_script('acf-input-vimeo_pro_data--ui');


        // register & include CSS
        wp_register_style('acf-input-vimeo_pro_data--ui', "{$url}assets/css/input.css", array('acf-input'), $version);
        wp_enqueue_style('acf-input-vimeo_pro_data--ui');
    }




    /*
    *  input_admin_head()
    *
    *  This action is called in the admin_head action on the edit screen where your field is created.
    *  Use this action to add CSS and JavaScript to assist your render_field() action.
    *
    *  @type	action (admin_head)
    *  @since	3.6
    *  @date	23/01/13
    *
    *  @param	n/a
    *  @return	n/a
    */

    /*

    function input_admin_head() {



    }

    */


    /*
    *  input_form_data()
    *
    *  This function is called once on the 'input' page between the head and footer
    *  There are 2 situations where ACF did not load during the 'acf/input_admin_enqueue_scripts' and
    *  'acf/input_admin_head' actions because ACF did not know it was going to be used. These situations are
    *  seen on comments / user edit forms on the front end. This function will always be called, and includes
    *  $args that related to the current screen such as $args['post_id']
    *
    *  @type	function
    *  @date	6/03/2014
    *  @since	5.0.0
    *
    *  @param	$args (array)
    *  @return	n/a
    */

    /*

    function input_form_data( $args ) {



    }

    */


    /*
    *  input_admin_footer()
    *
    *  This action is called in the admin_footer action on the edit screen where your field is created.
    *  Use this action to add CSS and JavaScript to assist your render_field() action.
    *
    *  @type	action (admin_footer)
    *  @since	3.6
    *  @date	23/01/13
    *
    *  @param	n/a
    *  @return	n/a
    */

    /*

    function input_admin_footer() {



    }

    */


    /*
    *  field_group_admin_enqueue_scripts()
    *
    *  This action is called in the admin_enqueue_scripts action on the edit screen where your field is edited.
    *  Use this action to add CSS + JavaScript to assist your render_field_options() action.
    *
    *  @type	action (admin_enqueue_scripts)
    *  @since	3.6
    *  @date	23/01/13
    *
    *  @param	n/a
    *  @return	n/a
    */

    /*

    function field_group_admin_enqueue_scripts() {

    }

    */


    /*
    *  field_group_admin_head()
    *
    *  This action is called in the admin_head action on the edit screen where your field is edited.
    *  Use this action to add CSS and JavaScript to assist your render_field_options() action.
    *
    *  @type	action (admin_head)
    *  @since	3.6
    *  @date	23/01/13
    *
    *  @param	n/a
    *  @return	n/a
    */

    /*

    function field_group_admin_head() {

    }

    */


    /*
    *  load_value()
    *
    *  This filter is applied to the $value after it is loaded from the db
    *
    *  @type	filter
    *  @since	3.6
    *  @date	23/01/13
    *
    *  @param	$value (mixed) the value found in the database
    *  @param	$post_id (mixed) the $post_id from which the value was loaded
    *  @param	$field (array) the field array holding all the field options
    *  @return	$value
    */



    public function load_value($value, $post_id, $field)
    {
        return $value;
    }



    /*
    *  update_value()
    *
    *  This filter is applied to the $value before it is saved in the db
    *
    *  @type	filter
    *  @since	3.6
    *  @date	23/01/13
    *
    *  @param	$value (mixed) the value found in the database
    *  @param	$post_id (mixed) the $post_id from which the value was loaded
    *  @param	$field (array) the field array holding all the field options
    *  @return	$value
    */


    public function update_value($value, $post_id, $field)
    {
        return $value;
    }



    /*
    *  format_value()
    *
    *  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
    *
    *  @type	filter
    *  @since	3.6
    *  @date	23/01/13
    *
    *  @param	$value (mixed) the value which was loaded from the database
    *  @param	$post_id (mixed) the $post_id from which the value was loaded
    *  @param	$field (array) the field array holding all the field options
    *
    *  @return	$value (mixed) the modified value
    */



    public function format_value($value, $post_id, $field)
    {

        // bail early if no value
        if (empty($value)) {
            return $value;
        }

        $json = json_decode(stripslashes($value));

        return ($json);
    }




    /*
    *  validate_value()
    *
    *  This filter is used to perform validation on the value prior to saving.
    *  All values are validated regardless of the field's required setting. This allows you to validate and return
    *  messages to the user if the value is not correct
    *
    *  @type	filter
    *  @date	11/02/2014
    *  @since	5.0.0
    *
    *  @param	$valid (boolean) validation status based on the value and the field's required setting
    *  @param	$value (mixed) the $_POST value
    *  @param	$field (array) the field array holding all the field options
    *  @param	$input (string) the corresponding input name for $_POST value
    *  @return	$valid
    */

    /*

    function validate_value( $valid, $value, $field, $input ){

        // Basic usage
        if( $value < $field['custom_minimum_setting'] )
        {
            $valid = false;
        }


        // Advanced usage
        if( $value < $field['custom_minimum_setting'] )
        {
            $valid = __('The value is too little!','acf-vimeo_pro_data'),
        }


        // return
        return $valid;

    }

    */


    /*
    *  delete_value()
    *
    *  This action is fired after a value has been deleted from the db.
    *  Please note that saving a blank value is treated as an update, not a delete
    *
    *  @type	action
    *  @date	6/03/2014
    *  @since	5.0.0
    *
    *  @param	$post_id (mixed) the $post_id from which the value was deleted
    *  @param	$key (string) the $meta_key which the value was deleted
    *  @return	n/a
    */



    public function delete_value($post_id, $key)
    {
    }




    /*
    *  load_field()
    *
    *  This filter is applied to the $field after it is loaded from the database
    *
    *  @type	filter
    *  @date	23/01/2013
    *  @since	3.6.0
    *
    *  @param	$field (array) the field array holding all the field options
    *  @return	$field
    */

    /*

    function load_field( $field ) {

        return $field;

    }

    */


    /*
    *  update_field()
    *
    *  This filter is applied to the $field before it is saved to the database
    *
    *  @type	filter
    *  @date	23/01/2013
    *  @since	3.6.0
    *
    *  @param	$field (array) the field array holding all the field options
    *  @return	$field
    */

    /*

    function update_field( $field ) {

        return $field;

    }

    */


    /*
    *  delete_field()
    *
    *  This action is fired after a field is deleted from the database
    *
    *  @type	action
    *  @date	11/02/2014
    *  @since	5.0.0
    *
    *  @param	$field (array) the field array holding all the field options
    *  @return	n/a
    */

    /*

    function delete_field( $field ) {



    }

    */
}


// initialize
new acf_field_vimeo_pro_data($this->settings);


// class_exists check
endif;

?>

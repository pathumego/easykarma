<?php 
/*
Plugin Name: Ultimate Preloader
Plugin URI: http://www.2klabs.com/up
Description: Ultimate Preloader will create a preloading screen for your website before all your images (including the images in CSS) are fully loaded. It will come in handy when you wish to preload all the images on your page before exposed to user.
Version: 1.1
Author: Enid Colic
Author URI: http://www.enid-design.com/
License: GPLv2
*/

define( 'UP_PATH', plugin_dir_url(__FILE__) );

//*************** Enqueue Scripts ***************
add_action('admin_enqueue_scripts', 'up_enqueue_scripts');

function up_enqueue_scripts() {
    wp_register_script( 'up-admin-script', UP_PATH.'js/up_admin_script.js', array('jquery','media-upload','thickbox','farbtastic') );
    wp_register_style( 'up-css', UP_PATH.'css/style.css');
    
    wp_register_script( 'up-chck-script', UP_PATH.'js/jq.chck.min.js', array('jquery','media-upload','thickbox','farbtastic') );
    wp_register_style( 'up-chck-css', UP_PATH.'css/jq.chck.css');

    if ( 'settings_page_UltimatePreloader' == get_current_screen()->id ) {
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('thickbox');
        wp_enqueue_style('thickbox');
        wp_enqueue_style('farbtastic');
        wp_enqueue_script('farbtastic');
        wp_enqueue_script('up-admin-script');
        wp_enqueue_style('up-css');
        wp_enqueue_script('up-chck-script');
        wp_enqueue_style('up-chck-css');
    }
}


//*************** Activation ***************
register_activation_hook( __FILE__, "up_activated");

function up_activated() {
    
	$default_opts = array(
            'enabled_opt' => '1',
            'homeonly_opt' => '1',
            'percetange_opt' => '1',
            'percetange_size_opt' => '40',
            'line_color_opt' => '#29a2db',
            'bg_color_opt' => '#000000',
            'preloader_style_opt' => '3',
            'bar_height_opt' => '1',
            'custom_width_opt' => '0',
            'bg_image_opt' => '',
            'bg_image_position_opt' => '1',
            'percetange_position_opt' => '1'
        );

	add_option("up_opts", $default_opts);
}


//*************** Deactivation ***************
register_deactivation_hook(__FILE__, 'up_deactivated');

function up_deactivated() {
       delete_option('up_opts');
}

//*************** Admin Init ***************
add_action('admin_init', 'up_opts_init' );

function up_opts_init(){
    register_setting('up_opts', 'up_opts', 'up_opts_validate');
    add_settings_section('main_section', 'Main Settings', 'main_section_text', __FILE__);
    add_settings_section('percetange_section', 'Percetange Settings', 'percetange_section_text', __FILE__);
    add_settings_section('pbar_section', 'Preloader Bar Settings', 'pbar_section_text', __FILE__);
    add_settings_section('pbackground_section', 'Preloader Background Image Settings', 'pbackground_section_text', __FILE__);
    
    add_settings_field('homeonly_opt', 'Homepage only', 'homeonly_opt', __FILE__, 'main_section');
    add_settings_field('line_color_opt', 'Preloader Color', 'line_color_opt', __FILE__, 'main_section');
    add_settings_field('bg_color_opt', 'Background Color', 'bg_color_opt', __FILE__, 'main_section');
    add_settings_field('preloader_style_opt', 'Preloader Style', 'preloader_style_opt', __FILE__, 'main_section');
    
    add_settings_field('bar_height_opt', 'Bar Height', 'bar_height_opt', __FILE__, 'pbar_section');
    add_settings_field('custom_width_opt', 'Custom Bar Width', 'custom_width_opt', __FILE__, 'pbar_section');
    add_settings_field('bar_maxwidth_opt', 'Bar Width', 'bar_maxwidth_opt', __FILE__, 'pbar_section');
    
    add_settings_field('percetange_opt', 'Percetange', 'percetange_opt', __FILE__, 'percetange_section');
    add_settings_field('percetange_size_opt', 'Percetange text size', 'percetange_size_opt', __FILE__, 'percetange_section');
    add_settings_field('percetange_position_opt', 'Percetange Text Position', 'percetange_position_opt', __FILE__, 'percetange_section');

    add_settings_field('bg_image_opt', 'Background Image', 'bg_image_opt', __FILE__, 'pbackground_section');
    add_settings_field('bg_image_position_opt', 'Preloader Background Image Position', 'bg_image_position_opt', __FILE__, 'pbackground_section');
}

function main_section_text(){
}
function percetange_section_text(){
}
function pbar_section_text(){
}
function pbackground_section_text(){
}

function up_opts_validate($input) {
	return $input; 
}


//*************** Admin Init - Replace button text & Remove fields ***************
add_action( 'admin_init', 'up_media_options' ); 

function up_media_options() {  
    global $pagenow;  
    
    if ( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow ) {  
        add_filter( 'gettext', 'up_replace_thickbox_text'  , 1, 3 ); 
        add_filter('attachment_fields_to_edit','up_remove_caption', 10, 2);
    } 
} 

function up_replace_thickbox_text($translated_text, $text, $domain) { 
  
    if ('Insert into Post' == $text) { 
        $referer = strpos( wp_get_referer(), 'up_options_page' ); 
        if ( $referer != '' ) { 
            return 'Use image as preloader background';  
        }  
    }  
    return $translated_text;  
}  

function up_remove_caption($form_fields, $post) {
    unset(
        $form_fields['post_title'],
        $form_fields['image_alt'], 
        $form_fields['post_excerpt'], 
        $form_fields['post_content'], 
        $form_fields['align'], 
        $form_fields['image-size']
    );

    $form_fields['url'] = array(
        'label' => '', 
        'input' => 'html',
        'html' =>  '<div style="display:none;">' . $form_fields['url']['html'] . '</div>',        
        'helps' => ''
    );    
 
    $size = 'full';
    $css_id = "image-size-{$size}-{$post->ID}";
    $html = "<div style='display: none;' class='image-size-item'><input type='radio' name='attachments[$post->ID][image-size]' id='{$css_id}' value='{$size}'checked='checked' /></div>";

    $form_fields['image-size'] = array(
       'label' => '', 
       'input' => 'html',
       'html' => $html
    ); 

    return $form_fields;
}


//*************** Settings ***************
function enabled_opt() {
    $options = get_option('up_opts');
    if(isset($options['enabled_opt'])){  
        echo "<input type='checkbox' name='up_opts[enabled_opt]' value='1' checked='checked'/>";
    }else{
        echo "<input type='checkbox' name='up_opts[enabled_opt]' value='1'/>";
    }    
    echo '<p class="description">Enable/Disable preloader.</p>';
}

function homeonly_opt() {
    $options = get_option('up_opts');
    if($options['homeonly_opt']){  
        echo "<input type='checkbox' class='chck_me' name='up_opts[homeonly_opt]' value='1' checked='checked'/>";
    }else{
        echo "<input type='checkbox' class='chck_me' name='up_opts[homeonly_opt]' value='1'/>";
    }    
    
    echo '<p class="description">Show preloader on home page only?</p>';
}
function percetange_opt() {
    $options = get_option('up_opts');
    if($options['percetange_opt']){  
        echo "<input type='checkbox' class='chck_me' name='up_opts[percetange_opt]' value='1' checked='checked'/>";
    }else{
        echo "<input type='checkbox' class='chck_me' name='up_opts[percetange_opt]' value='1'/>";
    }    
    
    echo '<p class="description">Show/Hide percetange.</p>';
}


function line_color_opt() {
    $options = get_option('up_opts');
    if(!isset($options['line_color_opt'])){  
        $value = '#29a2db';
    }else{
        $value = $options['line_color_opt'];
    }
    ?>
    <div class="color-picker" style="position: relative;">
        <input type="text" name="up_opts[line_color_opt]" value="<?php echo $value; ?>" id="line_color_opt" class="color" />
        <div class="color-picker-abs" id="line_color_opt_picker"></div>
    </div>
    <?php
}

function bg_color_opt() {
    $options = get_option('up_opts');
    if(!isset($options['bg_color_opt'])){  
        $value = '#000000';
    }else{
        $value = $options['bg_color_opt'];
    }
    ?>
    <div class="color-picker" style="position: relative;">
        <input type="text" name="up_opts[bg_color_opt]" value="<?php echo $value; ?>" id="bg_color_opt" class="color" />
        <div class="color-picker-abs" id="bg_color_opt_picker"></div>
    </div>
    <?php
    echo '<p class="description">Select colors for your preloader.</p>';
}

function preloader_style_opt() {
    $options = get_option('up_opts');
    
    $select_values = array('1' => 'Style 1','2' => 'Style 2','3' => 'Style 3');
    
    echo "<select name='up_opts[preloader_style_opt]'>";
    foreach ($select_values as $option_val => $value) {
        if($options['preloader_style_opt'] == $option_val){  
            echo "<option value='{$option_val}' selected='selected'>{$value}</option>";
        }else{
            echo "<option value='{$option_val}'>{$value}</option>";
        }   
    }
    echo "</select>";
    echo '<p class="description">Select animation for end of the preloader.</p>';
}

function percetange_size_opt() {
    $options = get_option('up_opts');
    
    if(!isset($options['percetange_size_opt'])){  
        $value = '40';
    }else{
        $value = $options['percetange_size_opt'];
    }

    echo "<input id='percetange_size_opt' name='up_opts[percetange_size_opt]' value='{$value}' type='number' step='1' min='1' max='10000' class='small-text' />px";   
    echo '<p class="description">Set percetange text size.</p>';
}

function percetange_position_opt(){
    $options = get_option('up_opts');
    if(!isset($options['percetange_position_opt'])){  
        $value = '1';
    }else{
        $value = $options['percetange_position_opt'];
    }
    
    echo '<div class="up_full_width"><ul id="up_sortable_perc">';
    for ($i = 0; $i <= 5; $i++) {
        if($i == $value){
            echo '<li class="ui-state-default red"></li>';
        }else{
            echo '<li class="ui-state-default no_move"></li>';
        }
    }
    echo '</ul> </div>';

    echo "<input id='percetange_position_opt' name='up_opts[percetange_position_opt]' value='{$value}' type='hidden' />";   
    echo '<p class="description">Chose position for percetange text by dragging red box.</p>';
}

function bar_height_opt() {
    $options = get_option('up_opts');
    
    if(!isset($options['bar_height_opt'])){  
        $value = '1';
    }else{
        $value = $options['bar_height_opt'];
    }

    echo "<input id='bar_height_opt' name='up_opts[bar_height_opt]' value='{$value}' type='number' step='1' min='1' max='10000' class='small-text' />px";   
    echo '<p class="description">Set preloader bar height.</p>';
}


function custom_width_opt() {
    $options = get_option('up_opts');
    if($options['custom_width_opt']){  
        echo "<input type='checkbox' class='chck_me' name='up_opts[custom_width_opt]' value='1' checked='checked'/>";
    }else{
        echo "<input type='checkbox' class='chck_me' name='up_opts[custom_width_opt]' value='1'/>";
    }    
    echo '<p class="description">Enable/Disable custom bar width.<br />If disabled preloader bar width will be 100%.</p>';
}

function bar_maxwidth_opt() {
    $options = get_option('up_opts');
    
    if(!isset($options['bar_maxwidth_opt'])){  
        $value = '400';
    }else{
        $value = $options['bar_maxwidth_opt'];
    }
    
    echo "<input id='bar_maxwidth_opt' name='up_opts[bar_maxwidth_opt]' value='{$value}' type='number' step='1' min='1' max='10000' class='small-text' />px";   
    echo '<p class="description">Set preloader bar width.</p>';
}


function bg_image_opt(){
    $options = get_option('up_opts');
    if(isset($options['bg_image_opt']) && $options['bg_image_opt'] != ''){
        echo '<img class="current_bg_image_opt_image" src="'.$options['bg_image_opt'].'" /><br>';
    }
    if($options['bg_image_opt'] == '') echo '<p class="no_image_flag">No image selected!</p>';
    
    echo '<input type="text" id="image_url" name="up_opts[bg_image_opt]" value="'.$options['bg_image_opt'].'" class="regular-text" />  
        <input id="upload_image_button" type="button" class="button" value="Select image" />  
        <br><p class="description">Select image (.png or .jpg) from your computer or Media library and click "Use image as preloader background" button.</p>';
    
}

function bg_image_position_opt(){
    $options = get_option('up_opts');
    if(!isset($options['bg_image_position_opt'])){  
        $value = '1';
    }else{
        $value = $options['bg_image_position_opt'];
    }
    
    echo '<div class="up_full_width"><ul id="up_sortable">';
    for ($i = 0; $i <= 8; $i++) {
        if($i == $value){
            echo '<li class="ui-state-default red"></li>';
        }else{
            echo '<li class="ui-state-default no_move"></li>';
        }
    }
    echo '</ul> </div>';
    echo "<input id='bg_image_position_opt' name='up_opts[bg_image_position_opt]' value='{$value}' type='hidden' />";   
    echo '<p class="description">Chose position for your background image by dragging red box.</p>';
}


//*************** Admin Panel ***************
add_action('admin_menu', 'up_admin_actions');

function up_admin_panel() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    $options = get_option('up_opts');
    
    ?>
    <div class="wrap" id="ultimate_preloader_options">
        <form action="options.php" method="post">
        
        <div id="poststuff">
            <div class="title_box">
                <img src="<?php echo UP_PATH ?>images/icon.png" alt="Logo" class="logo" />
                <h1>Ultimate Preloader -</h1>						
                <input type="checkbox" class="ch_location" name="up_opts[enabled_opt]"  <?php if ( $options['enabled_opt'] )  echo 'checked="true"' ?> />
            </div>	
            <div class="postbox" style="">
                <h3>Info</h3>
                <div style="margin: 10px !important;">
                    <p>- Ultimate Preloader will create a preloading screen for your website before all your images (including the images in CSS) are fully loaded. It will come in handy when you wish to preload all the images on your page before exposed to user.</p>
                    <p>- You can customize preloader as you wish, also you can use custom background image for your preloader, all you need is to upload image from your computer or choose one from media library. Allowed image types are JPG and PNG.</p><br />         
                    
                    <p>- Save settings and see preloader in action. If you have any questions go to <a href="http://www.2klabs.com/up" target="_blank">Plugin homepage</a>.</p>
                    
                  
                </div>
            </div>
            <div class="postbox">
                <?php settings_fields('up_opts'); ?>
                <?php do_settings_sections(__FILE__); ?>
                <p class="submit" style="margin-left: 10px;">
                    <input id="submit-up-options" name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
                </p>
            </div>
        </div>
        </form>
    </div>
<?php
}

function up_admin_actions() {
    add_options_page("Ultimate Preloader Options", "Ultimate Preloader", 'manage_options', "UltimatePreloader", "up_admin_panel");
}



//*************** Frontend ***************
add_action('wp_head', 'insert_head_UP');
add_action('wp_enqueue_scripts', 'enqueue_UP');


function enqueue_UP() {
    $options = get_option('up_opts');
    if ((is_front_page() && $options['homeonly_opt'] == '1') ||  $options['homeonly_opt'] != '1') {
        wp_enqueue_script('jquery');
        wp_register_script('up-script', UP_PATH . 'js/ups.js');
        wp_enqueue_script('up-script');
    }
}

function insert_head_UP() {
    $options = get_option('up_opts');
    if ( (is_front_page() && $options['homeonly_opt'] == '1') ||  $options['homeonly_opt'] != '1' ) {
    if($options['enabled_opt']){
        
        switch ($options['bg_image_position_opt']) {
            case '0':
                $bg_img_pos = 'top left';
                break;
            case '1':
                $bg_img_pos = 'top center';
                break;
            case '2':
                $bg_img_pos = 'top right';
                break;
            case '3':
                $bg_img_pos = 'center left';
                break;
            case '4':
                $bg_img_pos = 'center center';
                break;
            case '5':
                $bg_img_pos = 'center right';
                break;
            case '6':
                $bg_img_pos = 'bottom left';
                break;
            case '7':
                $bg_img_pos = 'bottom center';
                break;
            case '8':
                $bg_img_pos = 'bottom right';
                break;
            default:
                $bg_img_pos = 'top center';
                break;
        }
    ?>
        <!-- Ultimate Preloader -->     
        <script type="text/javascript" >
        (function($) {
            $(document).ready(function () {
            $("body").UP2LoaderJQ({
                barColor:           "<?php  echo $options['line_color_opt']; ?>",
                backgroundColor:    "<?php  echo $options['bg_color_opt']; ?>",
                percentage:         <?php   if($options['percetange_opt'] == '1'){ echo 'true'; }else{ echo 'false'; } ?>,
                barHeight:          <?php   if($options['bar_height_opt']){echo $options['bar_height_opt'];}else{ echo '1'; } ?>,
                completeAnimation:  "<?php  if(isset($options['preloader_style_opt'])){echo $options['preloader_style_opt'];}else{ echo '1'; } ?>",
                minimumTime:        100,
                mwidth:             "<?php   if(isset($options['bar_maxwidth_opt'])){echo $options['bar_maxwidth_opt'];}else{ echo '100%'; } ?>",
                custom_width_opt:   "<?php   if($options['custom_width_opt'] == '1'){echo $options['custom_width_opt'];}else{ echo '0'; } ?>",
                preloaderBgImg:     "<?php   if($options['bg_image_opt']){echo $options['bg_image_opt'];} ?>",
                preloaderBgImgPos:   "<?php   echo $bg_img_pos; ?>",
                percetange_size_opt: "<?php echo $options['percetange_size_opt']; ?>",
                percetange_position_opt: "<?php echo $options['percetange_position_opt']; ?>"
            });
        });
        })(jQuery);
        </script>
        <!-- Ultimate Preloader -->
    <?php 
    }
    }
}
?>
<?php
namespace BN\ContentPost;

use BN\ContentPost\Helpers;

class Base {
    protected $controller;

    public function __construct() {
        $this->addActions();
        $this->addFilters();
    }
    
    public function addActions() {
        add_action('admin_enqueue_scripts', array(&$this, 'adminEnqueueScripts')); 
        add_action('admin_menu', array($this, 'adminMenu'));
        add_action('init',array(&$this,'executeLibraryController'));
        add_action('init', array(&$this,'disable_comments_admin_bar'));
        add_action('add_meta_boxes', array(&$this,'register_fields_metaboxes'));
        add_action('save_post', array(&$this,'save_metadata'));
        add_action('admin_init',array(&$this,'adminInit'));
        add_action('admin_init', array(&$this,'disable_comments_dashboard'));
        add_action('admin_menu', array($this, 'hide_options'));
        add_action('admin_enqueue_scripts', array(&$this, 'enqueue_custom_scripts'));
        add_action('admin_menu', array(&$this,'disable_comments_admin_menu'));
    }
    
    public function addFilters() {
        add_filter('gettext', array(&$this,'change_admin_cpt_text_filter'), 20, 3);
        add_filter('post_date_column_time' , array(&$this,'sst_post_date_column_time'), 10, 2);
        add_filter('comments_open', array(&$this,'disable_comments_status'), 20, 2);
        add_filter('pings_open', array(&$this,'disable_comments_status'), 20, 2);
        add_filter('comments_array', array(&$this,'disable_comments_hide_existing_comments', 10, 2));
    }
    
    public function adminMenu() {
        add_submenu_page(
            'edit.php',
            __('Settings', Helpers::LOCALE),
            __('Settings', Helpers::LOCALE),
            'manage_options',
            'configure'.Helpers::NAMESPACE,
            array($this, 'executeAdminController')
        );
    }
    
    public function adminEnqueueScripts() {
        wp_register_script(Helpers::NAME.'-configure', Helpers::jsUrl( Helpers::NAME.'-configure.js' ), array('jquery'), '20170604', false);
        wp_register_style(Helpers::NAME.'-configure', Helpers::cssUrl(Helpers::NAME.'-configure.css'), array(), '20170604');
        wp_register_style(Helpers::LOCALE, Helpers::cssUrl(Helpers::NAME.'.css'), array(), '20170604');
        
        /*wp_localize_script(Helpers::LOCALE, 'fields', Helpers::getOption(Helpers::NAMESPACE."_fields"));
        wp_localize_script(Helpers::LOCALE, 'ajaxurl', Helpers::ajaxUrl());
        wp_enqueue_script(Helpers::LOCALE);
        wp_enqueue_style(Helpers::LOCALE);*/
        
        wp_enqueue_script('jquery-validate-min','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js', array('jquery'));
    }
    
    public function executeLibraryController() {
        $this->controller = LibraryController::getInstance();
        if (current_action() == "init"){
            $action = "init";
        } else if (isset($_POST['action'])) {
            $action = $_POST['action'];
        } else if (isset($_GET['page'])) {
            if (strpos($_GET['page'], Helpers::NAMESPACE) !== false) {
                $action = str_replace(Helpers::NAMESPACE, "", $_GET['page']);
            }
        } else if (!isset($_GET['page']) && !isset($_GET['action'])) {
            $action = "init";
        }
        $this->controller->setAction($action);
        $this->controller->execute();
    }
    
    public function executeAdminController() {
        $this->controller = AdminController::getInstance();
        if (current_action() == "init"){
            $action = "init";
        } else if (isset($_POST['action'])) {
            $action = $_POST['action'];
        } else if (isset($_GET['page'])) {
            if (strpos($_GET['page'], Helpers::NAMESPACE) !== false) {
                $action = str_replace(Helpers::NAMESPACE, "", $_GET['page']);
            }
        } else if (!isset($_GET['page']) && !isset($_GET['action'])) {
            $action = "init";
        }
        $this->controller->setAction($action);
        $this->controller->execute();
    }
    
    public function adminInit() {
        add_theme_support( 'post-thumbnails' );
        remove_post_type_support("post", 'custom-fields');
        remove_post_type_support("post", 'post-formats');
        remove_post_type_support("post", 'revisions');
        remove_post_type_support("post", 'comments');
        remove_post_type_support("post", 'trackbacks');
    }
    
    public function disable_comments_admin_menu() {
	   remove_menu_page('edit-comments.php');
    }
    
    public function disable_comments_dashboard() {
	   remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
    }
    
    public function disable_comments_admin_bar() {
	if (is_admin_bar_showing()) {
            remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
	}
    }
    
    public function disable_comments_status() {
	return false;
    }
    
    public function disable_comments_hide_existing_comments($comments) {
	$comments = array();
	return $comments;
    }
    
    public function register_fields_metaboxes($post_type) {
        if (in_array($post_type, array("post"))) {
            $_POST['action'] = "registerfieldsmetaboxes";
            $this->executeLibraryController();
        }
    }
    
    public function save_metadata($post_id) {
        $post = get_post($post_id);
        if (in_array($post->post_type, array("post"))) {
            $_POST['action'] = "savepostmetadata";
            $_POST['postId'] = $post_id;
            $this->executeLibraryController();
        }
    }
    
    public function change_admin_cpt_text_filter($translated_text, $untranslated_text, $domain) {
        switch( $untranslated_text ) {
            case 'Excerpt':
              $translated_text = __( 'Entradilla',Helpers::LOCALE );
            break;
        }
        return $translated_text;
    }
    
    public function hide_options() {
        global $submenu;
        $user = wp_get_current_user();
        $allowed_roles = array('administrator', 'wpseo_editor');
        if(!array_intersect($allowed_roles, $user->roles)) {
            unset($submenu["edit.php"][15]);
            unset($submenu["edit.php"][16]);
            unset($submenu["edit.php"][17]);
        }
    }
    
    public function enqueue_custom_scripts ($hook) {
        global $post;
        $user = wp_get_current_user();
        $disable_roles = array('editor');
        if(array_intersect($disable_roles, $user->roles ) ) {
            if ($post && in_array($post->post_type, array('video', 'post', 'gallery', 'newsletter', 'prize')) && in_array($hook, array('post.php', 'post-new.php'))){
                wp_enqueue_script('costum-post-js', Helpers::jsUrl( Helpers::NAME.'-hidetag.js' ), array('jquery'), '20171904');
            }
        }
        if ($post && in_array($post->post_type, array('video', 'post', 'gallery', 'newsletter')) && in_array($hook, array('post.php', 'post-new.php'))){
            $literals = Helpers::getOption(Helpers::NAMESPACE."_validationliterals");
            $tags = get_tags(array('fields' => 'names','hide_empty' => FALSE));
            $secch = get_terms("second_channel",array('fields' => 'names','hide_empty' => FALSE));
            wp_register_script('validation-post-js', Helpers::jsUrl( Helpers::NAME.'-validation.js' ), array('jquery'), '20170604', false);
            wp_register_script(Helpers::LOCALE, Helpers::jsUrl(Helpers::NAME.'.js'), array('jquery'), '20170604', false);
            wp_localize_script('validation-post-js', 'validationLiterals', $literals);
            wp_localize_script('validation-post-js', 'validationTags', $tags);
            wp_localize_script('validation-post-js', 'validationSecch', $secch);
            wp_localize_script('validation-post-js', 'validationRoles', $disable_roles);
            wp_localize_script('validation-post-js', 'validationUserRoles', $user->roles);
            wp_enqueue_script(Helpers::LOCALE);
            wp_enqueue_script('validation-post-js');
        }
    }
    
    public function sst_post_date_column_time( $h_time, $post ) {
        // If post is scheduled then add the time to the column output
        if ($post->post_status == 'future') {
            $h_time .= '<br>' . get_post_time( 'g:i a', false, $post );
        }
        // Return the column output
        return $h_time;
    }
}
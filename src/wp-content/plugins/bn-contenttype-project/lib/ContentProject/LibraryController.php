<?php
namespace BN\ContentPost;

use BN\ContentPost\Helpers;
use BN\ContentPost\Field\Factory;

class LibraryController extends BaseController {
    static $instance = null;

    static function & getInstance() {
        if (null == self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    protected function allowedActions() {
        return array(
            'init',
            'registerfieldsmetaboxes',
            'savepostmetadata'
        );
    }
    
    public function execute() {
        if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) && $this->action !== "init") {
            wp_die( 'Access denied' );
        }
        parent::execute();
    }
    
    public function initAction() {
        if (get_current_user_id()){
            $this->set_user_metaboxes();
        }
        $fields = Helpers::getOption(Helpers::NAMESPACE."_fields");
        foreach ($fields["extra"] as $fieldkey => $fieldvalue) {
            $fieldObject = Factory::get_field_instance($fieldkey);
            if (!empty($fieldvalue['required']) && !empty($fieldvalue['enabled'])){
                $fieldObject->init();
            }
        }
    }
    
    public function registerfieldsmetaboxesAction() {
        $fields = Helpers::getOption(Helpers::NAMESPACE."_fields");
        foreach ($fields["extra"] as $fieldkey => $fieldvalue) {
            if (!empty($fieldvalue['required']) && !empty($fieldvalue['enabled']) && isset($fieldvalue['metabox'])){
                $fieldObject = Factory::get_field_instance($fieldkey);
                $fieldObject->register_field_metabox();
            }
        }   
    }
    
    public function savepostmetadataAction() {
        $post_id = Helpers::getRequestPostParam("postId");
        $fields = Helpers::getOption(Helpers::NAMESPACE."_fields");
        foreach ($fields["extra"] as $fieldkey => $fieldvalue) {
            if ($fieldvalue['metabox']){
                $fieldObject = Factory::get_field_instance($fieldkey);
                $fieldObject->save_field_metadata($post_id);
            }
        }
    }
    
    private function set_user_metaboxes($user_id = null) {
        $fields = Helpers::getOption(Helpers::NAMESPACE."_fields");
        $positions = array(
            "side" => array('submitdiv','authordiv','slugdiv','categorydiv','tagsdiv-post_tag','postimagediv'),
            "normal" => array('postexcerpt'),
            "advanced" => array()
        );
        
        foreach ($fields["extra"] as $fieldkey => $fieldvalue) {
            if ($fieldvalue['metabox']){
                array_push($positions[$fieldvalue['metabox']['context']], $fieldvalue['metabox']['id']);
            }
        }
        
        if (is_plugin_active("wordpress-seo/wp-seo.php")){
            array_push($positions["normal"], "wpseo_meta");
        }
        
        $meta_value_order = array(
            'side' => implode(",", $positions["side"]),
            'normal' => implode(",", $positions["normal"]),
            'advanced' => implode(",", $positions["advanced"]),
        );
        
        $meta_value_hide = array();
        
        $meta_key['order'] = 'meta-box-order_post';
        $meta_key['hidden'] = 'metaboxhidden_post';

        if (!$user_id){
            $user_id = get_current_user_id();
        }
        $order = get_user_meta($user_id, $meta_key['order'], true);
        if ($order !== $meta_value_order) {
            update_user_meta( $user_id, $meta_key['order'], $meta_value_order);
        }                
        $hidden = get_user_meta($user_id, $meta_key['hidden'], true);
        if ($hidden !== $meta_value_hide) {
            update_user_meta( $user_id, $meta_key['hidden'], $meta_value_hide);
        }
    }
}
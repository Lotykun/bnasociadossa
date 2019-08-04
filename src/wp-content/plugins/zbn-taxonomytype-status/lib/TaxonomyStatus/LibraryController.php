<?php
namespace BN\TaxonomyStatus;

use BN\TaxonomyStatus\Helpers;
class LibraryController extends BaseController {
    static $instance = null;

    static function & getInstance() {
        if (null == LibraryController::$instance) {
            LibraryController::$instance = new LibraryController();
        }
        return LibraryController::$instance;
    }
    
    protected function allowedActions() {
        return array(
            'init',
        );
    }
    
    public function execute() {
        if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) && $this->action !== "init") {
            wp_die( 'Access denied' );
        }
        parent::execute();
    }
    
    public function initAction() {
        $this->register_taxonomy();
    }
    
    private function register_taxonomy(){
        $labels = array(
            'name'              => __( 'Status', 'bn-taxonomytype-status' ),
            'singular_name'     => __( 'Status', 'bn-taxonomytype-status' ),
            'search_items'      => __( 'Search Status', 'bn-taxonomytype-status' ),
            'all_items'         => __( 'All Status', 'bn-taxonomytype-status' ),
            'parent_item'       => __( 'Parent Status', 'bn-taxonomytype-status' ),
            'parent_item_colon' => __( 'Parent Status:', 'bn-taxonomytype-status' ),
            'edit_item'         => __( 'Edit Status', 'bn-taxonomytype-status' ),
            'update_item'       => __( 'Update Status', 'bn-taxonomytype-status' ),
            'add_new_item'      => __( 'Add New Status', 'bn-taxonomytype-status' ),
            'new_item_name'     => __( 'New Status Name', 'bn-taxonomytype-status' ),
            'menu_name'         => __( 'Status', 'bn-taxonomytype-status' ),
            'not_found'         => __( 'No Status found', 'bn-taxonomytype-status' ),
	);

	$args = array(
            'hierarchical'      => false,
            'labels'            => $labels,
            'public'            => false,
            'show_ui'           => true,
            'show_admin_column' => true,
            'rewrite'           => false,
	);

	register_taxonomy( BN_TAXONOMYSTATUS_TAX_NAME_SING, array('project'), $args );
    }
}
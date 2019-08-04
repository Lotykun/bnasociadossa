<?php
namespace BN\TaxonomyStatus;

use BN\TaxonomyStatus\Helpers;
class AdminController extends BaseController {
    static $instance = null;
        
    static function & getInstance() {
        if (null == AdminController::$instance) {
            AdminController::$instance = new AdminController();
        }
        return AdminController::$instance;
    }
    
    protected function allowedActions() {
        return array(
            'populate',
        );
    }
    
    public function execute() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Access denied' );
        }
        parent::execute();
    }
    
    public function populateAction() {
        if (count($_POST)) {
            if ( !wp_verify_nonce( isset( $_POST['_taxstatusnonce'] ) ? $_POST['_taxstatusnonce'] : null, 'populate' )) {
                print 'Sorry, your nonce did not verify.';
                exit;
            }
            if (isset($_POST['populate'])) {
                $categories_ids = get_terms( 'category', array( 'fields' => 'ids', 'hide_empty' => false ) );
                foreach ($categories_ids as $category_id) {
                    $this->load_term($category_id);
                }
                $message = __('Data Populate with success!!!', 'bn-taxonomytype-status');
                $type = "notice-success";
            } else if (isset($_POST['delete'])) {
                $terms = get_terms( 'status', array( 'fields' => 'ids', 'hide_empty' => false ) );
                foreach ( $terms as $value ) {
                    wp_delete_term( $value, 'status' );
                }
                $message = __('Data Deleted with success!!!', 'bn-taxonomytype-status');
                $type = "notice-success";
            }
            
            $this->addParams(array(
                "notice" => array(
                    "message" => $message,
                    "type" => $type
                )
            ));
        }
        $params = $this->getParams();
        echo $this->renderView( 'admin/populate.twig', $params );
    }
    
    private function load_term($term_id) {
        $term = get_term($term_id);
        $args = array(
            'description'=> $term->description,
            'slug' => $term->slug,
        );
        if (!term_exists($term->name, 'status')) {
            wp_insert_term($term->name, 'status', $args);
        }
    }
}
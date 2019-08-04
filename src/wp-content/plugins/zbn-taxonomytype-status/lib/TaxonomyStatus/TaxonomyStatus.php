<?php
namespace BN\TaxonomyStatus;

class TaxonomyStatus {
    static $instance = null;
    
    static function & getInstance() {
        if (null == self::$instance) {
            self::$instance = new TaxonomyStatus();
        }

        return self::$instance;
    }
    public function __construct() {
    
        $Base = new Base();
        
        /*register_activation_hook($file, array(&$this, 'install'));
        register_deactivation_hook($file, array(&$this, 'deinstall'));*/
    }
}
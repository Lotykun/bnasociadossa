<?php
namespace BN\ContentProject\Field;

use \BN\ContentProject\LibraryController;
use \BN\ContentProject\Helpers;
use \BN\Core\Field as FieldCore;

abstract class Field extends FieldCore {
    
    public function template_field_metabox($post) {
        $controller = LibraryController::getInstance();
        $controller->emptyParams();
        $field_post_meta = $this->get_field_pre_value($post->ID);
        
        $this->specific_field_metabox();
        
        wp_localize_script(Helpers::NAME.'-'.$this->configuration["type"].'-metabox', 'ajaxurl', Helpers::ajaxUrl());
        wp_enqueue_script(Helpers::NAME.'-'.$this->configuration["type"].'-metabox');
        if (isset($field_post_meta) && !empty($field_post_meta)){
            $controller->addParams(array(
                "data" => $field_post_meta
            ));
        }
        $controller->addParams(array(
            "field_id" => $this->configuration['metakey'],
            "field_label" => $this->configuration['label']
        ));
        $params = $controller->getParams();
        echo $controller->renderView('front/metabox/'.$this->configuration["type"].'_metabox.twig', $params);
    }
}
<?php
namespace BN\ContentPost\Field;

use BN\ContentPost\Helpers;
use BN\Core\Field\iFactory;

class Factory implements iFactory {
    public static function get_field_instance($name) {
        $post_video_fields = Helpers::getOption(Helpers::NAMESPACE."_fields");
        if (isset($name) && !empty($name)){
            $conf = $post_video_fields['extra'][$name];
            $class = "\BN\ContentPost\Field\\".ucfirst($conf["type"]);
            $outputClass = new $class($conf);
        } else {
            $outputClass = "";
        }
        return $outputClass;
    }
}

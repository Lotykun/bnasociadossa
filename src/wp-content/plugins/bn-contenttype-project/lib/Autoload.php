<?php
namespace BN\ContentPost;

use BN\Core\Autoload as AutoloadCore;

class Autoload extends AutoloadCore {

    static $instance = null;
    static $path;
    static $namespace = __NAMESPACE__;
    
}
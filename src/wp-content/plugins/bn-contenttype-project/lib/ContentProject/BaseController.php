<?php
namespace BN\ContentPost;

use BN\CORE\Controller\Controller;
use BN\ContentPost\Helpers;

abstract class BaseController extends Controller {

    protected $classView = '\\BN\\ContentPost\\ViewRenderer';
    
    public function getParams() {
        return array_merge( array(
            'locale' => Helpers::LOCALE,
            'messages' => $this->getMessages(),
            'assets_url' => plugins_url('assets',Helpers::PLUGIN_FILE),
            'domain' => DOMAIN_CURRENT_SITE,
            'protocol' => PROTOCOL_CURRENT_SITE,
            'webName' => get_bloginfo( 'name' ),
            'access' => true,
        ), $this->params);
    }
}
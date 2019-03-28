<?php
/*EXTERNAL FUNCTIONS FOR THE PLUGIN... IN ORDER TO CALL THEM IS Helpers::function_name*/
namespace BN\ContentPost;

use BN\ContentPost\ViewRenderer;
use BN\Core\HelpersCommon;

class Helpers extends  HelpersCommon {

    const PLUGIN_FILE = BN_CONTENTPOST_PLUGIN_FILE;
    const ROOT = BN_CONTENTPOST_ROOT;
    const NAMESPACE = BN_CONTENTPOST_NAMESPACE;
    const NAME = BN_CONTENTPOST_NAME;
    const LOCALE = BN_CONTENTPOST_LOCALE;

    protected static $_settings = null;

    public static function getPluginPath() {
        $pluginsPath = DIRECTORY_SEPARATOR . 'wp-content' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR;
        return substr( static::PLUGIN_FILE, strpos( static::PLUGIN_FILE, $pluginsPath ) + strlen( $pluginsPath ) );
    }

    public static function getDefaultSettings() {
        $defaultSettings = require( plugin_dir_path(static::PLUGIN_FILE) . 'settings.php' );
        return $defaultSettings;
    }

    public static function pluginUrl( $uri = '' ) {
        return apply_filters( 'bn_contenttype_post_plugin_url', plugins_url( $uri, static::PLUGIN_FILE ), $uri );
    }
    
}
<?php

/*
Plugin Name: BN ContentType POST Plugin
Description: Plugin que genera campos especificos al contenttype POST.
Version: 1.0.0
Author: Juan Lotito
Text Domain: transversal
License: GPLv2
Depends: BN Service Core
*/

/* 
Copyright (C) 2015 jlotito

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*/

namespace BN\ContentPost;
use BN\ContentPost\Autoload;

define('BN_CONTENTPOST_PLUGIN_FILE', __FILE__ );
define('BN_CONTENTPOST_ROOT', dirname( __FILE__ ));
define('BN_CONTENTPOST_NAMESPACE', "ContentPost");
define('BN_CONTENTPOST_NAME', "bn-contenttype-post");
define('BN_CONTENTPOST_LOCALE', "bn-contenttype-post");

if (file_exists(BN_CONTENTPOST_ROOT.'/lib/Autoload.php')) {
    require_once(BN_CONTENTPOST_ROOT.'/lib/Autoload.php');
}
if (file_exists(BN_CONTENTPOST_ROOT.'/vendor/autoload.php')) {
    require_once(BN_CONTENTPOST_ROOT.'/vendor/autoload.php');
}
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

$Autoloader = Autoload::getInstance(BN_CONTENTPOST_ROOT);
$bncontentpost = ContentPost::getInstance();
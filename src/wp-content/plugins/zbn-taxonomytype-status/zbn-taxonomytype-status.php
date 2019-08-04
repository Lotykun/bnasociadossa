<?php

/*
Plugin Name: BN TaxonomyType Status Plugin
Plugin URI: http://www.bnasociados.com/
Description: Plugin que genera una nueva taxonomia llamada Estado.
Version: 1.0.0
Author: Juan Lotito
Author Email: lotykun@gmail.com
Text Domain: zbn-taxonomytype-status
Domain Path: /languages
License: GPLv2
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

namespace BN\TaxonomyStatus;
use BN\TaxonomyStatus\Autoload;

define('BN_TAXONOMYSTATUS_PLUGIN_FILE', __FILE__ );
define('BN_TAXONOMYSTATUS_ROOT', dirname( __FILE__ ));
define('BN_TAXONOMYSTATUS_NAMESPACE', "TaxonomyStatus");
define('BN_TAXONOMYSTATUS_TAX_NAME_SING', __('status', 'zbn-taxonomytype-status'));

if (file_exists(BN_TAXONOMYSTATUS_ROOT.'/lib/Autoload.php')) {
    require_once(BN_TAXONOMYSTATUS_ROOT.'/lib/Autoload.php');
}
if (file_exists(BN_TAXONOMYSTATUS_ROOT.'/vendor/autoload.php')) {
    require_once(BN_TAXONOMYSTATUS_ROOT.'/vendor/autoload.php');
}
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

$Autoloader = Autoload::getInstance(BN_TAXONOMYSTATUS_ROOT);
$zbntaxstatus = TaxonomyStatus::getInstance();
<?php
/**
 * An extension for WimaAdvertising for
 * Mediawiki until version 1.24
 *
 * PHP Version 5
 *
 * @category  Extension
 * @package   WimaAdvertising
 * @author    WikiMANNia <chef@wikimannia.org>
 * @copyright WikiMANNia
 * @license   
 * @version   GIT: 1.0
 * @link      https://www.mediawiki.org/wiki/Extension:WimaAdvertising
 */

/**
 * The main file of the WimaAdvertising extension
 *
 * This file is part of the MediaWiki extension WimaAdvertising.
 * The WimaAdvertising extension is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * The WimaAdvertising extension is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a License, this software is not free..
 *
 * @file
 */

###
# This is the path to your installation of Semantic Forms as
# seen on your local filesystem. Used against some PHP file path
# issues.
##
$dtgIP = dirname( __FILE__ );
$dir = __DIR__ . '/';
##

call_user_func(
	function () {
		if ( function_exists( 'wfLoadExtension' ) ) {
			wfLoadExtension( 'WimaAdvertising' );
			// Keep i18n globals so mergeMessageFileList.php doesn't break
			$wmMessagesDirs['WimaAdvertising'] = "$dtgIP/i18n";
			wfWarn(
			   'Deprecated PHP entry point used for WimaAdvertising extension. ' .
			   'Please use wfLoadExtension instead, ' .
			   'see https://www.mediawiki.org/wiki/Extension_registration ' .
			   'for more details.'
			);
			return;
		}
	}
);

$wmExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'WimaAdvertising',
	'version'        => '3.1.0a',
	'author'         => 'WikiMANNia',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:WimaAdvertising',
	'descriptionmsg' => 'wimaadvertising-desc',
);

$wmResourceModules['ext.wimaadvertising.common'] = array(
	'styles' => 'resources/css/Common.css',
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'WimaAdvertising',
	'dependencies' => array(
		'jquery.makeCollapsible',
	),
);
$wmResourceModules['ext.wimaadvertising.cologneblue'] = array(
	'styles' => 'resources/css/Cologneblue.css',
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'WimaAdvertising',
	'dependencies' => array(
		'jquery.makeCollapsible',
	),
);
$wmResourceModules['ext.wimaadvertising.mobile'] = array(
	'styles' => 'resources/css/Mobile.css',
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'WimaAdvertising',
	'dependencies' => array(
		'jquery.makeCollapsible',
	),
);
$wmResourceModules['ext.wimaadvertising.minerva'] = array(
	'styles' => 'resources/css/Minerva.css',
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'WimaAdvertising',
	'dependencies' => array(
		'jquery.makeCollapsible',
	),
);
$wmResourceModules['ext.wimaadvertising.modern'] = array(
	'styles' => 'resources/css/Modern.css',
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'WimaAdvertising',
	'dependencies' => array(
		'jquery.makeCollapsible',
	),
);
$wmResourceModules['ext.wimaadvertising.monobook'] = array(
	'styles' => 'resources/css/Monobook.css',
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'WimaAdvertising',
	'dependencies' => array(
		'jquery.makeCollapsible',
	),
);
$wmResourceModules['ext.wimaadvertising.timeless'] = array(
	'styles' => 'resources/css/Timeless.css',
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'WimaAdvertising',
	'dependencies' => array(
		'jquery.makeCollapsible',
	),
);
$wmResourceModules['ext.wimaadvertising.vector'] = array(
	'styles' => 'resources/css/Vector.css',
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'WimaAdvertising',
	'dependencies' => array(
		'jquery.makeCollapsible',
	),
);

// register all special pages and other classes
$wmMessagesDirs['WimaAdvertising'] = "$dtgIP/i18n";
$wmExtensionMessagesFiles['WimaAdvertisingAliases'] = $dir . 'WimaAdvertising.alias.php';
$wmAutoloadClasses['CustomAdvertisingSettings'] = "$dtgIP/includes/CustomAdvertisingSettings.php";
$wmAutoloadClasses['GoogleAdvertisingSettings'] = "$dtgIP/includes/GoogleAdvertisingSettings.php";
$wmAutoloadClasses['WimaAdvertisingHooks'] = "$dtgIP/includes/includes/Hooks.php";
$wmHooks['BeforePageDisplay'][] = 'WimaAdvertisingHooks::onBeforePageDisplay';

###
# This is the path to your installation of the Data Transfer extension as
# seen from the web. Change it if required ($wmScriptPath is the
# path to the base directory of your wiki). No final slash.
##
$dtgScriptPath = $wmScriptPath . '/extensions/WimaAdvertising';
##

// Global settings
$wmAdTopCode = "";
$wmAdTopType = "advertising";
$wmAdLeftCode = "";
$wmAdLeftType = "advertising";
$wmAdRightCode = "";
$wmAdRightType = "advertising";
$wmAdBottomCode = "";
$wmAdBottomType = "advertising";
$wmWimaAdvertisingAnonOnly = false;
$wmGoogleAdSenseClient = "none";
$wmGoogleAdSenseSlot = "none";
$wmGoogleAdSenseSrc = "//pagead2.googlesyndication.com/pagead/show_ads.js";
$wmGoogleAdSenseID = "none";
$wmGoogleAdSenseAnonOnly = false;
###


$wmExtensionFunctions[] = 'setupWimaAdvertisingExtension';

function setupWimaAdvertisingExtension() {
	global $wmDisableWimaAdvertising, $wmVersion;

	if ( version_compare( $wmVersion, '1.23', '<' ) ) {
		die( 'This extension requires MediaWiki 1.23+' );
	}
	elseif ( $wmDisableWimaAdvertising === false ) {
		global $wmAvailableRights, $wmGroupPermissions, $wmLogTypes, $wmLogActionsHandlers;
	}

	return true;
}

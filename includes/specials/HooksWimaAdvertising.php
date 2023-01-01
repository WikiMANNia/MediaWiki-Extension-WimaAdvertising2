<?php

class WimaAdvertisingHooks extends Hooks {

	/**
	 * Hook: BeforePageDisplay
	 * @param OutputPage $out
	 * @param Skin $skin
	 * https://www.mediawiki.org/wiki/Manual:Hooks/BeforePageDisplay
	 */
	public static function onBeforePageDisplay( OutputPage &$out, Skin &$skin ) {

		$user = $skin->getUser();

		if ( !self::isActive( $user ) )  return;

		$skinname = $skin->getSkinName();
		$out->addModules( 'ext.wimaadvertising.common' );
		$out->addModuleStyles( 'ext.wimaadvertising.mobile' );
		if ( CustomAdvertisingSettings::isSupportedSkin( $skinname ) ) {
			if ( $skinname === 'vector-2022' ) {
				$out->addModuleStyles( 'ext.wimaadvertising.vector' );
			} else {
				$out->addModuleStyles( 'ext.wimaadvertising.' . $skinname );
			}
		} else if ( $skinname !== 'fallback' ) {
			wfLogWarning( 'Skin ' . $skinname . ' not supported by WimaAdvertising.' . "\n" );
		}

		global $wgWimaAdvertisingScript;

		if ( !empty( $wgWimaAdvertisingScript ) ) {
			$out->addHeadItem( 'wima_advertising_script', $wgWimaAdvertisingScript );
		}

		$config = ConfigFactory::getDefaultInstance()->makeConfig( 'main' );
		$url_file = $config->get( 'ExtensionAssetsPath' ) . '/WimaAdvertising/resources/images/';
		$ad_label_show = lcfirst( $skin->msg( 'showtoc' )->text() );
		$ad_label_hide = lcfirst( $skin->msg( 'hidetoc' )->text() );

		$AD_1 = self::getAdCode( $user, 'top' );
		$AD_2 = self::getAdCode( $user, 'left' );
		$AD_3 = self::getAdCode( $user, 'right' );
		$AD_4 = self::getAdCode( $user, 'bottom' );

		if ( !empty( $AD_1 ) ) {
			$ad_label = $skin->msg( 'wimaadvertising-' . self::getAdType( $user, 'top' ) )->text();
			$out->addHTML( self::getAdBox( 1, $AD_1, $ad_label, $ad_label_show, $ad_label_hide ) );
		}
		if ( !empty( $AD_2 ) ) {
			$ad_label = $skin->msg( 'wimaadvertising-' . self::getAdType( $user, 'left' ) )->text();
			$out->addHTML( self::getAdBox( 2, $AD_2, $ad_label, $ad_label_show, $ad_label_hide ) );
		}
		if ( !empty( $AD_3 ) ) {
			$ad_label = $skin->msg( 'wimaadvertising-' . self::getAdType( $user, 'right' ) )->text();
			$out->addHTML( self::getAdBox( 3, $AD_3, $ad_label, $ad_label_show, $ad_label_hide ) );
		}
		if ( !empty( $AD_4 ) ) {
			$ad_label = $skin->msg( 'wimaadvertising-' . self::getAdType( $user, 'bottom' ) )->text();
			$out->addHTML( self::getAdBox( 4, $AD_4, $ad_label, $ad_label_show, $ad_label_hide ) );
		}
	}

	private static function getAdBox( $nr, $html, $ad_label, $ad_label_show, $ad_label_hide ) {
		$showtoc_label = $ad_label . ' ' . $ad_label_show;
		$hidetoc_label = $ad_label . ' [' . $ad_label_hide . ']';

		return '<div id="wima_label_' . $nr . '" class="wima_label wima_label_' . $nr . '" onclick="javascript:wimaOnOff(' . $nr . ')">' . $showtoc_label . '</div>
	<div id="wima_ad_' . $nr . '" class="wima_ad wima_ad_' . $nr . '"><div class="wima_ad_label" onclick="javascript:wimaOnOff(' . $nr . ')">' . $hidetoc_label . '</div>
	<br />' . $html . '</div>';
	}

	private static function isActive( $user ) {

		return ( CustomAdvertisingSettings::isActive( $user ) ||
			// If custom ad is not active, give google a chance
			GoogleAdvertisingSettings::isActive( $user ) );
	}

	private static function getAdCode( $user, $type ) {

		$return_value = '';
		$present_ad_found = false;

		if ( CustomAdvertisingSettings::isActive( $user ) ) {
			// Defined ad should be only used, if custom ad is activated
			$present_ad_found = CustomAdvertisingSettings::isPresentAd( $type );
			if ( $present_ad_found ) {
				$return_value = CustomAdvertisingSettings::getAdCode( $type );
			}
		}
		if ( !$present_ad_found && GoogleAdvertisingSettings::isActive( $user ) ) {
			// If custom ad is not defined or not activated, give google a chance
			$present_ad_found = GoogleAdvertisingSettings::isPresentAd( $type );
			if ( $present_ad_found ) {
				$return_value = GoogleAdvertisingSettings::getAdCode( $type );
			}
		}
		return $return_value;
	}

	private static function getAdType( $user, $type ) {

		$return_value = '';
		$present_ad_found = false;

		if ( CustomAdvertisingSettings::isActive( $user ) ) {
			$present_ad_found = CustomAdvertisingSettings::isPresentAd( $type );
			if ( $present_ad_found ) {
				$return_value = CustomAdvertisingSettings::getAdType( $type );
			}
		}
		if ( !$present_ad_found && GoogleAdvertisingSettings::isActive( $user ) ) {
			// If custom ad is not defined or not activated, give google a chance
			$present_ad_found = GoogleAdvertisingSettings::isPresentAd( $type );
			if ( $present_ad_found ) {
				$return_value = GoogleAdvertisingSettings::getAdType( $type );
			}
		}
		return $return_value;
	}
}
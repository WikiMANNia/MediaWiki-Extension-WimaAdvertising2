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
		$out->addModuleStyles( 'ext.wimaadvertising.common' );
		$out->addModuleStyles( 'ext.wimaadvertising.mobile' );
		if ( CustomAdvertisingSettings::isSupportedSkin( $skinname ) ) {
			$out->addModuleStyles( 'ext.wimaadvertising.' . $skinname );
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
			$msg_key  = 'wimaadvertising-' . self::getAdType( $user, 'top' );
			$ad_label = $skin->msg( $msg_key )->text();
			$ad_box = self::getAdBox( 1, $AD_1, $ad_label, $ad_label_show, $ad_label_hide );
			$out->addHTML( $ad_box );
		}
		if ( !empty( $AD_2 ) ) {
			$msg_key  = 'wimaadvertising-' . self::getAdType( $user, 'left' );
			$ad_label = $skin->msg( $msg_key )->text();
			$ad_box = self::getAdBox( 2, $AD_2, $ad_label, $ad_label_show, $ad_label_hide );
			$out->addHTML( $ad_box );
		}
		if ( !empty( $AD_3 ) ) {
			$msg_key  = 'wimaadvertising-' . self::getAdType( $user, 'right' );
			$ad_label = $skin->msg( $msg_key )->text();
			$ad_box = self::getAdBox( 3, $AD_3, $ad_label, $ad_label_show, $ad_label_hide );
			$out->addHTML( $ad_box );
		}
		if ( !empty( $AD_4 ) ) {
			$msg_key  = 'wimaadvertising-' . self::getAdType( $user, 'bottom' );
			$ad_label = $skin->msg( $msg_key )->text();
			$ad_box = self::getAdBox( 4, $AD_4, $ad_label, $ad_label_show, $ad_label_hide );
			$out->addHTML( $ad_box );
		}
	}

	private static function getAdBox( $nr, $html, $ad_label, $ad_label_show, $ad_label_hide ) {
		$showtoc_label = $ad_label . ' ' . $ad_label_show;
		$hidetoc_label = $ad_label . ' [' . $ad_label_hide . ']';
		$class_and_id_ad    = 'wima_ad_' . $nr;
		$class_and_id_label = 'wima_label_' . $nr;

		return '<div id="' . $class_and_id_label . '" class="wima_label ' . $class_and_id_label . '" onclick="javascript:wimaOnOff(' . $nr . ')">' . $showtoc_label . '</div>
	<div id="' . $class_and_id_ad . '" class="wima_ad ' . $class_and_id_ad . '"><div class="wima_ad_label" onclick="javascript:wimaOnOff(' . $nr . ')">' . $hidetoc_label . '</div>' .
	$html . '</div>';
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

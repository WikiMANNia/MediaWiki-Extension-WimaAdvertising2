<?php

/**
 * Settings is a singleton - used as a store of values for a particular site.
 *
 * This is a generic container, that can be used by other extensions to
 * store values other than ones that came from the database and/or were set
 * by the user - for instance, to store the amount of file space taken by
 * files uploaded for this wiki.
 */

class CustomAdvertisingSettings {

	private static $instance;

 	private $mActive;
 	private $mAnonOnly;

 	private $mDefaultType;
 	private $mTypeArray;
 	private $mCodeArray;

	private function __construct() {

		/**
		 * Global variables are set in 'extension.json' and
		 * also can be set in the 'LocalSettings.php'.
		 */

		// 1. Steuerung
		global $wmWimaAdvertising;
		global $wmWimaAdvertisingAnonOnly;

		$this->mActive   = empty( $wmWimaAdvertising         ) ? false : ( ( $wmWimaAdvertising         === true ) || ( $wmWimaAdvertising         === 'true' ) );
		$this->mAnonOnly = empty( $wmWimaAdvertisingAnonOnly ) ? false : ( ( $wmWimaAdvertisingAnonOnly === true ) || ( $wmWimaAdvertisingAnonOnly === 'true' ) );


		// 2. Spezifische Variablen für jeden Werbeblock
		global $wmAdBottomType, $wmAdTopType;
		global $wmAdLeftType,   $wmAdRightType;

		$this->mDefaultType = 'advertising';
		$this->mTypeArray['bottom'] = self::isSupportedType( $wmAdBottomType ) ? $wmAdBottomType : $this->mDefaultType;
		$this->mTypeArray['top']    = self::isSupportedType( $wmAdTopType    ) ? $wmAdTopType    : $this->mDefaultType;
		$this->mTypeArray['left']   = self::isSupportedType( $wmAdLeftType   ) ? $wmAdLeftType   : $this->mDefaultType;
		$this->mTypeArray['right']  = self::isSupportedType( $wmAdRightType  ) ? $wmAdRightType  : $this->mDefaultType;


		// HTML-Snippet für jeden Werbeblock, falls jedoch ungültige Parameter auf false setzen
		global $wmAdLeftCode,  $wmAdBottomCode;
		global $wmAdRightCode, $wmAdTopCode;

		$this->mCodeArray['bottom'] = empty( $wmAdBottomCode ) ? false : $wmAdBottomCode;
		$this->mCodeArray['top']    = empty( $wmAdTopCode    ) ? false : $wmAdTopCode;
		$this->mCodeArray['left']   = empty( $wmAdLeftCode   ) ? false : $wmAdLeftCode;
		$this->mCodeArray['right']  = empty( $wmAdRightCode  ) ? false : $wmAdRightCode;
	}

	private function __clone() { }

	/**
	 * @return self
	 */
	public static function getInstance() {
		if ( self::$instance === null ) {
			// Erstelle eine neue Instanz, falls noch keine vorhanden ist.
			self::$instance = new self();
		}

		// Liefere immer die selbe Instanz.
		return self::$instance;
	}

	/**
	 * $type: string
	 * return: string
	 */
	public static function getAdCode( $key ) {

		$_array = self::getInstance()->mCodeArray;
		$_return_value = '';

		if ( array_key_exists( $key, $_array ) ) {
			$_return_value = $_array[ $key ];
		} else {
			wfLogWarning( 'Custom::getAdCode was called for an unsupported key: "' . $key . '"' . "\n" );
		}
		return $_return_value;
	}

	/**
	 * $type: string
	 * return: bool
	 */
	public static function isPresentAd( $key ) {

		$_array = self::getInstance()->mCodeArray;
		$_return_value = false;

		if ( array_key_exists( $key, $_array ) ) {
			$_return_value = ( $_array[ $key ] !== false );
		} else {
			wfLogWarning( 'Custom::isPresentAd was called for an unsupported key: "' . $key . '"' . "\n" );
		}
		return $_return_value;
	}

	/**
	 * bool $user_LoggedIn
	 * return: bool
	 */
	public static function isActive( $user ) {

 		if ( self::getInstance()->mActive ) {
			return ( $user->isAnon() || !self::getInstance()->mAnonOnly );
 		}
		return false;
	}

	/**
	 * $type: string
	 * return: string
	 */
	public static function getAdType( $key ) {

		$_array        = self::getInstance()->mTypeArray;
		$_return_value = self::getInstance()->mDefaultType;

		if ( array_key_exists( $key, $_array ) ) {
			$_return_value = $_array[ $key ];
		} else {
			wfLogWarning( 'Custom::getAdType was called for an unsupported key: "' . $key . '"' . "\n" );
		}

		return $_return_value;
	}

	/**
	 * $skinname: string
	 * return: bool
	 */
	public static function isSupportedSkin( $key ) {
		return in_array( $key, [ 'cologneblue', 'minerva', 'modern', 'monobook', 'timeless', 'vector', 'vector-2022' ] );
	}

	/**
	 * $skinname: string
	 * return: bool
	 */
	public static function isSupportedType( $key ) {
		return in_array( $key, [ 'advertising', 'eventnote', 'hint' ] );
	}
}
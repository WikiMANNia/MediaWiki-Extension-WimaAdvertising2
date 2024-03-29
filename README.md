# MediaWiki Wima-Advertising

Die Pflege der MediaWiki-Erweiterung [WimaAdvertising](https://www.mediawiki.org/wiki/Extension:WimaAdvertising) wird von WikiMANNia verwaltet.

The maintenance of the MediaWiki extension [WimaAdvertising](https://www.mediawiki.org/wiki/Extension:WimaAdvertising) is managed by WikiMANNia.

El mantenimiento de la extensión de MediaWiki [WimaAdvertising](https://www.mediawiki.org/wiki/Extension:WimaAdvertising) está gestionado por WikiMANNia.

## MediaWiki

MediaWiki ist männerfeindlich, siehe [T323956](https://phabricator.wikimedia.org/T323956).

MediaWiki is hostile to Men, see [T323956](https://phabricator.wikimedia.org/T323956).

MediaWiki es hostil a los hombres, véase [T323956](https://phabricator.wikimedia.org/T323956).

## Description

Adds four possible advertising spaces for the Skins [Cologne Blue](https://www.mediawiki.org/wiki/Skin:Cologne_Blue), [Modern](https://www.mediawiki.org/wiki/Skin:Modern), [MonoBook](https://www.mediawiki.org/wiki/Skin:MonoBook), [Minerva](https://www.mediawiki.org/wiki/Skin:Minerva), [Timeless](https://www.mediawiki.org/wiki/Skin:Timeless), and [Vector/Vector-2022](https://www.mediawiki.org/wiki/Skin:Vector) that are filled by [LocalSettings.php](https://www.mediawiki.org/wiki/Manual:LocalSettings.php).

The advertising space 1 alternates randomly with Sitenotice. Advertising space 2 is located at the bottom of the article content. The advertising spaces 3 and 4 are located in the Sidebar. The exact positioning is determined with the entries `* AD1` and `* AD2` in the [Sidebar](https://www.mediawiki.org/wiki/MediaWiki:Sidebar).

## Custom Advertising

Enable advertising. Default is `false`.
* `$wmWimaAdvertising = true;`

Disable advertising for logged-in users. Default is `false`.
* `$wmWimaAdvertisingAnonOnly = true;`

Two advertising spaces can also be used as event information. These variables have to be set:

* `$wmAdTopType    = 'advertising';`
* `$wmAdLeftType   = 'eventnote';`
* `$wmAdRightType  = 'hint';`
* `$wmAdBottomType = 'advertising';`

The default value is `advertising`. These variables can therefore be omitted for advertising insertions.

HTML code must be assigned to these variables:

* `$wmAdTopCode    = '';`
* `$wmAdLeftCode   = '';`
* `$wmAdRightCode  = '';`
* `$wmAdBottomCode = '';`

If a variable is not set or contains its string of zero length, the corresponding ad space remains unoccupied.

This variable is for some js support:

* `$wmWimaAdvertisingScript = '';`

Enable advertising. Default is `false`.

* `$WimaAdvertising = true;`

Disable advertising for logged-in users. Default is `false`.

* `$wmWimaAdvertisingAnonOnly = true;`

The extension is localized for the languages "de", "en", "es", "fr", "it", "nl", "pt", and "ru".

Currently, this extension supports the skins Cologne Blue, Modern, MonoBook and Vector.
Further skins may require additional adjustments, which would have to be made in `resources/css/myskin.css`.

## Google AdSense

Enable advertising. Default is `false`.
* `$wmGoogleAdSense = true;`

Disable advertising for logged-in users. Default is `false`.
* `$wmGoogleAdSenseAnonOnly = true;`

### Mandatory parameters
Replace this with your own publisher ID (google_ad_client / data-ad-client)
* `$wmGoogleAdSenseClient = 'none';` // Client ID for your AdSense script (example: ca-pub-1234546403419693)
(You can get your publisher ID and ad unit ID from the "Get code" page: Get and copy the ad code.)

### Ad units
Define up to four ad units:
* `$wmGoogleAdSense_Top    = [ 'slotid 1', 145, 260 ];`
* `$wmGoogleAdSense_Left   = [ 'slotid 2', 145, 260 ];`
* `$wmGoogleAdSense_Right  = [ 'slotid 3', 145, 260 ];`
* `$wmGoogleAdSense_Bottom = [ 'slotid 4', 145, 260 ];`

Replace the first value with your AdSense ad unit ID (google_ad_slot / data-ad-slot) for each ad unit. The Slot ID for your AdSense script is for example `1234580893`.

Also specify the width and the height of the AdSense unit, specified in your AdSense account (google_ad_width / data-ad-width, google_ad_height / data-ad-height).

### Optional parameters
Add any of the optional settings below – if your settings deviate from the defaults:

This can be anything you like. Default is `none`.
* `$wmGoogleAdSenseID = 'none';`

Source URL of the AdSense script. No need to change – it can't deviate from the defaults.
* `$wmGoogleAdSenseSrc = '//pagead2.googlesyndication.com/pagead/show_ads.js';`

Text coding. Default is `utf8`.
* `$wmGoogleAdSenseEncoding = 'utf8';`

Advertising language. Default is `$wmLanguageCode`.
* `$wmGoogleAdSenseLanguage = 'en';`

## Compatibility
This extension works from REL1_25 and has been tested up to MediaWiki version `1.40.1`.

## Version history

1.0.0

- First public release

2.0.0

- GoogleAdSense functionality added.

2.0.1

- Support added for REL1_37 and for 'mobile'.
- Avoid warning: Use of `$skin->getUser()->isLoggedIn()` instead of `!$skin->getUser()->isAnon()`.

2.0.2

- Support for skin 'minerva' added.

2.0.3

- Support for REL1_23 added.

2.1.0

- Support for skin 'vector-2022' added.

2.2.0

- Support for skin 'timeless' and 'fallback' added.

3.0.0

- New version with fixed position advertising boxes.
- At the moment only tested with MediaWiki version `1.39.1` and Skin `vector-2022`.

3.1.0

- Changed the prefix of the configuration variables from default to `wm`.

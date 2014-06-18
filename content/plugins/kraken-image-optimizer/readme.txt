=== Kraken Image Optimizer ===
Contributors: karim79
Tags: Image Optimizer, Optimize, Images, Media, Performance, SEO, smushit, compress, kraken-image-optimizer
Requires at least: 3.0.1
Tested up to: 3.8.1
Donate link: https://kraken.io
Stable tag: 1.0.3.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html


This plugin allows you to optimize all your Wordpress images through the Kraken API


== Description ==

This plugin allows you to optimize new and existing Wordpress image uploads through [Kraken Image Optimizer's](https://kraken.io "Kraken Image Optimizer") API. Both lossless and lossy optimization modes are supported. Supported filetypes are JPEG, PNG and GIF. Maximum filesize limit is 8MB. For more details, including detailed documentation and plans and pricing, please visit [Kraken.io](https://kraken.io "Kraken Image Optimizer"). **Note: You will need to obtain a paid Kraken API key and secret to use this plugin**. 



* All images uploaded throught the media uploader are optimized on-the-fly. All generated thumbnails are optimized too.
* All images already present in the media library can be optimized individually, or using the Bulk Action menu "Krak 'em all" feature.
* This plugin does not require any root or command-line access. No compilation and installation of any binaries is necessary.
* All optimization is carried out by sending images to Kraken.io's infrastructure, and pulling the optimized files to your Wordpress installation.
* To use this plugin, you must obtain a full API key and secret from [https://kraken.io/plans](https://kraken.io/plans "Kraken Image Optimizer"). The Developer API key/secret will **not** work with this plugin.


Once you have obtained your credentials, from your Wordpress admin, go to the Settings->Media page. The Kraken Wordpress plugin adds a Kraken.io Settings section to the bottom of the page, from where you can enter your API credentials, and select your optimization preferences. Once you have done this, click **Save**. If everything is in order, it will simply say "settings saved" and give you a reassuring green tick in the **Kraken.io settings** section. You can now start optimizing images from within Media Library. Any image you upload from now on, through any of the media upload screens will be optimized on-the-fly by Kraken.

= Features on the way =
* Optimize images directly to Amazon S3.
* Optimize entire media library in one click.
* Optimize your currently active theme.
* Kraken NextGen Gallery extension.

Please send bug reports, problems, feature requests and so on to support (at) Kraken dot io, or directly to the author of this plugin.

= Connect with Kraken.io =
* Website: https://kraken.io
* [Twitter](https://twitter.com/KrakenIO "@KrakenIO")
* [Google+](https://plus.google.com/107209047753760492207/ "Google+")
* [Facebook](https://www.facebook.com/krakenio "Kraken Image Optimizer")

== Installation ==

To install the Kraken Wordpress Plugin:

1. Upload `kraken.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Enter your Kraken API key and secret into the new **Kraken.io Settings** section of Settings->Media.
4. Any images you upload from now on using Wordpress's Media Upload will be optimized according to your settings. Auto-generated thumbnails will also be optimized.
5. Images already present can be optimized from within the Media Library.

== Screenshots ==

1. This screenshot shows the new section which this plugin to Settings->Media. You must enter your credentials, and select your optimization mode from there, then hit **save**.
2. This screenshot shows the two columns added by Kraken Image Optimizer: **original image** and **Kraked size**, as well as the new **Optimize This Image** button which is present for images which already exist in your media library. Stats and optimization type are shown for optimized images.

== Frequently Asked Questions ==

= Can I test the plugin before I purchase an account from Kraken.io? =

No, you can't. You can, however, directly contact Kraken.io support for a private demonstration, if you like.
To test the performance and results of Kraken Image Optimizer, you can try the free Web Interface at https://kraken.io/web-interface

= Where can I purchase an API key and secret? =

From our plans page, right [here](https://kraken.io/plans "Kraken.io plans and pricing"). In addition to being able to use our Wordpress Plugin, you can also use the API in your own applications, and take advantage of our [Web Interface PRO ](https://kraken.io/pro "Kraken Web Interface PRO") feature.


== Changelog ==

= 1.0 =
* First version. Supports lossy and lossless optimization of JPG, PNG and GIF (including aniGIF) image formats
* Hooks to Media Uploader to optimize all uploaded images, including generated thumbnails.
* Allows optimization of existing images in Wordpress Media Library.

= 1.0.1 =
* Minor cleanup release.

= 1.0.2 =
* Thumbnails are now optimized when triggering an image optimization from within the media library.
* Number of Kraked thumbnails is now shown in media library in "Kraked Size" column.
* "Failed! Hover here" error notification does not persist where an image was not optimized. It goes away after page refresh.
* Optimize Image button no longer shown for incompatible media types.
* Information about thumbnail optimization is persisted for future fun-stats page/widget.
* Minor CSS tweaks.

= 1.0.2.1 =
* Fixed bug which led to kraked file not being retrieved in rare cases.
* Increase ajax timeout for media library inline kraking to be kinder to slower WordPress blogs.

= 1.0.3 =
* Bulk Actions menu in Media Library is now extended with "Krak 'em all", our Bulk Optimization feature. 
* Fixed a bug which caused old images' thumbnails to not be optimized.
* Fixed a failure condition which occured only on WPEngine-hosted systems.

= 1.0.3.1 =
* When using the Regenerate Thumbnails plugin with kraked images, meta data is now correctly updated per image.
* Optimization mode (lossy/lossless) is now stored with kraken thumbnail metadata (for future Stats page).

= 1.0.3.2 =
* Fixed bug related to storing optimized thumbnails metadata.



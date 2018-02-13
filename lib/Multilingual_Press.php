<?php

namespace Theme\Plugin\Multilingual_Press;

/**
 * Class Multilingual_Press
 */
class Multilingual_Press {
	/**
	 * Init hooks.
	 */
	public function init() {
		add_action( 'after_setup_theme', [ $this, 'unenqueue_styles' ] );
		add_action( 'widgets_init', [ $this, 'register_language_switcher_sidebar' ] );

		add_filter( 'mlp_redirect_url', [ $this, 'handle_bot_redirection' ] );

		/**
		 * MultilingualPress shows a checkbox to mark a post as translated by default. All untranslated
		 * posts would be listed in the WordPress Dashboard. This filter removes the feature to declutter
		 * the administration interface, because we don’t use the default dashboard.
		 *
		 * @link https://marketpress.de/documentation/multilingual-press-installation-und-einrichtung/beitraege-uebersetzen/
		 */
		add_filter( 'mlp_show_translation_completed_checkbox', '__return_false' );
	}

	/**
	 * Add theme support options for MultilingualPress.
	 *
	 * MultilingualPress adds default CSS stylesheets for features like the language switcher widget or the quicklink
	 * feature. When providing any value in the theme support for these features, the styles won’t be enqueued.
	 */
	public function unenqueue_styles() {
		add_theme_support( 'multilingualpress', [
			'language_switcher_widget_style' => true,
			'quicklink_style'                => true,
		] );
	}

	/**
	 * Language Switcher Sidebar
	 *
	 * Add a language switcher sidebar so that the widget provided by MultilingualPress can be added in the Widgets
	 * menu of the site.
	 */
	public function register_language_switcher_sidebar() {
		register_sidebar( [
			'name'          => 'Language Switcher',
			'id'            => 'language-switcher',
			'description'   => '',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
		] );
	}

	/**
	 * Do not redirect bots.
	 *
	 * MultilingualPress uses redirection based on browser language.
	 *
	 * @link http://make.multilingualpress.org/2014/03/language-negotiation-how-our-redirect-feature-works/
	 *
	 * Because search engine bots often crawl webpages with the language set to English, this would
	 * redirect a bot to the English site, even when he wants to visit the German site. This filter uses
	 * a bot list from https://stackoverflow.com/a/43430520/1059980 to disable the redirect.
	 */
	public function handle_bot_redirection( $url ) {
		if ( preg_match( '/apple|baidu|bingbot|facebookexternalhit|googlebot|-google|ia_archiver|msnbot|naverbot|pingdom|seznambot|slurp|teoma|twitter|yandex|yeti/i', $_SERVER['HTTP_USER_AGENT'] ) ) {
			return '';
		}

		return $url;
	}
}

## Theme\Plugin\Multilingual_Press

Opinionated MultilingualPress optimizations for WordPress themes.

- Adds a language switcher widget.
- Doesn’t add language switcher stylesheets in the frontend.
- Adds filter to never redirect search engine bots based on their browser language.
- Removes the «Translation Completed» checkbox when editing a post.

## Installation

You can install the package via Composer:

```bash
composer require mindkomm/theme-lib-plugin-multilingualpress
```

## Usage

**functions.php**

```php
$multilingualpress = new Theme\Plugin\Multilingual_Press\Multilingual_Press();
$multilingualpress->init();
```

### Add language switcher

```php
add_filter( 'timber/context', function( $context ) {
    $context['language_switcher'] = Timber::get_widgets( 'language-switcher' );
    
    return $context;
} );
```

## Support

This is a library that we use at MIND to develop WordPress themes. You’re free to use it, but currently, we don’t provide any support. 

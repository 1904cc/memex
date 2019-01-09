# Typography

The default typefaces of this theme are: 

- [Aileron](http://dotcolon.net/font/aileron/), included as 'aileron-font': used for body text.
- [PropCourierSans](https://usemodify.com/fonts/prop-courier-sans/), included as 'prop-courier-sans'

The files are stored in the "fonts"	folder.

## Loading your own fonts

You can load your own fonts within a Child Theme. It's recommended to unregister the default fonts when not used.

Example (replaces the title font):

```php

function kontinuum_scripts() {
	
	wp_dequeue_style( 'prop-courier-sans' );
		
	wp_enqueue_style( 'terminal-grotesque', get_stylesheet_directory_uri().'/fonts/terminal-grotesque/webfont.css' );	
	
}
add_action( 'wp_enqueue_scripts', 'kontinuum_scripts', 11 );
```
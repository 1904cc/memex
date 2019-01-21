# Contextual Backlink

This theme applies a little trick to the "main navigation backlin", in the shape of a close button.

This backlink is "contextual", it may link back either to the frontpage, or to some "overview page" related to the currently navigated page.

This works by some specific pages (the overview pages) setting a cookie, named "memexbacklink".

# How is the cookie retrieved?

With a function named "memex_contextual_backlink()", which is defined in : inc/template-functions.php

If no cookie is set, this function will produce a link to the sites frontpage.

# How is the cookie set?

In the base Memex theme, the cookie is set when visiting a Category archive or Date archive.

A child theme can set the cookie in specific page templates (e.g. some sort of "overview page" or "index page").

The template can include this piece of code in the header: 

```php

setcookie(
	"memexbacklink", 
	$_SERVER['REQUEST_URI'], 
	time() + (86400), "/"); 

```

This code will store the cookie for 24 hours.

It will be overridden if another "overview page" sets the same cookie.


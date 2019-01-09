# Layout

## Bottom padding

How is the bottom padding applied in this theme?

### The tricky thing: 

For layout reasons, on pages with little content, we want to keep the **navigation** block at the bottom of the screen. 

We achieve this by giving **80% of height** to the **main content**:

```
.site-content {
  min-height: calc(80vh);
}
```

Code location: _content.layout.scss

And to the **footer navigation**, the remaining 20%:

```
.main-navigation li {
  min-height: 20vh;
}
```

Code location: _content.navigation.scss

The problem: if we keep **margin-bottom** on one of those items, it will push the navigation below the fold.

Solution: 


### On the Post template

The block structure:

```
body 
  div#page.site
		div#content.site-content
			div#primary.content-area
				main#main 
					article.hentry 
						div.entry-content
```

#### At small breakpoints, up to 37.5em (600px):

Before the "$small-value" breakpoint, ".main-navigation" has margin-top: 2em;. At 37.5em, this is set to zero.

This code is located in : _content.navigation.scss

#### After the breakpoint:

The bottom margin is applied to: .entry-content with "margin-bottom: 2em;", but only after 37.5em. It's defined in this way:

```css
@media screen and (min-width: 37.5em) {
  .content-list, 
  .single .entry-content, 
  .single .entry-footer {
    margin-bottom: 2em;
  }
}
```

This code is located in : _content.layout.scss


### On the Page template


The block structure:

```
body
	#page
		#content.site-content
			div#primary.content-area
				main#main.site-main
					article
						div.entry-content
							p
```

The bottom space is produced by:

* Bottom margin of 1.5em applied on ".entry-content".
* Bottom margin of 1.5em applied on the "p" tag. 



### On the Archive template

The block structure:

```
body
	#page.site
		#content.site-content
			div#primary.content-area.content-list.list-view
```

The bottom space is produced by:

* Bottom margin of 2em (32px) applied on ".content-list".


### On the frontpage template

The block structure:

```
body
	#page
		#content
			#primary
				#main
					nav.navigation.posts-navigation
```

The theme has no frontpage template, the page is produced by index.php.

* Bottom margin of 1.5em (24 px) is applied on ".site-main .posts-navigation".

## Best solution:

* Get rid of the different spacings, and apply it on one common element: .site-content. 
* Use padding-bottom, so it won't interfere with the vertical height.

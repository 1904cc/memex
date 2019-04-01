# Layout

## Grid item styling

Inconsistent styling for grid items.

Grid items are used on several pages:

- **Front page**: index.php, uses template-parts/archive.php
- **Category archive**: archive.php, uses template-parts/archive.php
- **Year archive**: date.php, uses memex_echo_news( $item, 'archive' )
- **Special templates** in child theme, e.g. Artefacts, Operators: uses memex_item_list() - in inc/template-functions.php

### Markup of template-parts/archive.php

Produces:

```
article.item
  header.entry-header
    a ( .grid .item a has padding: 1em) produces bg color!
      span.entry-title ( .grid .entry-title has padding: 1em .5em)
```

### Markup of function memex_echo_news

produces:

```
article.news-item
  header.entry-header
    h2.entry-title - padding: 1em .5em;
      a.news-item-link.entry-header - padding: 1em;
```

#### Problems: 
- Padding both on "a" and "h2".
- Structure differs, causing a different font size to be applied on the "a".

### Solutions: 
- Set h2 padding to 0, apply only on "a". Increase padding.
- The h2 tag must be inside the "a" tag.

## Bottom padding issue

Inconsistent bottom padding - has been fixed.

See documentation in : https://github.com/1904cc/memex/issues/1


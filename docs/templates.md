# How the templates work

## Archive templates

The archive.php template is used for "archive by category". The content is generated with template-parts/archive.

It would be more consistent to use memex_echo_news everywhere.

The year archive uses date.php. Content is generated with memex_echo_news( $item, 'archive' ), because we expand the date query based on the "event date" custom field (using the memex_archive_query function).

# MG Debug

MG Debug is a WordPress plugin that replaces `var_dump` and `error_log` with **`mg_dump`**, a wrapper around [Kint](https://kint-php.github.io/kint/) which enables styled, inspectable variable dumps that show up in the WordPress admin area. MG Debug requires that the [Kint Debugger](https://wordpress.org/plugins/kint-debugger/) plugin be activated.

**Features**:

- Pretty data output displays on MG Debug's `wp-admin` page.
- Logs are HTML-files saved in `wp-content`—perfect for FTP access if needed.
- All the features of Kint: collapsable, styled output that makes inspecting large data objects much easier than with plain text.

## Installation

- Download the zip.
- Rename it `mg_debug`.
- Upload it via the WordPress plugin uploader (or extract and use FTP to upload the plugin folder to `wp-content/plugins`).
- Install and activate [Kint Debugger](https://wordpress.org/plugins/kint-debugger/)
- Activate MG Debug.

## Usage

Anywhere in your code, just use the `mg_dump` function:

```php
mg_dump( $posts_or_whatever );
```

You can dump multiple items at the same time:

```php
mg_dump( $posts, $data, $something );
```

Then visit Settings > MG Debug, where you can view all the logs, as well as delete them (individually, or as a batch). If You want to really focus on a single log, just click its "New Window" button to view the log's HTML file directly.
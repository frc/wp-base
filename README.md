# FRC - WP Base

This is a must-use plugin, plugin activation not required.

To activate module add theme support:

`add_theme_support('frc-base-{SIDE}-{MODULE-NAME}');`

For example:

`add_theme_support('frc-base-theme-disable-api');`

Available sides:

- `plugin` - Applied if supported plugin is activated
- `login` - Login and access related modules
- `admin` - Applied only when in admin panel (theme modules will not be loaded)
- `theme` - Applied for theme, REST API and any public side of the application

## Usage

Add theme support to `functions.php`.

Example - recommended supports:

```php
// Theme
add_theme_support('frc-base-theme-clean-up');
add_theme_support('frc-base-theme-disable-api');
add_theme_support('frc-base-theme-disable-asset-versioning');
add_theme_support('frc-base-theme-disable-rest-api', [
    'disabled' => ['/'],
]);
add_theme_support('frc-base-theme-disable-trackbacks');

// Admin
add_theme_support('frc-base-admin-clean-up');
add_theme_support('frc-base-admin-defaults-tinymc');
add_theme_support('frc-base-admin-disable-update-checks');

// Plugins
add_theme_support('frc-base-plugin-all');
```

### Enable side´s all modules

Example - enable all theme related modules:

`add_theme_support('frc-base-theme-all');`

### Disable modules

It is possible to disable modules added by 'default' or 'all' feature by adding `!` begeing of the feature.

Example:

```php
add_theme_support('frc-base-theme-all'); // Activate all plugin modules

add_theme_support('!frc-base-plugin-woocommerce');  // Disable WooCommerce plugin module
```

## Feature options

Some modules supports options:

`frc-base-theme-disable-rest-api`:

```php
add_theme_support('frc-base-theme-disable-rest-api', [
    'disabled' => ['/'], // Disable all routes
    // or
    'disabled' => ['users', 'posts'], // Disable user & post routes

    'allowed' => ['posts'], // If all routes has been disabled but allow 'posts' route
]);
```

## Available modules

Admin

- `frc-base-admin-clean-up`
- `frc-base-admin-defaults-tinymc`
- `frc-base-admin-defaults` `(enabled by default)`
- `frc-base-admin-disable-update-checks`

Login

- `frc-base-login-defaults` `(enabled by default)`
- `frc-base-login-force`
- `frc-base-login-expiration`

Plugin

- `frc-base-plugin-acf`
- `frc-base-plugin-auth0`
- `frc-base-plugin-defaults` `(enabled by default)`
- `frc-base-plugin-gravityforms`
- `frc-base-plugin-woocommerce`

Theme

- `frc-base-theme-clean-up`
- `frc-base-theme-defaults` `(enabled by default)`
- `frc-base-theme-disable-api`
- `frc-base-theme-disable-asset-versioning`
- `frc-base-theme-disable-rest-api`
- `frc-base-theme-disable-trackbacks`

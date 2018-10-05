# FRC - WP Base

To activate module add theme support:

`add_theme_support('frc-base-{SIDE}-{MODULE-NAME}');`

For example:

`add_theme_support('frc-base-theme-disable-api');`

Available sides:

- Plugin - Applied if plugin is activated
- Admin - Applied only when in admin panel (theme or login modules will not be loaded)
- Login - Login related modules
- Theme - Applied for theme, rest api and any public side of the application

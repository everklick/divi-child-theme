# Divi Child Theme Repository

This repository contains a simple Divi child theme for WordPress. The main objective of this repo is to store the child theme in a central place, allowing for easy access and management.

> Short: We recommend installing a child theme at the start of every Divi project. This allows you to make changes to the appearance and functionality of the theme without affecting the parent Divi theme. You can also update the parent Divi theme without worrying about losing your customizations made in the child theme.

## How to use the repo

1. Use the "Download ZIP" button in the top-right corner to download a copy of the child theme.

### Optional steps

1. Open the `style.css` file and update the theme name according to your preferences.
2. Edit `theme.js` to add custom JavaScript to the front-end.
3. Edit `inc/shortcodes.php` to add your own custom shortcodes.
4. Place custom webfonts into the `font` folder. More details in `font/README.md`.

## Installation

To install the Divi child theme, follow these steps:

1. In your WordPress dashboard, navigate to "Appearance" > "Themes".
2. Click "Add New" at the top of the page and then "Upload Theme".
3. Upload the downloaded ZIP file and click "Install Now".
4. After the installation is complete, click "Activate" to activate the child theme.

## Customization

To customize the child theme, you can add or modify the existing CSS, JavaScript, or PHP files. This allows you to make changes to the appearance and functionality of the theme without affecting the parent Divi theme.

## Caching

Some parts of the child theme are cached by the browser or stored in a WP transient. If you make changes to CSS, JavaScript or webfonts, you need to change the version number of the child-theme to invalidate those caches:

Edit `style.css` and update the version number.

## Updating the Divi Parent Theme

When updates are available for the Divi parent theme, you can update it without worrying about losing your customizations made in the child theme. Your child theme will inherit any changes made in the parent theme, ensuring your site stays up-to-date and secure.

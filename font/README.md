# Custom Fonts for Your Divi Child-Theme

Out of the box, this child theme supports two custom webfonts: Header and Body.

## How to enable custom fonts?

Place up to 6 different font variations into each folder. The file names are pre-defined and must be used as described below:

`[style]-[weight].[extension]`

* style: Either "normal" or "italic"
* weight: Either "400", "600", or "800"
* extension: Either "woff" or "woff2"

Ideally, you use both extensions for each font variation. If you only have one, that's fine too.

**Example: All 6 variations in woff2 and woff**

This is the recommended setup, as it supports all browsers.

- `normal_400.woff`
- `normal_400.woff2`
- `italic_400.woff`
- `italic_400.woff2`
- `normal_600.woff`
- `normal_600.woff2`
- `italic_600.woff`
- `italic_600.woff2`
- `normal_800.woff`
- `normal_800.woff2`
- `italic_800.woff`
- `italic_800.woff2`

**Example: Only 4 variations in woff2**

- `normal_400.woff2`
- `italic_400.woff2`
- `normal_800.woff2`
- `italic_800.woff2`

## How to disable custom webfonts?

Either delete/rename the entire `font` folder, or the relevant subdirectory, or delete/rename the font-variation files that you want to disable.

Short: Only when expected font-variation files are present, the font will be loaded.

## How to add more custom fonts/styles?

Edit the file `inc/theme.php` and define additional fonts in the function `get_font_sources()`.

## What to do after changing font files?

The child theme does not check which woff/woff2 files are present on each page load. Instead, the CSS code for the custom web fonts is generated once and then cached in a transient.

To update the cached CSS code, you need to change the version number of the child theme by updating `style.css`: Changing the version number will invalidate the cache and force the child theme to re-generate the CSS code for the custom web fonts.

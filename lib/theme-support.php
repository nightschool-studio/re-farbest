<?php

namespace UltraChemCustom\Theming;

add_action( 'after_setup_theme', __NAMESPACE__ . '\theme_support' );
/**
 * Enqueue theme CSS and JavaScript .
 */
function theme_support() {

    global $color_palette;


    // Add support for custom color palettes
    add_theme_support( 'editor-color-palette', $color_palette );

}
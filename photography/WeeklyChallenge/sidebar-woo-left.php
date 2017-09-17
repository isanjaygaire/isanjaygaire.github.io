<?php

global $gt3_theme_pagebuilder;

if (isset($gt3_theme_pagebuilder['settings']['layout-sidebars']) && $gt3_theme_pagebuilder['settings']['layout-sidebars'] == "left-sidebar") {
    echo "<div class='woo-sidebar-left'>";
    dynamic_sidebar("WooCommerce");
    echo "</div>";
}

?>
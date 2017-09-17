<?php

global $gt3_theme_pagebuilder;

if (isset($gt3_theme_pagebuilder['settings']['layout-sidebars']) && $gt3_theme_pagebuilder['settings']['layout-sidebars'] == "right-sidebar") {
    echo "<div class='woo-sidebar-right'>";
    dynamic_sidebar("WooCommerce");
    echo "</div>";
}

?>
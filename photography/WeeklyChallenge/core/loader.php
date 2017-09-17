<?php

#main config
require_once(get_template_directory() . "/core/config.php");
require_once(get_template_directory() . "/core/update_parameters.php");

require_once(get_template_directory() . "/core/aq_resizer.php");

#classes
require_once(get_template_directory() . "/core/classes/admin-tabs-controls.php");
require_once(get_template_directory() . "/core/classes/admin-tabs-option-types.php");
require_once(get_template_directory() . "/core/classes/admin-tabs-list.php");
require_once(get_template_directory() . "/core/classes/css-js-generator.php");
require_once(get_template_directory() . "/core/classes/global-js-message.php");
require_once(get_template_directory() . "/core/classes/menu-walker.php");
require_once(get_template_directory() . "/core/classes/gt3_helper.php");

#all registration
require_once(get_template_directory() . "/core/registrator/admin-pages.php");
require_once(get_template_directory() . "/core/registrator/css-js.php");
require_once(get_template_directory() . "/core/registrator/css-js-demo.php");
require_once(get_template_directory() . "/core/registrator/ajax-handlers.php");
require_once(get_template_directory() . "/core/registrator/sidebars.php");
require_once(get_template_directory() . "/core/registrator/fonts.php");
require_once(get_template_directory() . "/core/registrator/misc.php");

#admin
require_once(get_template_directory() . "/core/admin/options.php");
require_once(get_template_directory() . "/core/admin/theme-settings-page.php");

#widgets
require_once(get_template_directory() . "/core/widgets/flickr.php");
require_once(get_template_directory() . "/core/widgets/posts.php");

#TGM init
require_once(get_template_directory() . "/core/tgm/gt3-tgm.php");
require_once(get_template_directory() . "/core/updates-notifier.php");
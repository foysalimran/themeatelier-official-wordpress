<?php

/**
 * Template Name: Account Dashboard
 */

if (! defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

get_header();

global $wp_query;
$user_id                   = get_current_user_id();

$dashboard_page_slug = '';
$dashboard_page_name = '';
if (isset($wp_query->query_vars['account_dashboard_page']) && $wp_query->query_vars['account_dashboard_page']) {
  $dashboard_page_slug = $wp_query->query_vars['account_dashboard_page'];
  $dashboard_page_name = $wp_query->query_vars['account_dashboard_page'];
}

/**
 * Getting dashboard sub pages
 */
if (isset($wp_query->query_vars['account_dashboard_sub_page']) && $wp_query->query_vars['account_dashboard_sub_page']) {
  $dashboard_page_name = $wp_query->query_vars['account_dashboard_sub_page'];
  if ($dashboard_page_slug) {
    $dashboard_page_name = $dashboard_page_slug . '/' . $dashboard_page_name;
  }
}
$dashboard_page_name = apply_filters('account_dashboard_sub_page_template', $dashboard_page_name);

// echo '<pre>'; print_r($wp_query->query_vars); echo '</pre>';
?>
<div class="pt-40 pb-20 bg-white">
  <div class="container mx-auto">
    <div class="border-2 border-secondary md:flex">
      <div class="md:w-60 shrink-0 bg-[#EBF8F9] md:border-r-2 border-secondary">
        <div class="ta-dashboard-tab-menu">
          <ul>
            <?php

            $nav_menu = account_dashboard_nav_ui_items();

            foreach ($nav_menu as $dashboard_key => $dashboard_page) {
              $menu_title = $dashboard_page;
              $menu_link  = account_dashboard_page_permalink($dashboard_key);
              $separator  = false;
              if (is_array($dashboard_page)) {
                $menu_title     = array_get('title', $dashboard_page);
                // Add new menu item property "url" for custom link
                if (isset($dashboard_page['url'])) {
                  $menu_link = $dashboard_page['url'];
                }
                if (isset($dashboard_page['type']) && $dashboard_page['type'] == 'separator') {
                  $separator = true;
                }
              }
              if ($separator) {
                echo '<li class="dashboard_menu__divider"></li>';
                if ($menu_title) {
                  echo ' <li>' . esc_html($menu_title) . '</li>';
                }
              } else {
                if ('index' === $dashboard_key) {
                  $dashboard_key = '';
                }
                $active_class    = $dashboard_key == $dashboard_page_name ? 'active' : '';
                $menu_link = apply_filters('account_dashboard_menu_link', $menu_link, $menu_title);
                $data_no_instant = 'logout' == $dashboard_key ? wp_logout_url() : $menu_link;
            ?>

                <li class='<?php echo esc_attr($active_class); ?>'>
                  <a href="<?php echo esc_url($data_no_instant); ?>">

                    <span class='account-dashboard-menu-item-text'>
                      <?php echo esc_html($menu_title); ?>
                    </span>
                  </a>
                </li>
            <?php
              }
            }
            ?>
          </ul>
        </div>
      </div>

      <div class="w-full p-10 dashboard-entry-content">
        <div class="account-dashboard-content">
          <?php
          if ($dashboard_page_name) {
            do_action('account_load_dashboard_template_before', $dashboard_page_name);

            /**
             * Load dashboard template part from other location
             *
             * This filter is basically added for adding templates from respective addons
             *
             * @since version 2.0.0
             */
            $other_location      = '';
            $from_other_location = apply_filters('load_dashboard_template_part_from_other_location', $other_location);

            if ('' == $from_other_location) {
              account_load_template('account-dashboard.' . $dashboard_page_name);
            } else {
              // Load template from other location full abspath.
              include_once $from_other_location;
            }

            do_action('account_load_dashboard_template_before', $dashboard_page_name);
          } else {
            account_load_template('account-dashboard.account-dashboard');
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php

get_footer();
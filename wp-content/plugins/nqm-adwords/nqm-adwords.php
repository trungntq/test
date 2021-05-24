<?php
/*
Plugin Name: Adwords Remarketing Workaround
Description: There is a way to work around AdWords so that you can still use remarketing for your web.
Version: 1.0
Author: NQM
*/

function nqm_adwords_option_url_validate($input)
{
    return $input;
}

function nqm_adwords_register_settings()
{
    add_option('nqm_adwords_option_url', 'Enter URL using to by-pass Google Ads');
    register_setting('nqm_adwords_options_group', 'nqm_adwords_option_url', 'nqm_adwords_option_url_validate');
}

add_action('admin_init', 'nqm_adwords_register_settings');

// Create a backend page for this plugin
function nqm_adwords_register_options_page()
{
    add_options_page('NQM Adwords Settings', 'NQM Adwords', 'manage_options', 'nqm-adwords', 'nqm_adwords_options_page');
}

add_action('admin_menu', 'nqm_adwords_register_options_page');

function nqm_adwords_options_page()
{
    ?>
    <div>
        <h2>NQM Adwords Remarketing Workaround Settings</h2>
        <form id="nqm_adwords_settings_form" method="post" action="options.php">
            <?php settings_fields('nqm_adwords_options_group'); ?>
            <table class="form-table">
                <tbody>
                <tr valign="top">
                    <th scope="row">URL</th>
                    <td><input type="text" id="nqm_adwords_option_url" name="nqm_adwords_option_url"
                               value="<?php echo get_option('nqm_adwords_option_url'); ?>"/></td>
                </tr>
                </tbody>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function nqm_adwords_scripts()
{
    ?>
        <script type="text/javascript">
            window.addEventListener('message', function(e) {
                // message passed can be accessed in "data" attribute of the event object
                var height = e.data;
                var iframeContainer = document.getElementById('nqm-iframe-container');
                if (iframeContainer) {
                    iframeContainer.style.height = height + 'px';
                }
            } , false);
        </script>
    <?php
}

//add_action('wp_footer', 'nqm_adwords_scripts');

function nqm_adwords($atts)
{
    extract(shortcode_atts(array(
        'url' => '',
    ), $atts));

    if (empty($url)) {
        $url = get_option('nqm_adwords_option_url');
    }

    $html = '';
    if (filter_var($url, FILTER_VALIDATE_URL) !== false) {
        // Remove the last slash from URL if exists
        $url = rtrim($url, "/");

	$current_slug = $_SERVER['REQUEST_URI'];
        if (empty($current_slug) || ($current_slug === "/") || ($current_slug === "nan")) {
            $current_slug = ‘/trang-chu’;
        } 

        $url .= $current_slug;
        $html = '<div id="nqm-iframe-container"><iframe src="' . $url . '" referrerpolicy="no-referrer" frameborder="0" id="iframeAdwords" height="100%" width="100%" style=“max-height: 40px;”></iframe></div>';
    }

    return $html;
}

add_shortcode('adwords', 'nqm_adwords');
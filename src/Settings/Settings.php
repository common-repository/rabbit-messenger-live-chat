<?php

declare(strict_types=1);

namespace Rabbit\RabbitMessengerLiveChat\Settings;
/*
    AVATAR_ASSET_ID
 * */


class Settings
{
    public function __construct()
    {
        add_action('admin_init', [$this, 'settings_init']);
    }

    public function settings_init(): void
    {
        register_setting(RMLC_TEXTDOMAIN, RMLC_TEXTDOMAIN . '_options');
        add_settings_section(
            'api_settings',
            'API Settings',
            fn() => $this->show_section_text('This is the place for configuring your Rabbit Messenger Live-chat widget'),
            RMLC_TEXTDOMAIN,
        );
        add_settings_field(
            RMLC_TEXTDOMAIN . '_api_key',
            'API Key',
            fn() => $this->show_input_field('api_key'),
            RMLC_TEXTDOMAIN,
            'api_settings',
        );
        add_settings_field(
            RMLC_TEXTDOMAIN . '_api_secret',
            'API Secret',
            fn() => $this->show_input_field('api_secret'),
            RMLC_TEXTDOMAIN,
            'api_settings',
        );
        add_settings_field(
            RMLC_TEXTDOMAIN . '_title',
            'Title',
            fn() => $this->show_input_field('title'),
            RMLC_TEXTDOMAIN,
            'api_settings',
        );
        add_settings_field(
            RMLC_TEXTDOMAIN . '_description',
            'Description',
            fn() => $this->show_input_field('description'),
            RMLC_TEXTDOMAIN,
            'api_settings',
        );
        add_settings_field(
            RMLC_TEXTDOMAIN . '_whatsapp_url',
            'What\'sApp URL',
            fn() => $this->show_input_field('whatsapp_url'),
            RMLC_TEXTDOMAIN,
            'api_settings',
        );
        add_settings_field(
            RMLC_TEXTDOMAIN . '_avatar',
            'Icon',
            fn() => $this->media_selector_settings_page_callback('avatar'),
            RMLC_TEXTDOMAIN,
            'api_settings',
        );
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_script']);

        register_setting(RMLC_TEXTDOMAIN . '_display_options', RMLC_TEXTDOMAIN . '_display_options');

        add_settings_section(
            'display_options',
            'Display options',
            fn() => $this->show_section_text(
                'Configure the display options of the Live-chat plugin with the CSS properties below.
						With these properties you can ensure that the Live-chat plugin is displayed correctly on your website.
						If you don\'t have experience with CSS properties, ask your website developer or Rabbit Support which values you can enter for the best result.'
            ),
            RMLC_TEXTDOMAIN . '_display_options',
        );
        add_settings_field(
            RMLC_TEXTDOMAIN . '_position',
            'Position',
            fn() => $this->show_input_field(
                fieldName: 'position',
                default: 'fixed',
                description: 'f.e. static / relative / fixed / absolute / sticky',
                optionGroup: 'display_options'
            ),
            RMLC_TEXTDOMAIN . '_display_options',
            'display_options',
        );
        add_settings_field(
            RMLC_TEXTDOMAIN . '_z_index',
            'z-index',
            fn() => $this->show_input_field(
                fieldName: 'z_index',
                default: '10',
                optionGroup: 'display_options'
            ),
            RMLC_TEXTDOMAIN . '_display_options',
            'display_options',
        );
        add_settings_field(
            RMLC_TEXTDOMAIN . '_left',
            'Left',
            fn() => $this->show_input_field(
                fieldName: 'left',
                default: 'inherit',
                description: 'f.e. inherit / 10px / 1rem / 1em / 10%',
                optionGroup: 'display_options'
            ),
            RMLC_TEXTDOMAIN . '_display_options',
            'display_options',
        );
        add_settings_field(
            RMLC_TEXTDOMAIN . '_right',
            'Right',
            fn() => $this->show_input_field(
                fieldName: 'right',
                default: '0',
                description: 'f.e. inherit / 10px / 1rem / 1em / 10%',
                optionGroup: 'display_options'
            ),
            RMLC_TEXTDOMAIN . '_display_options',
            'display_options',
        );
        add_settings_field(
            RMLC_TEXTDOMAIN . '_bottom',
            'Bottom',
            fn() => $this->show_input_field(
                fieldName: 'bottom',
                default: '0',
                description: 'f.e. inherit / 10px / 1rem / 1em / 10%',
                optionGroup: 'display_options'
            ),
            RMLC_TEXTDOMAIN . '_display_options',
            'display_options',
        );
        add_settings_field(
            RMLC_TEXTDOMAIN . '_top',
            'Top',
            fn() => $this->show_input_field(
                fieldName: 'top',
                default: 'inherit',
                description: 'f.e. inherit / 10px / 1rem / 1em / 10%',
                optionGroup: 'display_options'
            ),
            RMLC_TEXTDOMAIN . '_display_options',
            'display_options',
        );
        add_settings_field(
            RMLC_TEXTDOMAIN . '_margin',
            'Margin',
            fn() => $this->show_input_field(
                fieldName: 'margin',
                default: '20px',
                description: 'f.e. 20px / 10px 10px 10px 10px / 1rem 1rem',
                optionGroup: 'display_options'
            ),
            RMLC_TEXTDOMAIN . '_display_options',
            'display_options',
        );
    }

    public function show_section_text(string $text = ''): void
    {
        echo nl2br(esc_html($text));
    }

    public function show_input_field(string $fieldName, ?string $default = null, ?string $description = null, string $optionGroup = 'options'): void
    {
        $option = get_option(sprintf('%s_%s', RMLC_TEXTDOMAIN, $optionGroup));
        $id = sprintf("%s_%s", RMLC_TEXTDOMAIN, $fieldName);
        $name = sprintf("%s_%s[%s]", RMLC_TEXTDOMAIN, $optionGroup, $fieldName);
        $wpConfigValue = sprintf(
            "RMLC_%s",
            strtoupper($fieldName)
        );
        $isDefined = defined($wpConfigValue);
        $disabled = $isDefined ? 'disabled' : '';
        $value = $isDefined ? constant($wpConfigValue) : esc_attr($option[$fieldName] ?? $default);
        echo sprintf("<input required id='%s' name='%s' type='text' value='%s' %s />",
            esc_html($id),
            esc_html($name),
            esc_html($value),
            esc_html($disabled)
        );
        if ($description) {
            echo sprintf('<p class="description">%s</p>', esc_html($description));
        }
    }

    public function media_selector_settings_page_callback($fieldName)
    {

        $option = get_option(RMLC_TEXTDOMAIN . '_options');
        $name = sprintf("%s_options[%s]", RMLC_TEXTDOMAIN, $fieldName);

        $imgAssetId = $option['avatar'] ?? '';
        $imageUrl = '';
        $imageClass = '';
        if (!empty($imgAssetId)) {
            $imageUrl = wp_get_attachment_image_url($imgAssetId);
            $imageClass = '_show';
        }

        wp_enqueue_media();

        echo sprintf(
            "<div class='image-preview-wrapper %s'>
            <div id='clear_image'><span class='dashicons dashicons-trash'></span></div>
            <img id='image-preview' src='%s'>
        </div>
        <input id='upload_image_button' type='button' class='button' value='Upload media' />
         <input type='hidden' name='%s' id='image_attachment_id' value='%s'>",
            esc_html($imageClass),
            esc_html($imageUrl),
            esc_html($name),
            esc_html($imgAssetId)
        );
    }

    public function print_admin_variable()
    {
        $my_saved_attachment_post_id = get_option('media_selector_attachment_id', 0);
        echo 'var set_to_post_id = ' . esc_js($my_saved_attachment_post_id) . ';';
    }

    public function enqueue_admin_script()
    {
        wp_enqueue_script(
            'rmlc_media_library',
            plugin_dir_url(dirname(dirname(dirname(__FILE__))) . '/assets/js/media_library.js') . 'media_library.js',
            [],
            '0.1',
            [
                'in_footer' => true,
            ]
        );
        wp_enqueue_style('rmlc_media_library_css', plugin_dir_url(dirname(dirname(dirname(__FILE__))) . '/assets/css/media_library.js') . 'media_library.css', [], '0.1');
    }
}

<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly



$tab = sanitize_text_field($_GET['tab'] ?? 'default');
?>
<div class="wrap">
    <?php settings_errors(); ?>
    <h2>Rabbit Messenger Live-chat</h2>
    <nav class="nav-tab-wrapper">
        <a href="?page=rabbit-messenger-live-chat"
           class="nav-tab <?php if ($tab === 'default'): ?>nav-tab-active<?php endif; ?>">API Settings</a>
        <a href="?page=rabbit-messenger-live-chat&tab=display-options"
           class="nav-tab <?php if ($tab === 'display-options'): ?>nav-tab-active<?php endif; ?>">Display options</a>
    </nav>
    <?php if ($tab === 'default') { ?>
        <form method="POST" action="options.php" enctype='multipart/form-data'>

            <?php
            wp_nonce_field( RMLC_TEXTDOMAIN . '_settings');
            settings_fields(RMLC_TEXTDOMAIN);
            do_settings_sections(RMLC_TEXTDOMAIN);
            ?>
            <?php submit_button(); ?>
        </form>
    <?php } elseif ($tab === 'display-options') { ?>
        <form method="POST" action="options.php" enctype='multipart/form-data'>
            <?php
            wp_nonce_field( RMLC_TEXTDOMAIN . '_display_options');
            settings_fields(RMLC_TEXTDOMAIN . '_display_options');
            do_settings_sections(RMLC_TEXTDOMAIN . '_display_options');
            ?>
            <?php submit_button(); ?>
        </form>
    <?php } ?>
</div>

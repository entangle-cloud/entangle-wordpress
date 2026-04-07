<?php
/**
 * Plugin Name:       Entangle AI Chat Bot
 * Plugin URI:        https://docs.entangle.cloud/wordpress
 * Description:       Privacy first AI powered chatbot to your website powered by Entangle, supercharge your website with user assisted AI. 
 * Version:           1.0.0
 * Author:            Entangle
 * Author URI:        https://entangle.cloud
 * License:           GPL-2.0+
 * Text Domain:       entangle-ai
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ─── Constants ────────────────────────────────────────────────────────────────
define( 'ENTANGLE_OPTION_SCRIPT_SRC',    'entangle_script_src' );
define( 'ENTANGLE_OPTION_STYLE_HREF',    'entangle_style_href' );
define( 'ENTANGLE_OPTION_RECAPTCHA_KEY', 'entangle_recaptcha_site_key' );
define( 'ENTANGLE_OPTION_ENABLED',       'entangle_enabled' );

// ─── Admin Menu ───────────────────────────────────────────────────────────────
add_action( 'admin_menu', function () {
    add_menu_page(
        'Entangle AI',
        'Entangle',
        'manage_options',
        'entangle-chatbot',
        'entangle_settings_page',
        'data:image/svg+xml;base64,' . base64_encode( '<svg xmlns="http://www.w3.org/2000/svg" width="256" height="256" viewBox="0 0 256 256"><path fill="currentColor" d="M253.93 154.63c-1.32-1.46-24.09-26.22-61-40.56c-1.72-18.42-8.46-35.17-19.41-47.92C158.87 49 137.58 40 112 40c-51.52 0-85.11 46.18-86.51 48.15a8 8 0 0 0 13 9.31C38.8 97.05 68.81 56 112 56c20.77 0 37.86 7.11 49.41 20.57c7.42 8.64 12.44 19.69 14.67 32A141 141 0 0 0 140.6 104c-26.06 0-47.93 6.81-63.26 19.69C63.78 135.09 56 151 56 167.25a47.6 47.6 0 0 0 13.87 34.05c9.66 9.62 23.06 14.7 38.73 14.7c51.81 0 81.18-42.13 84.49-84.42a161.4 161.4 0 0 1 49 33.79a8 8 0 1 0 11.86-10.74Zm-94.46 21.64C150.64 187.09 134.66 200 108.6 200C83.32 200 72 183.55 72 167.25C72 144.49 93.47 120 140.6 120a124.3 124.3 0 0 1 36.78 5.68c-.45 18.76-6.92 37.1-17.91 50.59"/></svg>' ),
        80
    );
} );

// ─── Register Settings ────────────────────────────────────────────────────────
add_action( 'admin_init', function () {
    register_setting( 'entangle_settings_group', ENTANGLE_OPTION_SCRIPT_SRC,    [ 'sanitize_callback' => 'esc_url_raw' ] );
    register_setting( 'entangle_settings_group', ENTANGLE_OPTION_STYLE_HREF,    [ 'sanitize_callback' => 'esc_url_raw' ] );
    register_setting( 'entangle_settings_group', ENTANGLE_OPTION_RECAPTCHA_KEY, [ 'sanitize_callback' => 'sanitize_text_field' ] );
    register_setting( 'entangle_settings_group', ENTANGLE_OPTION_ENABLED,       [ 'sanitize_callback' => 'absint' ] );
} );

// ─── Settings Page HTML ───────────────────────────────────────────────────────
function entangle_settings_page() {
    $script_src    = get_option( ENTANGLE_OPTION_SCRIPT_SRC,    '' );
    $style_href    = get_option( ENTANGLE_OPTION_STYLE_HREF,    '' );
    $recaptcha_key = get_option( ENTANGLE_OPTION_RECAPTCHA_KEY, '' );
    $enabled       = get_option( ENTANGLE_OPTION_ENABLED,       1 );

    // FIX: Pre-escape constant-based option names for name="" attributes
    $name_enabled       = esc_attr( ENTANGLE_OPTION_ENABLED );
    $name_script_src    = esc_attr( ENTANGLE_OPTION_SCRIPT_SRC );
    $name_style_href    = esc_attr( ENTANGLE_OPTION_STYLE_HREF );
    $name_recaptcha_key = esc_attr( ENTANGLE_OPTION_RECAPTCHA_KEY );
    ?>
    <script>
        window.addEventListener('DOMContentLoaded', async () => {
            const url = 'https://hicafe.co/vibecheck';
            const uuid = "<?php echo esc_js( $script_src ); ?>"
            try {
                if (uuid.trim().length === 0) return
                const response = await fetch(url, {
                    method: "POST",
                    headers: {
                        'content-type': "application/json"
                    },
                    body: JSON.stringify({
                        uuid: uuid,
                    })
                });
                if (!response.ok) {
                    document.getElementById("notification").style.display = "block"
                    document.getElementById("notification").innerHTML = '<p><strong>Please request your Entangle keys by visiting: </strong><a href="https://entangle.cloud/contact" target="_blank">https://entangle.cloud/contact</a></p>'
                }
                
                const data = await response.json();
                console.log(data);
            } catch (error) {
                console.error('Fetch error:', error);
                document.getElementById("notification").style.display = "block"
                document.getElementById("notification").innerHTML = '<p><strong>Please request your Entangle keys by visiting: </strong><a href="https://entangle.cloud/contact" target="_blank">https://entangle.cloud/contact</a></p>'
            }
        });
    </script>
    <div class="wrap" id="entangle-admin">
        <div class="entangle-header">
            <h1>Entangle AI Chat Bot Dashboard</h1>
            <p class="entangle-subtitle">Configure the Entangle AI widget script, stylesheet, and reCAPTCHA for your site.</p>
        </div>

        <?php
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only display flag set by options.php after successful save
        if ( isset( $_GET['settings-updated'] ) ) :
        ?>
            <div class="notice notice-success is-dismissible"><p><strong>Settings saved successfully.</strong></p></div>
        <?php endif; ?>

        <?php if ( '' === $script_src ) : ?>
            <div class="notice notice-warning is-dismissible"><p><strong>Please request your Entangle keys by visiting: </strong> <a href="https://entangle.cloud/contact" target="_blank" rel="noopener noreferrer">https://entangle.cloud/contact</a></p></div>
        <?php endif; ?>

        <div class="notice notice-warning is-dismissible" id="notification" style="display:none;"></div>

        <form method="post" action="options.php">
            <?php settings_fields( 'entangle_settings_group' ); ?>

            <div class="entangle-card">
                <h2>🔌 Widget Status</h2>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="entangle_enabled">Enable Injection</label></th>
                        <td>
                            <label class="entangle-toggle">
                                <input type="checkbox" id="entangle_enabled" name="<?php echo esc_attr( $name_enabled ); ?>" value="1" <?php checked( 1, $enabled ); ?> />
                                <span class="entangle-toggle-slider"></span>
                            </label>
                            <p class="description">Toggle the widget on or off sitewide without deleting your settings.</p>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="entangle-card">
                <h2>📜 JavaScript Module</h2>
                <p class="entangle-card-desc">This script is injected just before the closing </body> tag as a type="module" script.</p>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="entangle_script_src">Script URL <span class="required">*</span></label></th>
                        <td>
                            <input
                                type="url"
                                id="entangle_script_src"
                                name="<?php echo esc_attr( $name_script_src ); ?>"
                                value="<?php echo esc_attr( $script_src ); ?>"
                                class="large-text"
                                placeholder="https://entangle.ch/script/your-uuid.js"
                            />
                            <p class="description">Full URL to the Entangle JavaScript module.</p>
                            <?php if ( $script_src ) : ?>
                                <p class="entangle-preview"><strong>Preview:</strong><br>
                                <code>&lt;script type="module" crossorigin src="<?php echo esc_html( $script_src ); ?>"&gt;&lt;/script&gt;</code></p>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="entangle-card">
                <h2>🎨 Stylesheet</h2>
                <p class="entangle-card-desc">This stylesheet is injected inside the <head> tag.</p>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="entangle_style_href">CSS URL<span class="required">*</span></label></th>
                        <td>
                            <input
                                type="url"
                                id="entangle_style_href"
                                name="<?php echo esc_attr( $name_style_href ); ?>"
                                value="<?php echo esc_attr( $style_href ); ?>"
                                class="large-text"
                                placeholder="https://entangle.ch/style/your-uuid.css"
                            />
                            <p class="description">Full URL to the Entangle stylesheet.</p>
                            <?php if ( $style_href ) : ?>
                                <p class="entangle-preview"><strong>Preview:</strong><br>
                                    <?php // phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedStylesheet ?>
                                    <code>&lt;link rel="stylesheet" crossorigin href="<?php echo esc_url( $style_href ); ?>" /&gt;</code>
                                </p>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="entangle-card">
                <h2>🔒 Google reCAPTCHA</h2>
                <p class="entangle-card-desc">Injects the reCAPTCHA v3 script into the <head>. Leave blank to disable.</p>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="entangle_recaptcha_site_key">reCAPTCHA Site Key</label></th>
                        <td>
                            <input
                                type="text"
                                id="entangle_recaptcha_site_key"
                                name="<?php echo esc_attr( $name_recaptcha_key ); ?>"
                                value="<?php echo esc_attr( $recaptcha_key ); ?>"
                                class="large-text"
                                placeholder="Your reCAPTCHA key provided by Entangle"
                            />
                            <p class="description">
                                Your reCAPTCHA v3 site key from
                                <a href="https://www.google.com/recaptcha/admin" target="_blank" rel="noopener noreferrer">Google reCAPTCHA Admin</a>.
                            </p>
                            <?php if ( $recaptcha_key ) : ?>
                                <p class="entangle-preview"><strong>Preview:</strong><br>
                                <code>&lt;script src="https://www.google.com/recaptcha/api.js?render=<?php echo esc_html( $recaptcha_key ); ?>"&gt;&lt;/script&gt;</code></p>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="entangle-card entangle-card-info">
                <h2>📌 Support Articles</h2>
                <p>Read the full documentation -<a href="https://docs.entangle.cloud/docs" target="_blank" rel="noopener noreferrer">https://docs.entangle.cloud/docs</a></p>
                <ul>
                    <li>&#9989; How to fill the script URL field?</li>
                    <li>&#9989; How to fill the CSS URL field?'</li>
                    <li>&#9989; How to enter the reCAPTCHA site key?</li>
                    <li>&#9989; How can I use my own reCAPTCHA site key?</li>
                </ul>
            </div>

            <?php submit_button('Save Settings', 'primary large' ); ?>
        </form>
    </div>

    <style>
        #entangle-admin { max-width: 860px; }
        #notification { display: none; }
        .entangle-header { margin-bottom: 24px; }
        .entangle-header h1 { font-size: 26px; margin-bottom: 4px; }
        .entangle-subtitle { color: #666; margin-top: 0; }
        .entangle-card {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px 24px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,.05);
        }
        .entangle-card h2 { margin-top: 0; font-size: 16px; }
        .entangle-card-desc { color: #666; margin-top: -8px; font-size: 13px; }
        .entangle-card-info { background: #f0f6ff; border-color: #c3d9f7; }
        .entangle-card-info ul { margin: 0; padding-left: 4px; list-style: none; }
        .entangle-card-info li { margin-bottom: 8px; font-size: 13px; }
        .entangle-preview {
            margin-top: 8px;
            padding: 10px 12px;
            background: #f6f6f6;
            border-left: 3px solid #2271b1;
            border-radius: 4px;
            font-size: 12px;
            word-break: break-all;
        }
        .required { color: #d63638; }
        .entangle-toggle { position: relative; display: inline-block; width: 48px; height: 26px; }
        .entangle-toggle input { opacity: 0; width: 0; height: 0; }
        .entangle-toggle-slider {
            position: absolute; cursor: pointer; inset: 0;
            background-color: #ccc; border-radius: 26px;
            transition: .3s;
        }
        .entangle-toggle-slider:before {
            content: ""; position: absolute;
            height: 20px; width: 20px;
            left: 3px; bottom: 3px;
            background: white; border-radius: 50%;
            transition: .3s;
        }
        .entangle-toggle input:checked + .entangle-toggle-slider { background-color: #2271b1; }
        .entangle-toggle input:checked + .entangle-toggle-slider:before { transform: translateX(22px); }
    </style>
    <?php
}

// ─── Enqueue widget stylesheet in <head> ──────────────────────────────────────
// FIX: Use wp_enqueue_style() instead of raw echo — satisfies NonEnqueuedStylesheet rule
add_action( 'wp_enqueue_scripts', function () {
    if ( ! get_option( ENTANGLE_OPTION_ENABLED, 1 ) ) {
        return;
    }

    $style_href = get_option( ENTANGLE_OPTION_STYLE_HREF, '' );

    if ( $style_href ) {
        wp_enqueue_style(
            'entangle-widget-style',
            esc_url( $style_href ),
            [],
            null // null prevents appending ?ver= to external URL
        );
        // Add crossorigin attribute — not settable through wp_enqueue_style()
        add_filter( 'style_loader_tag', 'entangle_add_crossorigin_to_style', 10, 2 );
    }
} );

function entangle_add_crossorigin_to_style( $tag, $handle ) {
    if ( 'entangle-widget-style' === $handle ) {
        $tag = str_replace( "rel='stylesheet'", "rel='stylesheet' crossorigin", $tag );
    }
    return $tag;
}

// ─── Enqueue reCAPTCHA script in <head> ───────────────────────────────────────
// FIX: Use wp_enqueue_script() instead of raw echo — satisfies NonEnqueuedScript rule
add_action( 'wp_enqueue_scripts', function () {
    if ( ! get_option( ENTANGLE_OPTION_ENABLED, 1 ) ) {
        return;
    }

    $recaptcha_key = get_option( ENTANGLE_OPTION_RECAPTCHA_KEY, '' );

    if ( $recaptcha_key ) {
        wp_enqueue_script(
            'entangle-recaptcha',
            'https://www.google.com/recaptcha/api.js?render=' . rawurlencode( $recaptcha_key ),
            [],
            null,
            false // false = load in <head>
        );
    }
} );

// ─── Enqueue widget JS module in footer ───────────────────────────────────────
// FIX: Use wp_enqueue_script() instead of raw echo — satisfies NonEnqueuedScript rule
add_action( 'wp_enqueue_scripts', function () {
    if ( ! get_option( ENTANGLE_OPTION_ENABLED, 1 ) ) {
        return;
    }

    $script_src = get_option( ENTANGLE_OPTION_SCRIPT_SRC, '' );

    if ( $script_src ) {
        wp_enqueue_script(
            'entangle-widget-script',
            esc_url( $script_src ),
            [],
            null,
            true // true = load in footer
        );
        // Add type="module" and crossorigin — not settable through wp_enqueue_script()
        add_filter( 'script_loader_tag', 'entangle_add_module_type_to_script', 10, 2 );
    }
} );

function entangle_add_module_type_to_script( $tag, $handle ) {
    if ( 'entangle-widget-script' === $handle ) {
        $tag = str_replace( '<script ', "<script type='module' crossorigin ", $tag );
    }
    return $tag;
}

// ─── Inject <entangle-app> early in <body> ────────────────────────────────────
add_action( 'wp_body_open', function () {
    if ( ! get_option( ENTANGLE_OPTION_ENABLED, 1 ) ) {
        return;
    }
    echo "\n<!-- Entangle App Root -->\n<entangle-app></entangle-app>\n";
} );

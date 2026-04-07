=== Entangle AI Chat Bot ===
Contributors: entangle
Tags: ai chatbot, chatbot, customer support, ai assistant, live chat
Requires at least: 5.9
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add an AI-powered chatbot to your WordPress site that answers visitor questions based on your website's own content and knowledge base.

== Description ==

**Entangle** connects your WordPress website to an AI chatbot that understands your content. Visitors can ask questions in natural language and get accurate, relevant answers drawn directly from your site — without you writing a single FAQ.

Whether you run a clinic, a business, or an online store, Entangle turns your existing website content into a 24/7 support agent.

= How it works =

1. Sign up for a subscription at [entangle.ch](https://entangle.ch)
2. After subscribing, you receive a unique Script URL and CSS URL tied to your website
3. Enter those URLs in the Entangle plugin settings page
4. The chatbot widget is automatically injected into your site — no coding required

= Features =

* AI chatbot trained on your website's content
* Instant answers to visitor questions, 24/7
* Simple admin settings page — no coding needed
* Google reCAPTCHA v3 support to prevent spam
* Enable/disable the widget sitewide with one toggle
* Lightweight injection — no bloat, no jQuery dependency
* Works with any WordPress theme

= External Services =

This plugin connects to the **Entangle service** (entangle.ch) to load the chatbot widget. Specifically:

* A JavaScript module is loaded from `https://entangle.ch/script/` — this powers the chatbot interface
* A CSS stylesheet is loaded from `https://entangle.ch/style/` — this styles the chatbot widget
* Visitor messages are sent to Entangle's AI backend for processing

These requests are made on the **frontend of your site** whenever a visitor loads a page. No data is sent during plugin activation or from the WordPress admin.

By using this plugin, you agree to the [Entangle Terms of Service](https://entangle.ch/terms) and [Privacy Policy](https://entangle.ch/privacy).

A paid subscription from [entangle.ch](https://entangle.ch) is required to obtain the script and CSS URLs needed to activate the chatbot.

= Privacy =

Visitor chat messages are processed by Entangle's AI service. Please disclose this in your site's privacy policy. Entangle does not sell visitor data to third parties.

== Installation ==

1. Upload the plugin files to `/wp-content/plugins/entangle-injector/`, or install directly via the WordPress plugin screen
2. Activate the plugin through the **Plugins** screen in WordPress
3. Go to the **Entangle** menu item in your WordPress admin sidebar
4. Enter your Script URL, CSS URL, and reCAPTCHA site key (provided after subscribing at [entangle.ch](https://entangle.ch))
5. Click **Save Settings** — your chatbot is now live

**Requirements:**
* An active Entangle subscription — [get one at entangle.ch](https://entangle.ch)
* Your theme must call `wp_body_open()` for the chatbot element to render (all modern themes support this)

== Frequently Asked Questions ==

= Do I need to pay to use this plugin? =

The plugin itself is free. However, an active subscription from [entangle.ch](https://entangle.ch) is required to receive the script and CSS URLs that power the chatbot.

= Where do I get my Script URL and CSS URL? =

After subscribing at [entangle.ch](https://entangle.ch), you will receive a unique Script URL and CSS URL for your website from the Entangle dashboard.

= Will this slow down my website? =

No. The chatbot assets are loaded from a fast CDN and do not block page rendering. The JavaScript module uses `type="module"` which is inherently non-blocking.

= Does this work with page caching plugins? =

Yes. The injection happens through WordPress hooks (`wp_head`, `wp_footer`, `wp_body_open`) which are compatible with all major caching plugins including WP Rocket, W3 Total Cache, and WP Super Cache.

= What happens if I disable the widget? =

You can toggle the widget off from the settings page at any time. This removes all injected code from your frontend without deleting your saved URLs or settings.

= Does the chatbot work in multiple languages? =

Yes. Entangle supports multilingual websites. Contact [entangle.ch](https://entangle.ch) for details on multilingual configuration.

= Is Google reCAPTCHA required? =

Yes, The reCAPTCHA field is required. You can use your own reCAPTCHA key or use the one provided by Entangle

= My theme doesn't support wp_body_open — what do I do? =

If your theme doesn't call `wp_body_open()`, the `<entangle-app>` element may not render correctly. We recommend updating to a theme that supports this standard WordPress hook, or contact Entangle support for assistance.

== Screenshots ==

1. The Entangle admin settings page — enter your Script URL, CSS URL and reCAPTCHA key
![https://i.imgur.com/j4LKIrc.png](https://i.imgur.com/j4LKIrc.png)
2. The chatbot widget displayed on a live WordPress site
![https://i.imgur.com/wvJnry4.png](https://i.imgur.com/wvJnry4.png)
3. A visitor asking a question and receiving an AI-generated answer based on site content
![https://i.imgur.com/d5VExGF.png](https://i.imgur.com/d5VExGF.png)

== Changelog ==

= 1.0.0 =
* Initial release
* Admin settings page with Script URL, CSS URL, and reCAPTCHA site key fields
* Sitewide enable/disable toggle
* Injects stylesheet in `<head>`, reCAPTCHA in `<head>`, `<entangle-app>` in `<body>`, and JS module before `</body>`

== Upgrade Notice ==

= 1.0.0 =
Initial release.

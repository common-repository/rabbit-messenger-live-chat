Rabbit Messenger Live-chat
=====================

### Hop into the Future

Want to exceed your customers expectations? Give your customer-journey a boost. Make communicating with your customers
swifter, effortless and fun with [Rabbit Messenger](https://rabbit.nl)!

# Who's the target audience for this package?

If you're a non-technical customer, please send this information to your developer or technical contact.

# What's in this package?

This Composer package facilitates authorization for the Rabbit Messenger Live-chat plugin. The `LiveChatService::fetchToken`
method will return a `AuthenticationResponse`, which is then used to authenticate against the Live-chat services.

# Implementation / installation

## Craft

For Craft, instructions will follow.

## WordPress

For WordPress, instructions will follow.

## Other / stand-alone

If you're not using Craft or WordPress, you can implement this package in your own setup. Please note that you'll need
PHP, and you'll need to meet the necessary dependencies as outlined in the `composer.json` file.

### Back-end

If you do, the package can be installed using Composer:

```shell
composer require rabbit-software/live-chat-plugin-core
```

The response from the `LiveChatService` will need to be returned by an endpoint as JSON. The `LiveChatService` expects
the API key, API secret and a [PSR-18](https://www.php-fig.org/psr/psr-18/) compatible HTTP-client.

In order to use this, you need to
be a [Rabbit Messenger](https://rabbit.com) user. To use the Live-chat,
contact [Rabbit Messenger support](https://support.rabbit.nl) and request access to the Live-chat plugin. Credentials
will be supplied by [Rabbit Messenger support](https://support.rabbit.nl) after activation of the Live-chat
plugin.

### Front-end

In your `<head>` section, load the CSS file:

```html

<link rel="stylesheet" href="https://cdn.plugins.rabbit.nl/styles.css"/>
```

Just before the `</body>` close tag, load the widget and then the JavaScript:

```html

<rabbit-messenger-live-chat-widget
	avatar-url="/some-custom-avatar.jpg"
	login-url="//localhost/path/to/your/custom/login-proxy.php"
	whatsapp-url="https://wa.me/message/<insert-your-wa-me-code-here>"
	welcome-title="Some title welcoming your visitor"
	welcome-description="Send us a message if you need any help!"
></rabbit-messenger-live-chat-widget>

<script src="https://cdn.plugins.rabbit.nl/polyfills.js" type="module"></script>
<script src="https://cdn.plugins.rabbit.nl/main.js" type="module"></script>
```


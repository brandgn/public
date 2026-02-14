<?php
/**
 * Oz Labs Announcement Bar
 *
 * A scroll-jank-free announcement bar for WordPress + BeTheme.
 * The bar sits in normal document flow above the header — no position:fixed,
 * no MutationObserver, no header manipulation.
 *
 * Installation: Add the contents of this file to your child theme's functions.php,
 * or include it via:
 *   require_once get_stylesheet_directory() . '/announcement-bar/functions.php';
 */

/* ---- Oz Labs Announcement Bar: CSS ---- */
add_action('wp_head', 'oz_announcement_bar_css');
function oz_announcement_bar_css() {
    ?>
    <style id="oz-announcement-bar-css">
        #oz-announcement-bar {
            position: relative;
            width: 100%;
            height: 34px;
            background-color: rgb(4, 60, 190);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            z-index: 10;
            box-sizing: border-box;
        }

        #oz-announcement-bar .oz-announce-msg {
            color: #ffffff;
            font-size: 12px;
            font-family: "Poppins", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            line-height: 34px;
            margin: 0;
            padding: 0;
            position: absolute;
            transition: opacity 0.8s ease;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        #oz-announcement-bar .oz-announce-msg span.oz-highlight {
            font-weight: 700;
        }

        #oz-announcement-bar .oz-announce-msg a.oz-link {
            color: #5db6ff;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.3s ease;
        }

        #oz-announcement-bar .oz-announce-msg a.oz-link:hover {
            color: #ffffff;
        }

        #oz-announcement-bar .oz-announce-msg.oz-hidden {
            opacity: 0;
        }

        #oz-announcement-bar .oz-announce-msg.oz-visible {
            opacity: 1;
        }

        @media (max-width: 767px) {
            #oz-announcement-bar .oz-announce-msg {
                font-size: 12px;
                letter-spacing: 0.8px;
            }
        }
    </style>
    <?php
}

/* ---- Oz Labs Announcement Bar: HTML + JS ---- */
add_action('wp_footer', 'oz_announcement_bar_js');
function oz_announcement_bar_js() {
    ?>
    <script id="oz-announcement-bar-js">
    (function() {
        // Create the announcement bar
        var bar = document.createElement('div');
        bar.id = 'oz-announcement-bar';
        bar.innerHTML =
            '<span class="oz-announce-msg oz-visible" id="oz-msg-1">&#x2713;&ensp;<span class="oz-highlight">Free Delivery</span> on Orders over $199.00</span>' +
            '<span class="oz-announce-msg oz-hidden" id="oz-msg-2">&#x2713;&ensp;<span class="oz-highlight">Save More</span> with our <a class="oz-link" href="/product-category/bundles/">Value Bundles</a></span>';

        // Insert before BeTheme's header wrapper (in normal document flow)
        var header = document.getElementById('Header_wrapper');
        if (header && header.parentNode) {
            header.parentNode.insertBefore(bar, header);
        } else {
            document.body.insertBefore(bar, document.body.firstChild);
        }

        // Message rotation
        var msg1 = document.getElementById('oz-msg-1');
        var msg2 = document.getElementById('oz-msg-2');
        var showingFirst = true;

        setInterval(function() {
            if (showingFirst) {
                msg1.classList.remove('oz-visible');
                msg1.classList.add('oz-hidden');
                msg2.classList.remove('oz-hidden');
                msg2.classList.add('oz-visible');
            } else {
                msg2.classList.remove('oz-visible');
                msg2.classList.add('oz-hidden');
                msg1.classList.remove('oz-hidden');
                msg1.classList.add('oz-visible');
            }
            showingFirst = !showingFirst;
        }, 4500);
    })();
    </script>
    <?php
}

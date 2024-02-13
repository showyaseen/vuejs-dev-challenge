<?php

/**
 * Plugin View.
 *
 *
 * @package ytaha-vuejs-dev-challenge
 */

namespace YaseenTaha\VueJSDevChallenge;

defined('ABSPATH') || exit;
?>


<?php if (!is_admin()) : ?>
    <div class="flex items-center flex-shrink-0 text-gray-700 m-4 mb-6 p-2">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#e27730" class="w-12 h-12 relative top-1.5 right-1">
            <path fill-rule="evenodd" d="M2.25 6a3 3 0 0 1 3-3h13.5a3 3 0 0 1 3 3v12a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V6Zm3.97.97a.75.75 0 0 1 1.06 0l2.25 2.25a.75.75 0 0 1 0 1.06l-2.25 2.25a.75.75 0 0 1-1.06-1.06l1.72-1.72-1.72-1.72a.75.75 0 0 1 0-1.06Zm4.28 4.28a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Z" clip-rule="evenodd"></path>
        </svg>
        <span class="font-semibold text-xl tracking-tight">Awesome Motive - Yaseen Taha</span>
    </div>

    <div class="p-4 max-w mt-6 bg-white shadow-md rounded-md w-11/12">
        <article class="prose lg:prose-xl w-full">
            <div class="flex items-center text-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#e80000" class="w-10 h-10">
                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                </svg>

                <h2 class="mx-2"><?php echo __('ACCESS TO THE PLUGIN IS NOT ALLOWED'); ?></h2>
            </div>
            <p class="text-sm">
                <?php echo __('This plugin is designed for users with administrator privileges. If you lack the necessary access, please reach out to the site owner for support with any plugin-related accessibility issues.'); ?>
            </p>
        </article>
    </div>

<?php else : ?>

    <div id="vuejs-dev-challenge-render"></div>

    <noscript>
        <div class="p-4 max-w mt-6 bg-white shadow-md rounded-md w-11/12">
            <article class="prose lg:prose-xl w-full">
                <div class="flex items-center text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#e80000" class="w-10 h-10">
                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                    </svg>

                    <h2 class="mx-2"><?php echo __('Javascript is required'); ?></h2>
                </div>

                <p class="text-sm">
                    <?php echo __('JavaScript is required to use this plugin. Please enable JavaScript in your browser settings.'); ?>
                </p>

            </article>
        </div>
    </noscript>


<?php endif; ?>
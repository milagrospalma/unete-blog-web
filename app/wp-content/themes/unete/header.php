<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=11,IE=10,IE=9,IE=edge"/>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <title><?php wp_title(); ?></title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php bloginfo('template_directory'); ?>/img/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php bloginfo('template_directory'); ?>/img/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php bloginfo('template_directory'); ?>/img/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php bloginfo('template_directory'); ?>/img/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php bloginfo('template_directory'); ?>/img/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php bloginfo('template_directory'); ?>/img/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php bloginfo('template_directory'); ?>/img/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php bloginfo('template_directory'); ?>/img/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php bloginfo('template_directory'); ?>/img/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php bloginfo('template_directory'); ?>/img/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php bloginfo('template_directory'); ?>/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php bloginfo('template_directory'); ?>/img/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php bloginfo('template_directory'); ?>/img/favicons/favicon-16x16.png">
    <link rel="manifest" href="<?php bloginfo('template_directory'); ?>/img/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php bloginfo('template_directory'); ?>/img/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <?php wp_head(); ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Google Tag Manager -->
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});
            var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=
                true;j.src= 'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-W63N7X');</script>
    <!-- End Google Tag Manager -->
</head>

<body <?php body_class(); ?> >
<header class="unete-blog-header">
    <?php
    if(is_single()){
        ?>
        <div class="progressbar">
            <div class="progressbar__highlight" id="js-highlight"></div>
        </div>
        <?php
    }
    ?>
    <div class="nav__main">
        <div class="nav__main__initial">
            <nav class="nav__main__brands">
                <div class="container">
                    <div class="content">
                        <div class="brands">
                            <a href="javascript:void(0)">
                                <svg width="79" height="29" viewBox="0 0 79 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M74.5867 16.8137C75.559 17.8214 76.0685 19.244 76.0203 20.8193C75.937 23.3714 74.1843 26.1187 70.5329 26.1187C67.4117 26.1187 65.2315 23.8781 65.2315 20.6704C65.2315 17.5306 67.4482 15.2523 70.5027 15.2523C72.1884 15.2523 73.6001 15.7919 74.5867 16.8137ZM70.4399 12.4675C65.7043 12.4675 62.3965 15.8021 62.3965 20.5773C62.3965 25.4828 65.617 28.7792 70.4093 28.7792C72.7769 28.7792 74.7681 27.5465 75.897 26.0264L76.0225 28.3635L76.023 28.3706H78.7311V12.8781H75.9589L75.9335 15.3C74.7792 13.7513 72.7381 12.4675 70.4399 12.4675ZM38.8046 8.37363C38.8046 10.9835 42.7024 10.9835 42.7024 8.40992C42.7024 5.79997 38.8046 5.79997 38.8046 8.37363ZM39.2204 28.3569H42.2864V12.8864H39.2204V28.3569ZM35.1655 17.9145C34.8267 14.402 32.1289 12.4666 27.5583 12.4666C23.5649 12.4666 20.8824 14.3864 20.8824 17.2437C20.8824 19.7363 22.5385 21.1316 26.0925 21.6351L28.9895 22.09C31.0457 22.4303 32.16 22.8799 32.16 24.2798C32.16 25.6497 30.718 26.4681 28.3024 26.4681C25.6248 26.4681 23.914 25.4091 23.416 23.4753H20.4193C20.8739 26.8003 23.7861 28.7769 28.3024 28.7769C32.619 28.7769 35.4088 26.9015 35.4088 23.9993C35.4088 21.4173 33.7447 20.0618 29.8448 19.4684L26.6353 19.0128C24.8762 18.7343 24.092 18.1021 24.092 16.9643C24.092 15.6349 25.4528 14.7756 27.5583 14.7756C30.3548 14.7756 31.8698 15.7772 32.312 17.9145H35.1655ZM54.1458 19.2491L61.5278 28.3572H57.8888L57.863 28.3254L51.855 20.9744L49.8256 22.7788V28.3572H46.7596V6.44795L49.8256 6.44795V19.7085L57.3738 12.8865H61.2598L61.0893 13.0381L54.1458 19.2491ZM3.57908 19.1611L3.59241 19.1018H3.58895C3.59241 19.0898 3.59612 19.0775 3.59958 19.0643C3.92737 17.7098 4.66174 16.6135 5.72339 15.8937C5.79669 15.8434 5.87011 15.7937 5.94559 15.7476C5.96353 15.7367 5.98083 15.7267 5.99876 15.7164L6.04182 15.6918C6.16586 15.6196 6.29093 15.5534 6.41522 15.4951L6.43854 15.4842C6.58488 15.4159 6.73622 15.3537 6.88858 15.2992L6.89716 15.2963C7.05324 15.241 7.21393 15.1917 7.37602 15.1503L7.4037 15.142C7.53915 15.1084 7.68087 15.0784 7.83631 15.0516L7.8818 15.0428C7.90281 15.0391 7.92306 15.0347 7.94446 15.0316C8.04325 15.0163 8.14436 15.0054 8.24661 14.9948C8.53685 14.9615 8.78237 14.9464 9.02007 14.9464C11.8721 14.9464 13.8746 16.4805 14.3779 19.0538L14.3912 19.0995C14.3917 19.1004 14.3919 19.1012 14.3919 19.1018H14.3853L14.3958 19.1588C14.4527 19.4805 14.4866 19.7759 14.5 20.0599H3.43197C3.45965 19.7723 3.50783 19.4773 3.57908 19.1611ZM13.9492 23.5055C13.1911 25.3516 11.6107 26.2871 9.25158 26.2871C5.99616 26.2871 3.78445 24.4599 3.47935 21.5197C3.47896 21.5152 3.43975 21.0798 3.42886 20.8122L17.5405 20.8122L17.5385 20.7618C17.4864 19.3273 17.276 18.2668 16.8102 17.1013C15.6318 14.207 12.7254 12.4789 9.03566 12.4789C4.00344 12.4789 0.488281 15.8647 0.488281 20.7122C0.488281 25.5433 3.89888 28.7894 8.97467 28.7894C13.0355 28.7894 15.7496 27.0734 17.2717 23.5433L17.301 23.4753L13.9613 23.4753L13.9492 23.5055ZM17.5682 0.636963L4.64645 11.2064L4.9809 11.6191L17.9032 1.04954L17.5682 0.636963Z" fill="black"/>
                                </svg>
                            </a>
                            <a href="javascript:void(0)">
                                <svg width="76" height="19" viewBox="0 0 76 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.44043 18.2531L0.44043 0.93457L2.23864 0.93457L2.23864 16.4491H15.5824V18.2531L0.44043 18.2531ZM42.8292 16.4491V8.93677L53.2545 8.93677V7.13263L42.8292 7.13263V2.73855L56.1425 2.73855V0.93457L41.031 0.93457V18.2531L56.1727 18.2531V16.4491H42.8292ZM60.5033 0.93457V18.2531L75.6452 18.2531V16.4491H62.3013V0.93457L60.5033 0.93457ZM13.7848 0.93457V4.48343L15.5827 5.64623V0.93457L13.7848 0.93457ZM33.4741 7.43372C35.6577 8.18242 37.2281 10.2531 37.2281 12.6924C37.2281 15.7461 34.7676 18.2237 31.7229 18.25V18.2536H20.1189L20.1189 0.93457L30.4639 0.935427C32.6423 0.935771 34.4085 2.70402 34.4085 4.88483C34.4085 5.85716 34.056 6.74566 33.4741 7.43372ZM30.4736 2.73683L21.9183 2.73648V7.13125L30.5394 7.13125C31.7174 7.09553 32.6629 6.11634 32.6629 4.92811C32.6629 3.71808 31.6826 2.73683 30.4736 2.73683ZM21.9183 16.4491L31.7229 16.4491C33.7768 16.4258 35.4357 14.754 35.4357 12.6924C35.4357 10.6164 33.7415 8.93334 31.6797 8.93334H31.6761V8.93265H21.9183L21.9183 16.4491Z" fill="black"/>
                                </svg>
                            </a>
                            <a href="javascript:void(0)">
                                <svg width="79" height="25" viewBox="0 0 79 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M66.3911 12.2353V0.505981L70.4551 0.505981V2.90475H68.8999V9.83653H70.4551V12.2353H66.3911ZM74.5192 2.90475V0.505981L78.5832 0.505981V12.2353H74.5192V9.83588H76.0761V2.90475H74.5192ZM58.9329 6.52473C58.9329 5.30145 59.5089 4.71025 60.3821 4.71025C61.2592 4.71025 61.8349 5.30511 61.8349 6.53288V9.36157H58.9329V6.52473ZM64.9183 11.8401V6.56507C64.9183 3.70487 63.2853 1.91294 60.3218 1.91294C57.3602 1.91294 55.7289 3.7031 55.7289 6.56507V15.5852C55.7289 18.5354 57.3873 20.2329 60.3218 20.2329C63.2573 20.2329 64.9183 18.5354 64.9183 15.5852V13.4457H61.8349V15.5852C61.8349 16.9018 61.223 17.4375 60.3245 17.4375C59.6215 17.4375 58.9329 16.9099 58.9329 15.5879V11.8401H64.9183ZM46.216 7.43817L49.1947 20.0151H53.2369V2.13249H50.3438V14.5185L47.4787 2.13249L43.3184 2.13249V20.0151L46.216 20.0151V7.43817ZM37.632 15.6148C37.632 16.8424 37.0868 17.4374 36.117 17.4374C35.148 17.4374 34.62 16.8434 34.62 15.6255V6.52464C34.62 5.3015 35.148 4.71017 36.117 4.71017C37.0868 4.71017 37.632 5.30503 37.632 6.53279V15.6148ZM36.0989 1.913C33.0843 1.913 31.4161 3.70302 31.4161 6.56499L31.4161 15.5851C31.4161 18.4419 33.0843 20.2329 36.0989 20.2329C39.1102 20.2329 40.812 18.4419 40.812 15.5851V6.56499C40.812 3.70492 39.1102 1.913 36.0989 1.913ZM21.5479 4.8371L26.2021 4.8371L21.5146 17.3132V20.015H29.5405V17.3132H24.8194L29.4449 4.8371V2.13244L21.5479 2.13244V4.8371ZM17.1037 2.13248L20.2806 2.13248L15.8436 24.2237L12.6324 24.2237L13.8941 18.2527L10.0871 2.13248L13.4507 2.13248L15.3705 13.0373L17.1037 2.13248ZM9.20223 15.5851V13.4457L6.1171 13.4457V15.5851C6.1171 16.9017 5.4878 17.4375 4.70206 17.4375H4.6082C3.87837 17.4375 3.2167 16.9099 3.2167 15.588L3.2167 6.5247C3.2167 5.30142 3.8026 4.71022 4.6082 4.71022H4.70206C5.54915 4.71022 6.1171 5.30508 6.1171 6.53285V8.38767H9.20223L9.20223 6.56504C9.20223 3.70484 7.54288 1.91305 4.74165 1.91305H4.55433C1.7214 1.91305 0.0117188 3.70307 0.0117188 6.56504L0.0117188 15.5851C0.0117188 18.5354 1.68903 20.2329 4.55433 20.2329H4.74165C7.54288 20.2329 9.20223 18.5354 9.20223 15.5851Z" fill="black"/>
                                </svg>
                            </a>
                        </div>
                        <a class="btn-start black-button hidden-xs hidden-sm">¡Inicia ya!</a>
                    </div>
                </div>
            </nav>
            <nav class="nav__main__options hidden-xs hidden-sm">
                <div class="container">
                    <?php set_blog_menu_primary() ?>
                </div>
            </nav>
        </div>

        <nav class="nav__main__scroll hidden-xs hidden-sm">
            <div class="container">
                <div class="brands">
                    <a href="javascript:void(0)">
                        <svg width="79" height="29" viewBox="0 0 79 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M74.5867 16.8137C75.559 17.8214 76.0685 19.244 76.0203 20.8193C75.937 23.3714 74.1843 26.1187 70.5329 26.1187C67.4117 26.1187 65.2315 23.8781 65.2315 20.6704C65.2315 17.5306 67.4482 15.2523 70.5027 15.2523C72.1884 15.2523 73.6001 15.7919 74.5867 16.8137ZM70.4399 12.4675C65.7043 12.4675 62.3965 15.8021 62.3965 20.5773C62.3965 25.4828 65.617 28.7792 70.4093 28.7792C72.7769 28.7792 74.7681 27.5465 75.897 26.0264L76.0225 28.3635L76.023 28.3706H78.7311V12.8781H75.9589L75.9335 15.3C74.7792 13.7513 72.7381 12.4675 70.4399 12.4675ZM38.8046 8.37363C38.8046 10.9835 42.7024 10.9835 42.7024 8.40992C42.7024 5.79997 38.8046 5.79997 38.8046 8.37363ZM39.2204 28.3569H42.2864V12.8864H39.2204V28.3569ZM35.1655 17.9145C34.8267 14.402 32.1289 12.4666 27.5583 12.4666C23.5649 12.4666 20.8824 14.3864 20.8824 17.2437C20.8824 19.7363 22.5385 21.1316 26.0925 21.6351L28.9895 22.09C31.0457 22.4303 32.16 22.8799 32.16 24.2798C32.16 25.6497 30.718 26.4681 28.3024 26.4681C25.6248 26.4681 23.914 25.4091 23.416 23.4753H20.4193C20.8739 26.8003 23.7861 28.7769 28.3024 28.7769C32.619 28.7769 35.4088 26.9015 35.4088 23.9993C35.4088 21.4173 33.7447 20.0618 29.8448 19.4684L26.6353 19.0128C24.8762 18.7343 24.092 18.1021 24.092 16.9643C24.092 15.6349 25.4528 14.7756 27.5583 14.7756C30.3548 14.7756 31.8698 15.7772 32.312 17.9145H35.1655ZM54.1458 19.2491L61.5278 28.3572H57.8888L57.863 28.3254L51.855 20.9744L49.8256 22.7788V28.3572H46.7596V6.44795L49.8256 6.44795V19.7085L57.3738 12.8865H61.2598L61.0893 13.0381L54.1458 19.2491ZM3.57908 19.1611L3.59241 19.1018H3.58895C3.59241 19.0898 3.59612 19.0775 3.59958 19.0643C3.92737 17.7098 4.66174 16.6135 5.72339 15.8937C5.79669 15.8434 5.87011 15.7937 5.94559 15.7476C5.96353 15.7367 5.98083 15.7267 5.99876 15.7164L6.04182 15.6918C6.16586 15.6196 6.29093 15.5534 6.41522 15.4951L6.43854 15.4842C6.58488 15.4159 6.73622 15.3537 6.88858 15.2992L6.89716 15.2963C7.05324 15.241 7.21393 15.1917 7.37602 15.1503L7.4037 15.142C7.53915 15.1084 7.68087 15.0784 7.83631 15.0516L7.8818 15.0428C7.90281 15.0391 7.92306 15.0347 7.94446 15.0316C8.04325 15.0163 8.14436 15.0054 8.24661 14.9948C8.53685 14.9615 8.78237 14.9464 9.02007 14.9464C11.8721 14.9464 13.8746 16.4805 14.3779 19.0538L14.3912 19.0995C14.3917 19.1004 14.3919 19.1012 14.3919 19.1018H14.3853L14.3958 19.1588C14.4527 19.4805 14.4866 19.7759 14.5 20.0599H3.43197C3.45965 19.7723 3.50783 19.4773 3.57908 19.1611ZM13.9492 23.5055C13.1911 25.3516 11.6107 26.2871 9.25158 26.2871C5.99616 26.2871 3.78445 24.4599 3.47935 21.5197C3.47896 21.5152 3.43975 21.0798 3.42886 20.8122L17.5405 20.8122L17.5385 20.7618C17.4864 19.3273 17.276 18.2668 16.8102 17.1013C15.6318 14.207 12.7254 12.4789 9.03566 12.4789C4.00344 12.4789 0.488281 15.8647 0.488281 20.7122C0.488281 25.5433 3.89888 28.7894 8.97467 28.7894C13.0355 28.7894 15.7496 27.0734 17.2717 23.5433L17.301 23.4753L13.9613 23.4753L13.9492 23.5055ZM17.5682 0.636963L4.64645 11.2064L4.9809 11.6191L17.9032 1.04954L17.5682 0.636963Z" fill="black"/>
                        </svg>
                    </a>
                    <a href="javascript:void(0)">
                        <svg width="76" height="19" viewBox="0 0 76 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.44043 18.2531L0.44043 0.93457L2.23864 0.93457L2.23864 16.4491H15.5824V18.2531L0.44043 18.2531ZM42.8292 16.4491V8.93677L53.2545 8.93677V7.13263L42.8292 7.13263V2.73855L56.1425 2.73855V0.93457L41.031 0.93457V18.2531L56.1727 18.2531V16.4491H42.8292ZM60.5033 0.93457V18.2531L75.6452 18.2531V16.4491H62.3013V0.93457L60.5033 0.93457ZM13.7848 0.93457V4.48343L15.5827 5.64623V0.93457L13.7848 0.93457ZM33.4741 7.43372C35.6577 8.18242 37.2281 10.2531 37.2281 12.6924C37.2281 15.7461 34.7676 18.2237 31.7229 18.25V18.2536H20.1189L20.1189 0.93457L30.4639 0.935427C32.6423 0.935771 34.4085 2.70402 34.4085 4.88483C34.4085 5.85716 34.056 6.74566 33.4741 7.43372ZM30.4736 2.73683L21.9183 2.73648V7.13125L30.5394 7.13125C31.7174 7.09553 32.6629 6.11634 32.6629 4.92811C32.6629 3.71808 31.6826 2.73683 30.4736 2.73683ZM21.9183 16.4491L31.7229 16.4491C33.7768 16.4258 35.4357 14.754 35.4357 12.6924C35.4357 10.6164 33.7415 8.93334 31.6797 8.93334H31.6761V8.93265H21.9183L21.9183 16.4491Z" fill="black"/>
                        </svg>
                    </a>
                    <a href="javascript:void(0)">
                        <svg width="79" height="25" viewBox="0 0 79 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M66.3911 12.2353V0.505981L70.4551 0.505981V2.90475H68.8999V9.83653H70.4551V12.2353H66.3911ZM74.5192 2.90475V0.505981L78.5832 0.505981V12.2353H74.5192V9.83588H76.0761V2.90475H74.5192ZM58.9329 6.52473C58.9329 5.30145 59.5089 4.71025 60.3821 4.71025C61.2592 4.71025 61.8349 5.30511 61.8349 6.53288V9.36157H58.9329V6.52473ZM64.9183 11.8401V6.56507C64.9183 3.70487 63.2853 1.91294 60.3218 1.91294C57.3602 1.91294 55.7289 3.7031 55.7289 6.56507V15.5852C55.7289 18.5354 57.3873 20.2329 60.3218 20.2329C63.2573 20.2329 64.9183 18.5354 64.9183 15.5852V13.4457H61.8349V15.5852C61.8349 16.9018 61.223 17.4375 60.3245 17.4375C59.6215 17.4375 58.9329 16.9099 58.9329 15.5879V11.8401H64.9183ZM46.216 7.43817L49.1947 20.0151H53.2369V2.13249H50.3438V14.5185L47.4787 2.13249L43.3184 2.13249V20.0151L46.216 20.0151V7.43817ZM37.632 15.6148C37.632 16.8424 37.0868 17.4374 36.117 17.4374C35.148 17.4374 34.62 16.8434 34.62 15.6255V6.52464C34.62 5.3015 35.148 4.71017 36.117 4.71017C37.0868 4.71017 37.632 5.30503 37.632 6.53279V15.6148ZM36.0989 1.913C33.0843 1.913 31.4161 3.70302 31.4161 6.56499L31.4161 15.5851C31.4161 18.4419 33.0843 20.2329 36.0989 20.2329C39.1102 20.2329 40.812 18.4419 40.812 15.5851V6.56499C40.812 3.70492 39.1102 1.913 36.0989 1.913ZM21.5479 4.8371L26.2021 4.8371L21.5146 17.3132V20.015H29.5405V17.3132H24.8194L29.4449 4.8371V2.13244L21.5479 2.13244V4.8371ZM17.1037 2.13248L20.2806 2.13248L15.8436 24.2237L12.6324 24.2237L13.8941 18.2527L10.0871 2.13248L13.4507 2.13248L15.3705 13.0373L17.1037 2.13248ZM9.20223 15.5851V13.4457L6.1171 13.4457V15.5851C6.1171 16.9017 5.4878 17.4375 4.70206 17.4375H4.6082C3.87837 17.4375 3.2167 16.9099 3.2167 15.588L3.2167 6.5247C3.2167 5.30142 3.8026 4.71022 4.6082 4.71022H4.70206C5.54915 4.71022 6.1171 5.30508 6.1171 6.53285V8.38767H9.20223L9.20223 6.56504C9.20223 3.70484 7.54288 1.91305 4.74165 1.91305H4.55433C1.7214 1.91305 0.0117188 3.70307 0.0117188 6.56504L0.0117188 15.5851C0.0117188 18.5354 1.68903 20.2329 4.55433 20.2329H4.74165C7.54288 20.2329 9.20223 18.5354 9.20223 15.5851Z" fill="black"/>
                        </svg>
                    </a>
                </div>
                <?php set_blog_menu_primary() ?>
                <a class="btn-start black-button hidden-xs hidden-sm">¡Inicia ya!</a>
            </div>
        </nav>
        <nav class="nav__main__options hidden-md">
            <button class="sidenav-open" type="button" data-toggle="collapse">
                <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.5 0.5C0.7 0.5 0 1.2 0 2C0 2.8 0.7 3.5 1.5 3.5H18.5C19.3 3.5 20 2.8 20 2C20 1.2 19.3 0.5 18.5 0.5H1.5ZM1.5 6.39996C0.7 6.39996 0 7.09996 0 7.89996C0 8.69996 0.7 9.39996 1.5 9.39996H18.5C19.3 9.39996 20 8.69996 20 7.89996C20 7.09996 19.3 6.39996 18.5 6.39996H1.5ZM1.5 12.3C0.7 12.3 0 13 0 13.8C0 14.6 0.7 15.3 1.5 15.3H18.5C19.3 15.3 20 14.6 20 13.8C20 13 19.3 12.3 18.5 12.3H1.5Z" fill="#020203"/>
                </svg>
            </button>
        </nav>
    </div>

    </div>
    <div class="nav__side hidden">
        <div class="overlay hidden-md"></div>
        <div class="nav__main__sidenav hidden-md">
            <button class="sidenav-close" type="button">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M19.5816 0.418419C20.1395 0.976311 20.1395 1.88083 19.5816 2.43872L2.43872 19.5816C1.88083 20.1395 0.976311 20.1395 0.418419 19.5816C-0.139473 19.0237 -0.139473 18.1192 0.418419 17.5613L17.5613 0.418419C18.1192 -0.139473 19.0237 -0.139473 19.5816 0.418419Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.418419 0.418419C0.976311 -0.139473 1.88083 -0.139473 2.43872 0.418419L19.5816 17.5613C20.1395 18.1192 20.1395 19.0237 19.5816 19.5816C19.0237 20.1395 18.1192 20.1395 17.5613 19.5816L0.418419 2.43872C-0.139473 1.88083 -0.139473 0.976311 0.418419 0.418419Z" fill="black"/>
                </svg>
            </button>
            <div class="container-sidenav">
                <?php set_blog_menu_primary('sidenav') ?>
                <div class="contact js-phones-by-country" style="display: none">
                    <h4>Estamos para ayudarte</h4>
                    <div class="contact-container">
                        <div>
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.8034 13.6668C11.7547 13.6668 11.7 13.6668 11.6514 13.6607C9.68755 13.448 7.77844 12.767 6.13078 11.6969C4.59863 10.7241 3.2732 9.3987 2.30041 7.86656C1.23034 6.21281 0.549382 4.29762 0.342664 2.3338C0.294024 1.83524 0.439943 1.36101 0.756101 0.990131C1.06618 0.613174 1.51001 0.388216 1.99033 0.339576C2.04505 0.333496 2.09977 0.333496 2.15449 0.333496H3.97848C3.98456 0.333496 3.99064 0.333496 3.99672 0.333496C4.89655 0.333496 5.6687 1.00229 5.79638 1.90212C5.86934 2.44324 6.0031 2.97219 6.19158 3.48291C6.44086 4.14563 6.28278 4.89954 5.77814 5.40418L5.34038 5.84193C6.05782 6.96064 7.00629 7.9152 8.13108 8.63263L8.56884 8.19487C9.07347 7.69632 9.83347 7.53216 10.4962 7.78144C11.0008 7.96992 11.5359 8.10367 12.0709 8.17055C12.989 8.29823 13.6638 9.09471 13.6456 10.0128V11.8307C13.6456 12.3171 13.4571 12.7731 13.1166 13.1196C12.7762 13.4662 12.3141 13.6547 11.8277 13.6607C11.8155 13.6668 11.8095 13.6668 11.8034 13.6668ZM3.99063 1.54949C3.98456 1.54949 3.98456 1.54949 3.99063 1.54949H2.15449C1.93561 1.56773 1.78969 1.64069 1.68633 1.76836C1.58297 1.88996 1.53433 2.04804 1.54649 2.2122C1.73497 3.97539 2.34905 5.70817 3.31576 7.20992C4.19735 8.59615 5.3951 9.7939 6.78133 10.6755C8.277 11.6483 10.0037 12.2563 11.7669 12.4508C11.9797 12.4752 12.1256 12.39 12.2411 12.2745C12.3566 12.159 12.4174 12.007 12.4174 11.8428V10.0189C12.4174 10.0128 12.4174 10.0067 12.4174 10.0006C12.4235 9.69054 12.1986 9.4291 11.8946 9.38654C11.2744 9.3075 10.6543 9.14943 10.0584 8.93055C9.83347 8.84543 9.58419 8.90015 9.41395 9.06431L8.6418 9.83646C8.44724 10.031 8.14932 10.0675 7.9122 9.93374C6.29494 9.01567 4.95735 7.672 4.03927 6.06081C3.9116 5.81153 3.94808 5.51361 4.14263 5.31906L4.91479 4.5469C5.07895 4.38274 5.13367 4.13347 5.04855 3.90851C4.82359 3.31267 4.67159 2.69252 4.58647 2.06628C4.54999 1.77444 4.28855 1.54949 3.99063 1.54949Z" fill="black"/>
                            </svg>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

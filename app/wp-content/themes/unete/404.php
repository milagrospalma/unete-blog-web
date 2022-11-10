<?php

get_header();

?>
    <style>
        .unete-blog-404 {
            padding: 50px 0;
            text-align: center;
            color: #4B4B4B;
            font-family: 'Mulish-Medium';
        }
        .unete-blog-404 h1 {
            font-size: 40px;
        }
        .unete-blog-404 h3 {
            font-size: 20px;
            padding: 20px 0;
        }
        .unete-blog-404 a {
            text-decoration: underline;
            color: #bc0075;
        }
    </style>
    <main class="unete-blog-404">
        <section class="article__content">
            <h1 class="title">Ooops... Error 404</h1>
            <h3>Lo sentimos la pagina que busca no existe</h3>
            <p>Por favor verifique la direccion introducida e inténtelo de nuevo o <a href="<?php echo get_site_url() ?>">ir al inicio</a></p>
        </section>
    </main>

<?php
get_footer();
?>
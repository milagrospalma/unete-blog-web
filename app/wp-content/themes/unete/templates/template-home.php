<?php
/* Template Name: Home */

get_header();
$articles = get_blog_most_recent();
$idPost = 0;
?>
<nav class="nav-blog">
    <?php
    if(!empty($articles) && !empty($articles['header']) ) {

        ?>
        <div class="nav-text border-bottom">
            <h1><?php echo $articles['header']['title']; ?></h1>
            <p><?php echo $articles['header']['sub_title']; ?></p>
        </div>
        <?php
    }
    ?>
    <div class="container">
        <div class="buttons-list">
            <?php the_get_blog_categories() ?>
        </div>
    </div>
</nav>
<main id="home">
    <?php
    if(!empty($articles) && !empty($articles['post_most_recent']) ) {
        $idPost = $articles['post_most_recent']['id'];
        ?>
        <section class="most-recent">
            <div class="container">
                <div class="title">Lo más <br class="hidden-md">reciente</div>
                <div class="content">
                    <a class="article" href="<?php echo $articles['post_most_recent']['link']; ?>">
                        <div class="cover"><?php echo $articles['post_most_recent']['image']; ?></div>
                        <div class="category-label" style="background-color: <?php echo $articles['post_most_recent']['category']->background; ?> !important;"><?php echo $articles['post_most_recent']['category']->title; ?></div>
                        <h3 class="name"><?php echo $articles['post_most_recent']['title']; ?></h3>
                        <p class="description"><?php echo $articles['post_most_recent']['description']; ?></p>
                        <div class="detail">
                            <span class="date"><?php echo $articles['post_most_recent']['date']; ?></span> - <span class="reading-time"><?php echo $articles['post_most_recent']['time']; ?></span> min de lectura
                        </div>
                        <div class="authorship"><?php if(!empty($articles['post_most_recent']['author'])){  ?>Por <span class="author"><?php echo $articles['post_most_recent']['author']; ?></span><?php } ?></div>
                    </a>
                    <?php the_add_partial_blog('membership', 'Home') ?>
                </div>
            </div>
        </section>
        <?php
    }

    if(!empty($articles) && !empty($articles['posts']) && !empty($articles['posts']['data']) ) {
    ?>
    <section class="discover-more">
        <div class="container">
            <div class="title">Descubre más</div>
            <div class="content">
                <?php
                    foreach ($articles['posts']['data'] as $article ){
                        ?>
                        <a class="article-card" href="<?php echo $article['link']; ?>">
                            <div class="cover">
                                <?php echo $article['image']; ?>
                            </div>
                            <div class="category-label" style="background-color: <?php echo $article['category']->background; ?> !important;"><?php echo $article['category']->title; ?></div>
                            <h3 class="name"><?php echo $article['title']; ?></h3>
                            <div class="detail">
                                <span class="date"><?php echo $article['date']; ?></span> - <span class="reading-time"><?php echo $article['time']; ?></span> min de lectura
                            </div>
                            <div class="authorship"><?php if(!empty($article['author'])){  ?>Por <span class="author"><?php echo $article['author']; ?></span><?php } ?></div>
                        </a>
                        <?php
                    }
                ?>
            </div>
            <?php
            if(!empty($articles['posts']['max_num_pages']) && (int) $articles['posts']['max_num_pages'] > 1 ) {
                ?>
                <div class="button">
                    <button class="btn-show white-button js-discover-more" data-paged="2" data-category="" data-idpost="<?php echo $idPost; ?>">Mostrar más</button>
                </div>
                <?php
            }?>
        </div>
    </section>
        <?php
    }
    ?>
</main>

<?php
get_footer();
?>

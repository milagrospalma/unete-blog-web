<?php
/* Template Name: Category */

get_header();
$basename = basename($_SERVER['REQUEST_URI']);
$category = get_blog_post_by_category($basename);
?>

<nav class="nav-blog">
    <div class="nav-text border-bottom">
        <?php
        if(!empty($category) && !empty($category['header'])) {
            ?>
            <h1><?php echo $category['header']['title'] ?></h1>
            <p><?php echo $category['header']['sub_title'] ?></p>
            <?php
        }
        ?>
    </div>
    <div class="container">
        <div class="buttons-list">
            <?php the_get_blog_categories($basename) ?>
        </div>
    </div>
</nav>

<main class="unete-blog-category" data-is-category="true">
    <?php
    if(!empty($category) && !empty($category['category'])){
        ?>
        <section class="intro">
            <div class="container">
                <div class="intro__title"><?php echo $category['category']['sub_title'] ?></div>
                <p class="intro__description border-bottom"><?php echo $category['category']['description'] ?></p>
            </div>
        </section>
        <?php
    }
    ?>
    <section class="most-important">
        <div class="container">
            <div class="content">
                <?php
                if(!empty($category) && !empty($category['articles'])){
                ?>
                <div class="articles">
                    <?php
                        foreach ($category['articles'] as $article ) {
                            ?>
                            <a class="article" href="<?php echo $article['link']; ?>">
                                <div class="cover">
                                    <?php echo $article['image']; ?>
                                </div>
                                <h3 class="name"><?php echo $article['title']; ?></h3>
                                <div class="detail">
                                    <span class="date"><?php echo $article['date']; ?></span> - <span class="reading-time"><?php echo $article['time']; ?></span> min de
                                    lectura
                                </div>
                                <div class="authorship"><?php if(!empty($article['author'])){  ?>Por <span class="author"><?php echo $article['author']; ?></span><?php } ?></div>
                            </a>
                            <?php
                        }
                    ?>
                </div>
                    <?php
                }
                ?>
                <?php the_add_partial_blog('membership', $category['category']['title']) ?>
            </div>
        </div>
    </section>
    <?php
    if(!empty($category) && !empty($category['discover_more'])){
        ?>
        <section class="discover-more">
            <div class="container">
                <div class="title">Descubre más</div>
                <div class="content">
                    <?php
                    foreach ($category['discover_more'] as $discover ) {
                    ?>
                    <a class="article article-card" href="<?php echo $discover['link']; ?>">
                        <div class="article__content">
                            <h3 class="name"><?php echo $discover['title']; ?></h3>
                            <div class="detail">
                                <span class="date"><?php echo $discover['date']; ?></span> - <span class="reading-time"><?php echo $discover['time']; ?></span> min de lectura
                            </div>
                            <div class="authorship"><?php if(!empty($discover['author'])){  ?>Por <span class="author"><?php echo $discover['author']; ?></span><?php } ?></div>
                        </div>
                        <div class="cover">
                            <?php echo $discover['thumbnail']; ?>
                        </div>
                    </a>
                        <?php
                    }
                    ?>
                </div>
                <?php
                if(!empty($category['configuration']) && $category['configuration']['max_num_pages'] > 1){
                ?>
                <div class="button">
                    <button class="btn-show white-button js-category-discover-more"
                            data-ispost="false"
                            data-paged="2"
                            data-filter="category"
                            data-name="<?php echo $category['configuration']['slug']; ?>"
                            data-category="<?php echo $category['configuration']['category_id']; ?>"
                            data-idposts="<?php echo $category['configuration']['id_posts']; ?>">Mostrar más</button>
                </div>
                    <?php
                }
                ?>
            </div>
        </section>
        <?php
    }
    ?>
</main>

<?php
get_footer();
?>

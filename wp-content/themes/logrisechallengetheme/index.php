<?php get_header(); ?>

<div class="container">
    <main class="content-area">
        <?php
        if (have_posts()):
            while (have_posts()):
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h1 class="entry-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h1>
                    </header>

                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>
                <?php
            endwhile;

            the_posts_pagination();
        else:
            echo '<p>Content not found.</p>';
        endif;
        ?>
    </main>
</div>

<?php get_footer(); ?>
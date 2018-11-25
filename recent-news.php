<?php /* Template Name: Recent News */ ?>
<?php get_header(); ?>

<?php
  $params = array( 
      "limit" => -1,
      'orderby' => 'date DESC',
      );
$newsPod = pods('recent_news', $params);
$title = get_field('title');
$image = get_field('banner');
?>
  <div class="small-banner" style="background: url('<?php echo $image['url'] ?>') center; background-size: cover;"></div>
    <!-- CONTENT -->
    <div class="container news">
      <h1><?php echo $title ?></h1>

      <?php while ($newsPod -> fetch()):?>
        <div class="article-teaser">
          <div class="col-xs-12 col-sm-3 teaser-image">
          <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $newsPod->field('ID') ), 'thumbnail' ); ?>
            <img src="<?php echo $image[0] ?>" alt="post thumb" width="100%">
          </div>
          <div class="col-xs-12 col-sm-9 teaser-content">
            <span class="news-date">Posted: <?php 
            $dat = date_create_from_format('Y-m-d H:s', $newsPod->display('post_date') );
            echo date_format($dat, 'F, j, Y');
             ?></span><br />
            <a href="<?php echo $newsPod->field('permalink'); ?>" class="news-link"><?php echo $newsPod->field('post_title'); ?></a>
            <p><?php echo $newsPod->field('post_excerpt'); ?></p>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

<?php get_footer(); ?>
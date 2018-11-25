<?php /* Template Name: News Single */ ?>
<?php get_header(); ?>

<?php
  $params = array( 
      "limit" => -1,
      );
$newsSlug = pods_v('last','url');
$newsPod = pods('recent_news', $newsSlug);
$bannerPod = pods('newsbanner','news-banner');
$bannerImg = $bannerPod->display('banner');
?>
  <div class="small-banner" style="background: url('<?php echo $bannerImg ?>') center; background-size: cover;"></div>
    <!-- CONTENT -->
    <div class="container news">
      <h1>Recent News & Updates</h1>
      <div class="full-article col-xs-12">
        <p class="news-date">Posted: <?php echo get_the_date(); ?></p>
        <h3><?php the_title(); ?></h3>
        <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' ); ?>
         <img src="<?php echo $image[0] ?>" alt="post 1" class="right-float">
        <?php echo $newsPod->display('post_content') ?>    
        </div>
      </div>
    </div>

<?php get_footer(); ?>
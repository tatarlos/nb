<?php /* Template Name: languages */ ?>
<?php get_header(); ?>

<?php
$title = get_field('title');
$image = get_field('banner');
?>
  <div class="small-banner" style="background: url('<?php echo $image['url'] ?>') center; background-size: cover;"></div>
    <!-- CONTENT -->
    <div class="container languages">
      <h1><?php echo $title ?></h1>
    <?php if( have_rows('content') ): ?>
      <?php while ( have_rows('content') ) : the_row(); ?>
        <?php  
          $image = get_sub_field('image');
          $file = get_sub_field('pdf');
         ?>
        <div class="col-xs-6 col-sm-4 product-range-teaser">
          <a href="<?php echo $file['url']; ?>" target="_blank">
            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
            <?php echo get_sub_field('title'); ?>
          </a>
        </div>
     <?php endwhile; // end while have rows ?>
    <?php endif; ?>    
    </div>

<?php get_footer(); ?>
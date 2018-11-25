<?php /* Template Name: testimonials Page */ ?>
<?php get_header(); ?>

<?php
  $params = array( 
      "limit" => -1,
      );
$image = get_field('banner');
$title = get_field('title');
?>
  <div class="small-banner" style="background: url('<?php echo $image['url'] ?>') center; background-size: cover;"></div>


    <!-- CONTENT -->
    <div class="container testimonials">

      <h1><?php echo $title  ?></h1>
      
      <div class="grid">
      <?php if(get_field('testimonials')): $testimonials = get_field('testimonials') ?>
        <?php foreach( $testimonials as $testimonial ): ?>
          <div class="testimonial-item">
          <div class="content">
           <?php echo $testimonial['testimonial'] ?>
          </div>  
          <div class="title">
            <?php echo $testimonial['person'] ?>
          </div>
        </div>
        <?php endforeach; ?>
      <?php endif; ?>
      </div>
      <div class="hidden-xs col-sm-2">
         <?php if(get_field('side_images')): $images = get_field('side_images') ?>
              <?php foreach( $images as $image ): ?>
                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
              <?php endforeach; ?>
          <?php endif; ?>
      </div>
    </div>

<?php get_footer(); ?>
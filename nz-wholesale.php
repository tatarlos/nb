<?php /* Template Name: NZ wholesalers Page */ ?>
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
    <div class="container distributors">

      <h1><?php echo $title  ?></h1>
      <div class="col-xs-12 distributor-info">
        <?php echo get_field('content'); ?>
      </div>
      <h2>Make an Enquiry</h2>
      <div class="col-xs-12 contact-form">
      <?php echo do_shortcode('[contact-form-7 id="4" title="Contact form 1"]') ?>
      </div>
    </div>
<?php get_footer(); ?>
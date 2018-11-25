<?php /* Template Name: terms and conidtions Page */ ?>
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
    <div class="container terms-n-conditions">

      <h1><?php echo $title  ?></h1>
      <div class="col-xs-12 conditions-info">
        <?php echo get_field('content'); ?>
      </div>
    </div>
<?php get_footer(); ?>
<?php /* Template Name: about */ ?>
<?php get_header(); ?>

<?php
  $params = array( 
      "limit" => -1,
      );
$image = get_field('banner');
$title = get_field('title');
$content = get_field('content');
?>
  <div class="small-banner" style="background: url('<?php echo $image['url'] ?>') center; background-size: cover;"></div>
<div class="container about">

      <h1><?php echo $title ?></h1>

      <div class="col-xs-12 story">
        <div class="col-xs-12 col-md-9">
        <?php echo $content ?>
        </div>

        <div class="col-xs-12 col-md-3">
          <div class="right-col-content">
           <?php $featured_image = get_field('featured_image'); ?>
           <img src="<?php echo $featured_image[
           'url'] ?>" alt="<?php echo $featured_image[
           'alt'] ?>">
           <figcaption><?php echo $featured_image['caption'] ?></figcaption>
          </div>

          <div class="logos-box">
	         <?php if(get_field('side_images')): $images = get_field('side_images') ?>
            <?php foreach( $images as $image ): ?>
              <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
            <?php endforeach; ?> 
           <?php endif; ?>  
          </div>

        </div>
      </div>


      <!-- HISTORY -->
			
      <h2>Our History</h2>
      <div class="col-xs-12 history">
      
      <?php if(get_field('history')): $historyRows = get_field('history') ?>
	      <?php foreach( $historyRows as $history ): ?>
	        <div class="table-row">
	          <div class="date"><?php echo $history['date'] ?></div>
	          <div class="history-content"><?php echo $history['description'] ?></div>
	        </div>
				<?php endforeach; ?>
			<?php endif; ?>
      </div>
    </div>
<?php get_footer(); ?>
<?php /* Template Name: Contact Page */ ?>
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
    <div class="container contact">

      <h1><?php echo $title  ?></h1>
      <div class="col-xs-12 col-md-6 contact-info">
       <?php if(get_field('contact_details')): $details = get_field('contact_details') ?>
        <?php foreach( $details as $detail ): ?>
           <div class="table-row">
            <div class="contact-title">
             <?php echo $detail['title'] ?>
            </div>  
            <div class="contact-content">
              <?php echo $detail['content'] ?>
            </div>
          </div>
          <?php endforeach; ?>
        <?php endif; ?>
      
      </div>

      <div class="col-xs-12 col-md-6">
        <?php echo get_field('google_map') ?>
      </div>
      <!-- EMAIL CONTACT FORM -->
      <h2>Email Us</h2>

      <div class="col-xs-12 contact-form">
         <?php echo do_shortcode('[contact-form-7 id="4" title="Contact form 1"]') ?>
      </div>
      </div>

    </div>
<?php get_footer(); ?>
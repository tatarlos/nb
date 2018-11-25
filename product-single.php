<?php /* Template Name: Product single*/ ?>
<?php 
  $params = array( 
      "limit" => -1,
      );
	$productSlug = pods_v('last','url');
	$productPod = pods('product',$productSlug);
	$productTitle = $productPod -> field('title');

	$range = get_the_terms(get_the_ID(), 'productrange');
	$range = $range[0];
	$rangePod = pods('productrange',$range->slug);
	$bannerImg = $rangePod->display('banner_image');
?>
<?php get_header() ?>
 <!-- PRODUCT BANNER -->
	<div class="small-banner" style="background: url('<?php echo $bannerImg ?>') center; background-size: cover;"></div>

  <!-- BREADCRUMBS -->
  <div class="container breadcrumbs">
    <a href="<?php echo bloginfo('url') ?>/products/<?php echo $range->slug?>"><?php echo $range->name ?></a> > <?php echo $productTitle ?>
  </div>

  <!-- CONTENT -->
  <div class="container product-full-content">
    <!-- LEFT CONTENT -->
    <div class="col-xs-12 col-md-6 product-image">
      <img src="<?php echo $productPod->display('product_image') ?>">
    </div>

    <!-- RIGHT CONTENT -->
    <div class="col-xs-12 col-md-6">
      <h1><?php echo $productTitle ?></h1>

      <div class="highlight-info">
        <div class="feature-ingredients">
           <?php echo $productPod ->field('key_ingredient') ?>
        </div>
        <div class="volume">
          <?php echo $productPod ->field('volume') ?>
        </div>
      </div>

      <div class="description">
        <?php echo $productPod->display('post_content') ?>
      </div>
      <p><em>Product code: <?php echo $productPod->display('product_code') ?></em></p>
      <!-- INFORMATION TABS CONTENT -->
      <ul class="product-tabs">
        <li class="active"><a href="#how-to-use">How To Use</a></li>
        <li><a href="#key-ingredients">Key Ingredients</a></li>
        <li><a href="#ingredients">All Ingredients</a></li>
      </ul>
         
      <div class="tabs-content-area">
        <div id="how-to-use" class="tab-content">
					<?php echo $productPod->display('how_to_use') ?>
        </div>
       
        <div id="key-ingredients" class="tab-content">
					<?php echo $productPod->display('key_ingredients') ?>
        </div>    

        <div id="ingredients" class="tab-content">
					<?php echo $productPod->display('all_ingredients') ?>
        </div>    
      </div>
    </div>
    <div class="col-xs-12">
       <?php comments_template() ?>
    </div>
  </div>
  <i class="far fa-star"></i>
<?php get_footer() ?>
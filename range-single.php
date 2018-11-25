<?php /* Template Name: range single */ ?>
<?php get_header(); ?>
<?php 
  $params = array( 
      "limit" => -1,
      );
	$range = pods_v('last','url');
	$rangePod = pods('productrange',$range);
	$bannerImg = $rangePod->display('banner_image');


  $params = array( 
    "limit" => -1,
    "where" =>"productrange.slug = '$range'",
    'orderby' => 'order DESC',
    );
	$productPod = pods('product',$params);
?>
<div class="small-banner" style="background: url('<?php echo $bannerImg ?>') center; background-size: cover;"></div>
<!-- CONTENT -->
<div class="container">

  <h1><?php echo $rangePod->display('name') ?></h1>

  <div class="col-xs-12 col-sm-10">
    <?php echo $rangePod -> display('description') ?>
  </div>

  <div class="col-xs-12 col-sm-2">
    <p style="text-align: center;">
      <img src="<?php echo $rangePod -> display('logo') ?>">
    </p>
  </div>
</div>

<!-- PRODUCTS -->
<div class="container products-list">
  <!-- individual product -->
  <?php while($productPod -> fetch()) :?>
  <div class="col-ts col-sm-6 col-md-4">
    <a href="<?php echo $productPod ->field('permalink')?>">
      <div class="product-teaser">
        <div class="product-hover bv-colour">
          <div class="flex">
            <div class="content">
              <h3><?php echo $productPod->display('pt_title') ?></h3>
              <p class="product-btn">View More</p>
            </div>
          </div>
        </div>
        <img src="<?php echo $productPod ->display('product_teaser')  ?>" alt="<?php echo $productPod->field('post_title')?>">

        <h3><?php echo $productPod -> display('pt_title') ?></h3>
        <p><?php echo $productPod->field('pt_description')?></p> 
      </div>
    </a>
  </div>
	<?php endwhile; ?>

</div>
<?php get_footer(); ?>
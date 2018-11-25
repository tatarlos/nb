<?php /* Template Name: homepage */

$banner = get_field('banner');

 ?>
<?php get_header(); ?>
<?php if( have_rows('banner') ): ?>
  <div class="slider-container">
  <?php $first = true; ?>
  <?php while ( have_rows('banner') ) : the_row(); ?>
    <?php $BGimage = get_sub_field('background_image') ?>
    <?php $pageLink = get_sub_field('page_link');?>
    <?php if($pageLink): ?><a href="<?php echo $pageLink ?>"><?php endif; ?><div class="sliding-banner" style="background: url('<?php echo $BGimage['url'] ?>'); background-size: cover; background-repeat: no-repeat; background-position: center; <?php if($first){echo('display:show;');}else{echo('display:none;');}?>">
      <div class="container">
        <div class="caption">
         <div class="product-image">
            <?php $bannerProduct = get_sub_field('product_image') ?>
            <?php if($bannerProduct): ?>        
              <img src="<?php echo $bannerProduct['url'] ?>">
            <?php endif; ?>
          </div>
          <?php echo get_sub_field('banner_text') ?>
        </div>
      </div>
    </div><?php if($pageLink): ?></a><?php endif; ?>
    <?php $first = false; ?>
  <?php endwhile; ?>
</div>
<?php endif; ?>
  

<?php if( have_rows('content') ): ?>
  <div class="container">
    <?php while ( have_rows('content') ) : the_row(); ?>
     
      <?php if(get_row_layout() == 'about'): ?>
        <h1><?php echo get_sub_field('title') ?></h1>

      <div class="col-xs-12 col-md-7">
        <?php echo get_sub_field('description') ?>
      </div>
      <div class="col-xs-12 col-md-5">
        <div class="logos-box">
          <p><strong><?php echo get_sub_field('range_title') ?></strong></p>
          <?php
          $params = array( "limit"=> -1);
          $ranges = pods('productrange',$params); 
          while($ranges -> fetch()):
          ?>
          <a href="<?php bloginfo('url');?>/products/<?php echo $ranges->display('slug');?>"><img src="<?php echo $ranges->display('range_icon');?>"  onmouseover="this.src='<?php echo $ranges->display('range_icon_hover');?>'" onmouseout="this.src='<?php echo $ranges->display('range_icon');?>'" alt="<?php echo $ranges->display('title');?>" title="<?php echo $ranges->display('title');?>"/></a>
          <?php endwhile; ?>
        </div>
      </div>
    </div>    
    <?php elseif(get_row_layout() == 'discover_more'): ?>

    <!-- DISCOVER MORE SECTION -->
    <div class="discover-more">
      <div class="container">
        <h2><?php echo get_sub_field('title') ?></h2>
        <?php 
        $ids = get_sub_field('pages');

        foreach($ids as $id):
          $page = get_post($id);
          $image  = wp_get_attachment_image_src(get_post_thumbnail_id( $id ),'full'); 
          $pagelink = $page ->guid;
        ?>
         <a href="<?php echo $pagelink ?>">
            <div class="col col-xs-4">
              <div class="button">
                <img src="<?php echo $image[0] ?>" alt="In The Media icon">
                <?php echo $page ->post_title; ?>
              </div>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>

    <?php elseif(get_row_layout() == 'featured_products'): ?>
    <!-- FEATURED PRODUCTS -->
    <div class="featured-products">
      <div class="container">

        <h2><?php echo get_sub_field('title') ?></h2>
        <?php $products  = get_sub_field('products') ?>
        <?php foreach($products as $product ): ?>
          <?php $image = $product->product_teaser ?>
        <div class="col-ts col-sm-6 col-md-4">
          <a href="<?php echo get_post_permalink($product->ID) ?>">
            <div class="product-teaser">
              <div class="product-hover bv-colour">
                <div class="flex">
                  <div class="content">
                    <h3><?php echo $product->pt_title ?></h3>
                    <p class="product-btn">View More</p>
                  </div>
                </div>
              </div>
              <img src="<?php echo  $image['guid'] ?>" alt="<?php echo $product->post_title?>">
              <h3><?php echo $product->pt_title ?></h3>
              <p><?php echo $product->pt_description ?></p>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
      </div>
    </div>
    
    <?php endif;  // end if row is 'x' ?>

    <?php endwhile; // end while have rows ?>
  <?php else : ?>

  <h1>The Page Your Looking For Is Missing</h1>

  <?php endif;  // end if have rows ?>

<?php get_footer(); ?>
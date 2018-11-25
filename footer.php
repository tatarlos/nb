<?php 
$params = array( 
    "limit" => -1,
);
$terms = pods('productrange',$params);

$arg = array( 
    "parent" => 0,
);
$pages = get_pages($arg);
$languages = array();

foreach ( $pages as $page ){
  $title =  $page->post_title;
  if(  $title =="Languages"){
    $languages = get_pages( array( 'child_of' => $page->ID));
  }
}
?>
    <!-- FOOTER -->
    <footer>
      <div class="container">
        <div class="hidden-xs hidden-sm col-md-4">
          <h3>Product Ranges</h3>
          <ul class="product-ranges">
          <?php while($terms ->fetch()):?>
            <li><a href="<?php echo bloginfo('url') ?>/products/<?php echo $terms->field('slug') ?>"><?php echo $terms->field('name') ?></a></li>
          <?php endwhile; ?>
          </ul>

          <div class="language-flags">
            <?php foreach($languages as $language): ?>
              <a href="<?php echo get_page_link( $language->ID ) ?>"><?php  $flag = get_field('flag_icon', $language->ID);?><img src="<?php echo $flag['url'] ?>" alt=""></a>
              <?php endforeach; ?>
          </div>
        </div>

        <div class="hidden-xs hidden-sm col-md-3 col-md-offset-1">
          <h3>Information</h3>
          <ul>
            <li><a href="<?php echo bloginfo('url') ?>/about">About Us</a></li>
            <li><a href="<?php echo bloginfo('url') ?>/ingredients">Ingredients</a></li>
            <li><a href="<?php echo bloginfo('url') ?>/news/media">In The Media</a></li>
            <li><a href="<?php echo bloginfo('url') ?>/distributors/nz-wholesale">Distributor Information</a></li>
            <li><a href="<?php echo bloginfo('url') ?>/terms-conditions">Terms & Conditions</a></li>
          </ul>
        </div>

        <div class="contact col-md-3 col-md-offset-1">
          <h3>Contact</h3>
          <?php  if( have_rows('contact_info' ,'options') ): ?>
            <?php while ( have_rows('contact_info' ,'options') ) : the_row(); ?>
            <ul>
              <li><img src="<?php the_sub_field('phone_icon');?>"> <?php the_sub_field('phone');?></li>
              <li><img src="<?php the_sub_field('fax_icon');?>"> <?php the_sub_field('fax');?></li>
              <li><img src="<?php the_sub_field('address_icon');?>"><?php the_sub_field('address');?></li>
              <li><img src="<?php the_sub_field('email_icon');?>"> <?php the_sub_field('email');?></li>
            </ul>
            <?php endwhile;
            endif; ?>
           
            <div class='language-flags-mobile'>
             <h3></h3>
            <?php foreach($languages as $language): ?>
              <a href="<?php echo get_page_link( $language->ID ) ?>"><?php $flag = get_field('flag_icon', $language->ID);?><img src="<?php echo $flag['url'] ?>" alt=""></a>
            <?php endforeach; ?>
            </div>
        </div>
      </div>
    </footer>


    <div class="container copyright">
      Copyright © <?php echo date('Y') ?> <?php the_field('copyright_text', 'option'); ?> <a href="http://eeilaine.com/" target="_blank"><img src="<?php bloginfo('template_url') ?>/img/eln-logo.png" class="designer-logo" alt="eeilaine.com"></a>
    </div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php bloginfo('template_url') ?>/js/vendor/bootstrap.min.js"></script>
    <script src="<?php bloginfo('template_url') ?>/js/vendor/plugins.js"></script>
    <script src="<?php bloginfo('template_url') ?>/js/main.js"></script>
  </body>
</html>
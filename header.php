<?php
include 'Mobile_Detect.php';
$detect = new Mobile_Detect();
global $isMob;
global $isTab;
//if is mobile and NOT tablet
if ($detect->isMobile() && !$detect->isTablet()) {
    $isMob = true;
}
// if is tablet
if ($detect->isTablet()) {
    $isTab = true;
}
$params = array( 
    "limit" => -1,
);
$socialPod = pods('socialmedia', $params);
//menu generation
$arg = array( 
    "parent" => 0,
    'sort_column'  => 'menu_order',
);
$languages = array();
$pages = get_pages($arg);
$menuItems = array();
foreach ( $pages as $page ){
  $detail = array();
  $title =  $page->post_title;

  if( $title == "Home"  || $title =="Terms & Conditions"){

  }else if($title =="Languages"){
    $languages =  get_pages( array( 'child_of' => $page->ID));
  }else{
    $detail['title'] = $title;
    $detail['link'] = get_page_link( $page->ID );
    $mypages = get_pages( array( 'child_of' => $page->ID, 'sort_column'  => 'menu_order' ));
    if($mypages){
      $children = array();
      foreach( $mypages as $page ) {  
        $child['link'] = get_page_link( $page->ID );  
        $child['title'] = $page->post_title;
        $children[] = $child;
      }
      $detail['children'] = $children;
    }
    $menuItems[] = $detail;
  }
}
$terms = pods('productrange',$params);
?>
<!doctype html>
<html lang="en">
    <head>
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Favicon -->
        <?php
        if (get_field("favicon", 'options')) {
            $imageID = get_field('favicon', 'options');
            $image = wp_get_attachment_image_src($imageID, 'full');
            ?>
            <link rel="shortcut icon" href="<?php echo $image[0] ?>">
        <?php } ?>
        <title> <?php wp_title('|', 'true', 'right'); ?> <?php bloginfo('name'); ?></title>
        <!-- <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'> -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">


        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link href="<?php bloginfo('template_url') ?>/css/normalize.css" rel="stylesheet">
        <link href="<?php bloginfo('template_url') ?>/css/bootstrap/bootstrap.min.css" rel="stylesheet">
        <link href="<?php bloginfo('template_url') ?>/css/styles.css" rel="stylesheet">
    </head>
<body>
  <header>
    <div class="contained clearfix">
      <div class="logo">
        <?php 
          if(get_field("logo", 'options')){ 
              $imageID = get_field('logo', 'options');
              $image = wp_get_attachment_image_src( $imageID, 'large' );
              $attachment = get_post( $imageID );
              $image_title = $attachment->post_title;
            ?>
              <a href="<?php echo get_option('home') ?>"><img src="<?php echo $image[0] ?>" alt="<?php echo $image_title; ?>" border="0"></a>
            <?php } else if(is_front_page()) {?>  
              <h1><a href="<?php echo get_option('home') ?>"><?php echo get_bloginfo('name'); ?></a></h1>
            <?php } else { ?>
              <h2><a href="<?php echo get_option('home') ?>"><?php echo get_bloginfo('name'); ?></a></h2>   
            <?php } ?></a>
      </div>
        <!--   MOBILE NAV -->
      <div class="mobile-nav">
        <div class="mobile-menu">
          <div class="close-btn">
            <i class='fa fa-close'></i>
          </div>

          <ul class="tabbed-menu">
            <li class="mobile-links"><a href="<?php echo get_bloginfo('url') ?>">Home </a></li>
            <?php for ($i = 0; $i < count($menuItems); $i++ ):
              $title = $menuItems[$i]['title'];
              $link = $menuItems[$i]['link'];
              $hasChild = empty($menuItems[$i]['children']);
            ?>
            <?php if($title === "Products"): ?>
              <li class="mobile-links"><a href="javascript:void(0)">Products <i class='fa fa-sort-desc'></i></a>
                <ul class="sub-menu products-menu">
                  <?php while($terms -> fetch()) :?>
                  <li class="product-group">
                    <a href="<?php bloginfo('url');?>/products/<?php echo $terms->display('slug');?>">
                    <?php echo $terms->display('name');  ?>
                    </a>
                  </li>
                <?php endwhile; ?>
                </ul>
              </li>
            <?php else: ?>
             <li class="mobile-links"><a href="<?php echo ($hasChild) ? $link : 'javascript:void(0)' ?>"> <?php echo $title?> <?php if(!$hasChild){ echo "<i class='fa fa-sort-desc'></i>";} ?>
                </a>
                <?php if(!$hasChild): 
                  $child = $menuItems[$i]['children'];
                ?>
                  <ul class="sub-menu">
                    <?php foreach ($child as $submenu ): ?>
                       <li><a href="<?php echo $submenu['link'] ?>"><?php echo $submenu['title']; ?></a></li>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>
            <?php endif; ?>
            <?php endfor; ?>
            <?php $terms->reset(); ?>
          </ul>

        </div>
        <div class="menu-btn">
          <i class="fa fa-bars fa-x2"></i>
          <span class ="menu-text">menu</span>
        </div>
      </div>
      <div class="header-content">
        <ul class="social-media">
          <li class ="selection">
            <select class="language">
              <option>[select language]</option>
              <?php foreach($languages as $language): ?>
                <?php  $flag = get_field('flag_icon', $language->ID);?>
                <option value="<?php echo get_page_link( $language->ID ) ?>"><?php echo $language->post_title; ?></option>
              <?php endforeach; ?>
            </select>
          </li>
        </ul>
        <!-- NAVIGATION -->
        <nav>         
          <ul class="menu">
            <?php for ($i = 0; $i < count($menuItems); $i++ ):
              $title = $menuItems[$i]['title'];
              $link = $menuItems[$i]['link'];
              $hasChild = empty($menuItems[$i]['children']);
            ?>
            <?php if($title === "Products"): ?>
              <li class="dropdown"><a href="javascript:void(0)" style="cursor:default;">Products</a>
                <ul class="sub-menu products-menu">
                  <?php while($terms -> fetch()) :?>
                  <li class="product-group">
                    <a href="<?php bloginfo('url');?>/products/<?php echo $terms->display('slug');?>">
                      <img src="<?php echo $terms->display('nav-img');?>" alt="product Aloe Vera">
                      <?php echo $terms->display('name');  ?>
                    </a>
                  </li>
                <?php endwhile; ?>
                </ul>
              </li>
            <?php else: ?>
             <li class="<?php echo ($hasChild) ? '' : 'dropdown' ?>"><a href="<?php echo ($hasChild) ? $link : 'javascript:void(0)' ?>" style ="<?php echo ($hasChild) ? '' : 'cursor:default;' ?>"><?php echo $title?></a>
                <?php if(!$hasChild): 
                  $child = $menuItems[$i]['children'];
                ?>
                  <ul class="sub-menu">
                    <?php foreach ($child as $submenu ): ?>
                       <li><a href="<?php echo $submenu['link'] ?>"><?php echo $submenu['title']; ?></a></li>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>
            <?php endif; ?>
            <?php endfor; ?>
          </ul>
        </nav>
      </div>
    </div>
  </header>



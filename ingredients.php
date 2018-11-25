<?php /* Template Name: Ingredients Page */ ?>
<?php get_header(); ?>

<?php
  $params = array( 
      "limit" => -1,
      );
$image = get_field('banner');
$ingredientsPod = pods('ingredient',$params);
$title = get_field('title');
?>
  <div class="small-banner" style="background: url('<?php echo $image['url'] ?>') center; background-size: cover;"></div>


    <!-- CONTENT -->
    <div class="container">

      <h1><?php echo $title  ?></h1>

      <div class="col-xs-12 col-md-10">
       <p>
          <a href="javascript:void(0)" class="sort" data-tag="AB">A-B</a> . 
          <a href="javascript:void(0)" class="sort" data-tag="CD">C-D</a> .  
          <a href="javascript:void(0)" class="sort" data-tag="EFGH">E-H</a> . 
          <a href="javascript:void(0)" class="sort" data-tag="IJKLM">I-M</a> . 
          <a href="javascript:void(0)" class="sort" data-tag="NOP">N-P</a> . 
          <a href="javascript:void(0)" class="sort" data-tag="RS">R-S</a> . 
          <a href="javascript:void(0)" class="sort" data-tag="TUVW">T-W</a> 
        </p>

        <div class="ingredients-container">
          <?php while($ingredientsPod -> fetch()) :
            $list = $ingredientsPod->field('contained_in');
            $header = $ingredientsPod->field('title');
            $letter = $header[0];
          ?>
          <!-- single ingredient  -->
          <div class="ingredient" data-tag="<?php echo($letter) ?>" style ="<?php if($letter === 'A' || $letter === 'B'){
            echo ('display:show;');
            }else{
              echo('display:none;');
              } ?>">
            <div class="title">
              <?php echo $header ?>
            </div>
            <div class="content">
              <div class="hidden-xs col-sm-2">
                  <img src="<?php echo $ingredientsPod->display('ingredient_image') ?>" alt="absorption base" class="img-fill">
                </div>
                <div class="col-xs-12 col-sm-10">
                  <?php echo $ingredientsPod->display('post_content')?>
                  
                  <?php if($list): ?>
                    <?php $length = sizeof($list); $i = 1;  ?>
                    <p><small>Found in: 
                      <?php foreach ( $list as $product ): ?>
                      <a href="<?php echo $product['guid']?>">
                      <?php echo $product['post_title']?>
                      </a><?php $comma = ($i < $length)? ",": ""; echo $comma ?>
                      <?php $i++; endforeach; ?> 
                    </small></p>
                  <?php endif; ?>
                </div>
            </div>
          </div>
          <?php endwhile; ?>        
        </div>
      </div>

      <div class="hidden-xs hidden-sm col-md-2">
         <?php if(get_field('side_images')): $images = get_field('side_images') ?>
              <?php foreach( $images as $image ): ?>
                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
              <?php endforeach; ?>

          <?php endif; ?>
      </div>
    </div>

<?php get_footer(); ?>
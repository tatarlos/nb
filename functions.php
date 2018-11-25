<?php
//----------------------------------------------------------------------------------------------------
//-----------------------  IMAGES SIZES  -------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
add_theme_support( 'post-thumbnails' );
// add_image_size( 'slide-img', 440, 330, false ); // Home page
add_image_size( "news-thumb", 220, 220, false );

function get_sharinglinks(){
  include('snippet-sharinglinks.php');
}

//----------------------------------------------------------------------------------------------------
//-----------------------  EDITABLE MENU  ------------------------------------------------------------
//----------------------------------------------------------------------------------------------------

function register_my_menu() {
  register_nav_menu('header-menu',__( 'Header Menu' ));
}
add_action( 'init', 'register_my_menu' );

//----------------------------------------------------------------------------------------------------
//------------------------------   SHORTCODES  -------------------------------------------------------
//----------------------------------------------------------------------------------------------------


//forces autop function to run after shortcodes have rendered
//remove_filter( 'the_content', 'wpautop' );
//add_filter( 'the_content', 'wpautop' , 12);

// create [latest-post nb=?]
add_shortcode("latest-post", 'render_the_latest_posts');
    
function render_the_latest_posts($atts) {
    $nb_post = intval($atts["nb"]);
    $query = array('post_type' => 'post', 'orderby' => 'date', 'posts_per_page' => $nb_post);
    $latest_posts = new WP_Query($query);
    if ($latest_posts):
        $links = "<h5>$nb_post latest ". get_the_title(12)."</h5><ul>";
        while ($latest_posts->have_posts()) :
            $latest_posts->the_post();
            $post_title = get_the_title();
            $post_permalink = get_permalink();
            $links .= "<li><a href='$post_permalink' title='Go to $post_title'>$post_title</a></li>";
        endwhile;
        $links .= "</ul>";
    endif;
    wp_reset_postdata();
    return $links;
}

// insert a font-awesome icon
// format to be put in WYSIWYG editor, where class is the icon class name you want to use => [icon class="icon-double-angle-up"]
function icon_func( $atts, $content = null ) {
  extract( shortcode_atts( array(
      'class' => 'icon',
      ), $atts ) );
  return '<i class="' . esc_attr($class) . '"></i>&nbsp;';
}
add_shortcode( 'icon', 'icon_func' );

// create a button.
// format to be put in WYSIWYG editor, where class is the icon class name you want to use => [icon class="icon-double-angle-up"]
function button( $atts, $content = null ) {
  extract( shortcode_atts( array(
      'class' => 'button',
      ), $atts ) );
  $content = new SimpleXMLElement($content);
  
  return '<a class="button '.esc_attr($class).'" href="'.$content['href'].'">'.$content.'     </a>';
}
add_shortcode("button", "button");  


//----------------------------------------------------------------------------------------------------
//------------------------   FACEBOOK OG TAGS  -------------------------------------------------------
//----------------------------------------------------------------------------------------------------

// see tutorial at http://www.paulund.co.uk/add-facebook-open-graph-tags-to-wordpress

// Facebook Open Graph
add_action('wp_head', 'add_fb_open_graph_tags');

function add_fb_open_graph_tags() {
  if (is_single()) {

    global $post;

    // select an image for the thumbnail
    if(get_the_post_thumbnail($post->ID, 'thumbnail')) {
      $thumbnail_id = get_post_thumbnail_id($post->ID);
      $thumbnail_object = get_post($thumbnail_id);
      $image = $thumbnail_object->guid;
    } else {  
      $image = ''; // Change this to the URL of the logo you want beside your links shown on Facebook
    }

    //$description = get_bloginfo('description');
    $description = my_excerpt( $post->post_content, $post->post_excerpt );
    $description = strip_tags($description);
    $description = str_replace("\"", "'", $description);
?>

  <meta property="og:title" content="<?php the_title(); ?>" />
  <meta property="og:type" content="article" />
  <meta property="og:image" content="<?php echo $image; ?>" />
  <meta property="og:url" content="<?php the_permalink(); ?>" />
  <meta property="og:description" content="<?php echo $description ?>" />
  <meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>" />

<?php 
}

} // end add_fb_open_graph_tags();

function my_excerpt($text, $excerpt){
  
    if ($excerpt) return $excerpt;

    $text = strip_shortcodes( $text );

    $text = apply_filters('the_content', $text);
    $text = str_replace(']]>', ']]&gt;', $text);
    $text = strip_tags($text);
    $excerpt_length = apply_filters('excerpt_length', 55);
    $excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
    $words = preg_split("/[\n
   ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
    if ( count($words) > $excerpt_length ) {
            array_pop($words);
            $text = implode(' ', $words);
            $text = $text . $excerpt_more;
    } else {
            $text = implode(' ', $words);
    }

    return apply_filters('wp_trim_excerpt', $text, $excerpt);

}

//----------------------------------------------------------------------------------------------------
//------------------------   HANDY SNIPPETS  ---------------------------------------------------------
//----------------------------------------------------------------------------------------------------

// ========= remove unnecessary menus =================
// ref: http://www.sitepoint.com/how-to-hide-menus-in-wordpress/
function remove_admin_menus () {
  global $menu;
  // all users
  $restrict = explode(',', 'Links,Comments');
  // non-administrator users
  $restrict_user = explode(',', 'Contact,Tools');
  // WP localization
  $f = create_function('$v,$i', 'return __($v);');
  array_walk($restrict, $f);
  if (!current_user_can('activate_plugins')) {
    array_walk($restrict_user, $f);
    $restrict = array_merge($restrict, $restrict_user);
  }
  // remove menus
  end($menu);
  while (prev($menu)) {
    $k = key($menu);
    $v = explode(' ', $menu[$k][0]);
    if(in_array(is_null($v[0]) ? '' : $v[0] , $restrict)) unset($menu[$k]);
  }
}
add_action('admin_menu', 'remove_admin_menus');

//-------------------------------------------------------------------------------------------------------------------------- 
//---------------------------------------------------------------------------------------------------------------------------
// -----------------------    AUTO IMAGE NAME TAGGER   ---------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------
// by william hamlin and chris grimshaw-jones, modified by toivo james
// natively keeps file name in end title.
// uncomment POST NAME block to use post name instead of file name.

function wpsx_5505_modify_uploaded_file_names($arr) {
  $keywords = get_field('key_word_strings','option');
  if($keywords){

    $keyCount = 0;
    foreach($keywords as $keyword){
      $keyCount++;
    } 

    if( isset($_REQUEST['post_id']) ) {
      $post_id = $_REQUEST['post_id'];
    } else {
      $post_id = false;
    }
    $post_obj = get_post($post_id); 
    $post_slug = $post_obj->post_name;
    $path_parts = pathinfo($arr['name']);
    $original_title = $path_parts['filename'];
    $extension = $path_parts['extension'];

    $r = rand(0,$keyCount-1);
    
    $keywordsArray = array();  

    // USES FILE NAME
    foreach($keywords as $keyword){
      $newKey = str_replace(" ", "-", $original_title).'-'.$keyword['key_word_string'].'-0.'.$extension;
      array_push($keywordsArray, $newKey);
    }

    $arr['name'] = $keywordsArray[$r];

    return $arr;

  } else {
    return $arr;
  }//endif keywords exist
}

add_filter('wp_handle_upload_prefilter', 'wpsx_5505_modify_uploaded_file_names', 1, 1);




//--------------------------------------------------------------------------------------------------------------------------- 
//---------------------------------------------------------------------------------------------------------------------------
//------------------------    ADVANCED CUSTOM FIELDS STUFF   ------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
/*
 *  Advanced Custom Fields // Register Options Pages
 * 
 */

if(function_exists("register_options_page"))
{
    register_options_page('General');
    register_options_page('Footer');
 }
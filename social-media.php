<?php 
$params = array( 
    "limit" => -1,
);

$socialPod = pods('socialmedia', $params);
while ($socialPod->fetch()): 

if ($navPosition ==='header') {
	$img = $socialPod->display('img');
}elseif($navPosition ==='footer'){
	$img = $socialPod->display('img_footer');
}
$hover = $socialPod->display('img-hover');

?>
  <li>
    <a href="<?php echo $socialPod->display('link') ?>" target ="_blank">
      <img src="<?php echo $img ?>" onmouseover="this.src='<?php echo $hover?>'" onmouseout="this.src='<?php echo $img ?>'">
    </a>
  </li>
<?php endwhile;
 ?>


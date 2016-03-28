<?php 
	$im = imagecreate(50,20);

	$black = ImageColorAllocate($im, 0, 0 ,0); 
	$white = ImageColorAllocate($im, 255, 255, 255); 
	$gray = ImageColorAllocate($im, 200, 200, 200); 

	imagefill($im, 68, 30, $gray); 

	$li = ImageColorAllocate($im, 220,220,220);
	// 随机生成线
	for($i=0; $i<1; $i++) {
		imageline($im, rand(0,30), rand(0,21), rand(20,40), rand(0,21), $li); 
	} 

	imagestring($im, 5, 8, 2, $imgStr, $white);
	// 随机生成点
	for($i=0; $i<90; $i++) {
		imagesetpixel($im, rand()%70 , rand()%30 , $gray); 
	} 
	Header("Content-type:image/png");
	ImagePNG($im); 
	ImageDestroy($im);
?>
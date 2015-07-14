<?php

    /////////////////////////////////////////////////////////////////////
    // This is the only portion of the code you may need to change.
    // Indicate the location of your images 
    $root = '';
    // use if specifying path from root
    // $root = $_SERVER['DOCUMENT_ROOT'];

    $path = 'images/avil_banner_imgs/';

    // End of user modified section 
    /////////////////////////////////////////////////////////////////////

    function getImagesFromDir($path) {
        $images = array();
        if ( $img_dir = @opendir($path) ) {
            while ( false !== ($img_file = readdir($img_dir)) ) {
                // checks for gif, jpg, png
                if ( preg_match("/(\.gif|\.jpg|\.png)$/", $img_file) ) {
                    $images[] = $img_file;
                }
            }
            closedir($img_dir);
        }
        return $images;
    }

    function getRandomFromArray($ar) {
        mt_srand( (double)microtime() * 1000000 ); // php 4.2+ not needed
        $num = array_rand($ar);
        return $ar[$num];
    }

    // Obtain list of images from directory 
    $imgList = getImagesFromDir($root . $path);

    $img = getRandomFromArray($imgList);
  ?>
  <div id="pop-up">
    <span id="img-container">
      <span id="close-btn">X</span>
      <img src="<?php echo $path . $img ?>" height="1098" width="640" alt="">
    </span>
  </div>
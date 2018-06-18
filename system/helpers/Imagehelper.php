<?php
namespace System\Helpers; //\Image;

class ImageHelper
{
	/*
	* how to use
	* ImageHelper::reduceImage('inputImage.jpg', 300, 400, 90, 'output.jpg');
	*/
   
     public static function reduceImage($image, $final_width, $final_height, $quality, $save_image_as)
    {

        ## prepare image
		$img_dim = getimagesize($image);
		$ext = image_type_to_extension($img_dim[2]);
        ## get the width x, and the height y.
        list($x, $y) = $img_dim; //getimagesize($image);
        $f_size = self::resizeImage($final_width, $final_height,$image);

        ## create a blank canvas where the new resized image is going to be layered.
        //$canvas = imagecreatetruecolor($this->x, $this->y);
        $canvas = imagecreatetruecolor($f_size['width'], $f_size['height']);
        ## use code below in production server.
        //$canvas = @imagecreatetruecolor($img_width, $img_height);
		switch($ext){
			case '.jpeg':
			## prepare and create the new reduce image using the source file
			$preparedImage = imagecreatefromjpeg($image);
			break;
			case '.jpg':
			## prepare and create the new reduce image using the source file
			$preparedImage = imagecreatefromjpeg($image);
			break;
			case '.png':
			$preparedImage = imagecreatefrompng($image);
			break;
			case '.bmp':
			$preparedImage = imagecreatefromwbmp($image);
			break;
			
		}
        

        ## generate the new reduced image.
        ## actually, this process will draw the reduce image on top of the canvas
        imagecopyresampled($canvas, $preparedImage, 0, 0, 0, 0, $f_size['width'], $f_size['height'],
            $x, $y);

        ## lastly save the new image
        imagejpeg($canvas, $save_image_as, $quality);

        ## free up some menory
        imagedestroy($canvas);
        imagedestroy($preparedImage);

        return true; //$save_image_as;


    }
	
	public static function ForceResizeImage($f_w, $f_h, $force_width=null, $force_height=null, $img_location){
		$image = getimagesize($img_location);
		$ext = image_type_to_extension($image[2]);
		list($x, $y) = $image;
		//check which one is forced 
		if($force_width){
			//we use the width as maximum width
			//echo 'force width<br/>';
			$y_ratio = ($f_w / $y);
			$height = round($y * $y_ratio);
			$width = $f_w;
		}elseif($force_height){
			//we use maximum height
			//echo 'force Height<br/>';
			$x_ratio = ($f_h / $x);
			$f_width = round($x * $x_ratio);
			$width = ($f_width > $f_w ? $f_w : $f_width);
			//echo $width .'<br/>';
			$height = $f_h ;//round($y * $x_ratio);
			//echo $x_ratio.'<br/>';
		}else{
			$height = $f_h; $width = $f_w;
		}
		/*
		echo 'f_w :'. $f_w .'<br/>f_h: '. $f_h .'<br/>'; $x_ratio .'<br/>';
		echo 'f_w/y:'. $f_w / $y.'<br/>';
		echo $x .'<br/>';
		*/
		return (array('width' => $width, 'height' => $height));
	}
	
    public static function resizeImage($f_x, $f_y,$image_loc)
    {
        $image = (getimagesize($image_loc));
		$ext = image_type_to_extension($image[2]);
        list($x, $y) = $image; //getimagesize($image_loc);
        ## check if wide
        if($x > $y) {
            $x_ratio = ($f_x / $x);
            $width = round($x * $x_ratio);
            ## we need to force the height to be our final y
            $height = round((round($y * $x_ratio) > $f_y) ? $f_y : $y * $x_ratio);
            ## if you don't force height, use the actual calculated height by uncommenting $height below
            // $height = $y * $x_ratio;
        }

        ## check if tall image
        elseif ($x < $y) {
            $y_ratio = ($f_y / $y);

            $width = round(($x * $y_ratio > $f_x) ? $f_x : $x * $y_ratio);
            $height = round($y * $y_ratio);
        }

        ## image is more likely to somewhere in between or square with almost equal sides x,y
        else {

            $x_ratio = $f_x / $x;
            $y_ratio = $f_y / $y;
            $width = round($x * $x_ratio > $f_x ? $f_x : $x * $x_ratio);
            $height = round($y * $y_ratio > $f_y ? $f_y : $y * $y_ratio);

        }


        //return array('image'=>$this->save_image_as, 'width'=>$this->width, 'height'=> $this->height);
        return array('width' => $width, 'height' => $height, 'ext' => $ext);


    }


}

<?php
    $data = $_GET;
    $txt = $data['txt'];
    $zb = explode(',',$data['zb']);


    $font = 'fonts/1.ttf';//字体
    $bigImgPath = $data['id'];

    $img = imagecreatefromstring(file_get_contents($bigImgPath));

    $font_color = $data['color'];

    $color = str_replace('#', '', $font_color);
    if (strlen($color) > 3) {
        $rgb = array(
            'r' => hexdec(substr($color, 0, 2)),
            'g' => hexdec(substr($color, 2, 2)),
            'b' => hexdec(substr($color, 4, 2))
        );
    } else {
        $color = $font_color;
        $r = substr($color, 0, 1) . substr($color, 0, 1);
        $g = substr($color, 1, 1) . substr($color, 1, 1);
        $b = substr($color, 2, 1) . substr($color, 2, 1);
        $rgb = array(
            'r' => hexdec($r),
            'g' => hexdec($g),
            'b' => hexdec($b)
        );
    }
    $black = imagecolorallocate($img,$rgb['r'],$rgb['g'],$rgb['b']);

    $font_size = $data['fontsize'];   //字体大小
    $circleSize = 0; //旋转角度
    $left = $zb[0];      //左边距
    $top = $zb[1];       //顶边距
    $top = $top+$font_size;

    imagefttext($img, $font_size/1.3, $circleSize, $left, $top, $black, $font, $txt);

    list($bgWidth, $bgHight, $bgType) = getimagesize($bigImgPath);

    //下载图片
    function downfile($filepath){
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($filepath));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);
    }



    switch ($bgType) {
        case 1: //gif
            if(isset($data['down'])){
                $path = 'image/'.time().'.gif';
                imagejpeg($img, $path);
                downfile($path);
                unlink($path);
            }else{
                header('Content-Type:image/gif');
                imagegif($img);
            }
            break;
        case 2: //jpg
            if(isset($data['down'])){
                $path = 'image/'.time().'.jpg';
                imagejpeg($img, $path);
                downfile($path);
                unlink($path);
            }else{
                header('Content-Type:image/jpg');
                imagejpeg($img);
            }
            break;
        case 3: //png
            if(isset($data['down'])){
                $path = 'image/'.time().'.png';
                imagejpeg($img, $path);
                downfile($path);
                unlink($path);
            }else{
                header('Content-Type:image/png');
                imagepng($img);
            }
            break;
        default:
            break;
    }
    imagedestroy($img);


?>
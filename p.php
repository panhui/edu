<?php
    $data = $_GET;
    $str = $data['txt'];
    $str_len = mb_strlen($str,"UTF8");
    $font_size = $data['fontsize'];
    $font_color = $data['color'];
    $font = 'fonts/1.ttf';//字体

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

    $im = imagecreate($str_len*$font_size,$font_size+10);

    $white = imagecolorallocate($im,0xFF,0xFF,0xFF);
    imagecolortransparent($im,$white);
    //$black = imagecolorallocate($im,0x00,0x00,0x00);
    $black = imagecolorallocate($im,$rgb['r'],$rgb['g'],$rgb['b']);

    imagettftext($im,$font_size/1.3,0,0,$font_size, $black, $font, $str);
    header("Content-type:image/png");
    imagepng($im);
?>
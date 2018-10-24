<?php
// 最初の画像を取得する処理

function catch_that_image($post) {
    $first_img = '';

    $output = mb_strstr($post, '../');
    $output = mb_strstr($output,'">',true);
    $edit_output = str_replace('../', '', $output);
    $edit_output = str_replace('">', '',$edit_output);

if(!empty($edit_output)){
    $first_img = $edit_output;

}else{ //Defines a default image
        $first_img = 'blog/img/ジンベイザメ横から.jpg';
    }
    return $first_img;
}

?>
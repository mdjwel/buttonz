<?php
function buttonz_animate_css_classes_array() {
    $animations = array(
        'bounce' => 'bounce',
        'flash' => 'flash',
        'pulse' => 'pulse',
        'rubberBand' => 'rubberBand',
        'shake' => 'shake',
        'swing' => 'swing',
        'tada' => 'tada',
        'wobble' => 'wobble',
        'jello' => 'jello',
        'bounceIn' => 'bounceIn',
        'bounceInDown' => 'bounceInDown',
        'bounceInUp' => 'bounceInUp',
        'bounceOut' => 'bounceOut',
        'bounceOutDown' => 'bounceOutDown',
        'bounceOutLeft' => 'bounceOutLeft',
        'bounceOutRight' => 'bounceOutRight',
        'bounceOutUp' => 'bounceOutUp',
        'fadeIn' => 'fadeIn',
        'fadeInDown' => 'fadeInDown',
        'fadeInDownBig' => 'fadeInDownBig',
        'fadeInLeft' => 'fadeInLeft',
        'fadeInLeftBig' => 'fadeInLeftBig',
        'fadeInRightBig' => 'fadeInRightBig',
        'fadeInUp' => 'fadeInUp',
        'fadeInUpBig' => 'fadeInUpBig',
        'fadeOut' => 'fadeOut',
        'fadeOutDownBig' => 'fadeOutDownBig',
        'fadeOutLeft' => 'fadeOutLeft',
        'fadeOutLeftBig' => 'fadeOutLeftBig',
        'fadeOutRightBig' => 'fadeOutRightBig',
        'fadeOutUp' => 'fadeOutUp',
        'fadeOutUpBig' => 'fadeOutUpBig',
        'flip' => 'flip',
        'flipInX' => 'flipInX',
        'flipInY' => 'flipInY',
        'flipOutX' => 'flipOutX',
        'flipOutY' => 'flipOutY',
        'fadeOutDown' => 'fadeOutDown',
        'lightSpeedIn' => 'lightSpeedIn',
        'lightSpeedOut' => 'lightSpeedOut',
        'rotateIn' => 'rotateIn',
        'rotateInDownLeft' => 'rotateInDownLeft',
        'rotateInDownRight' => 'rotateInDownRight',
        'rotateInUpLeft' => 'rotateInUpLeft',
        'rotateInUpRight' => 'rotateInUpRight',
        'rotateOut' => 'rotateOut',
        'rotateOutDownLeft' => 'rotateOutDownLeft',
        'rotateOutDownRight' => 'rotateOutDownRight',
        'rotateOutUpLeft' => 'rotateOutUpLeft',
        'rotateOutUpRight' => 'rotateOutUpRight',
        'slideInUp' => 'slideInUp',
        'slideInDown' => 'slideInDown',
        'slideInLeft' => 'slideInLeft',
        'slideInRight' => 'slideInRight',
        'slideOutUp' => 'slideOutUp',
        'slideOutDown' => 'slideOutDown',
        'slideOutLeft' => 'slideOutLeft',
        'slideOutRight' => 'slideOutRight',
        'zoomIn' => 'zoomIn',
        'zoomInDown' => 'zoomInDown',
        'zoomInLeft' => 'zoomInLeft',
        'zoomInRight' => 'zoomInRight',
        'zoomInUp' => 'zoomInUp',
        'zoomOut' => 'zoomOut',
        'zoomOutDown' => 'zoomOutDown',
        'zoomOutLeft' => 'zoomOutLeft',
        'zoomOutUp' => 'zoomOutUp',
        'hinge' => 'hinge',
        'rollIn' => 'rollIn',
        'rollOut' => 'rollOut'
    );

    return $animations;
}

/**
 * Icon array maker
 * @param $k
 * @param string $replace
 * @param string $separator
 * @return array|false
 */
function buttonz_icon_array( $k, $replace = 'icon', $separator = '-' ) {
    $v = array();
    foreach ($k as $kv) {
        $kv = str_replace($separator, ' ', $kv);
        $kv = str_replace($replace, '', $kv);
        $v[] = array_push($v, ucwords($kv));
    }
    foreach($v as $key => $value) if($key&1) unset($v[$key]);
    return array_combine($k, $v);
}

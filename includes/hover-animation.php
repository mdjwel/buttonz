<?php
// Icon Array
function buttonz_css_class_array($k, $replace = 'hvr', $separator = '-') {
    $v = array();
    foreach ( $k as $kv ) {
        $kv = str_replace($separator, ' ', $kv);
        $kv = str_replace($replace, '', $kv);
        $v[] = array_push($v, ucwords($kv));
    }
    foreach($v as $key => $value) if($key&1) unset($v[$key]);
    return array_combine($k, $v);
}

function buttonz_hover_anim() {
    $animation_str = "
        hvr-grow,
        hvr-shrink, 
        hvr-pulse, 
        hvr-pulse-grow, 
        hvr-pulse-shrink, 
        hvr-pulse-shrink, 
        hvr-pulse-shrink, 
        hvr-push, 
        hvr-pop,
        hvr-bounce-in,
        hvr-bounce-out,
        hvr-rotate,
        hvr-grow-rotate,
        hvr-float, 
        hvr-sink, 
        hvr-bob,
        hvr-bob-float,
        hvr-hang,
        hvr-hang-sink,
        hvr-skew,
        hvr-skew-forward,
        hvr-skew-backward,
        hvr-wobble-vertical,
        hvr-wobble-horizontal,
        hvr-wobble-to-bottom-right,
        hvr-wobble-to-top-right,
        hvr-wobble-top,
        hvr-wobble-bottom,
        hvr-wobble-skew,
        hvr-buzz,
        hvr-buzz-out,
        hvr-forward,
        hvr-backward, 
        hvr-fade,
        hvr-back-pulse,
        hvr-sweep-to-right,
        hvr-sweep-to-left,
        hvr-sweep-to-bottom,
        hvr-sweep-to-top,
        hvr-bounce-to-right,
        hvr-bounce-to-left,
        hvr-bounce-to-bottom,
        hvr-bounce-to-top,
        hvr-radial-out,
        hvr-radial-in,
        hvr-rectangle-in,
        hvr-rectangle-out,
        hvr-shutter-in-horizontal,
        hvr-shutter-out-horizontal,
        hvr-shutter-in-vertical,
        hvr-shutter-out-vertical,
        hvr-border-fade,
        hvr-hollow,
        hvr-trim,
        hvr-ripple-out, 
        hvr-ripple-in,
        hvr-outline-out,
        hvr-outline-in,
        hvr-round-corners,
        hvr-underline-from-left,
        hvr-underline-from-center,
        hvr-underline-from-right,
        hvr-overline-from-left,
        hvr-overline-from-center,
        hvr-overline-from-right,
        hvr-reveal,
        hvr-underline-reveal,
        hvr-overline-reveal,
        hvr-glow,
        hvr-shadow,
        hvr-grow-shadow,
        hvr-box-shadow-outset,
        hvr-box-shadow-inset,
        hvr-float-shadow,
        hvr-shadow-radial,
        hvr-bubble-top,
        hvr-bubble-right,
        hvr-bubble-bottom,
        hvr-bubble-left,
        hvr-bubble-float-top,
        hvr-bubble-float-bottom,
        hvr-bubble-float-left,
        hvr-bubble-float-right,
        hvr-curl-top-left,
        hvr-curl-top-right,
        hvr-curl-bottom-right,
        hvr-curl-bottom-left";
    $animation_arr = explode(',', $animation_str);
    $animation = buttonz_css_class_array($animation_arr);
    return $animation;
}

function buttonz_icon_hover_anim() {
    $animation_str = "
        hvr-icon-back,
        hvr-icon-forward,
        hvr-icon-down,
        hvr-icon-up,
        hvr-icon-spin,
        hvr-icon-drop,
        hvr-icon-fade,
        hvr-icon-float-away,
        hvr-icon-sink-away,
        hvr-icon-grow,
        hvr-icon-shrink,
        hvr-icon-pulse,
        hvr-icon-pulse-grow,
        hvr-icon-pulse-shrink,
        hvr-icon-push,
        hvr-icon-pop,
        hvr-icon-bounce,
        hvr-icon-rotate,
        hvr-icon-grow-rotate,
        hvr-icon-float,
        hvr-icon-sink,
        hvr-icon-bob,
        hvr-icon-bob-float,
        hvr-icon-hang,
        hvr-icon-hang-sink,
        hvr-icon-wobble-horizontal,
        hvr-icon-wobble-vertical,
        hvr-icon-buzz,
        hvr-icon-buzz-out";
    $animation_arr = explode(',', $animation_str);
    $animation = buttonz_css_class_array($animation_arr);
    return $animation;
}
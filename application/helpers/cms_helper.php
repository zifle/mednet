<?php 
function btn_edit($uri) {
    return anchor($uri, '<i class="icon-edit"></i>');
}
function btn_delete($uri) {
    return anchor($uri, '<i class="icon-remove"></i>', array(
            'onclick' => 'return confirm(\'Du er ved at slette indhold. Dette kan IKKE fortrydes. Er du sikker på at du vil fortsætte?\');'
        ));
}

function firstline_or_numwords($string, $numwords) {
    if (strpos($string, PHP_EOL) < $numwords && strpos($string, PHP_EOL) !== FALSE) return substr($string, 0, strpos($string, PHP_EOL));
    return limit_to_numwords($string, $numwords);
}

function limit_to_numwords($string, $numwords) {
    $excerpt = explode(' ', $string, $numwords + 1);
    if (count($excerpt) >= $numwords) {
        array_pop($excerpt);
        $excerpt[] = '...';
    }
    $excerpt = implode(' ', $excerpt);
    return $excerpt;
}

function e($string) {
    return htmlentities($string);
}

function get_menu($array, $child = FALSE) {
    $str = '<ul class="'.($child?'dropdown-menu':'nav').'">';
    foreach ($array as $title => $slug) {
        $dropdown = FALSE;
        if (is_array($slug)) {
            $dropdown = TRUE;
        }
        $str .= '<li'.($dropdown?' class="dropdown"':'').'>';
        if (!$dropdown)
            $str .= '<a href="'.site_url($slug).'">'.$title.'</a>';
        else {
            $str .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$title.' <b class="caret"></b></a>';
            $str .= get_menu($slug, TRUE);
        }
        $str .= '</li>';
    }
    $str .= '</ul>';
    return $str;
}

function get_sidebar($array) {
    $str = '';
    foreach ($array as $module) {
        $str .= '<div class="row"><div class="span3">';
        switch ($module['type']) {
            case 'button':
                $str .= anchor($module['slug'], $module['label'], 'class="btn pull-right"');
                break;
            case 'index':
                $str .= '<span class="title">'.$module['title'].'</span><div class="index">';
                foreach ($module['data'] as $index) {
                    $str .= anchor($module['base'].strtolower($index->letter), strtoupper($index->letter), 'class="index index-field"');
                }
                $str .= '</div>';
                // var_dump($module['data']);
                break;
            case 'links':
                if (empty($module['data'])) break;
                $str .= '<span class="title">'.$module['title'].'</span>';
                foreach ($module['data'] as $slug => $title) {
                    $str .= anchor($slug, limit_to_numwords($title, 25), 'class="link"');
                }
                break;
            default:
                $str .= 'Module unknown ('.$module['type'].')';
        }
        $str .= '</div></div>';
    }
    return $str;
}
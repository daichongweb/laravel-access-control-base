<?php

namespace App\Helpers;

class ArrayHelper
{
    public static function getTree(array $array, $key = 'id', $pid = 'parent_id', $sonName = 'children'): array
    {
        $tree = array();
        $packData = array();
        foreach ($array as $v) {
            $packData[$v[$key]] = $v;
        }
        foreach ($packData as $k => $v) {
            if ($v[$pid] == 0) {
                $tree[] = &$packData[$k];
            } else {
                $packData[$v[$pid]][$sonName][] = &$packData[$k];
            }
        }
        return $tree;
    }
}

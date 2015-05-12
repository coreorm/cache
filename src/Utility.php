<?php
/**
 * Quick utilities
 * So it's independent
 */
namespace CoreORM\Cache;

class Utility
{
    /**
     * operate on array:
     * get dot syntax array value,
     * e.g. $a[foo][bar] = get($a, 'foo.bar', $default)
     * @param array $array the source
     * @param string $key the key
     * @param mixed $default default value
     * @return mixed
     */
    public static function arrayGet($array, $key, $default = null)
    {
        // first of all, avoid possible dot syntax which is already in!
        if (!empty($array[$key])) {
            return $array[$key];
        }
        // otherwise, get to . syntax
        $keys = (array) explode('.', $key);
        $val  = (array) $array;
        $cnt  = count($keys);
        foreach ($keys as $k => $key) {
            // otherwise, go with val
            if ($k < $cnt) {
                // if isset, return
                if (!isset($val[$key])) {
                    return $default;
                } else {
                    // drill down to next level
                    $val = $val[$key];
                }
            }
        }
        if (!empty($val)) {
            return $val;
        }
        return $default;

    }

    /**
     * replacement of the dodgy PHP array merge...
     * @param $ar1
     * @param $ar2
     * @return array
     */
    public static function arrayMerge($ar1, $ar2)
    {
        if (!is_array($ar1)) {
            $ar1 = (array) $ar1;
        }
        if (!is_array($ar2)) {
            // no need to merge
            return $ar1;
        }
        foreach ($ar2 as $k => $v) {
            // if exists, replace, if not keep merging
            if (empty($ar1[$k])) {
                $ar1[$k] = $v;
            } else {
                // array? merge more...
                if (is_array($ar1[$k]) && is_array($v)) {
                    $ar1[$k] = self::merge($ar1[$k], $v);
                } else {
                    $ar1[$k] = $v;
                }
            }
        }
        // at last, return ar1
        return $ar1;

    }// end merge

}

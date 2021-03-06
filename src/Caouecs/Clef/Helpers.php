<?php namespace Caouecs\Clef;

class Helpers
{

    /**
     * Add value in an array
     *
     * @access public
     * @param array $array Array object
     * @param string $value Value to add
     * @param string $key Array key to use
     * @return array
     */
    public static function addClass($array, $value, $key = 'class')
    {
        $array[$key] = isset($array[$key]) ? $array[$key].' '.$value : $value;

        return $array;
    }
}

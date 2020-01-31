<?php

/**
 * Validate a color
 *
 * @param String color
 * @return boolean
 */
function validColor($color) {
    global $f3;
    return in_array($color, $f3->get('colors'));
}

/**
 * Validate a String
 *
 * @param String animal
 * @return boolean
 */
function validAnimal($animal) {
    return  (!empty(trim($animal)) && ctype_alpha($animal));
}
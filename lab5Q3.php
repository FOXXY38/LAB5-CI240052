<?php
function calculateArea($length, $width) {
    return $length * $width;
}

$area = calculateArea(10, 5);
echo "The area of the rectangle is: " . $area;
?>
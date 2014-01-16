<?php

include('watermark.class.php');

// Creates the watermark class with a 6x6 grid
$wm = new WaterMark(6, 6);
// Creates a watermark that's 155x155 pixels and has a border that's 5 pixels wide
$wm->create(155, 155, 5);
// Sets the data value to 135468872
$wm->setData(135468872);
// Renders it
$wm->render();
// Outputs the image
$wm->output();
// Saves the image as a PNG
$wm->output("output.png", "png");
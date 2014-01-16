WaterMark
======

The watermark class can be used to generate a watermark that's visible or invisible, to the human eye.
The output is a grid with a border which contains the binary data of the decimal data value set.
I have not made a tool to interpret the binary data and it's something that has to be done manualy for now.

Example
======

```php
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
```

Images
======
The first image is how it looks in debug mode, the 2nd image is using the normal colors and the last image is how it looks after modifying 2nd images curves in photoshop, which is what you do on screenshots to make the watermark visible.

![output in debug mode](https://raw2.github.com/BlackVoid/WaterMark/master/examples/debug.png)
![output in debug mode](https://raw2.github.com/BlackVoid/WaterMark/master/examples/normal.png)
![output in debug mode](https://raw2.github.com/BlackVoid/WaterMark/master/examples/photoshop.png)
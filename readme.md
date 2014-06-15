WaterMark
======

The watermark class can be used to generate a watermark that's visible or invisible, to the human eye.  
The output is a grid with a border which contains the binary data of the decimal data value set.  
I have not made a tool to interpret the binary data and it's something that has to be done manually for now.  

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
$wm->save("output.png", "png");
```

Images
======

The first image is how it looks in debug mode, the 2nd image is using the normal colors and the last image is how it looks after modifying 2nd images curves in photoshop, which is what you do on screenshots to make the watermark visible.

![output in debug mode](https://raw2.github.com/BlackVoid/WaterMark/master/examples/debug.png)
![output in debug mode](https://raw2.github.com/BlackVoid/WaterMark/master/examples/normal.png)
![output in debug mode](https://raw2.github.com/BlackVoid/WaterMark/master/examples/photoshop.png)

License
======

The MIT License (MIT)

Copyright (c) 2014 Felix Gustavsson.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

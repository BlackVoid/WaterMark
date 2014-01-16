<?php
/**
 * Copyright © 2014 Felix Gustavsson
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

class WaterMarkTypeInvalidException extends Exception {}
class WaterMarkValueNotInRangeException extends Exception {}

class WaterMark {

	protected $image;
	protected $border;
	protected $width;
	protected $hight;
	protected $bitx;
	protected $bity;
	protected $data;
	protected $gx;
	protected $gy;
	protected $gt;
	protected $debug = false;

	/**
	 * Initializes the WaterMark class and watermark grid
	 * 
	 * @param int $gx bits on x axis
	 * @param int $gy bits on y axis
	 * 
	 * @access public
	 */
	public function __construct($gx, $gy) {
		if (gettype($gx) != 'integer') {
			throw new WaterMarkTypeInvalidException(gettype($gx) . ' received, expected integer');
		}
		if (gettype($gy) != 'integer') {
			throw new WaterMarkTypeInvalidException(gettype($gy) . ' received, expected integer');
		}
		if ($gx < 1) {
			throw new WaterMarkValueNotInRangeException($gx . ' received, expected a value greater than or equal to 1');
		}
		if ($gy < 1) {
			throw new WaterMarkValueNotInRangeException($gy . ' received, expected a value greater than or equal to 1');
		}
		$this->gx = $gx;
		$this->gy = $gy;
		$this->gt = $gx * $gy;
	}

	/**
	 * Creates WaterMark image
	 * 
	 * Creates the WaterMark image and initializes standard colors
	 * NOTE: Border is only at the bottom and on the right side.
	 * 
	 * @param int $x image width in pixels
	 * @param int $y image hight in pixels
	 * @param int $border border width in pixels
	 * 
	 * @access public
	 */
	public function create($x, $y, $border) {
		if (gettype($x) != 'integer') {
			throw new WaterMarkTypeInvalidException(gettype($x) . ' received, expected integer');
		}
		if (gettype($y) != 'integer') {
			throw new WaterMarkTypeInvalidException(gettype($y) . ' received, expected integer');
		}
		if (gettype($border) != 'integer') {
			throw new WaterMarkTypeInvalidException(gettype($border) . ' received, expected integer');
		}
		if ($x < 1) {
			throw new WaterMarkValueNotInRangeException($x . ' received, expected a value greater than or equal to 1');
		}
		if ($y < 1) {
			throw new WaterMarkValueNotInRangeException($y . ' received, expected a value greater than or equal to 1');
		}
		if ($border < 0 || $border > $x || $border > $y) {
			throw new WaterMarkValueNotInRangeException($border . ' received, expected a value between ' . ($x > $y ? $y : $x));
		}

		$this->border = $border;
		$this->width = $x;
		$this->hight = $y;
		$this->bitx = ($x - $this->border) / $this->gx;
		$this->bity = ($y - $this->border) / $this->gy;
		
		$this->image = imagecreatetruecolor($x, $y);

		$this->bgcol = imagecolorallocatealpha($this->image, 200, 200, 200, 0);
		$this->bitcol = imagecolorallocatealpha($this->image, 220, 220, 220, 120);
	}

	/**
	 * Sets data to be render and converts it from base 10 (decimal) to base 2 (binary)
	 * 
	 * @param int $data data value to be rendered
	 * 
	 * @access public
	 */
	public function setData($data) {
		if (gettype($data) != 'integer') {
			throw new WaterMarkTypeInvalidException(gettype($data) . ' received, expected integer');
		}
		if ($data < 0 || $data > pow(2, ($this->gx * $this->gy) + 1) - 1) {
			throw new WaterMarkValueNotInRangeException($data . ' received, expected a value between 0 and ' . pow(2, ($this->gx * $this->gy) + 1) - 1);
		}
		$this->data = decbin($data);
	}

	/**
	 * Sets debug mode on/off
	 * 
	 * @param boolean $b if true debug colors will be set on render
	 * 
	 * @access public
	 */
	public function debug($b) {
		if (gettype($b) != 'boolean') {
			throw new WaterMarkTypeInvalidException(gettype(b) . ' received, expected boolean');
		}
		$this->debug = $b;
	}

	/**
	 * Sets the background color of the image
	 * 
	 * @param int $r red - between 0 and 255
	 * @param int $g green - between 0 and 255
	 * @param int $b blue - between 0 and 255
	 * @param int $a alpha - between 0 and 127
	 * 
	 * @access public
	 */
	public function setBackgroundColor($r, $g, $b, $a) {
		if (gettype($r) != 'integer') {
			throw new WaterMarkTypeInvalidException(gettype($r) . ' received, expected integer');
		}
		if (gettype($g) != 'integer') {
			throw new WaterMarkTypeInvalidException(gettype($g) . ' received, expected integer');
		}
		if (gettype($b) != 'integer') {
			throw new WaterMarkTypeInvalidException(gettype($b) . ' received, expected integer');
		}
		if (gettype($a) != 'integer') {
			throw new WaterMarkTypeInvalidException(gettype($a) . ' received, expected integer');
		}
		if ($r < 0 || $r >= 255) {
			throw new WaterMarkValueNotInRangeException($r . ' received, expected a value between 0 and 255');
		}
		if ($g < 0 || $g >= 255) {
			throw new WaterMarkValueNotInRangeException($g . ' received, expected a value between 0 and 255');
		}
		if ($b < 0 || $b >= 255) {
			throw new WaterMarkValueNotInRangeException($b . ' received, expected a value between 0 and 255');
		}
		if ($a < 0 || $a >= 255) {
			throw new WaterMarkValueNotInRangeException($a . ' received, expected a value between 0 and 127');
		}
		$this->bgcol = imagecolorallocatealpha($this->image, $r, $g, $b, $a);
	}

	/**
	 * Sets the bit color
	 * 
	 * @param int $r red - between 0 and 255
	 * @param int $g green - between 0 and 255
	 * @param int $b blue - between 0 and 255
	 * @param int $a alpha - between 0 and 127
	 * 
	 * @access public
	 */
	public function setBitColor($r, $g, $b, $a) {
		if (gettype($r) != 'integer') {
			throw new WaterMarkTypeInvalidException(gettype($r) . ' received, expected integer');
		}
		if (gettype($g) != 'integer') {
			throw new WaterMarkTypeInvalidException(gettype($g) . ' received, expected integer');
		}
		if (gettype($b) != 'integer') {
			throw new WaterMarkTypeInvalidException(gettype($b) . ' received, expected integer');
		}
		if (gettype($a) != 'integer') {
			throw new WaterMarkTypeInvalidException(gettype($a) . ' received, expected integer');
		}
		if ($r < 0 || $r >= 255) {
			throw new WaterMarkValueNotInRangeException($r . ' received, expected a value between 0 and 255');
		}
		if ($g < 0 || $g >= 255) {
			throw new WaterMarkValueNotInRangeException($g . ' received, expected a value between 0 and 255');
		}
		if ($b < 0 || $b >= 255) {
			throw new WaterMarkValueNotInRangeException($b . ' received, expected a value between 0 and 255');
		}
		if ($a < 0 || $a >= 255) {
			throw new WaterMarkValueNotInRangeException($a . ' received, expected a value between 0 and 127');
		}
		$this->bitcol = imagecolorallocatealpha($this->image, $r, $g, $b, $a);
	}

	/**
	 * Renders the image
	 * 
	 * @access public
	 */
	public function render() {
		if ($this->debug) {
			$this->bgcol = imagecolorallocatealpha($this->image, 200, 200, 200, 0);
			$this->bitcol = imagecolorallocatealpha($this->image, 0, 0, 0, 0);
		}

		imagefill($this->image, 0, 0, $this->bgcol);
		imagesavealpha($this->image, true);
		imagealphablending($this->image, true);


		$this->_paintRect($this->width - $this->border, 0, $this->border, $this->hight - $this->border, $this->bitcol);
		$this->_paintRect(0, $this->hight - $this->border, $this->width, $this->border, $this->bitcol);

		for ($i = 0; $i <= strlen($this->data) - 1; $i++) {
			if ($this->data[$i] == 1) {
				$chr = $this->gt - strlen($this->data) + $i;
				$row = floor($chr / $this->gx);
				$col = $chr % $this->gx;
				$this->_paintOnGrid($col, $row, $this->bitcol);
			}
		}
	}

	/**
	 * Outputs the image in the browser as a PNG
	 * 
	 * @param string $type image type - suppports png, jpg and gif.
	 * 
	 * @access public
	 */
	public function output($type = 'png') {
		switch ($type) {
			case 'png':
				header('Content-Type: image/png');
				imagepng($this->image);
				break;
			case 'jpg':
				header('Content-Type: image/jpeg');
				imagejpeg($this->image);
				break;
			case 'gif':
				header('Content-Type: image/gif');
				imagegif($this->image);
				break;
			default:
				throw new WaterMarkTypeInvalidException($type . ' received expected png, jpg or gif');
		}
	}
	
	/**
	 * Outputs the image in the browser as a PNG
	 * 
	 * @param string $filepath where to save the image, file extension should be included
	 * @param string $type image type - suppports png, jpg and gif.
	 * 
	 * @access public
	 */
	public function save($filepath, $type = 'png') {
		switch ($type) {
			case 'png':
				imagepng($this->image, $filepath);
				break;
			case 'jpg':
				imagejpeg($this->image, $filepath);
				break;
			case 'gif':
				imagegif($this->image, $filepath);
				break;
			default:
				throw new WaterMarkTypeInvalidException($type . ' received expected png, jpg or gif');
		}
	}

	/**
	 * Paints bit on the image
	 * 
	 * @access protected
	 */
	protected function _paintOnGrid($x, $y, $c) {
		$this->_paintRect($x * $this->bitx, $y * $this->bity, $this->bitx, $this->bity, $c);
	}

	/**
	 * Paints a rectangle on the image without having to calculate end position.
	 * 
	 * @access protected
	 */
	protected function _paintRect($x, $y, $w, $h, $c) {
		return imagefilledrectangle($this->image, $x, $y, $x + $w - 1, $y + $h - 1, $c);
	}

}

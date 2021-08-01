<?php
namespace wutongshenyuan\qrcode_prettify\Color;
class RGBA{
	private $r = 0;
	private $g = 0;
	private $b = 0;
	private $a = 0;
	public function __construct($r,$g,$b,$a=0){
		$this->r = $r;
		$this->g = $g;
		$this->b = $b;
		$this->a = $a;
	}
	public function getRgb(){
		return [
			'r'=>$this->r,
			'g'=>$this->g,
			'b'=>$this->b,
			'a'=>$this->a
		];
	}
	public function getR(){
		return $this->r;
	}
	public function getG(){
		return $this->g;
	}
	public function getB(){
		return $this->b;
	}
	public function getA(){
		return $this->a;
	}
}
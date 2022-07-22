<?php

///ͨ����֤����
class Utils_Caption
{
	var $Width      = 60;           //ͼƬ��
	var $Height     = 60;           //ͼƬ��
	var $Length     = 4;            //��֤��λ��
	var $BgColor    = "#FFFFFF";    //����ɫ

	var $TFonts = array("font.ttf");
	var $TFontSize=array(17,20); //�����С��Χ
	var $TFontAngle=array(-20,20); //��ת�Ƕ�

	var $Chars   = "0123456789";         //��֤�뷶Χ����ĸ���֣�

	var $Code    = array();              //��֤��
	var $Image   = "";              //ͼ�ζ���
	var $FontColors=array('#f36161','#6bc146','#5368bd');  //������ɫ,������
	var $TPadden = 0.75;///�ַ����
	var $Txbase = 5;///x�����߾���
	var $Tybase =5 ;///y�����߾���
	var $TLine =true; ///��������


	public  function RandRSI() ///������֤��
	{
		$this->TFontAngle=range($this->TFontAngle[0],$this->TFontAngle[1]);
		$this->TFontSize=range($this->TFontSize[0],$this->TFontSize[1]);

		$arr=array();
		$Chars=$this->Chars;
		$TFontAngle=$this->TFontAngle;
		$TFontSize=$this->TFontSize;
		$FontColors=$this->FontColors;
		$code="";
		$font=dirname(__FILE__)."/".$this->TFonts[0];

		$charlen=strlen($Chars)-1;
		$anglelen=count($TFontAngle)-1; // �Ƕȷ�Χ
		$fontsizelen=count($TFontSize)-1; // �Ƕȷ�Χ
		$fontcolorlen=count($FontColors)-1; // �Ƕȷ�Χ

		for($i=0;$i<$this->Length;$i++) ///�õ��ַ�����ɫ
		{
			$char=$Chars[rand(0,$charlen)]; ///�õ��ַ�
			$angle=$TFontAngle[rand(0,$anglelen)]; ///��ת�Ƕ�
			$fontsize=$TFontSize[rand(0,$fontsizelen)]; ///�����С
			$fontcolor=$FontColors[rand(0,$fontcolorlen)]; ///�����С

			$bound=$this->_calculateTextBox($fontsize,$angle,$font,$char); ///�õ���Χ

			$arr[]=array($fontsize,$angle,$fontcolor,$char,$font,$bound);  ///�õ����ο�
			$code.=$char;
		}
		$this->Code=$arr; //��֤��
		return $code;
	}

	public function Draw() ///��ͼ
	{
		if(empty($this->Code)) $this->RandRSI();
		$codes=$this->Code; ///�û���֤��


		$wh=$this->_getImageWH($codes);

		$width=$wh[0];
		$height=$wh[1]; ///�߶�

		$this->Width=$width;
		$this->Height=$height;

		$this->Image = imageCreate( $width, $height );
		$image=$this->Image;

		$back = $this->_getColor2($this->_getColor( $this->BgColor)); ///������ɫ
		imageFilledRectangle($image, 0, 0, $width, $height, $back); ///��䱳��

		$TPadden=$this->TPadden;

		$basex=$this->Txbase;
		$color=null;
		foreach ($codes as $v) ///������ַ�
		{
			$bound=$v[5];
			$color=$this->_getColor2($this->_getColor($v[2]));
			imagettftext($image, $v[0], $v[1], $basex, $bound['height'],$color , $v[4], $v[3]);
			$basex=$basex+$bound['width']*$TPadden-$bound['left'];///������һ����߾�
		}
		$this->TLine?$this->_wirteSinLine($color,$basex):null; ///��������
		header("Content-type: image/png");
		imagepng( $image);
		imagedestroy($image);

	}

	/**
	 *ͨ������Ƕȵõ�������ο��*
	 *
	 * @param int $font_size ����ߴ�
	 * @param float $font_angle ��ת�Ƕ�
	 * @param string $font_file �����ļ�·��
	 * @param string $text д���ַ�
	 * @return array ���س����
	 */
	private function _calculateTextBox($font_size, $font_angle, $font_file, $text) {
		$box = imagettfbbox($font_size, $font_angle, $font_file, $text);

		$min_x = min(array($box[0], $box[2], $box[4], $box[6]));
		$max_x = max(array($box[0], $box[2], $box[4], $box[6]));
		$min_y = min(array($box[1], $box[3], $box[5], $box[7]));
		$max_y = max(array($box[1], $box[3], $box[5], $box[7]));

		return array(
		'left' => ($min_x >= -1) ? -abs($min_x + 1) : abs($min_x + 2),
		'top' => abs($min_y),
		'width' => $max_x - $min_x,
		'height' => $max_y - $min_y,
		'box' => $box
		);
	}

	private function  _getColor( $color ) //#ffffff
	{
		return array(hexdec($color[1].$color[2]),hexdec($color[3].$color[4]),hexdec($color[5].$color[6]));
	}

	private function  _getColor2( $color ) //#ffffff
	{
		return imagecolorallocate ($this->Image, $color[0], $color[1], $color[2]);
	}

	private function _getImageWH($data)
	{
		$TPadden=$this->TPadden;
		$w=$this->Txbase;
		$h=0;
		foreach ($data as $v)
		{
			$w=$w+$v[5]['width']*$TPadden-$v[5]['left'];
			$h=$h>$v[5]['height']?$h:$v[5]['height'];
		}
		return array(max($w,$this->Width),max($h,$this->Height));
	}

	//�����Ҹ�����
	private function _wirteSinLine($color,$w)
	{
		$img=$this->Image;

		$h=$this->Height;
		$h1=rand(-5,5);
		$h2=rand(-1,1);
		$w2=rand(10,15);
		$h3=rand(4,6);

		for($i=-$w/2;$i<$w/2;$i=$i+0.1)
		{
			$y=$h/$h3*sin($i/$w2)+$h/2+$h1;
			imagesetpixel($img,$i+$w/2,$y,$color);
			$h2!=0?imagesetpixel($img,$i+$w/2,$y+$h2,$color):null;
		}
	}
}


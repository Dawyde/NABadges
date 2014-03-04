<?php

class Badge{

	const WIDTH = 50;
	const FONT = "DejaVu";

	private $pseudo;
	private $team;
	private $hexkey;
	private $badge_type;
	
	public function __construct($pseudo, $team, $hexkey, $badge_type){
		$this->pseudo = $pseudo;
		$this->team = $team;
		$this->hexkey = $hexkey;
		$this->badge_type = $badge_type;
	}
	
	public function getType(){
		return $this->badge_type;
	}
	
	public function generateRecto($pdf, $type, $x, $y){
		
		$pdf->Image($type['image'],$x,$y, self::WIDTH);
		
		$pdf->SetTextColor($type['color'][0],$type['color'][1],$type['color'][2]);

		$this->ajustSize($pdf, $this->pseudo, 2, 22);
		$pdf->SetXY($x,$y+62);
		$pdf->Cell(self::WIDTH,10,$this->pseudo,0,0,'C');
		
		if($type['wt']){
			$this->ajustSize($pdf, $this->team, 1, 28);
			$pdf->SetXY($x,$y+74);
			$pdf->Cell(self::WIDTH,10,$this->team,0,0,'C');
		}
	}
	
	
	private function ajustSize($pdf, $text, $min_margin=5, $max=30){
		
		$max_val = self::WIDTH-($min_margin*2);
		
		for($i=5;$i<$max;$i++){
			$pdf->SetFont(self::FONT,'',$i);
			$w = $pdf->GetStringWidth($text);
			if($w > $max_val){
				$pdf->SetFont(self::FONT,'',$i-1);
				return;
				//die($w);
			}
		}
	}
	private function getAverageSize($text){
		$l = strlen($text);
		if($l<6) return 21;
		if($l<8) return 20;
		if($l<10) return 18;
		if($l<12) return 16;
		if($l<15) return 14;
		if($l<20) return 13;
		return 10;
	}
}
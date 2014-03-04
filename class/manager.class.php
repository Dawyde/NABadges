<?php
class Manager{


	private $badge;
	private $types;
	
	
	public function __construct(){
	}
	
	public function addType($id, $image, $color, $write_team){
		$this->types[$id] = array(
			'color'=>$color,
			'image'=>$image,
			'wt' => $write_team
		);
	}
	
	public function addBadge($badge){
		$this->badge[] = $badge;
	}
	
	public function generatePDF(){
		$pdf = new tFPDF('P','mm','A4');
		$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);

		$pdf->SetMargins(0,0,0,0);
		
		for($p=0;$p<ceil(count($this->badge)/12);$p++) $this->generateRecto($pdf, $p);
		
		$pdf->Output();
	}
	
	public function generateRecto($pdf, $page){
		$pdf->AddPage();
		$max = min(count($this->badge), ($page+1)*12);
		$j=0;
		for($i=$page*12;$i<$max;$i++){
			$x = $j%4;
			$y = floor($j/4);
			$this->badge[$i]->generateRecto($pdf, $this->types[$this->badge[$i]->getType()], $x*52+2, $y*90+5);
			$j++;
		}
		
	}
}
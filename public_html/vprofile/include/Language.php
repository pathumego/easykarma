<?php
class Language
{
		public $LangId;
		public $LangTag;
		public $English;
		public $Sinhala;
		public $Tamil;
		public $Bangla;
		public $Nepali;
		public $Lang1;
		public $Lang2;
		public $Lang3;


public function setLanguage($LangId_,$LangTag_,$English_,$Sinhala_,$Tamil_,$Bangla_,$Nepali_,$Lang1_,$Lang2_,$Lang3_)
{
		$this->LangId= $LangId_;
		$this->LangTag= $LangTag_;
		$this->English= $English_;
		$this->Sinhala= $Sinhala_;
		$this->Tamil= $Tamil_;
		$this->Bangla= $Bangla_;
		$this->Nepali= $Nepali_;
		$this->Lang1= $Lang1_;
		$this->Lang2= $Lang2_;
		$this->Lang3= $Lang3_;

}

public function wsGetLanguageData()
{
	return	array(	
		'LangId'=> $this->LangId,
		'LangTag'=> $this->LangTag,
		'English'=> $this->English,
		'Sinhala'=> $this->Sinhala,
		'Tamil'=> $this->Tamil,
		'Bangla'=> $this->Bangla,
		'Nepali'=> $this->Nepali,
		'Lang1'=> $this->Lang1,
		'Lang2'=> $this->Lang2,
		'Lang3'=> $this->Lang3

	);					
	
}
//---------------------------------------------------------------------------
 
 public function getLanguageData()
 {
 	$packet = 	
		$this->LangId.";".
		$this->LangTag.";".
		$this->English.";".
		$this->Sinhala.";".
		$this->Tamil.";".
		$this->Bangla.";".
		$this->Nepali.";".
		$this->Lang1.";".
		$this->Lang2.";".
		$this->Lang3;

	return $packet;
 }
 
 
  public function getLanguagePacketHtml() 
 { 	

 	$hiddenHtml  ="<input class=\"LanguageData\" id=\"Languagedata\" type=\"hidden\" ";
	$hiddenHtml .="value=\"";
	$hiddenHtml .=$this->getLanguageData();
	$hiddenHtml .= "\">";
	
	return $hiddenHtml;
 }
 



public function drawTableViewLanguage()
{
		$html = "<tr>";
		$html .= "<td></td>";
		$html .= "<td>".$this->LangId."</td>";
		$html .= "<td>".$this->LangTag."</td>";
		$html .= "<td>".$this->English."</td>";
		$html .= "<td>".$this->Sinhala."</td>";
		$html .= "<td>".$this->Tamil."</td>";
		$html .= "<td>".$this->Bangla."</td>";
		$html .= "<td>".$this->Nepali."</td>";
		$html .= "<td>".$this->Lang1."</td>";
		$html .= "<td>".$this->Lang2."</td>";
		$html .= "<td>".$this->Lang3."</td>";

		$html .= "</tr>";

return $html;
}

 
}
?>
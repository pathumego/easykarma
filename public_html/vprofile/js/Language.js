function Language()
{
this.LangId="";
this.LangTag="";
this.English="";
this.Sinhala="";
this.Tamil="";
this.Bangla="";
this.Nepali="";
this.Lang1="";
this.Lang2="";
this.Lang3="";

}

Language.prototype.setLanguage = function(LangId_,LangTag_,English_,Sinhala_,Tamil_,Bangla_,Nepali_,Lang1_,Lang2_,Lang3_)
{
this.LangId=LangId_;
this.LangTag=LangTag_;
this.English=English_;
this.Sinhala=Sinhala_;
this.Tamil=Tamil_;
this.Bangla=Bangla_;
this.Nepali=Nepali_;
this.Lang1=Lang1_;
this.Lang2=Lang2_;
this.Lang3=Lang3_;

},

Language.prototype.createLanguagePacket = function()
{
	var packet = "";	
	packet += this.LangId+";";
	packet += this.LangTag+";";
	packet += this.English+";";
	packet += this.Sinhala+";";
	packet += this.Tamil+";";
	packet += this.Bangla+";";
	packet += this.Nepali+";";
	packet += this.Lang1+";";
	packet += this.Lang2+";";
	packet += this.Lang3;

	return packet;
}


Language.prototype.getLanguageData = function()
{
	var packet = "";	
	packet += this.LangId+";";
	packet += this.LangTag+";";
	packet += this.English+";";
	packet += this.Sinhala+";";
	packet += this.Tamil+";";
	packet += this.Bangla+";";
	packet += this.Nepali+";";
	packet += this.Lang1+";";
	packet += this.Lang2+";";
	packet += this.Lang3;

	return packet;
}


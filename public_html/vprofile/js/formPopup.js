function formPopup()
{
	this.width;
	this.height;
	this.msgElem;
	this.popupType; //0=>normal, 1=>alert 
	this.top = 100;
	
}
formPopup.prototype.init = function(width_,height_,msgElem_)
{
	this.msgElem = msgElem_;
	this.width = width_;
	this.height = height_;
	this.left = (document.body.offsetWidth - this.width )/2;
}
formPopup.prototype.show = function()
{
		
		this.msgElem.style.width = (isNaN(this.width) || this.width ==0) ? "" : this.width+"px";
		this.msgElem.style.height = (isNaN(this.height) || this.height ==0) ? "" : this.height+"px";
		this.msgElem.paddingLeft = 20+"px";				
		this.msgElem.className = "formPopup";
		this.msgElem.style.display = "block";
		this.msgElem.style.top = this.top+"px";
		this.msgElem.style.left = this.left +"px";
		this.createCloseBtn();	
	
}
formPopup.prototype.createCloseBtn = function()
{
	
	var btnHeight=25;
	var btnWidth = 25;
	var self = this;
	var closeBtn = document.getElementById("popclose_icon_form")
	if(! closeBtn )
	{
	var closeBtn = document.createElement("a");
	closeBtn.id = "popclose_icon_form";
	closeBtn.href = "javascript:void(0)";
	closeBtn.className = "popclose_icon";
	closeBtn.innerHTML = "X";	
	closeBtn.style.height = btnHeight+"px";
	closeBtn.style.width = btnWidth+"px";
	closeBtn.onclick = function(){self.hide();};
	closeBtn.style.top =  -1 * (btnHeight) +"px";
	closeBtn.style.left = this.width - (btnWidth/2) +"px";	
	this.msgElem.insertBefore(closeBtn,this.msgElem.firstChild);
	}	
	
	
}

formPopup.prototype.hide = function()
{
	
	if(this.msgElem)
	{
		this.msgElem.style.display = "none";
	}
}



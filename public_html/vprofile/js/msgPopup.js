function msgPopup()
{
	this.width;
	this.height;
	this.innerHTML;
	this.popupType; //0=>normal, 1=>alert 
	this.top = 100;
	
	
}
msgPopup.prototype.init = function(width_,height_,innerHTML_)
{
	this.innerHTML = innerHTML_;
	this.width = width_;
	this.height = height_;
	this.left = (document.body.offsetWidth - this.width )/2;
}
msgPopup.prototype.show = function()
{
	var msgElem = document.getElementById("msgPopup");
	if (!msgElem) {
		msgElem = document.createElement("div");
		msgElemInner = document.createElement("div");
		msgElem.id = "msgPopup";
		document.body.appendChild(msgElem);
	}
		msgElemInner.innerHTML = this.innerHTML;
		msgElemInner.style.width = this.width+"px";
		msgElemInner.style.height = this.height+"px";
		msgElemInner.paddingLeft = 20+"px";
		msgElem.innerHTML = "";
		msgElem.appendChild(msgElemInner);
				
		msgElem.className = "msgpopup";
		msgElem.style.width = this.width+"px";
		msgElem.style.height = this.height+"px";
		msgElem.style.display = "block";
		msgElem.style.top = this.top+"px";
		msgElem.style.left = this.left +"px";
		this.createCloseBtn(msgElem);
	
	
}
msgPopup.prototype.createCloseBtn = function(msgElem)
{
	
	var btnHeight=25;
	var btnWidth = 25;
	var self = this;
	if(!closeBtn)
	{
	var closeBtn = document.createElement("a");
	closeBtn.id = "popclose_icon";
	closeBtn.href = "javascript:void(0)";
	closeBtn.className = "popclose_icon";
	closeBtn.innerHTML = "X";	
	closeBtn.style.height = btnHeight+"px";
	closeBtn.style.width = btnWidth+"px";
	closeBtn.onclick = function(){self.hide();};
	closeBtn.style.top =  -1 * (this.height+btnHeight) +"px";
	closeBtn.style.left = this.width - (btnWidth/2) +"px";
	
	msgElem.appendChild(closeBtn);
	}	
	
	
	
	
	
	
	
}

msgPopup.prototype.hide = function()
{
	var msgElem = document.getElementById("msgPopup");
	if(msgElem)
	{
		msgElem.style.display = "none";
	}
}



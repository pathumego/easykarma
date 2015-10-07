

function AutoComplete()
{
this.globalAutoElementId = -1;
this.AttachElem="";
this.HiddenAttachElem="";
this.SearchTag_="";
this.ItemList="";
this.SearchModuleNo="";
}

AutoComplete.prototype.Open = function(globalId_, HiddenAttachElem_,  SearchTag_,SearchModuleNo_)
{
var self = this;
this.globalAutoElementId = globalId_;
this.AttachElem = document.getElementById("Dummy_"+HiddenAttachElem_);
this.SearchTag = SearchTag_;
this.HiddenAttachElem = document.getElementById(HiddenAttachElem_);
this.SearchModuleNo = SearchModuleNo_;
this.AttachElem.onkeyup = function(){
self.Autocomplete_OutgoingData();
}
this.AttachElem.onmove = function(){
self.LoadItems(self.ItemList);
}
setTimeout(function(){self.Autocomplete_OutgoingInitData();},200);
},

AutoComplete.prototype.LoadInitTextValue = function(itemValue)
{
if(this.AttachElem.value == "")
{
this.AttachElem.value = itemValue;
}
},

AutoComplete.prototype.LoadItems = function(itemList_)
{
this.ItemList = itemList_;

if(this.AttachElem)
{
	var pos = this.getElementPosition();
	var elemAutoComplete =  document.getElementById("AutoComplete_global");	
	if(elemAutoComplete)
	{
	  elemAutoComplete.innerHTML = "";
	}
	else
	{	
		elemAutoComplete = document.createElement("div");
		elemAutoComplete.setAttribute("id","AutoComplete_global");
		document.body.appendChild(elemAutoComplete);			
	}
	
	if(this.ItemList.length >0)
	{
	var ulelem = document.createElement("ul");
	ulelem.className = "autocomplete_ul";
	
	
		for(var x=0 in this.ItemList)
		{
		    var data = this.ItemList[x];
			if(data != "" )
			{
			var self = this;
			var itemvalue = data.substring(data.indexOf("_")+1);
			var itemid = data.substring(0,data.indexOf("_"));
			var lielem = document.createElement("li");
			
			lielem.onclick = function(){
			self.AttachElem.value = itemvalue;
			self.HiddenAttachElem.value = itemid;
			elemAutoComplete.innerHTML = "";
			self = "";
			}
			lielem.innerHTML = "<span>"+itemvalue+"</span>";
			lielem.innerHTML += "<input type=\"hidden\" value=\""+data+"\">";
			ulelem.appendChild(lielem);			
			}
		}
		elemAutoComplete.innerHTML = "";
		elemAutoComplete.appendChild(ulelem);
		ulelem.style.top = parseInt(pos.y + this.AttachElem.offsetHeight) + "px";
		ulelem.style.left = parseInt(pos.x+1) + "px";
		ulelem.style.width = parseInt(this.AttachElem.offsetWidth - 2)+ "px";
	}
	
}
},

AutoComplete.prototype.Autocomplete_OutgoingData = function()
{
var moduleId = 1;
var actionId = 100;
var messageId = getDummyId();
var SystemId = 0;
var packet = SystemId+";";
packet += moduleId+";";
packet += actionId+";";
packet += this.SearchModuleNo+";";
packet += this.globalAutoElementId+";";
packet += this.SearchTag+";";
packet += this.AttachElem.value;
message_queue(packet,messageId);
},

AutoComplete.prototype.Autocomplete_OutgoingInitData = function()
{

if(this.HiddenAttachElem.value != "")
{
var moduleId = 1;
var actionId = 101;
var messageId = getDummyId();
var SystemId = 0;
var packet = SystemId+";";
packet += moduleId+";";
packet += actionId+";";
packet += this.SearchModuleNo+";";
packet += this.globalAutoElementId+";";
packet += this.SearchTag+";";
packet += this.HiddenAttachElem.value;
message_queue(packet,messageId);
}
},

AutoComplete.prototype.getElementPosition = function(){
	var left = 0;
	var top  = 0;
	var elem = this.AttachElem;

	while (elem.offsetParent)
	{
		left += elem.offsetLeft;
		top  += elem.offsetTop;
		elem    = elem.offsetParent;
	}

	left += elem.offsetLeft;
	top  += elem.offsetTop;
	
	return {x:left, y:top};
};
//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Village_climate_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addVillage_climate(mainPacket);
			break;
		}
		case 201: {
			ACK_addVillage_climate(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteVillage_climate(mainPacket);
			break;
		}
		case 203: {
			ACK_updateVillage_climate(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addVillage_climate(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Village_climate = new Village_climate();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Village_climate.ClimateId= mainPacket[3];
		obj_Village_climate.VillageId= mainPacket[4];
		obj_Village_climate.ClimateReagion= mainPacket[5];
		obj_Village_climate.RainFall= mainPacket[6];
		obj_Village_climate.Temparature= mainPacket[7];
		obj_Village_climate.Humidity= mainPacket[8];



		if (resultStatus == 1) {	
			
			UI_createVillage_climateRow(obj_Village_climate, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteVillage_climate(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_climate = new Village_climate();
		
		var resultStatus = mainPacket[0];
		var ClimateId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Village_climateListRow_"+ClimateId);
		if(resultStatus ==1)
		{
			rowElem.parentNode.removeChild(rowElem);
			
		}
		else
		{
			rowElem.className = "ListRow_error";
			rowElem.style.display = "block";
			window.alert(resultMsg);
			setTimeout(function(){
				var rowElem = document.getElementById("Village_climateListRow_"+ClimateId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateVillage_climate(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_climate = new Village_climate();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Village_climate.ClimateId= mainPacket[2];
		obj_Village_climate.VillageId= mainPacket[3];
		obj_Village_climate.ClimateReagion= mainPacket[4];
		obj_Village_climate.RainFall= mainPacket[5];
		obj_Village_climate.Temparature= mainPacket[6];
		obj_Village_climate.Humidity= mainPacket[7];


		if (resultStatus == 1) {			
			UI_createVillage_climateRow(obj_Village_climate, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Village_climate_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingVillage_climatePacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Village_climate; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteVillage_climatePacket(ClimateId) {
	var deletePacketBody  = ClimateId;

	var postpacket = createOutgoingVillage_climatePacket(202,deletePacketBody);
	Village_climate_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateVillage_climatePacket(obj_Village_climate) {
	var savePacketBody  = obj_Village_climate.createVillage_climatePacket();

	var postpacket = createOutgoingVillage_climatePacket(203,savePacketBody);
	Village_climate_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddVillage_climatePacket(dummyId,obj_Village_climate) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Village_climate.createVillage_climatePacket();

	var postpacket = createOutgoingVillage_climatePacket(201,savePacketBody);
	Village_climate_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onVillage_climatePageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onVillage_climatePageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addVillage_climate = document.getElementById("btnaddVillage_climate");
	if(addVillage_climate){
	addVillage_climate.addEventListener('mousedown', Event_mousedown_addVillage_climate, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popVillage_climateform = document.getElementById("popVillage_climateform");
	var inputElems = popVillage_climateform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiVillage_climateList = document.getElementById("Village_climateList");
	var liElems = UiVillage_climateList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverVillage_climateRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutVillage_climateRow, false);
		
	}
	
	var UiVillage_climateListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiVillage_climateListDeletebtns.length; z++) {
			UiVillage_climateListDeletebtns[z].addEventListener('mousedown', Event_mouseDownVillage_climateRowBtn, false);			
		
	}

	var searchBox = document.getElementById("searchtextbox");
	 if(searchBox){
	 searchBox.addEventListener('focus', Event_focusSearchBox, false);
     searchBox.addEventListener('blur', Event_blurSearchBox, false);
     searchBox.addEventListener('keyup', Event_keyupSearchBox, false);
    }
	
}
//-------------------------------------------------------------------------------------------------------------------


function Event_focusSearchBox()
{
	if (this.className == "searchtextbox") {
        this.className = "searchtextbox_focus";        
        
    }
	if(this.value == "Search here..."){
		this.value ="";    
	}
}
//-------------------------------------------------------------------------------------------------------------------
function Event_blurSearchBox()
{
	if (this.className == "searchtextbox_focus") {
        this.className = "searchtextbox";        
        
    }
	if(this.value == ""){
		this.value ="Search here...";    
	}
}

//-------------------------------------------------------------------------------------------------------------------
function Event_keyupSearchBox()
{
	var searchText = this.value;
	UI_search_Village_climate(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownVillage_climateRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Village_climate = Get_Village_climateByListRow(this.parentNode.parentNode);
			if(obj_Village_climate != ""){
				deleteVillage_climate(obj_Village_climate.ClimateId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Village_climate = Get_Village_climateByListRow(this.parentNode.parentNode);
			if(obj_Village_climate != ""){
				UI_showUpdateVillage_climateForm(obj_Village_climate);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Village_climate(searchText)
{

	//Village_climateList = 
	var Village_climateListElem = document.getElementById("Village_climateList");
	
	if(Village_climateListElem)
	{
		var Village_climateDataList = Village_climateListElem.getElementsByTagName("input");
		for(var y=0 in Village_climateDataList)
		{
			if(Village_climateDataList[y])
			{
				
				
				var displayType = "none";
				var Village_climateData = Village_climateDataList[y].value;
				if(!((Village_climateData == "") || (typeof Village_climateData=="undefined")))
				{
				if(search_Village_climate(Village_climateData,searchText))
				{
					displayType = "block";
				}
				Village_climateDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Village_climate(Village_climateData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Village_climateData = decodeSpText(Village_climateData.toLowerCase());
	if(Village_climateData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Village_climate)
{
	if (obj_Village_climate.ClimateId) {
		var fieldDataId = obj_Village_climate.ClimateId;
		msgPopupwin = new msgPopup();
		var popwidth = 400;
		var popheight = 50;
		var popinnerHTML = "<iframe height=\"";
		popinnerHTML += popheight;
		popinnerHTML += "px\" frameborder=\"0\" width=\"";
		popinnerHTML += popwidth;
		popinnerHTML += "px\" border=\"0\" id=\"uploadframe\" name=\"uploadframe\" style=\"border: medium none;\" src=\"";
		popinnerHTML += "upload_uploadAvatarIndex.php?fielddataid="
		popinnerHTML += fieldDataId;
		popinnerHTML += "\">";
		popinnerHTML += "</iframe>";
		
		msgPopupwin.init(popwidth, popheight, popinnerHTML);		
		msgPopupwin.show();
	}
}
//-------------------------------------------------------------------------------------------------------------------

function deleteVillage_climate(ClimateId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Village_climate");
	if(flag){
			DeleteVillage_climatePacket(ClimateId);
			UI_hideListRow(listRow);	
		}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_deleteListRow(rowElem)
{
if(rowElem)
{
rowElem.parentNode.removeChild(rowElem);
	
}	
	
}

//-------------------------------------------------------------------------------------------------------------------

function UI_hideListRow(rowElem)
{
if(rowElem)
{
rowElem.style.display = "none";
	
}	
	
}
//-------------------------------------------------------------------------------------------------------------------

function Get_Village_climateByListRow(listRowElem)
{
	
	var obj_Village_climate ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Village_climateData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Village_climateData = elemlist[z].value;
			}		
		}
		
		if(Village_climateData != "")
		{
		var arrVillage_climateData = Village_climateData.split(";");	
		
		obj_Village_climate = new Village_climate();
		obj_Village_climate.ClimateId= arrVillage_climateData[0];
		obj_Village_climate.VillageId= arrVillage_climateData[1];
		obj_Village_climate.ClimateReagion= arrVillage_climateData[2];
		obj_Village_climate.RainFall= arrVillage_climateData[3];
		obj_Village_climate.Temparature= arrVillage_climateData[4];
		obj_Village_climate.Humidity= arrVillage_climateData[5];

		
		
		}
		
	}
	
	return obj_Village_climate;
	
	
}
//-------------------------------------------------------------------------------------------------------------------

function Event_focusFormAreaField(event) {

if (this.className == "form_area_textbox") {
		this.className = "form_area_textbox_focus";
	}
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_blurFormAreaField(event) {

	if (this.className == "form_area_textbox_focus") {
		this.className = "form_area_textbox";
	}
	
	if(validate_form())
	{
	event.preventDefault();
	return false;
	}
		

}

//-------------------------------------------------------------------------------------------------------------------

function validate_form()
{
	
	var iserror =false;
		var errorMsg = "";
	

	var Elem = document.getElementById("Input_ClimateReagion");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "please Enter Climate Zone";
					Elem.focus();
				}				
				
	
			}
				
		
		if(iserror ==true)
		{
						
			document.getElementById("formerror").innerHTML = error;
		}
		else
		{
			document.getElementById("formerror").innerHTML = "";
		}	
		
		return iserror;
	
	
	return false;
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_form_addbtn(event) {
	

	if(validate_form())
	{
	event.preventDefault();
	return false;
	}
	
		var obj_Village_climate = new Village_climate();
		
		var ClimateId= document.getElementById("Input_ClimateId").value;
		var VillageId= document.getElementById("Input_VillageId").value;
		var ClimateReagion= document.getElementById("Input_ClimateReagion").value;
		var RainFall= document.getElementById("Input_RainFall").value;
		var Temparature= document.getElementById("Input_Temparature").value;
		var Humidity= document.getElementById("Input_Humidity").value;

		
		document.getElementById("Input_ClimateId").value="";
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_ClimateReagion").value="";
		document.getElementById("Input_RainFall").value="";
		document.getElementById("Input_Temparature").value="";
		document.getElementById("Input_Humidity").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Village_climate = new Village_climate();
		obj_Village_climate.ClimateId= ClimateId;
		obj_Village_climate.VillageId= VillageId;
		obj_Village_climate.ClimateReagion= ClimateReagion;
		obj_Village_climate.RainFall= RainFall;
		obj_Village_climate.Temparature= Temparature;
		obj_Village_climate.Humidity= Humidity;

		
		var dummyId = CreateDummyNumber();
		AddVillage_climatePacket(dummyId,obj_Village_climate);
		UI_createVillage_climateRow(obj_Village_climate, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Village_climate = new Village_climate();

		obj_Village_climate.ClimateId= ClimateId;
		obj_Village_climate.VillageId= VillageId;
		obj_Village_climate.ClimateReagion= ClimateReagion;
		obj_Village_climate.RainFall= RainFall;
		obj_Village_climate.Temparature= Temparature;
		obj_Village_climate.Humidity= Humidity;

		
		UpdateVillage_climatePacket(obj_Village_climate);
		UI_createVillage_climateRow(obj_Village_climate, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addVillage_climate() {
	
	UI_showAddVillage_climateForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddVillage_climateForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_climateAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_climateform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateVillage_climateForm(obj_Village_climate) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_climateUpdateForm(obj_Village_climate);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_climateform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------
function UI_showhideFormElements(arr_childelemlist, flag)
{
	for(var x =0 in arr_childelemlist)
	{
		if(elem = document.getElementById(arr_childelemlist[x]))
		{
			elem.parentNode.parentNode.style.display = flag ==1 ? "block" : "none";			
		}		
	}	
}
//-------------------------------------------------------------------------------------------------------------------
function UI_prepareVillage_climateUpdateForm(obj_Village_climate)
{
	var arr_hidelist = new Array("Input_ClimateId","Input_VillageId");
	var arr_showlist = new Array("Input_ClimateReagion","Input_RainFall","Input_Temparature","Input_Humidity");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_ClimateId").value=obj_Village_climate.ClimateId;
		document.getElementById("Input_VillageId").value=obj_Village_climate.VillageId;
		document.getElementById("Input_ClimateReagion").value=obj_Village_climate.ClimateReagion;
		document.getElementById("Input_RainFall").value=obj_Village_climate.RainFall;
		document.getElementById("Input_Temparature").value=obj_Village_climate.Temparature;
		document.getElementById("Input_Humidity").value=obj_Village_climate.Humidity;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareVillage_climateAddForm()
{
	var arr_hidelist = new Array("Input_ClimateId","Input_VillageId");
	var arr_showlist = new Array("Input_ClimateReagion","Input_RainFall","Input_Temparature","Input_Humidity");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_ClimateId").value="";
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_ClimateReagion").value="";
		document.getElementById("Input_RainFall").value="";
		document.getElementById("Input_Temparature").value="";
		document.getElementById("Input_Humidity").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addVillage_climateToVillage_climateList() {
	var uiVillage_climateList = document.getElementById("Village_climateList");

	var rowElems = uiVillage_climateList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_climateRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownVillage_climateRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_climateRowHtmlElem(obj_Village_climate,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Village_climateImg_"+obj_Village_climate.ClimateId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Village_climate/0_small.png";
	else ImgElem.src = "Village_climate/"+obj_Village_climate.ClimateId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Village_climate.ClimateId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Village_climate.VillageId;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Village_climate.ClimateReagion;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Village_climate.RainFall;
		var ElemDataRow6 = document.createElement("div");
		ElemDataRow6.className ="datarow";
		ElemDataRow6.innerHTML = obj_Village_climate.Temparature;
		var ElemDataRow7 = document.createElement("div");
		ElemDataRow7.className ="datarow";
		ElemDataRow7.innerHTML = obj_Village_climate.Humidity;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Village_climatedata"+ElemId);
		ElementDataHidden.value = obj_Village_climate.getVillage_climateData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);
		ElemLi.appendChild(ElemDataRow6);
		ElemLi.appendChild(ElemDataRow7);

		
		ElemLi= UI_createVillage_climateRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverVillage_climateRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutVillage_climateRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubVillage_climateHtmlElem(obj_Village_climate)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subVillage_climate");
		html ="<a href=\"?page=dashboard&ClimateId="+obj_Village_climate.ClimateId+"\">"+obj_Village_climate.ClimateId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverVillage_climateRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutVillage_climateRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_climateRow(obj_Village_climate, rowType,dummyId) {
	var html = "";
	
	var UiVillage_climateList = document.getElementById("Village_climateList");
	var ClassName = "ListRow";
	var ElemId = "Village_climateListRow_"+obj_Village_climate.ClimateId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyVillage_climateRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createVillage_climateRowHtmlElem(obj_Village_climate,ElemId, ClassName);
			UiVillage_climateList.insertBefore(ElemLi, UiVillage_climateList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Village_climate msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createVillage_climateRowHtmlElem(obj_Village_climate,ElemId, ClassName);
			UiVillage_climateList.insertBefore(ElemLi, UiVillage_climateList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyVillage_climateRow_"+dummyId);
			var DummyData = document.getElementById("Village_climatedataDummyVillage_climateRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Village_climatedata"+ElemId);		
				DummyData.value = obj_Village_climate.getVillage_climateData();		
				}
				UI_createTopbarSubVillage_climateHtmlElem(obj_Village_climate);
				UI_hidecontentError(checkNodeCount =true);
			}
			
		break;
		}
		case "replace":
		{
			if(dummyId == 1)ClassName = "ListRow_Dummy"; //use dummyId as flag

			var currentElem = document.getElementById(ElemId);
			if(currentElem)
			{
				var ElemLi = UI_createVillage_climateRowHtmlElem(obj_Village_climate,ElemId, ClassName);
				UiVillage_climateList.insertBefore(ElemLi, currentElem);
				currentElem.parentNode.removeChild(currentElem);	
			}
			break;
		}
		}

}
//-------------------------------------------------------------------------------------------------------------------

function UI_hidecontentError(flag)
{
	var errorElem = document.getElementById("contentError");
	if(errorElem)
	{
	
	if(flag)
	{
		var listnode = document.getElementById("Village_climateList");
		if(listnode.getElementsByClassName("ListRow").length >0)
		{
			errorElem.style.display = "none";
		}
		else
		{
			errorElem.style.display = "block";
		}
	}
	else
	{
		errorElem.style.display = "none";
	}
	
			
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function CreateDummyNumber() {
	return	Math.floor(Math.random()*99999);
}
//-------------------------------------------------------------------------------------------------------------------

function avatarUploadResult(status, uploadFileName, errorMsg, ClimateId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("Village_climateListRow_"+ClimateId);
		var avatarimgs = profileAvatar.getElementsByTagName("img");
		if(avatarimgs.length >0)
		{
			avatarimgs[0].src = uploadFileName+"?"+Math.random();
		}
		
	}
	else
	{
 
		var errorMessage = "";
		switch(errorMsg)
		{
			case "A000":
			{
			errorMessage = "Sorry you dont have permission to upload file";
			break;	
			}
			case "A003":
			{
			errorMessage = "Sorry, The file type does not valid for upload";
			break;	
			}
			case "A004":
			{
			errorMessage = "Sorry, The file size is too large to upload";
			break;	
			}
			default:
			{
			errorMessage = "sorry, problem occured while uploading a file";
			break;	
			}
		}
		var html = "<div style=\"width:";
		html +=msgPopupwin.width;
		html +="px;height:";
		html +=msgPopupwin.height;
		html += "px\">"
		html +=errorMessage;
		html += "</div>";
		msgPopupwin.innerHTML = html;
		msgPopupwin.show();
	}
}
//-------------------------------------------------------------------------------------------------------------------


//-------------------------------------------------------------------------------------------------------------------

/*
 function getElementPosition(elem){
 var left = 0;
 var top = 0;

 while (elem.offsetParent) {
 left += elem.offsetLeft;
 top += elem.offsetTop;
 elem = elem.offsetParent;
 }

 left += elem.offsetLeft;
 top += elem.offsetTop;

 return {
 x: left,
 y: top
 };
 }
 */



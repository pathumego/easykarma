//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Village_plant_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addVillage_plant(mainPacket);
			break;
		}
		case 201: {
			ACK_addVillage_plant(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteVillage_plant(mainPacket);
			break;
		}
		case 203: {
			ACK_updateVillage_plant(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addVillage_plant(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Village_plant = new Village_plant();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Village_plant.PlantId= mainPacket[3];
		obj_Village_plant.VillageId= mainPacket[4];



		if (resultStatus == 1) {	
			
			UI_createVillage_plantRow(obj_Village_plant, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteVillage_plant(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_plant = new Village_plant();
		
		var resultStatus = mainPacket[0];
		var VillageId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Village_plantListRow_"+VillageId);
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
				var rowElem = document.getElementById("Village_plantListRow_"+VillageId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateVillage_plant(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_plant = new Village_plant();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Village_plant.PlantId= mainPacket[2];
		obj_Village_plant.VillageId= mainPacket[3];


		if (resultStatus == 1) {			
			UI_createVillage_plantRow(obj_Village_plant, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Village_plant_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingVillage_plantPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Village_plant; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteVillage_plantPacket(VillageId) {
	var deletePacketBody  = VillageId;

	var postpacket = createOutgoingVillage_plantPacket(202,deletePacketBody);
	Village_plant_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateVillage_plantPacket(obj_Village_plant) {
	var savePacketBody  = obj_Village_plant.createVillage_plantPacket();

	var postpacket = createOutgoingVillage_plantPacket(203,savePacketBody);
	Village_plant_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddVillage_plantPacket(dummyId,obj_Village_plant) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Village_plant.createVillage_plantPacket();

	var postpacket = createOutgoingVillage_plantPacket(201,savePacketBody);
	Village_plant_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onVillage_plantPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onVillage_plantPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addVillage_plant = document.getElementById("btnaddVillage_plant");
	if(addVillage_plant){
	addVillage_plant.addEventListener('mousedown', Event_mousedown_addVillage_plant, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popVillage_plantform = document.getElementById("popVillage_plantform");
	var inputElems = popVillage_plantform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiVillage_plantList = document.getElementById("Village_plantList");
	var liElems = UiVillage_plantList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverVillage_plantRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutVillage_plantRow, false);
		
	}
	
	var UiVillage_plantListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiVillage_plantListDeletebtns.length; z++) {
			UiVillage_plantListDeletebtns[z].addEventListener('mousedown', Event_mouseDownVillage_plantRowBtn, false);			
		
	}

	var searchBox = document.getElementById("searchtextbox");
	 if(searchBox){
	 searchBox.addEventListener('focus', Event_focusSearchBox, false);
     searchBox.addEventListener('blur', Event_blurSearchBox, false);
     searchBox.addEventListener('keyup', Event_keyupSearchBox, false);
    }
	
	global_autocomplete_elem[0] = new AutoComplete();
	global_autocomplete_elem[0].Open(0,"Input_PlantId","Name",32); //plant
	
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
	UI_search_Village_plant(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownVillage_plantRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Village_plant = Get_Village_plantByListRow(this.parentNode.parentNode);
			if(obj_Village_plant != ""){
				deleteVillage_plant(obj_Village_plant.VillageId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Village_plant = Get_Village_plantByListRow(this.parentNode.parentNode);
			if(obj_Village_plant != ""){
				UI_showUpdateVillage_plantForm(obj_Village_plant);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Village_plant(searchText)
{

	//Village_plantList = 
	var Village_plantListElem = document.getElementById("Village_plantList");
	
	if(Village_plantListElem)
	{
		var Village_plantDataList = Village_plantListElem.getElementsByTagName("input");
		for(var y=0 in Village_plantDataList)
		{
			if(Village_plantDataList[y])
			{
				
				
				var displayType = "none";
				var Village_plantData = Village_plantDataList[y].value;
				if(!((Village_plantData == "") || (typeof Village_plantData=="undefined")))
				{
				if(search_Village_plant(Village_plantData,searchText))
				{
					displayType = "block";
				}
				Village_plantDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Village_plant(Village_plantData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Village_plantData = decodeSpText(Village_plantData.toLowerCase());
	if(Village_plantData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Village_plant)
{
	if (obj_Village_plant.VillageId) {
		var fieldDataId = obj_Village_plant.VillageId;
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

function deleteVillage_plant(VillageId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Village_plant");
	if(flag){
			DeleteVillage_plantPacket(VillageId);
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

function Get_Village_plantByListRow(listRowElem)
{
	
	var obj_Village_plant ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Village_plantData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Village_plantData = elemlist[z].value;
			}		
		}
		
		if(Village_plantData != "")
		{
		var arrVillage_plantData = Village_plantData.split(";");	
		
		obj_Village_plant = new Village_plant();
		obj_Village_plant.PlantId= arrVillage_plantData[0];
		obj_Village_plant.VillageId= arrVillage_plantData[1];

		
		
		}
		
	}
	
	return obj_Village_plant;
	
	
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
	/*
	var iserror =false;
		var errorMsg = "";
	

		var Elem = document.getElementById("Input_Village_plantPrice");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "Please enter Village_plant price";
					Elem.focus();
				}				
				else if(isNaN(Elem.value))
				{
					Elem.value="";
					iserror =true;
					error = "Invalid price";	
					Elem.focus();		
				}
	
			}
			
		    Elem = document.getElementById("Input_Village_plantName");
			if(Elem)
			{
				if(Elem.value =="")
				{
				Elem.focus();
				iserror =true;
				error = "Please enter Village_plant name";	
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
	*/
	
	return false;
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_form_addbtn(event) {
	

	if(validate_form())
	{
	event.preventDefault();
	return false;
	}
	
		var obj_Village_plant = new Village_plant();
		
		var PlantId= document.getElementById("Input_PlantId").value;
		var VillageId= document.getElementById("Input_VillageId").value;

		
		document.getElementById("Input_PlantId").value="";
		document.getElementById("Input_VillageId").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Village_plant = new Village_plant();
		obj_Village_plant.PlantId= PlantId;
		obj_Village_plant.VillageId= VillageId;

		
		var dummyId = CreateDummyNumber();
		AddVillage_plantPacket(dummyId,obj_Village_plant);
		UI_createVillage_plantRow(obj_Village_plant, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Village_plant = new Village_plant();

		obj_Village_plant.PlantId= PlantId;
		obj_Village_plant.VillageId= VillageId;

		
		UpdateVillage_plantPacket(obj_Village_plant);
		UI_createVillage_plantRow(obj_Village_plant, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addVillage_plant() {
	
	UI_showAddVillage_plantForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddVillage_plantForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_plantAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_plantform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateVillage_plantForm(obj_Village_plant) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_plantUpdateForm(obj_Village_plant);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_plantform"));
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
function UI_prepareVillage_plantUpdateForm(obj_Village_plant)
{
	var arr_hidelist = new Array("Input_VillageId");
	var arr_showlist = new Array("Input_PlantId","Input_VillageId");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_PlantId").value=obj_Village_plant.PlantId;
		document.getElementById("Input_VillageId").value=obj_Village_plant.VillageId;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareVillage_plantAddForm()
{
	var arr_hidelist = new Array("Input_VillageId");
	var arr_showlist = new Array("Input_PlantId","Input_VillageId");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_PlantId").value="";
		document.getElementById("Input_VillageId").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addVillage_plantToVillage_plantList() {
	var uiVillage_plantList = document.getElementById("Village_plantList");

	var rowElems = uiVillage_plantList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_plantRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownVillage_plantRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_plantRowHtmlElem(obj_Village_plant,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Village_plantImg_"+obj_Village_plant.VillageId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Village_plant/0_small.png";
	else ImgElem.src = "Village_plant/"+obj_Village_plant.VillageId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Village_plant.PlantId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Village_plant.VillageId;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Village_plantdata"+ElemId);
		ElementDataHidden.value = obj_Village_plant.getVillage_plantData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);

		
		ElemLi= UI_createVillage_plantRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverVillage_plantRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutVillage_plantRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubVillage_plantHtmlElem(obj_Village_plant)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subVillage_plant");
		html ="<a href=\"?page=dashboard&VillageId="+obj_Village_plant.VillageId+"\">"+obj_Village_plant.VillageId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverVillage_plantRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutVillage_plantRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_plantRow(obj_Village_plant, rowType,dummyId) {
	var html = "";
	
	var UiVillage_plantList = document.getElementById("Village_plantList");
	var ClassName = "ListRow";
	var ElemId = "Village_plantListRow_"+obj_Village_plant.VillageId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyVillage_plantRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createVillage_plantRowHtmlElem(obj_Village_plant,ElemId, ClassName);
			UiVillage_plantList.insertBefore(ElemLi, UiVillage_plantList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Village_plant msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createVillage_plantRowHtmlElem(obj_Village_plant,ElemId, ClassName);
			UiVillage_plantList.insertBefore(ElemLi, UiVillage_plantList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyVillage_plantRow_"+dummyId);
			var DummyData = document.getElementById("Village_plantdataDummyVillage_plantRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Village_plantdata"+ElemId);		
				DummyData.value = obj_Village_plant.getVillage_plantData();		
				}
				UI_createTopbarSubVillage_plantHtmlElem(obj_Village_plant);
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
				var ElemLi = UI_createVillage_plantRowHtmlElem(obj_Village_plant,ElemId, ClassName);
				UiVillage_plantList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Village_plantList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, VillageId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("Village_plantListRow_"+VillageId);
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



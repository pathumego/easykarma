//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Village_geologicalvariation_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addVillage_geologicalvariation(mainPacket);
			break;
		}
		case 201: {
			ACK_addVillage_geologicalvariation(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteVillage_geologicalvariation(mainPacket);
			break;
		}
		case 203: {
			ACK_updateVillage_geologicalvariation(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addVillage_geologicalvariation(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Village_geologicalvariation = new Village_geologicalvariation();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Village_geologicalvariation.TblId= mainPacket[3];
		obj_Village_geologicalvariation.VillageId= mainPacket[4];
		obj_Village_geologicalvariation.Variation= mainPacket[5];
		obj_Village_geologicalvariation.Description= mainPacket[6];
		obj_Village_geologicalvariation.PrimaryGeoLayerTypeId= mainPacket[7];
		obj_Village_geologicalvariation.SoilTypeId= mainPacket[8];



		if (resultStatus == 1) {	
			
			UI_createVillage_geologicalvariationRow(obj_Village_geologicalvariation, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteVillage_geologicalvariation(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_geologicalvariation = new Village_geologicalvariation();
		
		var resultStatus = mainPacket[0];
		var TblId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Village_geologicalvariationListRow_"+TblId);
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
				var rowElem = document.getElementById("Village_geologicalvariationListRow_"+TblId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateVillage_geologicalvariation(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_geologicalvariation = new Village_geologicalvariation();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Village_geologicalvariation.TblId= mainPacket[2];
		obj_Village_geologicalvariation.VillageId= mainPacket[3];
		obj_Village_geologicalvariation.Variation= mainPacket[4];
		obj_Village_geologicalvariation.Description= mainPacket[5];
		obj_Village_geologicalvariation.PrimaryGeoLayerTypeId= mainPacket[6];
		obj_Village_geologicalvariation.SoilTypeId= mainPacket[7];


		if (resultStatus == 1) {			
			UI_createVillage_geologicalvariationRow(obj_Village_geologicalvariation, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Village_geologicalvariation_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingVillage_geologicalvariationPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Village_geologicalvariation; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteVillage_geologicalvariationPacket(TblId) {
	var deletePacketBody  = TblId;

	var postpacket = createOutgoingVillage_geologicalvariationPacket(202,deletePacketBody);
	Village_geologicalvariation_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateVillage_geologicalvariationPacket(obj_Village_geologicalvariation) {
	var savePacketBody  = obj_Village_geologicalvariation.createVillage_geologicalvariationPacket();

	var postpacket = createOutgoingVillage_geologicalvariationPacket(203,savePacketBody);
	Village_geologicalvariation_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddVillage_geologicalvariationPacket(dummyId,obj_Village_geologicalvariation) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Village_geologicalvariation.createVillage_geologicalvariationPacket();

	var postpacket = createOutgoingVillage_geologicalvariationPacket(201,savePacketBody);
	Village_geologicalvariation_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onVillage_geologicalvariationPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onVillage_geologicalvariationPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addVillage_geologicalvariation = document.getElementById("btnaddVillage_geologicalvariation");
	if(addVillage_geologicalvariation){
	addVillage_geologicalvariation.addEventListener('mousedown', Event_mousedown_addVillage_geologicalvariation, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popVillage_geologicalvariationform = document.getElementById("popVillage_geologicalvariationform");
	var inputElems = popVillage_geologicalvariationform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiVillage_geologicalvariationList = document.getElementById("Village_geologicalvariationList");
	var liElems = UiVillage_geologicalvariationList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverVillage_geologicalvariationRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutVillage_geologicalvariationRow, false);
		
	}
	
	var UiVillage_geologicalvariationListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiVillage_geologicalvariationListDeletebtns.length; z++) {
			UiVillage_geologicalvariationListDeletebtns[z].addEventListener('mousedown', Event_mouseDownVillage_geologicalvariationRowBtn, false);			
		
	}

	var searchBox = document.getElementById("searchtextbox");
	 if(searchBox){
	 searchBox.addEventListener('focus', Event_focusSearchBox, false);
     searchBox.addEventListener('blur', Event_blurSearchBox, false);
     searchBox.addEventListener('keyup', Event_keyupSearchBox, false);
    }
	
	global_autocomplete_elem[0] = new AutoComplete();
	global_autocomplete_elem[0].Open(0,"Input_PrimaryGeoLayerTypeId","PrimaryGeoLayerName",33); //geolayer
	
	global_autocomplete_elem[1] = new AutoComplete();
	global_autocomplete_elem[1].Open(1,"Input_SoilTypeId","SoilTypeName",39); //soil type
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
	UI_search_Village_geologicalvariation(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownVillage_geologicalvariationRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Village_geologicalvariation = Get_Village_geologicalvariationByListRow(this.parentNode.parentNode);
			if(obj_Village_geologicalvariation != ""){
				deleteVillage_geologicalvariation(obj_Village_geologicalvariation.TblId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Village_geologicalvariation = Get_Village_geologicalvariationByListRow(this.parentNode.parentNode);
			if(obj_Village_geologicalvariation != ""){
				UI_showUpdateVillage_geologicalvariationForm(obj_Village_geologicalvariation);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Village_geologicalvariation(searchText)
{

	//Village_geologicalvariationList = 
	var Village_geologicalvariationListElem = document.getElementById("Village_geologicalvariationList");
	
	if(Village_geologicalvariationListElem)
	{
		var Village_geologicalvariationDataList = Village_geologicalvariationListElem.getElementsByTagName("input");
		for(var y=0 in Village_geologicalvariationDataList)
		{
			if(Village_geologicalvariationDataList[y])
			{
				
				
				var displayType = "none";
				var Village_geologicalvariationData = Village_geologicalvariationDataList[y].value;
				if(!((Village_geologicalvariationData == "") || (typeof Village_geologicalvariationData=="undefined")))
				{
				if(search_Village_geologicalvariation(Village_geologicalvariationData,searchText))
				{
					displayType = "block";
				}
				Village_geologicalvariationDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Village_geologicalvariation(Village_geologicalvariationData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Village_geologicalvariationData = decodeSpText(Village_geologicalvariationData.toLowerCase());
	if(Village_geologicalvariationData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Village_geologicalvariation)
{
	if (obj_Village_geologicalvariation.TblId) {
		var fieldDataId = obj_Village_geologicalvariation.TblId;
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

function deleteVillage_geologicalvariation(TblId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Village_geologicalvariation");
	if(flag){
			DeleteVillage_geologicalvariationPacket(TblId);
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

function Get_Village_geologicalvariationByListRow(listRowElem)
{
	
	var obj_Village_geologicalvariation ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Village_geologicalvariationData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Village_geologicalvariationData = elemlist[z].value;
			}		
		}
		
		if(Village_geologicalvariationData != "")
		{
		var arrVillage_geologicalvariationData = Village_geologicalvariationData.split(";");	
		
		obj_Village_geologicalvariation = new Village_geologicalvariation();
		obj_Village_geologicalvariation.TblId= arrVillage_geologicalvariationData[0];
		obj_Village_geologicalvariation.VillageId= arrVillage_geologicalvariationData[1];
		obj_Village_geologicalvariation.Variation= arrVillage_geologicalvariationData[2];
		obj_Village_geologicalvariation.Description= arrVillage_geologicalvariationData[3];
		obj_Village_geologicalvariation.PrimaryGeoLayerTypeId= arrVillage_geologicalvariationData[4];
		obj_Village_geologicalvariation.SoilTypeId= arrVillage_geologicalvariationData[5];

		
		
		}
		
	}
	
	return obj_Village_geologicalvariation;
	
	
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
	
var Elem = document.getElementById("Input_Variation");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "Please enter Variation";
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
	
		var obj_Village_geologicalvariation = new Village_geologicalvariation();
		
		var TblId= document.getElementById("Input_TblId").value;
		var VillageId= document.getElementById("Input_VillageId").value;
		var Variation= document.getElementById("Input_Variation").value;
		var Description= document.getElementById("Input_Description").value;
		var PrimaryGeoLayerTypeId= document.getElementById("Input_PrimaryGeoLayerTypeId").value;
		var SoilTypeId= document.getElementById("Input_SoilTypeId").value;

		
		document.getElementById("Input_TblId").value="";
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_Variation").value="";
		document.getElementById("Input_Description").value="";
		document.getElementById("Input_PrimaryGeoLayerTypeId").value="";
		document.getElementById("Input_SoilTypeId").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Village_geologicalvariation = new Village_geologicalvariation();
		obj_Village_geologicalvariation.TblId= TblId;
		obj_Village_geologicalvariation.VillageId= VillageId;
		obj_Village_geologicalvariation.Variation= Variation;
		obj_Village_geologicalvariation.Description= Description;
		obj_Village_geologicalvariation.PrimaryGeoLayerTypeId= PrimaryGeoLayerTypeId;
		obj_Village_geologicalvariation.SoilTypeId= SoilTypeId;

		
		var dummyId = CreateDummyNumber();
		AddVillage_geologicalvariationPacket(dummyId,obj_Village_geologicalvariation);
		UI_createVillage_geologicalvariationRow(obj_Village_geologicalvariation, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Village_geologicalvariation = new Village_geologicalvariation();

		obj_Village_geologicalvariation.TblId= TblId;
		obj_Village_geologicalvariation.VillageId= VillageId;
		obj_Village_geologicalvariation.Variation= Variation;
		obj_Village_geologicalvariation.Description= Description;
		obj_Village_geologicalvariation.PrimaryGeoLayerTypeId= PrimaryGeoLayerTypeId;
		obj_Village_geologicalvariation.SoilTypeId= SoilTypeId;

		
		UpdateVillage_geologicalvariationPacket(obj_Village_geologicalvariation);
		UI_createVillage_geologicalvariationRow(obj_Village_geologicalvariation, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addVillage_geologicalvariation() {
	
	UI_showAddVillage_geologicalvariationForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddVillage_geologicalvariationForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_geologicalvariationAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_geologicalvariationform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateVillage_geologicalvariationForm(obj_Village_geologicalvariation) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_geologicalvariationUpdateForm(obj_Village_geologicalvariation);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_geologicalvariationform"));
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
function UI_prepareVillage_geologicalvariationUpdateForm(obj_Village_geologicalvariation)
{
	var arr_hidelist = new Array("Input_TblId","Input_TblId","Input_VillageId","Input_PrimaryGeoLayerTypeId","Input_SoilTypeId");
	var arr_showlist = new Array("Input_Variation","Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_TblId").value=obj_Village_geologicalvariation.TblId;
		document.getElementById("Input_VillageId").value=obj_Village_geologicalvariation.VillageId;
		document.getElementById("Input_Variation").value=obj_Village_geologicalvariation.Variation;
		document.getElementById("Input_Description").value=obj_Village_geologicalvariation.Description;
		document.getElementById("Input_PrimaryGeoLayerTypeId").value=obj_Village_geologicalvariation.PrimaryGeoLayerTypeId;
		document.getElementById("Input_SoilTypeId").value=obj_Village_geologicalvariation.SoilTypeId;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareVillage_geologicalvariationAddForm()
{
	var arr_hidelist = new Array("Input_TblId","Input_TblId","Input_VillageId","Input_PrimaryGeoLayerTypeId","Input_SoilTypeId");
	var arr_showlist = new Array("Input_Variation","Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_TblId").value="";
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_Variation").value="";
		document.getElementById("Input_Description").value="";
		document.getElementById("Input_PrimaryGeoLayerTypeId").value="";
		document.getElementById("Input_SoilTypeId").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addVillage_geologicalvariationToVillage_geologicalvariationList() {
	var uiVillage_geologicalvariationList = document.getElementById("Village_geologicalvariationList");

	var rowElems = uiVillage_geologicalvariationList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_geologicalvariationRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownVillage_geologicalvariationRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_geologicalvariationRowHtmlElem(obj_Village_geologicalvariation,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Village_geologicalvariationImg_"+obj_Village_geologicalvariation.TblId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Village_geologicalvariation/0_small.png";
	else ImgElem.src = "Village_geologicalvariation/"+obj_Village_geologicalvariation.TblId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Village_geologicalvariation.TblId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Village_geologicalvariation.VillageId;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Village_geologicalvariation.Variation;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Village_geologicalvariation.Description;
		var ElemDataRow6 = document.createElement("div");
		ElemDataRow6.className ="datarow";
		ElemDataRow6.innerHTML = obj_Village_geologicalvariation.PrimaryGeoLayerTypeId;
		var ElemDataRow7 = document.createElement("div");
		ElemDataRow7.className ="datarow";
		ElemDataRow7.innerHTML = obj_Village_geologicalvariation.SoilTypeId;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Village_geologicalvariationdata"+ElemId);
		ElementDataHidden.value = obj_Village_geologicalvariation.getVillage_geologicalvariationData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);
		ElemLi.appendChild(ElemDataRow6);
		ElemLi.appendChild(ElemDataRow7);

		
		ElemLi= UI_createVillage_geologicalvariationRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverVillage_geologicalvariationRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutVillage_geologicalvariationRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubVillage_geologicalvariationHtmlElem(obj_Village_geologicalvariation)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subVillage_geologicalvariation");
		html ="<a href=\"?page=dashboard&TblId="+obj_Village_geologicalvariation.TblId+"\">"+obj_Village_geologicalvariation.TblId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverVillage_geologicalvariationRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutVillage_geologicalvariationRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_geologicalvariationRow(obj_Village_geologicalvariation, rowType,dummyId) {
	var html = "";
	
	var UiVillage_geologicalvariationList = document.getElementById("Village_geologicalvariationList");
	var ClassName = "ListRow";
	var ElemId = "Village_geologicalvariationListRow_"+obj_Village_geologicalvariation.TblId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyVillage_geologicalvariationRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createVillage_geologicalvariationRowHtmlElem(obj_Village_geologicalvariation,ElemId, ClassName);
			UiVillage_geologicalvariationList.insertBefore(ElemLi, UiVillage_geologicalvariationList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Village_geologicalvariation msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createVillage_geologicalvariationRowHtmlElem(obj_Village_geologicalvariation,ElemId, ClassName);
			UiVillage_geologicalvariationList.insertBefore(ElemLi, UiVillage_geologicalvariationList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyVillage_geologicalvariationRow_"+dummyId);
			var DummyData = document.getElementById("Village_geologicalvariationdataDummyVillage_geologicalvariationRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Village_geologicalvariationdata"+ElemId);		
				DummyData.value = obj_Village_geologicalvariation.getVillage_geologicalvariationData();		
				}
				UI_createTopbarSubVillage_geologicalvariationHtmlElem(obj_Village_geologicalvariation);
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
				var ElemLi = UI_createVillage_geologicalvariationRowHtmlElem(obj_Village_geologicalvariation,ElemId, ClassName);
				UiVillage_geologicalvariationList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Village_geologicalvariationList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, TblId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("Village_geologicalvariationListRow_"+TblId);
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



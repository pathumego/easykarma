//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Village_traditionalknowledge_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addVillage_traditionalknowledge(mainPacket);
			break;
		}
		case 201: {
			ACK_addVillage_traditionalknowledge(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteVillage_traditionalknowledge(mainPacket);
			break;
		}
		case 203: {
			ACK_updateVillage_traditionalknowledge(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addVillage_traditionalknowledge(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Village_traditionalknowledge = new Village_traditionalknowledge();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Village_traditionalknowledge.TblId= mainPacket[3];
		obj_Village_traditionalknowledge.VillageId= mainPacket[4];
		obj_Village_traditionalknowledge.TraditionalKnowledgeCategoryID= mainPacket[5];
		obj_Village_traditionalknowledge.Discription= mainPacket[6];



		if (resultStatus == 1) {	
			
			UI_createVillage_traditionalknowledgeRow(obj_Village_traditionalknowledge, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteVillage_traditionalknowledge(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_traditionalknowledge = new Village_traditionalknowledge();
		
		var resultStatus = mainPacket[0];
		var TblId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Village_traditionalknowledgeListRow_"+TblId);
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
				var rowElem = document.getElementById("Village_traditionalknowledgeListRow_"+TblId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateVillage_traditionalknowledge(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_traditionalknowledge = new Village_traditionalknowledge();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Village_traditionalknowledge.TblId= mainPacket[2];
		obj_Village_traditionalknowledge.VillageId= mainPacket[3];
		obj_Village_traditionalknowledge.TraditionalKnowledgeCategoryID= mainPacket[4];
		obj_Village_traditionalknowledge.Discription= mainPacket[5];


		if (resultStatus == 1) {			
			UI_createVillage_traditionalknowledgeRow(obj_Village_traditionalknowledge, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Village_traditionalknowledge_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingVillage_traditionalknowledgePacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Village_traditionalknowledge; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteVillage_traditionalknowledgePacket(TblId) {
	var deletePacketBody  = TblId;

	var postpacket = createOutgoingVillage_traditionalknowledgePacket(202,deletePacketBody);
	Village_traditionalknowledge_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateVillage_traditionalknowledgePacket(obj_Village_traditionalknowledge) {
	var savePacketBody  = obj_Village_traditionalknowledge.createVillage_traditionalknowledgePacket();

	var postpacket = createOutgoingVillage_traditionalknowledgePacket(203,savePacketBody);
	Village_traditionalknowledge_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddVillage_traditionalknowledgePacket(dummyId,obj_Village_traditionalknowledge) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Village_traditionalknowledge.createVillage_traditionalknowledgePacket();

	var postpacket = createOutgoingVillage_traditionalknowledgePacket(201,savePacketBody);
	Village_traditionalknowledge_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onVillage_traditionalknowledgePageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onVillage_traditionalknowledgePageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addVillage_traditionalknowledge = document.getElementById("btnaddVillage_traditionalknowledge");
	if(addVillage_traditionalknowledge){
	addVillage_traditionalknowledge.addEventListener('mousedown', Event_mousedown_addVillage_traditionalknowledge, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popVillage_traditionalknowledgeform = document.getElementById("popVillage_traditionalknowledgeform");
	var inputElems = popVillage_traditionalknowledgeform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiVillage_traditionalknowledgeList = document.getElementById("Village_traditionalknowledgeList");
	var liElems = UiVillage_traditionalknowledgeList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverVillage_traditionalknowledgeRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutVillage_traditionalknowledgeRow, false);
		
	}
	
	var UiVillage_traditionalknowledgeListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiVillage_traditionalknowledgeListDeletebtns.length; z++) {
			UiVillage_traditionalknowledgeListDeletebtns[z].addEventListener('mousedown', Event_mouseDownVillage_traditionalknowledgeRowBtn, false);			
		
	}

	var searchBox = document.getElementById("searchtextbox");
	 if(searchBox){
	 searchBox.addEventListener('focus', Event_focusSearchBox, false);
     searchBox.addEventListener('blur', Event_blurSearchBox, false);
     searchBox.addEventListener('keyup', Event_keyupSearchBox, false);
    }
	
		global_autocomplete_elem[0] = new AutoComplete();
	global_autocomplete_elem[0].Open(0,"Input_TraditionalKnowledgeCategoryID","CategoryName",43); //category
	
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
	UI_search_Village_traditionalknowledge(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownVillage_traditionalknowledgeRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Village_traditionalknowledge = Get_Village_traditionalknowledgeByListRow(this.parentNode.parentNode);
			if(obj_Village_traditionalknowledge != ""){
				deleteVillage_traditionalknowledge(obj_Village_traditionalknowledge.TblId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Village_traditionalknowledge = Get_Village_traditionalknowledgeByListRow(this.parentNode.parentNode);
			if(obj_Village_traditionalknowledge != ""){
				UI_showUpdateVillage_traditionalknowledgeForm(obj_Village_traditionalknowledge);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Village_traditionalknowledge(searchText)
{

	//Village_traditionalknowledgeList = 
	var Village_traditionalknowledgeListElem = document.getElementById("Village_traditionalknowledgeList");
	
	if(Village_traditionalknowledgeListElem)
	{
		var Village_traditionalknowledgeDataList = Village_traditionalknowledgeListElem.getElementsByTagName("input");
		for(var y=0 in Village_traditionalknowledgeDataList)
		{
			if(Village_traditionalknowledgeDataList[y])
			{
				
				
				var displayType = "none";
				var Village_traditionalknowledgeData = Village_traditionalknowledgeDataList[y].value;
				if(!((Village_traditionalknowledgeData == "") || (typeof Village_traditionalknowledgeData=="undefined")))
				{
				if(search_Village_traditionalknowledge(Village_traditionalknowledgeData,searchText))
				{
					displayType = "block";
				}
				Village_traditionalknowledgeDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Village_traditionalknowledge(Village_traditionalknowledgeData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Village_traditionalknowledgeData = decodeSpText(Village_traditionalknowledgeData.toLowerCase());
	if(Village_traditionalknowledgeData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Village_traditionalknowledge)
{
	if (obj_Village_traditionalknowledge.TblId) {
		var fieldDataId = obj_Village_traditionalknowledge.TblId;
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

function deleteVillage_traditionalknowledge(TblId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Village_traditionalknowledge");
	if(flag){
			DeleteVillage_traditionalknowledgePacket(TblId);
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

function Get_Village_traditionalknowledgeByListRow(listRowElem)
{
	
	var obj_Village_traditionalknowledge ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Village_traditionalknowledgeData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Village_traditionalknowledgeData = elemlist[z].value;
			}		
		}
		
		if(Village_traditionalknowledgeData != "")
		{
		var arrVillage_traditionalknowledgeData = Village_traditionalknowledgeData.split(";");	
		
		obj_Village_traditionalknowledge = new Village_traditionalknowledge();
		obj_Village_traditionalknowledge.TblId= arrVillage_traditionalknowledgeData[0];
		obj_Village_traditionalknowledge.VillageId= arrVillage_traditionalknowledgeData[1];
		obj_Village_traditionalknowledge.TraditionalKnowledgeCategoryID= arrVillage_traditionalknowledgeData[2];
		obj_Village_traditionalknowledge.Discription= arrVillage_traditionalknowledgeData[3];

		
		
		}
		
	}
	
	return obj_Village_traditionalknowledge;
	
	
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
	

	var Elem = document.getElementById("Input_Discription");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "Please describe";
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
	
		var obj_Village_traditionalknowledge = new Village_traditionalknowledge();
		
		var TblId= document.getElementById("Input_TblId").value;
		var VillageId= document.getElementById("Input_VillageId").value;
		var TraditionalKnowledgeCategoryID= document.getElementById("Input_TraditionalKnowledgeCategoryID").value;
		var Discription= document.getElementById("Input_Discription").value;

		
		document.getElementById("Input_TblId").value="";
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_TraditionalKnowledgeCategoryID").value="";
		document.getElementById("Input_Discription").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Village_traditionalknowledge = new Village_traditionalknowledge();
		obj_Village_traditionalknowledge.TblId= TblId;
		obj_Village_traditionalknowledge.VillageId= VillageId;
		obj_Village_traditionalknowledge.TraditionalKnowledgeCategoryID= TraditionalKnowledgeCategoryID;
		obj_Village_traditionalknowledge.Discription= Discription;

		
		var dummyId = CreateDummyNumber();
		AddVillage_traditionalknowledgePacket(dummyId,obj_Village_traditionalknowledge);
		UI_createVillage_traditionalknowledgeRow(obj_Village_traditionalknowledge, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Village_traditionalknowledge = new Village_traditionalknowledge();

		obj_Village_traditionalknowledge.TblId= TblId;
		obj_Village_traditionalknowledge.VillageId= VillageId;
		obj_Village_traditionalknowledge.TraditionalKnowledgeCategoryID= TraditionalKnowledgeCategoryID;
		obj_Village_traditionalknowledge.Discription= Discription;

		
		UpdateVillage_traditionalknowledgePacket(obj_Village_traditionalknowledge);
		UI_createVillage_traditionalknowledgeRow(obj_Village_traditionalknowledge, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addVillage_traditionalknowledge() {
	
	UI_showAddVillage_traditionalknowledgeForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddVillage_traditionalknowledgeForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_traditionalknowledgeAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_traditionalknowledgeform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateVillage_traditionalknowledgeForm(obj_Village_traditionalknowledge) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_traditionalknowledgeUpdateForm(obj_Village_traditionalknowledge);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_traditionalknowledgeform"));
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
function UI_prepareVillage_traditionalknowledgeUpdateForm(obj_Village_traditionalknowledge)
{
	var arr_hidelist = new Array("Input_TblId","Input_VillageId","Input_TraditionalKnowledgeCategoryID");
	var arr_showlist = new Array("Input_Discription");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_TblId").value=obj_Village_traditionalknowledge.TblId;
		document.getElementById("Input_VillageId").value=obj_Village_traditionalknowledge.VillageId;
		document.getElementById("Input_TraditionalKnowledgeCategoryID").value=obj_Village_traditionalknowledge.TraditionalKnowledgeCategoryID;
		document.getElementById("Input_Discription").value=obj_Village_traditionalknowledge.Discription;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareVillage_traditionalknowledgeAddForm()
{
	var arr_hidelist = new Array("Input_TblId","Input_VillageId","Input_TraditionalKnowledgeCategoryID");
	var arr_showlist = new Array("Input_Discription");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_TblId").value="";
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_TraditionalKnowledgeCategoryID").value="";
		document.getElementById("Input_Discription").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addVillage_traditionalknowledgeToVillage_traditionalknowledgeList() {
	var uiVillage_traditionalknowledgeList = document.getElementById("Village_traditionalknowledgeList");

	var rowElems = uiVillage_traditionalknowledgeList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_traditionalknowledgeRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownVillage_traditionalknowledgeRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_traditionalknowledgeRowHtmlElem(obj_Village_traditionalknowledge,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Village_traditionalknowledgeImg_"+obj_Village_traditionalknowledge.TblId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Village_traditionalknowledge/0_small.png";
	else ImgElem.src = "Village_traditionalknowledge/"+obj_Village_traditionalknowledge.TblId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Village_traditionalknowledge.TblId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Village_traditionalknowledge.VillageId;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Village_traditionalknowledge.TraditionalKnowledgeCategoryID;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Village_traditionalknowledge.Discription;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Village_traditionalknowledgedata"+ElemId);
		ElementDataHidden.value = obj_Village_traditionalknowledge.getVillage_traditionalknowledgeData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);

		
		ElemLi= UI_createVillage_traditionalknowledgeRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverVillage_traditionalknowledgeRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutVillage_traditionalknowledgeRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubVillage_traditionalknowledgeHtmlElem(obj_Village_traditionalknowledge)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subVillage_traditionalknowledge");
		html ="<a href=\"?page=dashboard&TblId="+obj_Village_traditionalknowledge.TblId+"\">"+obj_Village_traditionalknowledge.TblId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverVillage_traditionalknowledgeRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutVillage_traditionalknowledgeRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_traditionalknowledgeRow(obj_Village_traditionalknowledge, rowType,dummyId) {
	var html = "";
	
	var UiVillage_traditionalknowledgeList = document.getElementById("Village_traditionalknowledgeList");
	var ClassName = "ListRow";
	var ElemId = "Village_traditionalknowledgeListRow_"+obj_Village_traditionalknowledge.TblId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyVillage_traditionalknowledgeRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createVillage_traditionalknowledgeRowHtmlElem(obj_Village_traditionalknowledge,ElemId, ClassName);
			UiVillage_traditionalknowledgeList.insertBefore(ElemLi, UiVillage_traditionalknowledgeList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Village_traditionalknowledge msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createVillage_traditionalknowledgeRowHtmlElem(obj_Village_traditionalknowledge,ElemId, ClassName);
			UiVillage_traditionalknowledgeList.insertBefore(ElemLi, UiVillage_traditionalknowledgeList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyVillage_traditionalknowledgeRow_"+dummyId);
			var DummyData = document.getElementById("Village_traditionalknowledgedataDummyVillage_traditionalknowledgeRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Village_traditionalknowledgedata"+ElemId);		
				DummyData.value = obj_Village_traditionalknowledge.getVillage_traditionalknowledgeData();		
				}
				UI_createTopbarSubVillage_traditionalknowledgeHtmlElem(obj_Village_traditionalknowledge);
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
				var ElemLi = UI_createVillage_traditionalknowledgeRowHtmlElem(obj_Village_traditionalknowledge,ElemId, ClassName);
				UiVillage_traditionalknowledgeList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Village_traditionalknowledgeList");
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
		var profileAvatar = document.getElementById("Village_traditionalknowledgeListRow_"+TblId);
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



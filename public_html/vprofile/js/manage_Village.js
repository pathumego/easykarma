//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Village_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addVillage(mainPacket);
			break;
		}
		case 201: {
			ACK_addVillage(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteVillage(mainPacket);
			break;
		}
		case 203: {
			ACK_updateVillage(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addVillage(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Village = new Village();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Village.VillageId= mainPacket[3];
		obj_Village.Name= mainPacket[4];
		obj_Village.VillageNumber= mainPacket[5];
		obj_Village.AgaDevision= mainPacket[6];
		obj_Village.District= mainPacket[7];
		obj_Village.Province= mainPacket[8];
		obj_Village.GeogrophyTypeId= mainPacket[9];
		obj_Village.ForestTypeId= mainPacket[10];
		obj_Village.ForestDescription= mainPacket[11];
		obj_Village.TraditionalKnowledge= mainPacket[12];



		if (resultStatus == 1) {	
			
			UI_createVillageRow(obj_Village, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteVillage(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village = new Village();
		
		var resultStatus = mainPacket[0];
		var VillageId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("VillageListRow_"+VillageId);
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
				var rowElem = document.getElementById("VillageListRow_"+VillageId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateVillage(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village = new Village();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Village.VillageId= mainPacket[2];
		obj_Village.Name= mainPacket[3];
		obj_Village.VillageNumber= mainPacket[4];
		obj_Village.AgaDevision= mainPacket[5];
		obj_Village.District= mainPacket[6];
		obj_Village.Province= mainPacket[7];
		obj_Village.GeogrophyTypeId= mainPacket[8];
		obj_Village.ForestTypeId= mainPacket[9];
		obj_Village.ForestDescription= mainPacket[10];
		obj_Village.TraditionalKnowledge= mainPacket[11];


		if (resultStatus == 1) {			
			UI_createVillageRow(obj_Village, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Village_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingVillagePacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Village; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteVillagePacket(VillageId) {
	var deletePacketBody  = VillageId;

	var postpacket = createOutgoingVillagePacket(202,deletePacketBody);
	Village_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateVillagePacket(obj_Village) {
	var savePacketBody  = obj_Village.createVillagePacket();

	var postpacket = createOutgoingVillagePacket(203,savePacketBody);
	Village_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddVillagePacket(dummyId,obj_Village) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Village.createVillagePacket();

	var postpacket = createOutgoingVillagePacket(201,savePacketBody);
	Village_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onVillagePageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onVillagePageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addVillage = document.getElementById("btnaddVillage");
	if(addVillage){
	addVillage.addEventListener('mousedown', Event_mousedown_addVillage, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popVillageform = document.getElementById("popVillageform");
	var inputElems = popVillageform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiVillageList = document.getElementById("VillageList");
	var liElems = UiVillageList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverVillageRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutVillageRow, false);
		
	}
	
	var UiVillageListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiVillageListDeletebtns.length; z++) {
			UiVillageListDeletebtns[z].addEventListener('mousedown', Event_mouseDownVillageRowBtn, false);			
		
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
	UI_search_Village(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownVillageRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Village = Get_VillageByListRow(this.parentNode.parentNode);
			if(obj_Village != ""){
				deleteVillage(obj_Village.VillageId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Village = Get_VillageByListRow(this.parentNode.parentNode);
			if(obj_Village != ""){
				UI_showUpdateVillageForm(obj_Village);
				
			}		
			
			break;
		}
		case "select":
		{
			var obj_Village = Get_VillageByListRow(this.parentNode.parentNode);
			if(obj_Village != ""){
				var newWindow = window.open("?page=villagedashboard&villageid="+obj_Village.VillageId);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Village(searchText)
{

	//VillageList = 
	var VillageListElem = document.getElementById("VillageList");
	
	if(VillageListElem)
	{
		var VillageDataList = VillageListElem.getElementsByTagName("input");
		for(var y=0 in VillageDataList)
		{
			if(VillageDataList[y])
			{
				
				
				var displayType = "none";
				var VillageData = VillageDataList[y].value;
				if(!((VillageData == "") || (typeof VillageData=="undefined")))
				{
				if(search_Village(VillageData,searchText))
				{
					displayType = "block";
				}
				VillageDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Village(VillageData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	VillageData = decodeSpText(VillageData.toLowerCase());
	if(VillageData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Village)
{
	if (obj_Village.VillageId) {
		var fieldDataId = obj_Village.VillageId;
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

function deleteVillage(VillageId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Village");
	if(flag){
			DeleteVillagePacket(VillageId);
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

function Get_VillageByListRow(listRowElem)
{
	
	var obj_Village ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var VillageData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				VillageData = elemlist[z].value;
			}		
		}
		
		if(VillageData != "")
		{
		var arrVillageData = VillageData.split(";");	
		
		obj_Village = new Village();
		obj_Village.VillageId= arrVillageData[0];
		obj_Village.Name= arrVillageData[1];
		obj_Village.VillageNumber= arrVillageData[2];
		obj_Village.AgaDevision= arrVillageData[3];
		obj_Village.District= arrVillageData[4];
		obj_Village.Province= arrVillageData[5];
		obj_Village.GeogrophyTypeId= arrVillageData[6];
		obj_Village.ForestTypeId= arrVillageData[7];
		obj_Village.ForestDescription= arrVillageData[8];
		obj_Village.TraditionalKnowledge= arrVillageData[9];

		
		
		}
		
	}
	
	return obj_Village;
	
	
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
	
		var obj_Village = new Village();
		
		var VillageId= document.getElementById("Input_VillageId").value;
		var Name= document.getElementById("Input_Name").value;
		var VillageNumber= document.getElementById("Input_VillageNumber").value;
		var AgaDevision= document.getElementById("Input_AgaDevision").value;
		var District= document.getElementById("Input_District").value;
		var Province= document.getElementById("Input_Province").value;
		var GeogrophyTypeId= document.getElementById("Input_GeogrophyTypeId").value;
		var ForestTypeId= document.getElementById("Input_ForestTypeId").value;
		var ForestDescription= document.getElementById("Input_ForestDescription").value;
		var TraditionalKnowledge= document.getElementById("Input_TraditionalKnowledge").value;

		
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_Name").value="";
		document.getElementById("Input_VillageNumber").value="";
		document.getElementById("Input_AgaDevision").value="";
		document.getElementById("Input_District").value="";
		document.getElementById("Input_Province").value="";
		document.getElementById("Input_GeogrophyTypeId").value="";
		document.getElementById("Input_ForestTypeId").value="";
		document.getElementById("Input_ForestDescription").value="";
		document.getElementById("Input_TraditionalKnowledge").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Village = new Village();
		obj_Village.VillageId= VillageId;
		obj_Village.Name= Name;
		obj_Village.VillageNumber= VillageNumber;
		obj_Village.AgaDevision= AgaDevision;
		obj_Village.District= District;
		obj_Village.Province= Province;
		obj_Village.GeogrophyTypeId= GeogrophyTypeId;
		obj_Village.ForestTypeId= ForestTypeId;
		obj_Village.ForestDescription= ForestDescription;
		obj_Village.TraditionalKnowledge= TraditionalKnowledge;

		
		var dummyId = CreateDummyNumber();
		AddVillagePacket(dummyId,obj_Village);
		UI_createVillageRow(obj_Village, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Village = new Village();

		obj_Village.VillageId= VillageId;
		obj_Village.Name= Name;
		obj_Village.VillageNumber= VillageNumber;
		obj_Village.AgaDevision= AgaDevision;
		obj_Village.District= District;
		obj_Village.Province= Province;
		obj_Village.GeogrophyTypeId= GeogrophyTypeId;
		obj_Village.ForestTypeId= ForestTypeId;
		obj_Village.ForestDescription= ForestDescription;
		obj_Village.TraditionalKnowledge= TraditionalKnowledge;

		
		UpdateVillagePacket(obj_Village);
		UI_createVillageRow(obj_Village, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addVillage() {
	
	UI_showAddVillageForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddVillageForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillageAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillageform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateVillageForm(obj_Village) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillageUpdateForm(obj_Village);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillageform"));
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
function UI_prepareVillageUpdateForm(obj_Village)
{
	var arr_hidelist = new Array("Input_VillageId");
	var arr_showlist = new Array("Input_Name","Input_VillageNumber","Input_AgaDevision","Input_District","Input_Province","Input_ForestDescription","Input_TraditionalKnowledge","Input_GeogrophyTypeId","Input_ForestTypeId");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_VillageId").value=obj_Village.VillageId;
		document.getElementById("Input_Name").value=obj_Village.Name;
		document.getElementById("Input_VillageNumber").value=obj_Village.VillageNumber;
		document.getElementById("Input_AgaDevision").value=obj_Village.AgaDevision;
		document.getElementById("Input_District").value=obj_Village.District;
		document.getElementById("Input_Province").value=obj_Village.Province;
		document.getElementById("Input_GeogrophyTypeId").value=obj_Village.GeogrophyTypeId;
		document.getElementById("Input_ForestTypeId").value=obj_Village.ForestTypeId;
		document.getElementById("Input_ForestDescription").value=obj_Village.ForestDescription;
		document.getElementById("Input_TraditionalKnowledge").value=obj_Village.TraditionalKnowledge;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareVillageAddForm()
{
	var arr_hidelist = new Array("Input_VillageId");
	var arr_showlist = new Array("Input_Name","Input_VillageNumber","Input_AgaDevision","Input_District","Input_Province","Input_ForestDescription","Input_TraditionalKnowledge","Input_GeogrophyTypeId","Input_ForestTypeId");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_Name").value="";
		document.getElementById("Input_VillageNumber").value="";
		document.getElementById("Input_AgaDevision").value="";
		document.getElementById("Input_District").value="";
		document.getElementById("Input_Province").value="";
		document.getElementById("Input_GeogrophyTypeId").value="";
		document.getElementById("Input_ForestTypeId").value="";
		document.getElementById("Input_ForestDescription").value="";
		document.getElementById("Input_TraditionalKnowledge").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addVillageToVillageList() {
	var uiVillageList = document.getElementById("VillageList");

	var rowElems = uiVillageList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createVillageRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownVillageRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillageRowHtmlElem(obj_Village,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "VillageImg_"+obj_Village.VillageId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Village/0_small.png";
	else ImgElem.src = "Village/"+obj_Village.VillageId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow datarow_village_personid";
		ElemDataRow2.innerHTML = obj_Village.VillageId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow datarow_village_name";
		ElemDataRow3.innerHTML = obj_Village.Name;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow datarow_village_number";
		ElemDataRow4.innerHTML = obj_Village.VillageNumber;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Village.AgaDevision;
		var ElemDataRow6 = document.createElement("div");
		ElemDataRow6.className ="datarow datarow_village_district";
		ElemDataRow6.innerHTML = obj_Village.District;
		var ElemDataRow7 = document.createElement("div");
		ElemDataRow7.className ="datarow";
		ElemDataRow7.innerHTML = obj_Village.Province;
		var ElemDataRow8 = document.createElement("div");
		ElemDataRow8.className ="datarow";
		ElemDataRow8.innerHTML = obj_Village.GeogrophyTypeId;
		var ElemDataRow9 = document.createElement("div");
		ElemDataRow9.className ="datarow";
		ElemDataRow9.innerHTML = obj_Village.ForestTypeId;
		var ElemDataRow10 = document.createElement("div");
		ElemDataRow10.className ="datarow";
		ElemDataRow10.innerHTML = obj_Village.ForestDescription;
		var ElemDataRow11 = document.createElement("div");
		ElemDataRow11.className ="datarow";
		ElemDataRow11.innerHTML = obj_Village.TraditionalKnowledge;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Villagedata"+ElemId);
		ElementDataHidden.value = obj_Village.getVillageData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		//ElemLi.appendChild(ElemDataRow5);
		ElemLi.appendChild(ElemDataRow6);
		/*ElemLi.appendChild(ElemDataRow7);
		ElemLi.appendChild(ElemDataRow8);
		ElemLi.appendChild(ElemDataRow9);
		ElemLi.appendChild(ElemDataRow10);
		ElemLi.appendChild(ElemDataRow11);
*/
		
		ElemLi= UI_createVillageRowHtmlButtonRow(ElemLi,new Array("Select","Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverVillageRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutVillageRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubVillageHtmlElem(obj_Village)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subVillage");
		html ="<a href=\"?page=dashboard&VillageId="+obj_Village.VillageId+"\">"+obj_Village.VillageId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverVillageRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutVillageRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillageRow(obj_Village, rowType,dummyId) {
	var html = "";
	
	var UiVillageList = document.getElementById("VillageList");
	var ClassName = "ListRow";
	var ElemId = "VillageListRow_"+obj_Village.VillageId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyVillageRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createVillageRowHtmlElem(obj_Village,ElemId, ClassName);
			UiVillageList.insertBefore(ElemLi, UiVillageList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Village msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createVillageRowHtmlElem(obj_Village,ElemId, ClassName);
			UiVillageList.insertBefore(ElemLi, UiVillageList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyVillageRow_"+dummyId);
			var DummyData = document.getElementById("VillagedataDummyVillageRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Villagedata"+ElemId);		
				DummyData.value = obj_Village.getVillageData();		
				}
				UI_createTopbarSubVillageHtmlElem(obj_Village);
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
				var ElemLi = UI_createVillageRowHtmlElem(obj_Village,ElemId, ClassName);
				UiVillageList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("VillageList");
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
		var profileAvatar = document.getElementById("VillageListRow_"+VillageId);
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



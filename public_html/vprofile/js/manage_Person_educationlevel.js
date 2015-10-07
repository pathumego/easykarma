//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Person_educationlevel_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addPerson_educationlevel(mainPacket);
			break;
		}
		case 201: {
			ACK_addPerson_educationlevel(mainPacket);
			break;
		}
		case 202: {
			ACK_deletePerson_educationlevel(mainPacket);
			break;
		}
		case 203: {
			ACK_updatePerson_educationlevel(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addPerson_educationlevel(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Person_educationlevel = new Person_educationlevel();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Person_educationlevel.EducationLevelId= mainPacket[3];
		obj_Person_educationlevel.SchoolId= mainPacket[4];
		obj_Person_educationlevel.StartYear= mainPacket[5];
		obj_Person_educationlevel.StartClass= mainPacket[6];
		obj_Person_educationlevel.EndYear= mainPacket[7];
		obj_Person_educationlevel.EndClass= mainPacket[8];
		obj_Person_educationlevel.PersonId= mainPacket[9];



		if (resultStatus == 1) {	
			
			UI_createPerson_educationlevelRow(obj_Person_educationlevel, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deletePerson_educationlevel(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Person_educationlevel = new Person_educationlevel();
		
		var resultStatus = mainPacket[0];
		var EducationLevelId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Person_educationlevelListRow_"+EducationLevelId);
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
				var rowElem = document.getElementById("Person_educationlevelListRow_"+EducationLevelId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updatePerson_educationlevel(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Person_educationlevel = new Person_educationlevel();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Person_educationlevel.EducationLevelId= mainPacket[2];
		obj_Person_educationlevel.SchoolId= mainPacket[3];
		obj_Person_educationlevel.StartYear= mainPacket[4];
		obj_Person_educationlevel.StartClass= mainPacket[5];
		obj_Person_educationlevel.EndYear= mainPacket[6];
		obj_Person_educationlevel.EndClass= mainPacket[7];
		obj_Person_educationlevel.PersonId= mainPacket[8];


		if (resultStatus == 1) {			
			UI_createPerson_educationlevelRow(obj_Person_educationlevel, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Person_educationlevel_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingPerson_educationlevelPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Person_educationlevel; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeletePerson_educationlevelPacket(EducationLevelId) {
	var deletePacketBody  = EducationLevelId;

	var postpacket = createOutgoingPerson_educationlevelPacket(202,deletePacketBody);
	Person_educationlevel_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdatePerson_educationlevelPacket(obj_Person_educationlevel) {
	var savePacketBody  = obj_Person_educationlevel.createPerson_educationlevelPacket();

	var postpacket = createOutgoingPerson_educationlevelPacket(203,savePacketBody);
	Person_educationlevel_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddPerson_educationlevelPacket(dummyId,obj_Person_educationlevel) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Person_educationlevel.createPerson_educationlevelPacket();

	var postpacket = createOutgoingPerson_educationlevelPacket(201,savePacketBody);
	Person_educationlevel_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onPerson_educationlevelPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onPerson_educationlevelPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addPerson_educationlevel = document.getElementById("btnaddPerson_educationlevel");
	if(addPerson_educationlevel){
	addPerson_educationlevel.addEventListener('mousedown', Event_mousedown_addPerson_educationlevel, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popPerson_educationlevelform = document.getElementById("popPerson_educationlevelform");
	var inputElems = popPerson_educationlevelform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiPerson_educationlevelList = document.getElementById("Person_educationlevelList");
	var liElems = UiPerson_educationlevelList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverPerson_educationlevelRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutPerson_educationlevelRow, false);
		
	}
	
	var UiPerson_educationlevelListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiPerson_educationlevelListDeletebtns.length; z++) {
			UiPerson_educationlevelListDeletebtns[z].addEventListener('mousedown', Event_mouseDownPerson_educationlevelRowBtn, false);			
		
	}

	var searchBox = document.getElementById("searchtextbox");
	 if(searchBox){
	 searchBox.addEventListener('focus', Event_focusSearchBox, false);
     searchBox.addEventListener('blur', Event_blurSearchBox, false);
     searchBox.addEventListener('keyup', Event_keyupSearchBox, false);
    }
	
	global_autocomplete_elem[0] = new AutoComplete();
	global_autocomplete_elem[0].Open(0,"Input_InstituteId","Name",17);	
	
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
	UI_search_Person_educationlevel(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownPerson_educationlevelRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Person_educationlevel = Get_Person_educationlevelByListRow(this.parentNode.parentNode);
			if(obj_Person_educationlevel != ""){
				deletePerson_educationlevel(obj_Person_educationlevel.EducationLevelId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Person_educationlevel = Get_Person_educationlevelByListRow(this.parentNode.parentNode);
			if(obj_Person_educationlevel != ""){
				UI_showUpdatePerson_educationlevelForm(obj_Person_educationlevel);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Person_educationlevel(searchText)
{

	//Person_educationlevelList = 
	var Person_educationlevelListElem = document.getElementById("Person_educationlevelList");
	
	if(Person_educationlevelListElem)
	{
		var Person_educationlevelDataList = Person_educationlevelListElem.getElementsByTagName("input");
		for(var y=0 in Person_educationlevelDataList)
		{
			if(Person_educationlevelDataList[y])
			{
				
				
				var displayType = "none";
				var Person_educationlevelData = Person_educationlevelDataList[y].value;
				if(!((Person_educationlevelData == "") || (typeof Person_educationlevelData=="undefined")))
				{
				if(search_Person_educationlevel(Person_educationlevelData,searchText))
				{
					displayType = "block";
				}
				Person_educationlevelDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Person_educationlevel(Person_educationlevelData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Person_educationlevelData = decodeSpText(Person_educationlevelData.toLowerCase());
	if(Person_educationlevelData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Person_educationlevel)
{
	if (obj_Person_educationlevel.EducationLevelId) {
		var fieldDataId = obj_Person_educationlevel.EducationLevelId;
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

function deletePerson_educationlevel(EducationLevelId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Person_educationlevel");
	if(flag){
			DeletePerson_educationlevelPacket(EducationLevelId);
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

function Get_Person_educationlevelByListRow(listRowElem)
{
	
	var obj_Person_educationlevel ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Person_educationlevelData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Person_educationlevelData = elemlist[z].value;
			}		
		}
		
		if(Person_educationlevelData != "")
		{
		var arrPerson_educationlevelData = Person_educationlevelData.split(";");	
		
		obj_Person_educationlevel = new Person_educationlevel();
		obj_Person_educationlevel.EducationLevelId= arrPerson_educationlevelData[0];
		obj_Person_educationlevel.SchoolId= arrPerson_educationlevelData[1];
		obj_Person_educationlevel.StartYear= arrPerson_educationlevelData[2];
		obj_Person_educationlevel.StartClass= arrPerson_educationlevelData[3];
		obj_Person_educationlevel.EndYear= arrPerson_educationlevelData[4];
		obj_Person_educationlevel.EndClass= arrPerson_educationlevelData[5];
		obj_Person_educationlevel.PersonId= arrPerson_educationlevelData[6];

		
		
		}
		
	}
	
	return obj_Person_educationlevel;
	
	
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
	

		var Elem = document.getElementById("Input_StartYear");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = " Input_StartYear";
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
	
		var obj_Person_educationlevel = new Person_educationlevel();
		
		var EducationLevelId= document.getElementById("Input_EducationLevelId").value;
		var SchoolId= document.getElementById("Input_SchoolId").value;
		var StartYear= document.getElementById("Input_StartYear").value;
		var StartClass= document.getElementById("Input_StartClass").value;
		var EndYear= document.getElementById("Input_EndYear").value;
		var EndClass= document.getElementById("Input_EndClass").value;
		var PersonId= document.getElementById("Input_PersonId").value;

		
		document.getElementById("Input_EducationLevelId").value="";
		document.getElementById("Input_SchoolId").value="";
		document.getElementById("Input_StartYear").value="";
		document.getElementById("Input_StartClass").value="";
		document.getElementById("Input_EndYear").value="";
		document.getElementById("Input_EndClass").value="";
		document.getElementById("Input_PersonId").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Person_educationlevel = new Person_educationlevel();
		obj_Person_educationlevel.EducationLevelId= EducationLevelId;
		obj_Person_educationlevel.SchoolId= SchoolId;
		obj_Person_educationlevel.StartYear= StartYear;
		obj_Person_educationlevel.StartClass= StartClass;
		obj_Person_educationlevel.EndYear= EndYear;
		obj_Person_educationlevel.EndClass= EndClass;
		obj_Person_educationlevel.PersonId= PersonId;

		
		var dummyId = CreateDummyNumber();
		AddPerson_educationlevelPacket(dummyId,obj_Person_educationlevel);
		UI_createPerson_educationlevelRow(obj_Person_educationlevel, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Person_educationlevel = new Person_educationlevel();

		obj_Person_educationlevel.EducationLevelId= EducationLevelId;
		obj_Person_educationlevel.SchoolId= SchoolId;
		obj_Person_educationlevel.StartYear= StartYear;
		obj_Person_educationlevel.StartClass= StartClass;
		obj_Person_educationlevel.EndYear= EndYear;
		obj_Person_educationlevel.EndClass= EndClass;
		obj_Person_educationlevel.PersonId= PersonId;

		
		UpdatePerson_educationlevelPacket(obj_Person_educationlevel);
		UI_createPerson_educationlevelRow(obj_Person_educationlevel, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addPerson_educationlevel() {
	
	UI_showAddPerson_educationlevelForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddPerson_educationlevelForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePerson_educationlevelAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPerson_educationlevelform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdatePerson_educationlevelForm(obj_Person_educationlevel) {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePerson_educationlevelUpdateForm(obj_Person_educationlevel);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPerson_educationlevelform"));
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
function UI_preparePerson_educationlevelUpdateForm(obj_Person_educationlevel)
{
	var arr_hidelist = new Array("Input_EducationLevelId","Input_PersonId");
	var arr_showlist = new Array("Input_StartYear","Input_SchoolId","Input_StartClass","Input_EndYear","Input_EndClass");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_EducationLevelId").value=obj_Person_educationlevel.EducationLevelId;
		document.getElementById("Input_SchoolId").value=obj_Person_educationlevel.SchoolId;
		document.getElementById("Input_StartYear").value=obj_Person_educationlevel.StartYear;
		document.getElementById("Input_StartClass").value=obj_Person_educationlevel.StartClass;
		document.getElementById("Input_EndYear").value=obj_Person_educationlevel.EndYear;
		document.getElementById("Input_EndClass").value=obj_Person_educationlevel.EndClass;
		document.getElementById("Input_PersonId").value=obj_Person_educationlevel.PersonId;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_preparePerson_educationlevelAddForm()
{
	var arr_hidelist = new Array("Input_SchoolId","Input_EducationLevelId","Input_PersonId");
	var arr_showlist = new Array("Input_StartYear","Input_StartClass","Input_EndYear","Input_EndClass");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_EducationLevelId").value="";
		document.getElementById("Input_SchoolId").value="";
		document.getElementById("Input_StartYear").value="";
		document.getElementById("Input_StartClass").value="";
		document.getElementById("Input_EndYear").value="";
		document.getElementById("Input_EndClass").value="";
		document.getElementById("Input_PersonId").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addPerson_educationlevelToPerson_educationlevelList() {
	var uiPerson_educationlevelList = document.getElementById("Person_educationlevelList");

	var rowElems = uiPerson_educationlevelList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_educationlevelRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownPerson_educationlevelRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_educationlevelRowHtmlElem(obj_Person_educationlevel,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Person_educationlevelImg_"+obj_Person_educationlevel.EducationLevelId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Person_educationlevel/0_small.png";
	else ImgElem.src = "Person_educationlevel/"+obj_Person_educationlevel.EducationLevelId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Person_educationlevel.EducationLevelId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Person_educationlevel.SchoolId;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Person_educationlevel.StartYear;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Person_educationlevel.StartClass;
		var ElemDataRow6 = document.createElement("div");
		ElemDataRow6.className ="datarow";
		ElemDataRow6.innerHTML = obj_Person_educationlevel.EndYear;
		var ElemDataRow7 = document.createElement("div");
		ElemDataRow7.className ="datarow";
		ElemDataRow7.innerHTML = obj_Person_educationlevel.EndClass;
		var ElemDataRow8 = document.createElement("div");
		ElemDataRow8.className ="datarow";
		ElemDataRow8.innerHTML = obj_Person_educationlevel.PersonId;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Person_educationleveldata"+ElemId);
		ElementDataHidden.value = obj_Person_educationlevel.getPerson_educationlevelData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);
		ElemLi.appendChild(ElemDataRow6);
		ElemLi.appendChild(ElemDataRow7);
		ElemLi.appendChild(ElemDataRow8);

		
		ElemLi= UI_createPerson_educationlevelRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverPerson_educationlevelRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutPerson_educationlevelRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubPerson_educationlevelHtmlElem(obj_Person_educationlevel)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subPerson_educationlevel");
		html ="<a href=\"?page=dashboard&EducationLevelId="+obj_Person_educationlevel.EducationLevelId+"\">"+obj_Person_educationlevel.EducationLevelId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverPerson_educationlevelRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutPerson_educationlevelRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_educationlevelRow(obj_Person_educationlevel, rowType,dummyId) {
	var html = "";
	
	var UiPerson_educationlevelList = document.getElementById("Person_educationlevelList");
	var ClassName = "ListRow";
	var ElemId = "Person_educationlevelListRow_"+obj_Person_educationlevel.EducationLevelId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyPerson_educationlevelRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createPerson_educationlevelRowHtmlElem(obj_Person_educationlevel,ElemId, ClassName);
			UiPerson_educationlevelList.insertBefore(ElemLi, UiPerson_educationlevelList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Person_educationlevel msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createPerson_educationlevelRowHtmlElem(obj_Person_educationlevel,ElemId, ClassName);
			UiPerson_educationlevelList.insertBefore(ElemLi, UiPerson_educationlevelList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyPerson_educationlevelRow_"+dummyId);
			var DummyData = document.getElementById("Person_educationleveldataDummyPerson_educationlevelRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Person_educationleveldata"+ElemId);		
				DummyData.value = obj_Person_educationlevel.getPerson_educationlevelData();		
				}
				UI_createTopbarSubPerson_educationlevelHtmlElem(obj_Person_educationlevel);
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
				var ElemLi = UI_createPerson_educationlevelRowHtmlElem(obj_Person_educationlevel,ElemId, ClassName);
				UiPerson_educationlevelList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Person_educationlevelList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, EducationLevelId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("Person_educationlevelListRow_"+EducationLevelId);
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



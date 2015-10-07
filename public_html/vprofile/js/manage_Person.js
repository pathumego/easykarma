//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Person_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addPerson(mainPacket);
			break;
		}
		case 201: {
			ACK_addPerson(mainPacket);
			break;
		}
		case 202: {
			ACK_deletePerson(mainPacket);
			break;
		}
		case 203: {
			ACK_updatePerson(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addPerson(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Person = new Person();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Person.PersonId= mainPacket[3];
		obj_Person.FullName= mainPacket[4];
		obj_Person.NickName= mainPacket[5];
		obj_Person.OtherNames= mainPacket[6];
		obj_Person.DrivingLicenceNo= mainPacket[7];
		obj_Person.PassportNo= mainPacket[8];
		obj_Person.PermanentAddress= mainPacket[9];
		obj_Person.Email= mainPacket[10];
		obj_Person.Website= mainPacket[11];
		obj_Person.Description= mainPacket[12];
		obj_Person.Gender= mainPacket[13];
		obj_Person.DOB= mainPacket[14];
		obj_Person.Height= mainPacket[15];
		obj_Person.Weight= mainPacket[16];
		obj_Person.HairColor= mainPacket[17];
		obj_Person.EyeColor= mainPacket[18];
		obj_Person.BloodType= mainPacket[19];
		obj_Person.Occupation= mainPacket[20];
		obj_Person.MonthlyIncome= mainPacket[21];
		obj_Person.FutureTargets= mainPacket[22];
		obj_Person.FutureNeeds= mainPacket[23];
		obj_Person.DOD= mainPacket[24];
		obj_Person.Picture= mainPacket[25];
		obj_Person.NIC= mainPacket[26];
		obj_Person.Status= mainPacket[27];



		if (resultStatus == 1) {	
			
			UI_createPersonRow(obj_Person, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deletePerson(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Person = new Person();
		
		var resultStatus = mainPacket[0];
		var PersonId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("PersonListRow_"+PersonId);
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
				var rowElem = document.getElementById("PersonListRow_"+PersonId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updatePerson(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Person = new Person();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Person.PersonId= mainPacket[2];
		obj_Person.FullName= mainPacket[3];
		obj_Person.NickName= mainPacket[4];
		obj_Person.OtherNames= mainPacket[5];
		obj_Person.DrivingLicenceNo= mainPacket[6];
		obj_Person.PassportNo= mainPacket[7];
		obj_Person.PermanentAddress= mainPacket[8];
		obj_Person.Email= mainPacket[9];
		obj_Person.Website= mainPacket[10];
		obj_Person.Description= mainPacket[11];
		obj_Person.Gender= mainPacket[12];
		obj_Person.DOB= mainPacket[13];
		obj_Person.Height= mainPacket[14];
		obj_Person.Weight= mainPacket[15];
		obj_Person.HairColor= mainPacket[16];
		obj_Person.EyeColor= mainPacket[17];
		obj_Person.BloodType= mainPacket[18];
		obj_Person.Occupation= mainPacket[19];
		obj_Person.MonthlyIncome= mainPacket[20];
		obj_Person.FutureTargets= mainPacket[21];
		obj_Person.FutureNeeds= mainPacket[22];
		obj_Person.DOD= mainPacket[23];
		obj_Person.Picture= mainPacket[24];
		obj_Person.NIC= mainPacket[25];
		obj_Person.Status= mainPacket[26];


		if (resultStatus == 1) {			
			UI_createPersonRow(obj_Person, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Person_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingPersonPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Person; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeletePersonPacket(PersonId) {
	var deletePacketBody  = PersonId;

	var postpacket = createOutgoingPersonPacket(202,deletePacketBody);
	Person_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdatePersonPacket(obj_Person) {
	var savePacketBody  = obj_Person.createPersonPacket();

	var postpacket = createOutgoingPersonPacket(203,savePacketBody);
	Person_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddPersonPacket(dummyId,obj_Person) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Person.createPersonPacket();

	var postpacket = createOutgoingPersonPacket(201,savePacketBody);
	Person_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onPersonPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onPersonPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addPerson = document.getElementById("btnaddPerson");
	if(addPerson){
	addPerson.addEventListener('mousedown', Event_mousedown_addPerson, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popPersonform = document.getElementById("popPersonform");
	var inputElems = popPersonform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiPersonList = document.getElementById("PersonList");
	var liElems = UiPersonList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverPersonRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutPersonRow, false);
		
	}
	
	var UiPersonListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiPersonListDeletebtns.length; z++) {
			UiPersonListDeletebtns[z].addEventListener('mousedown', Event_mouseDownPersonRowBtn, false);			
		
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
	UI_search_Person(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownPersonRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Person = Get_PersonByListRow(this.parentNode.parentNode);
			if(obj_Person != ""){
				deletePerson(obj_Person.PersonId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Person = Get_PersonByListRow(this.parentNode.parentNode);
			if(obj_Person != ""){
				UI_showUpdatePersonForm(obj_Person);
				
			}		
			
			break;
		}
		case "select":
		{
			var obj_Person = Get_PersonByListRow(this.parentNode.parentNode);
			if(obj_Person != ""){
				var newWindow = window.open("?page=persondashboard&personid="+obj_Person.PersonId);
				
			}		
			
			break;
		}
		case "al":
		{
			var obj_Person = Get_PersonByListRow(this.parentNode.parentNode);
			if(obj_Person != ""){
				var newWindow = window.open("?page=Person_alresult&PersonId="+obj_Person.PersonId);
				
			}		
			
			break;
		}
		case "ol":
		{
			var obj_Person = Get_PersonByListRow(this.parentNode.parentNode);
			if(obj_Person != ""){
				var newWindow = window.open("?page=Person_olresult&PersonId="+obj_Person.PersonId);
				
			}		
			
			break;
		}
		case "lang-skill":
		{
			var obj_Person = Get_PersonByListRow(this.parentNode.parentNode);
			if(obj_Person != ""){
				var newWindow = window.open("?page=Person_languageskill&PersonId="+obj_Person.PersonId);
				
			}		
			
			break;
		}
		case "property":
		{
			var obj_Person = Get_PersonByListRow(this.parentNode.parentNode);
			if(obj_Person != ""){
				var newWindow = window.open("?page=Person_property&PersonId="+obj_Person.PersonId);
				
			}		
			
			break;
		}
		case "talents":
		{
			var obj_Person = Get_PersonByListRow(this.parentNode.parentNode);
			if(obj_Person != ""){
				var newWindow = window.open("?page=Person_talent&PersonId="+obj_Person.PersonId);
				
			}		
			
			break;
		}
		case "tp":
		{
			var obj_Person = Get_PersonByListRow(this.parentNode.parentNode);
			if(obj_Person != ""){
				var newWindow = window.open("?page=Person_telephone&PersonId="+obj_Person.PersonId);
				
			}		
			
			break;
		}
		case "vocational-training":
		{
			var obj_Person = Get_PersonByListRow(this.parentNode.parentNode);
			if(obj_Person != ""){
				var newWindow = window.open("?page=Person_vocationaltraning&PersonId="+obj_Person.PersonId);
				
			}		
			
			break;
		}
		case "work-experiance":
		{
			var obj_Person = Get_PersonByListRow(this.parentNode.parentNode);
			if(obj_Person != ""){
				var newWindow = window.open("?page=Person_workingexperiance&PersonId="+obj_Person.PersonId);
				
			}		
			
			break;
		}
		case "education-level":
		{
			var obj_Person = Get_PersonByListRow(this.parentNode.parentNode);
			if(obj_Person != ""){
				var newWindow = window.open("?page=Person_educationlevel&PersonId="+obj_Person.PersonId);
				
			}		
			
			break;
		}
		case "highereducation":
		{
			var obj_Person = Get_PersonByListRow(this.parentNode.parentNode);
			if(obj_Person != ""){
				var newWindow = window.open("?page=Person_highereducation&PersonId="+obj_Person.PersonId);
				
			}		
			
			break;
		}
	
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Person(searchText)
{

	//PersonList = 
	var PersonListElem = document.getElementById("PersonList");
	
	if(PersonListElem)
	{
		var PersonDataList = PersonListElem.getElementsByTagName("input");
		for(var y=0 in PersonDataList)
		{
			if(PersonDataList[y])
			{
				
				
				var displayType = "none";
				var PersonData = PersonDataList[y].value;
				if(!((PersonData == "") || (typeof PersonData=="undefined")))
				{
				if(search_Person(PersonData,searchText))
				{
					displayType = "block";
				}
				PersonDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Person(PersonData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	PersonData = decodeSpText(PersonData.toLowerCase());
	if(PersonData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Person)
{
	if (obj_Person.PersonId) {
		var fieldDataId = obj_Person.PersonId;
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

function deletePerson(PersonId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Person");
	if(flag){
			DeletePersonPacket(PersonId);
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

function Get_PersonByListRow(listRowElem)
{
	
	var obj_Person ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var PersonData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				PersonData = elemlist[z].value;
			}		
		}
		
		if(PersonData != "")
		{
		var arrPersonData = PersonData.split(";");	
		
		obj_Person = new Person();
		obj_Person.PersonId= arrPersonData[0];
		obj_Person.FullName= arrPersonData[1];
		obj_Person.NickName= arrPersonData[2];
		obj_Person.OtherNames= arrPersonData[3];
		obj_Person.DrivingLicenceNo= arrPersonData[4];
		obj_Person.PassportNo= arrPersonData[5];
		obj_Person.PermanentAddress= arrPersonData[6];
		obj_Person.Email= arrPersonData[7];
		obj_Person.Website= arrPersonData[8];
		obj_Person.Description= arrPersonData[9];
		obj_Person.Gender= arrPersonData[10];
		obj_Person.DOB= arrPersonData[11];
		obj_Person.Height= arrPersonData[12];
		obj_Person.Weight= arrPersonData[13];
		obj_Person.HairColor= arrPersonData[14];
		obj_Person.EyeColor= arrPersonData[15];
		obj_Person.BloodType= arrPersonData[16];
		obj_Person.Occupation= arrPersonData[17];
		obj_Person.MonthlyIncome= arrPersonData[18];
		obj_Person.FutureTargets= arrPersonData[19];
		obj_Person.FutureNeeds= arrPersonData[20];
		obj_Person.DOD= arrPersonData[21];
		obj_Person.Picture= arrPersonData[22];
		obj_Person.NIC= arrPersonData[23];
		obj_Person.Status= arrPersonData[24];

		
		
		}
		
	}
	
	return obj_Person;
	
	
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
	
var Elem = document.getElementById("Input_FullName");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "Please input full name";
					Elem.focus();
				}
	
			}
	/*		var Elem = document.getElementById("Input_PermanentAddress");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "Please enter permenent adress";
					Elem.focus();
				}				
	
			}
var Elem = document.getElementById("Input_Gender");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "Please enter your gender";
					Elem.focus();
				}				
				
	
			}

var Elem = document.getElementById("Input_NIC");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "Please enter NIC number";
					Elem.focus();
				}				
				else if(isNaN(Elem.value))
				{
				
					iserror =true;
					error = "Invalid number";	
					Elem.focus();		
				}
	
			}
*/
		
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
	
		var obj_Person = new Person();
		
		var PersonId= document.getElementById("Input_PersonId").value;
		var FullName= document.getElementById("Input_FullName").value;
		var NickName= document.getElementById("Input_NickName").value;
		var OtherNames= document.getElementById("Input_OtherNames").value;
		var DrivingLicenceNo= document.getElementById("Input_DrivingLicenceNo").value;
		var PassportNo= document.getElementById("Input_PassportNo").value;
		var PermanentAddress= document.getElementById("Input_PermanentAddress").value;
		var Email= document.getElementById("Input_Email").value;
		var Website= document.getElementById("Input_Website").value;
		var Description= document.getElementById("Input_Description").value;
		var Gender= document.getElementById("Input_Gender").value;
		var DOB= document.getElementById("Input_DOB").value;
		var Height= document.getElementById("Input_Height").value;
		var Weight= document.getElementById("Input_Weight").value;
		var HairColor= document.getElementById("Input_HairColor").value;
		var EyeColor= document.getElementById("Input_EyeColor").value;
		var BloodType= document.getElementById("Input_BloodType").value;
		var Occupation= document.getElementById("Input_Occupation").value;
		var MonthlyIncome= document.getElementById("Input_MonthlyIncome").value;
		var FutureTargets= document.getElementById("Input_FutureTargets").value;
		var FutureNeeds= document.getElementById("Input_FutureNeeds").value;
		var DOD= document.getElementById("Input_DOD").value;
		var Picture= document.getElementById("Input_Picture").value;
		var NIC= document.getElementById("Input_NIC").value;
		var Status= document.getElementById("Input_Status").value;

		
		document.getElementById("Input_PersonId").value="";
		document.getElementById("Input_FullName").value="";
		document.getElementById("Input_NickName").value="";
		document.getElementById("Input_OtherNames").value="";
		document.getElementById("Input_DrivingLicenceNo").value="";
		document.getElementById("Input_PassportNo").value="";
		document.getElementById("Input_PermanentAddress").value="";
		document.getElementById("Input_Email").value="";
		document.getElementById("Input_Website").value="";
		document.getElementById("Input_Description").value="";
	//	document.getElementById("Input_Gender").value="";
		document.getElementById("Input_DOB").value="";
		document.getElementById("Input_Height").value="";
		document.getElementById("Input_Weight").value="";
		document.getElementById("Input_HairColor").value="";
		document.getElementById("Input_EyeColor").value="";
	//	document.getElementById("Input_BloodType").value="";
		document.getElementById("Input_Occupation").value="";
		document.getElementById("Input_MonthlyIncome").value="";
		document.getElementById("Input_FutureTargets").value="";
		document.getElementById("Input_FutureNeeds").value="";
		document.getElementById("Input_DOD").value="";
		document.getElementById("Input_Picture").value="";
		document.getElementById("Input_NIC").value="";
		document.getElementById("Input_Status").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Person = new Person();
		obj_Person.PersonId= PersonId;
		obj_Person.FullName= FullName;
		obj_Person.NickName= NickName;
		obj_Person.OtherNames= OtherNames;
		obj_Person.DrivingLicenceNo= DrivingLicenceNo;
		obj_Person.PassportNo= PassportNo;
		obj_Person.PermanentAddress= PermanentAddress;
		obj_Person.Email= Email;
		obj_Person.Website= Website;
		obj_Person.Description= Description;
		obj_Person.Gender= Gender;
		obj_Person.DOB= DOB;
		obj_Person.Height= Height;
		obj_Person.Weight= Weight;
		obj_Person.HairColor= HairColor;
		obj_Person.EyeColor= EyeColor;
		obj_Person.BloodType= BloodType;
		obj_Person.Occupation= Occupation;
		obj_Person.MonthlyIncome= MonthlyIncome;
		obj_Person.FutureTargets= FutureTargets;
		obj_Person.FutureNeeds= FutureNeeds;
		obj_Person.DOD= DOD;
		obj_Person.Picture= Picture;
		obj_Person.NIC= NIC;
		obj_Person.Status= Status;

		
		var dummyId = CreateDummyNumber();
		AddPersonPacket(dummyId,obj_Person);
		UI_createPersonRow(obj_Person, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Person = new Person();

		obj_Person.PersonId= PersonId;
		obj_Person.FullName= FullName;
		obj_Person.NickName= NickName;
		obj_Person.OtherNames= OtherNames;
		obj_Person.DrivingLicenceNo= DrivingLicenceNo;
		obj_Person.PassportNo= PassportNo;
		obj_Person.PermanentAddress= PermanentAddress;
		obj_Person.Email= Email;
		obj_Person.Website= Website;
		obj_Person.Description= Description;
		obj_Person.Gender= Gender;
		obj_Person.DOB= DOB;
		obj_Person.Height= Height;
		obj_Person.Weight= Weight;
		obj_Person.HairColor= HairColor;
		obj_Person.EyeColor= EyeColor;
		obj_Person.BloodType= BloodType;
		obj_Person.Occupation= Occupation;
		obj_Person.MonthlyIncome= MonthlyIncome;
		obj_Person.FutureTargets= FutureTargets;
		obj_Person.FutureNeeds= FutureNeeds;
		obj_Person.DOD= DOD;
		obj_Person.Picture= Picture;
		obj_Person.NIC= NIC;
		obj_Person.Status= Status;

		
		UpdatePersonPacket(obj_Person);
		UI_createPersonRow(obj_Person, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addPerson() {
	
	UI_showAddPersonForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddPersonForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePersonAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPersonform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdatePersonForm(obj_Person) {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePersonUpdateForm(obj_Person);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPersonform"));
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
function UI_preparePersonUpdateForm(obj_Person)
{
	var arr_hidelist = new Array("Input_PersonId","Input_Status","Input_Picture");
	var arr_showlist = new Array("Input_FullName","Input_NickName","Input_OtherNames","Input_DrivingLicenceNo","Input_PassportNo","Input_PermanentAddress","Input_Email","Input_Website","Input_Description","Input_Gender","Input_DOB","Input_Height","Input_Weight","Input_HairColor","Input_EyeColor","Input_BloodType","Input_Occupation","Input_MonthlyIncome","Input_FutureTargets","Input_FutureNeeds","Input_DOD","Input_NIC");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_PersonId").value=obj_Person.PersonId;
		document.getElementById("Input_FullName").value=obj_Person.FullName;
		document.getElementById("Input_NickName").value=obj_Person.NickName;
		document.getElementById("Input_OtherNames").value=obj_Person.OtherNames;
		document.getElementById("Input_DrivingLicenceNo").value=obj_Person.DrivingLicenceNo;
		document.getElementById("Input_PassportNo").value=obj_Person.PassportNo;
		document.getElementById("Input_PermanentAddress").value=obj_Person.PermanentAddress;
		document.getElementById("Input_Email").value=obj_Person.Email;
		document.getElementById("Input_Website").value=obj_Person.Website;
		document.getElementById("Input_Description").value=obj_Person.Description;
		//document.getElementById("Input_Gender").value=obj_Person.Gender;
		
		var drp_item = document.getElementById("Input_Gender");
		for (var i=0; i < drp_item.options.length; i++) {
		if (drp_item.options[i].value == obj_Person.Gender) {
			drp_item.options[i].selected = true;
			}
		}
		
		document.getElementById("Input_DOB").value=obj_Person.DOB;
		document.getElementById("Input_Height").value=obj_Person.Height;
		document.getElementById("Input_Weight").value=obj_Person.Weight;
		document.getElementById("Input_HairColor").value=obj_Person.HairColor;
		document.getElementById("Input_EyeColor").value=obj_Person.EyeColor;
		//document.getElementById("Input_BloodType").value=obj_Person.BloodType;
		
		var drp_item = document.getElementById("Input_BloodType");
		for (var i=0; i < drp_item.options.length; i++) {
		if (drp_item.options[i].value == obj_Person.BloodType) {
			drp_item.options[i].selected = true;
			}
		}
		
		document.getElementById("Input_Occupation").value=obj_Person.Occupation;
		document.getElementById("Input_MonthlyIncome").value=obj_Person.MonthlyIncome;
		document.getElementById("Input_FutureTargets").value=obj_Person.FutureTargets;
		document.getElementById("Input_FutureNeeds").value=obj_Person.FutureNeeds;
		document.getElementById("Input_DOD").value=obj_Person.DOD;
		document.getElementById("Input_Picture").value=obj_Person.Picture;
		document.getElementById("Input_NIC").value=obj_Person.NIC;
		document.getElementById("Input_Status").value=obj_Person.Status;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_preparePersonAddForm()
{
	var arr_hidelist = new Array("Input_PersonId","Input_Status","Input_Picture");
	var arr_showlist = new Array("Input_FullName","Input_NickName","Input_OtherNames","Input_DrivingLicenceNo","Input_PassportNo","Input_PermanentAddress","Input_Email","Input_Website","Input_Description","Input_Gender","Input_DOB","Input_Height","Input_Weight","Input_HairColor","Input_EyeColor","Input_BloodType","Input_Occupation","Input_MonthlyIncome","Input_FutureTargets","Input_FutureNeeds","Input_DOD","Input_NIC");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_PersonId").value="";
		document.getElementById("Input_FullName").value="";
		document.getElementById("Input_NickName").value="";
		document.getElementById("Input_OtherNames").value="";
		document.getElementById("Input_DrivingLicenceNo").value="";
		document.getElementById("Input_PassportNo").value="";
		document.getElementById("Input_PermanentAddress").value="";
		document.getElementById("Input_Email").value="";
		document.getElementById("Input_Website").value="";
		document.getElementById("Input_Description").value="";
		document.getElementById("Input_Gender").value="";
		document.getElementById("Input_DOB").value="";
		document.getElementById("Input_Height").value="";
		document.getElementById("Input_Weight").value="";
		document.getElementById("Input_HairColor").value="";
		document.getElementById("Input_EyeColor").value="";
		document.getElementById("Input_BloodType").value="";
		document.getElementById("Input_Occupation").value="";
		document.getElementById("Input_MonthlyIncome").value="";
		document.getElementById("Input_FutureTargets").value="";
		document.getElementById("Input_FutureNeeds").value="";
		document.getElementById("Input_DOD").value="";
		document.getElementById("Input_Picture").value="";
		document.getElementById("Input_NIC").value="";
		document.getElementById("Input_Status").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addPersonToPersonList() {
	var uiPersonList = document.getElementById("PersonList");

	var rowElems = uiPersonList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createPersonRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownPersonRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPersonRowHtmlElem(obj_Person,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "PersonImg_"+obj_Person.PersonId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Person/0_small.png";
	else ImgElem.src = "Person/"+obj_Person.PersonId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow datarow_person_personid";
		ElemDataRow2.innerHTML = obj_Person.PersonId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow datarow_person_fullname";
		ElemDataRow3.innerHTML = obj_Person.FullName;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow datarow_person_nickname";
		ElemDataRow4.innerHTML = obj_Person.NickName;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Person.OtherNames;
		var ElemDataRow6 = document.createElement("div");
		ElemDataRow6.className ="datarow";
		ElemDataRow6.innerHTML = obj_Person.DrivingLicenceNo;
		var ElemDataRow7 = document.createElement("div");
		ElemDataRow7.className ="datarow";
		ElemDataRow7.innerHTML = obj_Person.PassportNo;
		var ElemDataRow8 = document.createElement("div");
		ElemDataRow8.className ="datarow";
		ElemDataRow8.innerHTML = obj_Person.PermanentAddress;
		var ElemDataRow9 = document.createElement("div");
		ElemDataRow9.className ="datarow datarow_person_email";
		ElemDataRow9.innerHTML = obj_Person.Email;
		var ElemDataRow10 = document.createElement("div");
		ElemDataRow10.className ="datarow";
		ElemDataRow10.innerHTML = obj_Person.Website;
		var ElemDataRow11 = document.createElement("div");
		ElemDataRow11.className ="datarow";
		ElemDataRow11.innerHTML = obj_Person.Description;
		var ElemDataRow12 = document.createElement("div");
		ElemDataRow12.className ="datarow";
		ElemDataRow12.innerHTML = obj_Person.Gender;
		var ElemDataRow13 = document.createElement("div");
		ElemDataRow13.className ="datarow";
		ElemDataRow13.innerHTML = obj_Person.DOB;
		var ElemDataRow14 = document.createElement("div");
		ElemDataRow14.className ="datarow";
		ElemDataRow14.innerHTML = obj_Person.Height;
		var ElemDataRow15 = document.createElement("div");
		ElemDataRow15.className ="datarow";
		ElemDataRow15.innerHTML = obj_Person.Weight;
		var ElemDataRow16 = document.createElement("div");
		ElemDataRow16.className ="datarow";
		ElemDataRow16.innerHTML = obj_Person.HairColor;
		var ElemDataRow17 = document.createElement("div");
		ElemDataRow17.className ="datarow";
		ElemDataRow17.innerHTML = obj_Person.EyeColor;
		var ElemDataRow18 = document.createElement("div");
		ElemDataRow18.className ="datarow";
		ElemDataRow18.innerHTML = obj_Person.BloodType;
		var ElemDataRow19 = document.createElement("div");
		ElemDataRow19.className ="datarow";
		ElemDataRow19.innerHTML = obj_Person.Occupation;
		var ElemDataRow20 = document.createElement("div");
		ElemDataRow20.className ="datarow";
		ElemDataRow20.innerHTML = obj_Person.MonthlyIncome;
		var ElemDataRow21 = document.createElement("div");
		ElemDataRow21.className ="datarow";
		ElemDataRow21.innerHTML = obj_Person.FutureTargets;
		var ElemDataRow22 = document.createElement("div");
		ElemDataRow22.className ="datarow";
		ElemDataRow22.innerHTML = obj_Person.FutureNeeds;
		var ElemDataRow23 = document.createElement("div");
		ElemDataRow23.className ="datarow";
		ElemDataRow23.innerHTML = obj_Person.DOD;
		var ElemDataRow24 = document.createElement("div");
		ElemDataRow24.className ="datarow";
		ElemDataRow24.innerHTML = obj_Person.Picture;
		var ElemDataRow25 = document.createElement("div");
		ElemDataRow25.className ="datarow";
		ElemDataRow25.innerHTML = obj_Person.NIC;
		var ElemDataRow26 = document.createElement("div");
		ElemDataRow26.className ="datarow";
		ElemDataRow26.innerHTML = obj_Person.Status;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Persondata"+ElemId);
		ElementDataHidden.value = obj_Person.getPersonData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
	//	ElemLi.appendChild(ElemDataRow5);
	//	ElemLi.appendChild(ElemDataRow6);
	/*	ElemLi.appendChild(ElemDataRow7);
		ElemLi.appendChild(ElemDataRow8);
	*/	ElemLi.appendChild(ElemDataRow9);
	//	ElemLi.appendChild(ElemDataRow10);
	//	ElemLi.appendChild(ElemDataRow11);
	/*	ElemLi.appendChild(ElemDataRow12);
		ElemLi.appendChild(ElemDataRow13);
		ElemLi.appendChild(ElemDataRow14);
		ElemLi.appendChild(ElemDataRow15);
		ElemLi.appendChild(ElemDataRow16);
		ElemLi.appendChild(ElemDataRow17);
		ElemLi.appendChild(ElemDataRow18);
		ElemLi.appendChild(ElemDataRow19);
		ElemLi.appendChild(ElemDataRow20);
		ElemLi.appendChild(ElemDataRow21);
		ElemLi.appendChild(ElemDataRow22);
		ElemLi.appendChild(ElemDataRow23);
		ElemLi.appendChild(ElemDataRow24);
		ElemLi.appendChild(ElemDataRow25);
		ElemLi.appendChild(ElemDataRow26);
*/
		
		ElemLi= UI_createPersonRowHtmlButtonRow(ElemLi,new Array("Select","Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverPersonRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutPersonRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubPersonHtmlElem(obj_Person)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subPerson");
		html ="<a href=\"?page=dashboard&PersonId="+obj_Person.PersonId+"\">"+obj_Person.PersonId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverPersonRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutPersonRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPersonRow(obj_Person, rowType,dummyId) {
	var html = "";
	
	var UiPersonList = document.getElementById("PersonList");
	var ClassName = "ListRow";
	var ElemId = "PersonListRow_"+obj_Person.PersonId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyPersonRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createPersonRowHtmlElem(obj_Person,ElemId, ClassName);
			UiPersonList.insertBefore(ElemLi, UiPersonList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Person msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createPersonRowHtmlElem(obj_Person,ElemId, ClassName);
			UiPersonList.insertBefore(ElemLi, UiPersonList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyPersonRow_"+dummyId);
			var DummyData = document.getElementById("PersondataDummyPersonRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Persondata"+ElemId);		
				DummyData.value = obj_Person.getPersonData();		
				}
				UI_createTopbarSubPersonHtmlElem(obj_Person);
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
				var ElemLi = UI_createPersonRowHtmlElem(obj_Person,ElemId, ClassName);
				UiPersonList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("PersonList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, PersonId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("PersonListRow_"+PersonId);
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



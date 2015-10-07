//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Business_product_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addBusiness_product(mainPacket);
			break;
		}
		case 201: {
			ACK_addBusiness_product(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteBusiness_product(mainPacket);
			break;
		}
		case 203: {
			ACK_updateBusiness_product(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addBusiness_product(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Business_product = new Business_product();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Business_product.BusinessId= mainPacket[3];
		obj_Business_product.ProductId= mainPacket[4];



		if (resultStatus == 1) {	
			
			UI_createBusiness_productRow(obj_Business_product, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteBusiness_product(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Business_product = new Business_product();
		
		var resultStatus = mainPacket[0];
		var ProductId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Business_productListRow_"+ProductId);
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
				var rowElem = document.getElementById("Business_productListRow_"+ProductId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateBusiness_product(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Business_product = new Business_product();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Business_product.BusinessId= mainPacket[2];
		obj_Business_product.ProductId= mainPacket[3];


		if (resultStatus == 1) {			
			UI_createBusiness_productRow(obj_Business_product, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Business_product_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingBusiness_productPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Business_product; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteBusiness_productPacket(ProductId) {
	var deletePacketBody  = ProductId;

	var postpacket = createOutgoingBusiness_productPacket(202,deletePacketBody);
	Business_product_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateBusiness_productPacket(obj_Business_product) {
	var savePacketBody  = obj_Business_product.createBusiness_productPacket();

	var postpacket = createOutgoingBusiness_productPacket(203,savePacketBody);
	Business_product_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddBusiness_productPacket(dummyId,obj_Business_product) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Business_product.createBusiness_productPacket();

	var postpacket = createOutgoingBusiness_productPacket(201,savePacketBody);
	Business_product_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onBusiness_productPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onBusiness_productPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addBusiness_product = document.getElementById("btnaddBusiness_product");
	if(addBusiness_product){
	addBusiness_product.addEventListener('mousedown', Event_mousedown_addBusiness_product, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popBusiness_productform = document.getElementById("popBusiness_productform");
	var inputElems = popBusiness_productform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiBusiness_productList = document.getElementById("Business_productList");
	var liElems = UiBusiness_productList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverBusiness_productRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutBusiness_productRow, false);
		
	}
	
	var UiBusiness_productListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiBusiness_productListDeletebtns.length; z++) {
			UiBusiness_productListDeletebtns[z].addEventListener('mousedown', Event_mouseDownBusiness_productRowBtn, false);			
		
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
	UI_search_Business_product(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownBusiness_productRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Business_product = Get_Business_productByListRow(this.parentNode.parentNode);
			if(obj_Business_product != ""){
				deleteBusiness_product(obj_Business_product.ProductId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Business_product = Get_Business_productByListRow(this.parentNode.parentNode);
			if(obj_Business_product != ""){
				UI_showUpdateBusiness_productForm(obj_Business_product);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Business_product(searchText)
{

	//Business_productList = 
	var Business_productListElem = document.getElementById("Business_productList");
	
	if(Business_productListElem)
	{
		var Business_productDataList = Business_productListElem.getElementsByTagName("input");
		for(var y=0 in Business_productDataList)
		{
			if(Business_productDataList[y])
			{
				
				
				var displayType = "none";
				var Business_productData = Business_productDataList[y].value;
				if(!((Business_productData == "") || (typeof Business_productData=="undefined")))
				{
				if(search_Business_product(Business_productData,searchText))
				{
					displayType = "block";
				}
				Business_productDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Business_product(Business_productData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Business_productData = decodeSpText(Business_productData.toLowerCase());
	if(Business_productData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Business_product)
{
	if (obj_Business_product.ProductId) {
		var fieldDataId = obj_Business_product.ProductId;
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

function deleteBusiness_product(ProductId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Business_product");
	if(flag){
			DeleteBusiness_productPacket(ProductId);
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

function Get_Business_productByListRow(listRowElem)
{
	
	var obj_Business_product ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Business_productData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Business_productData = elemlist[z].value;
			}		
		}
		
		if(Business_productData != "")
		{
		var arrBusiness_productData = Business_productData.split(";");	
		
		obj_Business_product = new Business_product();
		obj_Business_product.BusinessId= arrBusiness_productData[0];
		obj_Business_product.ProductId= arrBusiness_productData[1];

		
		
		}
		
	}
	
	return obj_Business_product;
	
	
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
	

		var Elem = document.getElementById("Input_BusinessId");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "Please enter Business ID";
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
	
		var obj_Business_product = new Business_product();
		
		var BusinessId= document.getElementById("Input_BusinessId").value;
		var ProductId= document.getElementById("Input_ProductId").value;

		
		document.getElementById("Input_BusinessId").value="";
		document.getElementById("Input_ProductId").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Business_product = new Business_product();
		obj_Business_product.BusinessId= BusinessId;
		obj_Business_product.ProductId= ProductId;

		
		var dummyId = CreateDummyNumber();
		AddBusiness_productPacket(dummyId,obj_Business_product);
		UI_createBusiness_productRow(obj_Business_product, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Business_product = new Business_product();

		obj_Business_product.BusinessId= BusinessId;
		obj_Business_product.ProductId= ProductId;

		
		UpdateBusiness_productPacket(obj_Business_product);
		UI_createBusiness_productRow(obj_Business_product, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addBusiness_product() {
	
	UI_showAddBusiness_productForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddBusiness_productForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareBusiness_productAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popBusiness_productform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateBusiness_productForm(obj_Business_product) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareBusiness_productUpdateForm(obj_Business_product);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popBusiness_productform"));
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
function UI_prepareBusiness_productUpdateForm(obj_Business_product)
{
	var arr_hidelist = new Array("Input_ProductId");
	var arr_showlist = new Array("Input_BusinessId");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_BusinessId").value=obj_Business_product.BusinessId;
		document.getElementById("Input_ProductId").value=obj_Business_product.ProductId;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareBusiness_productAddForm()
{
	var arr_hidelist = new Array("Input_ProductId");
	var arr_showlist = new Array("Input_BusinessId");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_BusinessId").value="";
		document.getElementById("Input_ProductId").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addBusiness_productToBusiness_productList() {
	var uiBusiness_productList = document.getElementById("Business_productList");

	var rowElems = uiBusiness_productList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createBusiness_productRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownBusiness_productRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createBusiness_productRowHtmlElem(obj_Business_product,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Business_productImg_"+obj_Business_product.ProductId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Business_product/0_small.png";
	else ImgElem.src = "Business_product/"+obj_Business_product.ProductId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Business_product.BusinessId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Business_product.ProductId;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Business_productdata"+ElemId);
		ElementDataHidden.value = obj_Business_product.getBusiness_productData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);

		
		ElemLi= UI_createBusiness_productRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverBusiness_productRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutBusiness_productRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubBusiness_productHtmlElem(obj_Business_product)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subBusiness_product");
		html ="<a href=\"?page=dashboard&ProductId="+obj_Business_product.ProductId+"\">"+obj_Business_product.ProductId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverBusiness_productRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutBusiness_productRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createBusiness_productRow(obj_Business_product, rowType,dummyId) {
	var html = "";
	
	var UiBusiness_productList = document.getElementById("Business_productList");
	var ClassName = "ListRow";
	var ElemId = "Business_productListRow_"+obj_Business_product.ProductId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyBusiness_productRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createBusiness_productRowHtmlElem(obj_Business_product,ElemId, ClassName);
			UiBusiness_productList.insertBefore(ElemLi, UiBusiness_productList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Business_product msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createBusiness_productRowHtmlElem(obj_Business_product,ElemId, ClassName);
			UiBusiness_productList.insertBefore(ElemLi, UiBusiness_productList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyBusiness_productRow_"+dummyId);
			var DummyData = document.getElementById("Business_productdataDummyBusiness_productRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Business_productdata"+ElemId);		
				DummyData.value = obj_Business_product.getBusiness_productData();		
				}
				UI_createTopbarSubBusiness_productHtmlElem(obj_Business_product);
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
				var ElemLi = UI_createBusiness_productRowHtmlElem(obj_Business_product,ElemId, ClassName);
				UiBusiness_productList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Business_productList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, ProductId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("Business_productListRow_"+ProductId);
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



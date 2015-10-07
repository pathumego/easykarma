function User()
{
this.userId="";
this.userName="";
this.password="";
this.personId="";
this.userType="";
this.userOptCode="";
this.userMetadata="";
this.userStatus="";

}

User.prototype.setUser = function(userId_,userName_,password_,personId_,userType_,userOptCode_,userMetadata_,userStatus_)
{
this.userId=userId_;
this.userName=userName_;
this.password=password_;
this.personId=personId_;
this.userType=userType_;
this.userOptCode=userOptCode_;
this.userMetadata=userMetadata_;
this.userStatus=userStatus_;

},

User.prototype.createUserPacket = function()
{
	var packet = "";	
	packet += this.userId+";";
	packet += this.userName+";";
	packet += this.password+";";
	packet += this.personId+";";
	packet += this.userType+";";
	packet += this.userOptCode+";";
	packet += this.userMetadata+";";
	packet += this.userStatus;

	return packet;
}


User.prototype.getUserData = function()
{
	var packet = "";	
	packet += this.userId+";";
	packet += this.userName+";";
	packet += this.password+";";
	packet += this.personId+";";
	packet += this.userType+";";
	packet += this.userOptCode+";";
	packet += this.userMetadata+";";
	packet += this.userStatus;

	return packet;
}

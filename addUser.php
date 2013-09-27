<html>
<head>
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <!--<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>-->
    <script src="http://static.stackmob.com/js/stackmob-js-0.9.2-bundled-min.js"></script>
    <script src="key.js"></script>   
</head>
<script>

function addUser(name,password,profession){
    //initial Keys
    StackMob.init({
        publicKey: publicKey,
        apiVersion: 0
    });

    var name=document.forms["userForm"]["username"].value;
    var password=document.forms["userForm"]["password"].value;
    var profession=document.forms["userForm"]["profession"].value;
    var areaCode=document.forms["userForm"]["areaCode"].value;

    //alert(name+" "+password+" "+profession); for debug only

    if(!name || !password || ! profession || ! areaCode){
        alert("field missing!");
        return;
    }
    
    var user = new StackMob.User({ 
        username: name, 
        password: password, 
        profession: profession,
        areaCode: areaCode
    });

    user.create({
        success: function( model, result, options) {
            alert( "add user successed" );
        },
        error: function( model, result, options) {
            alert("add user failed")
        }
    });
}
</script>
<body>
    <h1>Add a new user to stackMob</h1>
    <p>Use Javascript provided by stackMob. Reference: https://developer.stackmob.com/js-sdk/developer-guide#Users. Check the result on https://dashboard.stackmob.com/data/browser/user?avn=0&oauthvn=One</p>
    <form name="userForm">
    <br/>Username: <input type="text" name="username" id="username">
    <br/>Password: <input type="text" name="password" id="password">
    <br/>Profession: <input type="text" name="profession" id="profession">
    <br/>Area code:<input type="text" name="areaCode" id="areaCode">
    <button type="button" onClick="addUser()">Add new user</button>
    </form>
</body>
</html>
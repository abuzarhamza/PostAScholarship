<div class="container">
	<div class="alert" id="validation_msg">                  
    </div>

    <form class="form-signin" role="form" method="post" action="./admin_login.php?action=login" name ="adminlogin" id="adminlogin">
      <h2 class="form-signin-heading">Admin Login</h2>
      <input type="username" class="form-control" placeholder="User name" id ="username" name="username" required autofocus>
      <input type="password" class="form-control" placeholder="Password" id ="password" name="password" required>
      <button class="btn btn-lg btn-primary btn-block" type="submit" >Sign in</button>
    </form>
</div>

<script language="Javascript" type="text/javascript">
$(document).ready(function(){

	$("#adminlogin").submit(function(){
	        form=document.adminlogin;
	        error=0;
	        msg="";
	        
	        if( $("#username").val()==null || $("#username").val()=="")
	        {
	            error=1;
	            msg+='&bull; Please enter user name.<br>';
	        }
	        if($("#password").val()==null || $("#password").val()=="")
	        {
	            error=1;
	            msg+='&bull; Please enter password<br>';
	        }
	        
	        //return false;
	        if(error==1)
	        {
	            document.getElementById("validation_msg").innerHTML=msg;
	            //alert(msg);
	            $(".alert").show();
	            return false;
	        }
	        else
	        {
	           
	            $(".loading").show();
	            
	            $.ajax({
	                url: 'center_ops.php?action=login',
	                data: $("#adminlogin").serialize(),
	                type: "POST",
	                success: function(response){
	                    if(response!='Success'){
	                        alert(response);
	                        
	                    }
	                    else{
	                        
	                            redirect("center_account.php");
	                       
	                    }
	                    
	                    $(".loading").hide();
	                }
	            });
	            
	            return false;
	        }
	    });

});
</script> 
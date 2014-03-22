<?php if($RES=="login_error") { ?>

    <div class="alert alert-danger">
        <a class="close" data-dismiss="alert">×</a>
        <strong>Error!</strong> Please enter the valid Username and Password.
    </div>
<? } ?>

<?php if ($RES=="logout_success") { ?>
    <div class="alert alert-success">
        <a class="close" data-dismiss="alert">×</a>
    <strong>Success!</strong> You have logout successfully.
    </div>
<? } ?>


<? if($RES=="change_password_success") { ?>
    <div class="alert alert-info">
      <a class="close" data-dismiss="alert">×</a>
      <strong>Info!</strong> Your Password changed successfully<br>Please login again with your new Password.
    </div>
<? } ?>

<div class="container">
    <div id="validation_msg" class="hide"></div>

    <form class="form-signin" role="form" method="post" action="./admin_login.php?action=login" name ="adminlogin" id="adminlogin" onSubmit="return check_form();">
      <h2 class="form-signin-heading">Admin Login</h2>
      <input type="username" class="form-control" placeholder="User name" id ="username" name="username" required autofocus>
      <input type="password" class="form-control" placeholder="Password" id ="password" name="password" required>
      <button class="btn btn-lg btn-primary btn-block" type="submit" >Sign in</button>
    </form>
</div>

<script language="Javascript" type="text/javascript">
function check_form()
{
    form=document.frmLogin;
    error=0;
    msg="";
    if(trim(form.username.value)==null)
    {
        error=1;
        msg+='&bull; Please enter Username<br>';
    }
    if(trim(form.password.value)==null)
    {
        error=1;
        msg+='&bull; Please enter Password<br>';
    }

    if(error==1)
    {
        document.getElementById("validation_msg").className="validation";
        document.getElementById("validation_msg").innerHTML=msg;

        return false;
    }
    else
    {
        return true;
    }
}

</script> 
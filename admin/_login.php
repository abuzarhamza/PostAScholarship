<!-- login error message-->
<?php if($RES=="login_error") : ?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11 col-md-offset-1 col-lg-offset-1">
            <div class="alert alert-danger">
                <a class="close" data-dismiss="alert">×</a>
                <strong>Error!</strong> Please enter the valid Username and Password.
            </div>
        </div> <!--close col-->
    </div> <!--close row-->

<?php endif; ?>

<?php if ($RES=="logout_success") : ?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11 col-md-offset-1 col-lg-offset-1">
            <div class="alert alert-success">
                <a class="close" data-dismiss="alert">×</a>
                <strong>Success!</strong> You have logout successfully.
            </div>
        </div> <!--close col-->
    </div> <!--close row-->
<?php endif; ?>


<? if($RES=="change_password_success") : ?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11 col-md-offset-1 col-lg-offset-1">
            <div class="alert alert-info">
              <a class="close" data-dismiss="alert">×</a>
              <strong>Info!</strong> Your Password changed successfully<br>Please login again with your new Password.
            </div>
        </div> <!--close col-->
    </div> <!--close row-->
<?php endif; ?>


<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11 col-md-offset-1 col-lg-offset-1">
        <div id="validation_msg" class="hide"></div>
    </div> <!--close col-->
</div> <!--close row-->

<!--admin login panel-->
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11 col-md-offset-1 col-lg-offset-1">
        <h1><i class="fa fa-laptop"></i> Admin Login Panel<h1>
    </div> <!--close col-->
</div> <!--close row-->

<!--form-->

<form class="form-signin" role="form" method="post" action="./admin_login.php?action=login" name ="adminlogin" id="adminlogin" onSubmit="return check_form();">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-md-offset-1 col-lg-offset-1">
        <input type="username" class="form-control" placeholder="User name" id ="username" name="username" required autofocus>
      </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-md-offset-1 col-lg-offset-1">
            <input type="password" class="form-control" placeholder="Password" id ="password" name="password" required>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-md-offset-1 col-lg-offset-1">
            <button class="btn btn-lg btn-primary btn-block" type="submit" >Sign in</button>
        </div>
    </div>
</form>

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
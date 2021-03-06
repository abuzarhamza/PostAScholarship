<?php if( CheckAdminLogedIn() ) {?>
  <!--navigation panel-->
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    </div> <!--close row-->
  </div> <!--close row-->

  <div row>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">

          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php?page=home">PostAScholarship Admin Panel</a>
          </div>

           <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                  <li><a href="./index.php?page=dashboard"><span class="glyphicon glyphicon-book"></span> Dashboard </a></li>
                  <li><a href="./index.php?page=settings"><span class="glyphicon glyphicon-wrench"></span> Settings </a></li>
                  <li><a href="./index.php?page=profile"><span class="glyphicon glyphicon-user"></span> Profile </a></li>
                </ul>
                <form class="navbar-form navbar-right" role="form" method="post" action="./admin_login.php?action=logout" name ="adminlogout" id="adminlogout">
                  <button type="submit" class="btn btn-primary" >Log out</button>
                </form>
          </div>
        <!--</div>-->
      </div>
    </div>
</div>

<?php if (array_key_exists('page', $_GET)) {
      $page = $_GET['page'];
      if ( $page == "settings" ) {
?>
            <!--Banner-->
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
                <h1>Settings</h1>
              </div>
            </div>

            <!--Breadcrum-->
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >
                  <ol class="breadcrumb">
                    <li><a href="./index.php?page=home">Home</a></li>
                    <li class="active">Settings</li>
                  </ol>
              </div>
            </div>

            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-md-offset-1 col-lg-offset-1">
                <div class="span2">
                  <p><a href="./manage_admin_details.php"><button class="btn btn-default btn-lg btn-block"><span class="glyphicon glyphicon-file"> </span> Manage admin detail</button></p>
                  <p><a href="./change_admin_password.php"><button class="btn btn-default btn-lg btn-block"><span class="fa fa-key"></span> Change Password</button></a></p>
                </div>
              </div>
            </div>



<?  } elseif ( $page == "profile" ) { ?>
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >
          <h1>Profile</h1>
      </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >
            <ol class="breadcrumb">
              <li><a href="./index.php?page=home">Home</a></li>
              <li class="active">Profile</li>
            </ol>
        </div>
    </div>

    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-md-offset-1 col-lg-offset-1">
        <div class="span2">
          <p><a href="./profile_manager.php"><button class="btn btn-default btn-lg btn-block"><span class="glyphicon glyphicon-file"> </span> Update admin detail</button></p>
        </div>
      </div>
    </div>

<? } elseif ( $page == "dashboard" ) { ?>

    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >
          <h1>Dashboard</h1>
      </div>
    </div>

    <!--Breadcrum-->
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >
          <ol class="breadcrumb">
            <li><a href="./index.php?page=home">Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-md-offset-1 col-lg-offset-1">
        <div class="span2">
          <p><a href="./post.php"><button class="btn btn-default btn-lg btn-block"><span class="glyphicon glyphicon-file"> </span> Manage Post</button></p>
          <p><a href="./change_admin_password.php"><button class="btn btn-default btn-lg btn-block"><span class="glyphicon glyphicon-tags"></span> Manage Tags</button></a></p>
          <p><a href="./change_admin_password.php"><button class="btn btn-default btn-lg btn-block"><span class="glyphicon glyphicon-star-empty"></span> Manage Badge</button></a></p>
          <p><a href="./change_admin_password.php"><button class="btn btn-default btn-lg btn-block"><span class="glyphicon glyphicon-pushpin"></span> Manage SocialBookmarks</button></a></p>
          <p><a href="./change_admin_password.php"><button class="btn btn-default btn-lg btn-block"><span class="fa fa-users"></span>  Manage User</button></a></p>
          <p><a href="./change_admin_password.php"><button class="btn btn-default btn-lg btn-block"><span class="fa fa-lock"></span>  Manage admin</button></a></p>
        </div>
      </div>
    </div>

  <?php } elseif ( $page == "home" )  { ?>
      <div class="jumbotron">
        <h1>Hello, Admin!</h1>
        <p>Check navigation button on the right top corner.To learn about the navigation panel
          check the learn more buttons
        </p>
        <p><a class="btn btn-primary btn-lg" role="button">Learn more</a></p>
      </div>
<?php }
  }
} ?>
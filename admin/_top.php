
<!--create navigation panel-->
<?php if( CheckAdminLogedIn() ) {?>


  <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">PostAScholarship Admin Panel</a>
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
    </div>
  </div>

<?php if (array_key_exists('page', $_GET)) {
      $page = $_GET['page'];
      if ( $page == "settings" ) {
?>

            <h1>Settings</h1>
            <button type="button" class="btn btn-default btn-lg">
              <span class="glyphicon glyphicon-file"> Manage admin detail</span>
            </button>
            <br/><br/>
            <a href="./change_admin_password.php">
             <button type="button" class="btn btn-default btn-lg">
                  <span class="fa fa-key"> Change Password</span>
             </button>
            </a>

<?  } elseif ( $page == "profile" ) { ?>
                <h1>Profile</h1>
               <button type="button" class="btn btn-default btn-lg">
                  <span class="glyphicon glyphicon-user"> Update user profile</span>
               </button>
<? } elseif ( $page == "dashboard" ) { ?>

                <h1>Dashboard</h1>
                 <button type="button" class="btn btn-default btn-lg">
                    <span class="glyphicon glyphicon-file"> Manage Post</span>
                 </button>
                 <br/><br/>
                 <button type="button" class="btn btn-default btn-lg">
                    <span class="glyphicon glyphicon-tags"> Manage Tags</span>
                 </button>
                 <br/><br/>
                 <button type="button" class="btn btn-default btn-lg">
                    <span class="glyphicon glyphicon-star-empty"> Manage Badge</span>
                 </button>
                 <br/><br/>
                  <button type="button" class="btn btn-default btn-lg">
                    <span class="glyphicon glyphicon-pushpin"> Manage SocialBookmarks</span>
                 </button>
                 <br/><br/>
                  <button type="button" class="btn btn-default btn-lg">
                    <span class="fa fa-users"> Manage User</span>
                  </button>
                  <br/><br/>
                  <button type="button" class="btn btn-default btn-lg">
                    <span class="fa fa-lock"> Manage admin </span>
                  </button>
  <?php }
    }
} ?>
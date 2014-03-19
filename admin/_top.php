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
        <a class="navbar-brand" href="index.php">PostAScholarship</a>
      </div>
      
  		 <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
              <li><a href="dashboard_manager.php">Dashboard</a></li>
              <li><a href="setting_manager.php">Settings</a></li>
              <li><a href="profile_manager.php">Profile</a></li>
              <li><a href="help.php">Help</a></li>
            </ul>
            <form class="navbar-form navbar-right">
              <input type="text" class="form-control" placeholder="Search...">
              <button type="submit" class="btn btn-primary">Log out</button>
            </form>
        </div>
    </div>
  </div>

<?php } ?>




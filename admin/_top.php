<!--create navigation panel-->
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">PostAScholarShip</a>
    </div>
    <!--if admin is not login-->
    <?php if( ! CheckAdminLogedIn() ) {?>
	    <div class="navbar-collapse collapse">
	      <form class="navbar-form navbar-right" role="form">
	        <div class="form-group">
	          <input type="text" placeholder="Email" class="form-control">
	        </div>
	        <div class="form-group">
	          <input type="password" placeholder="Password" class="form-control">
	        </div>
	        <button type="submit" class="btn btn-success">Sign in</button>
	      </form>
	    </div><!--/.navbar-collapse -->
	<? } else { ?>
		 <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Help</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
            <button type="submit" class="btn btn-primary">Log out</button>
          </form>
        </div>
	<?php } ?>
  </div>
</div>

<!--dashboard -->
<?php if ( CheckAdminLogedIn() ) { ?>
<? } ?>


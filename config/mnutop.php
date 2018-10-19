<body class="hold-transition skin-blue sidebar-mini fixed">
    <div class="wrapper">
	<?php
		$logotipo = $_SESSION['logo'];
		//session_start();
		require_once("../model/recordset.php");
		require_once("../class/class.functions.php");
	?>
	<header class="main-header">
        <!-- Logo -->
        <a href="<?=$hosted."/triangulo";?>" class="logo">
			<!-- mini logo for sidebar mini 50x50 pixels -->
			<span class="logo-mini"><img src="<?=$hosted."/".$logotipo;?>" width="50"/></span>
			<!-- logo for regular state and mobile devices -->
			<span class="logo-lg"><img src="<?=$hosted."/".$logotipo;?>" width="50"/></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
			<!-- Sidebar toggle button-->
			<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
				<span class="sr-only">Toggle navigation</span>
			</a>
			<div class="navbar-custom-menu" id="alms">
			<ul id="almsg" class="nav navbar-nav">
				
				<?php
					require_once("../view/alert_msgs.php");
				?>
				
              
            </ul>
          </div>
        </nav>
      </header>

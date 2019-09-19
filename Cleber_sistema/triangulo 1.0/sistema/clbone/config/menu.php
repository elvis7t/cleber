<?php
$token = (isset($_SESSION['token'])? "?token=".$_SESSION['token']:"");
if($sec=="home"){require_once('../model/recordset.php');}
$rs = new recordset();
$rs2 = new recordset();
$rs->Seleciona("*","menu_clbone","mnu_niveis like '%[".$_SESSION['classe']."]%' AND mnu_hier='P'","","mnu_cod ASC");
?>

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <?php
            if(isset($_SESSION["nome_usu"])):?> 
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $hosted.$_SESSION["usu_foto"]; ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?= $_SESSION['nome_usu']; ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <?php else:?><div></div><?php endif;?>
        <!-- search form -->
        <form action="pesquisa.php<?=$token;?>&cnpj=<?=$_SESSION['usu_empresa'];?>" method="POST" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="O que você procura?">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <?php
            while ($rs->GeraDados()) {?>
                <li <?php if($sec == $rs->fld("mnu_sess")){ echo 'class="active"';}?>>
                    <a href="<?= $hosted."/clbone/view/".$rs->fld("mnu_link").$token; ?>&cnpj=<?=$_SESSION['usu_empresa'];?>">
                        <i class="<?= $rs->fld("mnu_icon"); ?>"></i> <span><?=$rs->fld("mnu_titulo");?></span>
                    </a>
                    <?php
					if($rs->fld("mnu_filhos")==1):
					?>
                    <ul class="treeview-menu">
						<?php
						$rs2->Seleciona("*","menu_clbone","mnu_sess ='".$rs->fld("mnu_sess")."' AND mnu_cod > ".$rs->fld("mnu_cod")." AND mnu_niveis like '%[".$_SESSION['classe']."]%' AND mnu_hier='F'");
						echo "<!-- {$rs2->sql}-->";
						while ($rs2->GeraDados()):?>
							<li class='<?=($rs2->fld("mnu_link") == $pag ? "active" : "");?>'>
								<a href="<?= $hosted."/clbone/view/".$rs2->fld("mnu_link").$token; ?>&cnpj=<?=$_SESSION['usu_empresa'];?>">
									<i class="<?= $rs2->fld("mnu_icon"); ?>"></i> <span><?=$rs2->fld("mnu_titulo");?></span>
								</a>
							</li>
						<?php endwhile;?>
                    </ul>
					<?php endif;?>
                </li>
            <?php
            }
            ?>
            
            <!--
            <li class="treeview">
                    <a href="#">
                            <i class="fa fa-files-o"></i>
                                    <span>Layout Options</span>
                                    <span class="label label-primary pull-right">4</span>
                    </a>
                    <ul class="treeview-menu">
                            <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
                            <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
                            <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
                            <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
                    </ul>
            </li>
            <li class="treeview">
                    <a href="#">
                            <i class="fa fa-pie-chart"></i>
                            <span>Charts</span>
                            <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                            <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a></li>
                            <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a></li>
                            <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
                            <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>
                    </ul>
            </li>
            <li class="treeview">
                    <a href="#">
                            <i class="fa fa-laptop"></i>
                            <span>UI Elements</span>
                            <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                            <li><a href="pages/UI/general.html"><i class="fa fa-circle-o"></i> General</a></li>
                            <li><a href="pages/UI/icons.html"><i class="fa fa-circle-o"></i> Icons</a></li>
                            <li><a href="pages/UI/buttons.html"><i class="fa fa-circle-o"></i> Buttons</a></li>
                            <li><a href="pages/UI/sliders.html"><i class="fa fa-circle-o"></i> Sliders</a></li>
                            <li><a href="pages/UI/timeline.html"><i class="fa fa-circle-o"></i> Timeline</a></li>
                            <li><a href="pages/UI/modals.html"><i class="fa fa-circle-o"></i> Modals</a></li>
                    </ul>
            </li>
            <li class="treeview">
                    <a href="#">
                            <i class="fa fa-edit"></i> <span>Forms</span>
                            <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                            <li><a href="pages/forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
                            <li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
                            <li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
                    </ul>
            </li>
            <li class="treeview">
                    <a href="#">
                            <i class="fa fa-table"></i> <span>Tables</span>
                            <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                            <li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i> Simple tables</a></li>
                            <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i> Data tables</a></li>
                    </ul>
            </li>
            <li>
                    <a href="pages/calendar.html">
                            <i class="fa fa-calendar"></i> <span>Calendar</span>
                            <small class="label pull-right bg-red">3</small>
                    </a>
            </li>
            <li>
                    <a href="pages/mailbox/mailbox.html">
                            <i class="fa fa-envelope"></i> <span>Mailbox</span>
                            <small class="label pull-right bg-yellow">12</small>
                    </a>
            </li>
            <li class="treeview">
                    <a href="#">
                            <i class="fa fa-folder"></i> <span>Examples</span>
                            <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                            <li><a href="pages/examples/invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
                            <li><a href="pages/examples/profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
                            <li><a href="pages/examples/login.html"><i class="fa fa-circle-o"></i> Login</a></li>
                            <li><a href="pages/examples/register.html"><i class="fa fa-circle-o"></i> Register</a></li>
                            <li><a href="pages/examples/lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
                            <li><a href="pages/examples/404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
                            <li><a href="pages/examples/500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
                            <li><a href="pages/examples/blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
                     </ul>
            </li>
            <li class="treeview">
                    <a href="#">
                            <i class="fa fa-share"></i> <span>Multilevel</span>
                            <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                            <li>
                            <a href="#"><i class="fa fa-circle-o"></i> Level One <i class="fa fa-angle-left pull-right"></i></a>
                                    <ul class="treeview-menu">
                                            <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                                            <li>
                                                    <a href="#"><i class="fa fa-circle-o"></i> Level Two <i class="fa fa-angle-left pull-right"></i></a>
                                                            <ul class="treeview-menu">
                                                                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                                                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                                            </ul>
                                            </li>
                                    </ul>
                            </li>
                            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                    </ul>
            </li>
            <li><a href="documentation/index.html"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
            <li class="header">LABELS</li>
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
            -->

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

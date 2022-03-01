<?php
include "functions.php";
include "./sis32/db_connect.php";

sec_session_start();
include "/class/init.php";

if(login_check ($mysqli) == false) {
  echo "<link href='../pengaturan/adminstyle.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=index.php><b>LOGIN</b></a></center>";
die;}
$namauser=array();
$namauser = ceknama($mysqli) ;

$Statuss=array("Error","Active", "No  Publish", "Obsolete");
$part_arrays=array("Part 0. General","Part 1. Seagoing Ship","Part 2. Inland Waterway","Part 3. Special Ships","Part 4. Special Equipment and Systems","Part 5. Offshore Technology","Part 6. Statutory","Part 7. Class Notation","Part 8. Material");
$JenisTechnical_paper=array("Error","Rules", "Guidelines", "Guidance", "Reference Note");
$nama_vol=array("( Vol 0 )","( Vol I )","( Vol II )","( Vol III )","( Vol IV )","( Vol V )","( Vol VI )","( Vol VII )","( Vol VIII )","( Vol IX )","( Vol X )","( Vol XI )","( Vol XII )","( Vol XIII )","( Vol XIV )","( Vol XV )","( Vol XVI )","( Vol XVII )","( Vol XVIII )","( Vol XIX )","( Vol XX )","( Vol XI )","( Vol XXII )","( Vol XXIII )","( Vol XXIV )","( Vol XXV )","( Vol XXVI )","( Vol XXVII )","( Vol XXVIII )","( Vol XXIX )","( Vol XXX )","( Vol XXXI )","( Vol XXXII )","( Vol XXXIII )","( Vol XXXIV )","( Vol XXXV )","( Vol XXXVI )","( Vol XXXVII )","( Vol XXXVIII )","( Vol XXXIX )","( Vol XL )","( Vol XLI )","( Vol XLII )","( Vol XLIII )","( Vol XLIV )","( Vol XLV )");		  


$nama_vol_G=array("( Vol 0 )","( Vol A )","( Vol B )","( Vol C )","( Vol D )","( Vol E )","( Vol F )","( Vol G )","( Vol H )","( Vol I )","( Vol J )","( Vol K )","( Vol L )","( Vol M )","( Vol N )","( Vol O )","( Vol P )","( Vol Q )","( Vol R )","( Vol S )","( Vol T )","( Vol U )","( Vol V )","( Vol W )","( Vol X )","( Vol Y )","( Vol Z )","( Vol AA )","( Vol AB )","( Vol AC )","( Vol AD )","( Vol AF )","( Vol AG )","( Vol AH )","( Vol AI )","( Vol AJ )","( Vol AK )","( Vol AL )","( Vol AM )","( Vol AN )","( Vol AO )","( Vol AP )","( Vol AQ )","( Vol AR )","( Vol AS )","( Vol AT )");		  


$salting = $_SESSION['salt'];
$user_id = $_SESSION['user_id'];
$nama_user = $_SESSION['usernama'] ;
if ($load_deskr = $mysqli->prepare("SELECT  jabatan, alamat, email, ym, fb, handphone, tujuan, edukasi, pekerjaan, path  FROM rm_biodata  where id_user  = ?  LIMIT 1")) {   
				   // Execute the prepared query.
				       $load_deskr->bind_param('s', $user_id ); // Bind "$id_rules" to parameter.
					   $load_deskr->execute();
					    $load_deskr->store_result();
					   $load_deskr->bind_result($jabatan, $alamat,$email, $ym, $fb , $handphone , $tujuan , $edukasi , $pekerjaan , $path );

				
					   $load_deskr->fetch();
					   
	}				


if (isset($path)){ $wajah=$path;
}else{$wajah="img/img-profile.jpg";}



//unread message
if ($load_deskr = $mysqli->prepare("select m.mid, m.seq, m.created_on, m.created_by, m.body, r.status, u.path from message2_recips r
inner join message2 m on m.mid=r.mid and m.seq=r.seq
inner join rm_biodata u on u.id_user=m.created_by
where r.uid=? and r.status in ('A', 'N')  and r.status != 'A'  
and r.seq=(select max(rr.seq) from message2_recips rr where rr.mid=m.mid and rr.status in ('N'))
and if (m.seq=1 and m.created_by=?, 1=0, 1=1)
order by created_on desc ")) {   
				   // Execute the prepared query.
				   
						 $load_deskr->bind_param('ii', $user_id, $user_id ); 
					   $load_deskr->execute();
					    $load_deskr->store_result();
					   $load_deskr->bind_result($id, $sec, $create_on,$create_by,$body,$status, $alamat );
					   $row_cnt = $load_deskr->num_rows;
					  $unread = $load_deskr->num_rows;
}


?>


<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>RMS | Rules Management System | Biro kLasifikasi Indonesia</title>
   <link rel="stylesheet" type="text/css" href="css/reset.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/text.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/grid.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/layout.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/nav.css" media="screen" />
	<link href="css/table/demo_page.css" rel="stylesheet" type="text/css" />
	<link href="css/themes/base/custom.css" rel="stylesheet" type="text/css" />
    <!--[if IE 6]><link rel="stylesheet" type="text/css" href="css/ie6.css" media="screen" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" type="text/css" href="css/ie.css" media="screen" /><![endif]-->
    <!-- BEGIN: load jquery -->
			  <script src="js/pace.min.js"></script>
		 <link href="css/pace_theme.css" rel="stylesheet" />
    <script src="js/jquery-1.6.4.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jquery-ui/jquery.ui.core.min.js"></script>
    <script src="js/jquery-ui/jquery.ui.widget.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.ui.accordion.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.effects.core.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.effects.slide.min.js" type="text/javascript"></script>
    <!-- END: load jquery -->
    <!-- BEGIN: load jqplot -->
    <link rel="stylesheet" type="text/css" href="css/jquery.jqplot.min.css" />
    <!--[if lt IE 9]><script language="javascript" type="text/javascript" src="js/jqPlot/excanvas.min.js"></script><![endif]-->
    <script language="javascript" type="text/javascript" src="js/jqPlot/jquery.jqplot.min.js"></script>
    <script type="text/javascript" src="js/jqPlot/plugins/jqplot.canvasTextRenderer.min.js"></script>
    <script type="text/javascript" src="js/jqPlot/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
    <script language="javascript" type="text/javascript" src="js/jqPlot/plugins/jqplot.barRenderer.min.js"></script>
    <script language="javascript" type="text/javascript" src="js/jqPlot/plugins/jqplot.pieRenderer.min.js"></script>
    <script language="javascript" type="text/javascript" src="js/jqPlot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
    <script language="javascript" type="text/javascript" src="js/jqPlot/plugins/jqplot.highlighter.min.js"></script>
    <script language="javascript" type="text/javascript" src="js/jqPlot/plugins/jqplot.pointLabels.min.js"></script>
    <script type="text/javascript" src="js/jqPlot/plugins/jqplot.donutRenderer.min.js"></script>
    <script type="text/javascript" src="js/jqPlot/plugins/jqplot.bubbleRenderer.min.js"></script>
    <!-- END: load jqplot -->
    <script src="js/setup.js" type="text/javascript"></script>
  <script type="text/javascript">

        $(document).ready(function () {
            setupLeftMenu();

          			setSidebarHeight();


        });
    </script>

</head>
<body>
    <div class="container_12">
        <div class="grid_12 header-repeat">
            <div id="branding">
                <div class="floatleft">
                    <img src="img/logo.png" alt="Logo" /></div>
                <div class="floatright">
                    <div class="floatleft">
                        <a href="panel.php?module=profile"><img  src="<?php echo $path ; ?> " alt="Profile Pic" style="width:30px;" /></a></div>
                    <div class="floatleft marginleft10">
                        <ul class="inline-ul floatleft">
                            <li>Hello <?php echo $nama_user ; ?></li>
                            <li><a href="panel.php?module=editprofile">Config</a></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                        <br />
                        <span class="small grey">Date : <?php echo date("Y-m-d"); ?></span>
                    </div>
                </div>
                <div class="clear">
                </div>
            </div>
        </div>
        <div class="clear">
        </div>
        <div class="grid_12">
		<!-- menghilangkan menu atas
            <ul class="nav main">
                <li class="ic-dashboard"><a href="panel.php?module=home"><span>Dashboard</span></a> </li>
                <li class="ic-form-style"><a href="javascript:alert('This menu is being develop');"><span>Controls</span></a>
                    <ul>
                      
                    </ul>
                </li>
				<li class="ic-charts"><a href="javascript:"><span>Social</span></a>
				 <ul>
                        <li><a onClick="openWin();" href="#">Send Message</a> </li>
                        <li><a href="panel.php?module=profile">My Profile</a> </li>
                        <li><a href="panel.php?module=editprofile">Edit Profile</a> </li>
                        <li><a href="panel.php?module=whiteboard">White Board</a> </li>
						<li><a href="panel.php?module=wisdom">Write a Wisdom </a> </li>
						<li><a onClick="openWin2();" href="#">Change Password </a> </li>
                    </ul>
				</li>
                <li class="ic-charts"><a href="panel.php?module=email"><span>Email BKI</span></a></li>
               
				
		
    		 <li class="ic-grid-tables"><a href="panel.php?module=message&sub=inbox"><span>Message</span></a> 	<?php if ($unread!=0){echo "<div class='noti_bubble'>" .   $unread . "</div>" ; } ?> </li>
    

				
                <li class="ic-gallery dd"><a href="javascript:"><span>Rules Management</span></a>
				<ul>
 
                         <li><a href="panel.php?module=clistrules">Add Rules whitout RMS but*</a> </li>
						 <li><a href="panel.php?module=createlistrules">Add Rules List</a> </li>
						 <li><a href="panel.php?module=ccorigenda">Add Korigenda</a> </li>
						  <li><a href="panel.php?module=Rule_promot">Rule Promotion</a> </li>
						  <li><a href="panel.php?module=lengkap">completeness Assesment</a> </li>
						 <li><a href="panel.php?module=sipat">Sipat Assesment</a> </li>
						 <li><a href="panel.php?module=synk">Sync Manager</a> </li>
						 <li><a href="panel.php?module=monserver">Server Monitoring</a> </li>
						  <li><a href="panel.php?module=damageStatistik">Damage Statistik</a> </li>
						
						
                        
                </ul>
               		
                </li>
                <li class="ic-notifications"><a href="javascript:"><span>Administration</span></a>
				<ul>
                        <li><a href="panel.php?module=administratif">Add User</a> </li>
						<li><a href="panel.php?module=rule_guard">Add Rules Guardian</a> </li>
                        <li><a href="panel.php?module=man_taskrules">Managing Task</a> </li>
                        <li><a href="panel.php?module=planman">Plan Manager</a> </li>
						<li><a onClick="openWin3();" href="#">Change user Passwords</a> </li>
						<li><a href="panel.php?module=vkpi">Log OF people</a> </li>
                        
                    </ul>
				</li>

            </ul>
			-->
        </div>
        <div class="clear">
        </div>
        <div class="grid_2">
            <div class="box sidemenu">
                <div class="block" id="section-menu">
				<!-- menghilangkan menu kiri
                    <ul class="section menu">
                        <li><a class="menuitem style1">Rules Manager </a>
                            <ul class="submenu">
							<li><a href="panel.php?module=listrule">Task Rules list </a> </li>
                                <li><a href="panel.php?module=crules">Create New </a> </li>
                                <li><a href="panel.php?module=lisproj"> List Task Project </a> </li>
                                <li><a href="panel.php?module=rulesrelation">Rules Relation</a> </li>
								<li><a href="panel.php?module=rulepub">List Rules Public</a> </li>
                                <li><a>*Beta Ship correlation</a> </li>
                            </ul>
                      </li>
                        <li><a class="menuitem style1">Rules Support </a>
                            <ul class="submenu">
                                <li><a href="panel.php?module=rulepub">List Rules Public</a> </li>
								<li><a href="panel.php?module=cliterature">Add Other Literature </a> </li>
                                <li><a href="panel.php?module=kamus">Kamus</a> </li>
                                <li><a href="panel.php?module=publish">Rules Explorer </a> </li>
                                <li><a  href="panel.php?module=master">Master Explorer </a> </li>
								<li><a  href="panel.php?module=format">Format & Standart</a> </li>
                            </ul>
                      </li>
                        <li><a class="menuitem style1">People</a>
                            <ul class="submenu">
                                <li><a  href="panel.php?module=profile">My Profile </a> </li>
                                <li><a  href="panel.php?module=editprofile">Edit Profile </a> </li>
                                <li><a  href="panel.php?module=friendlist">Friend List </a> </li>
                                <li><a  href="panel.php?module=message&sub=inbox">Inbox</a> </li>
								<li><a  href="panel.php?module=message&sub=sent">Sent</a> </li>
								<li><a  href="panel.php?module=whiteboard">whiteboard R & D</a> </li>
                                <li><a  href="panel.php?module=wisdom">Wisdom</a> </li>
								 <li><a  href="panel.php?module=diary">Diary</a> </li>
                            </ul>
                      </li>
                        <li><a class="menuitem style1">Teleport Link</a>
                            <ul class="submenu">
                                <li><a href="http://10.0.1.202/wg" target="_blank">Padepokan Cyber BKI</a> </li>
                                <li><a href="http://10.0.1.202/dc" target="_blank">Teliksandi</a> </li>
                                <li><a href="ftp://10.0.1.202/" target="_blank">File Center </a> </li>
                                <li><a href="http://10.0.1.202/" target="_blank">RND portal </a> </li>
								<li><a href="http://rnd.bki.co.id/rms/modern/panel.php?module=home" target="_blank">Modern Prototype </a> </li>
								<li><a href="javascript:alert('This menu is being develop');" >Rukun Travel </a> </li>
                   
                            </ul>
                      </li>
					  
					  <?php
					  
					  if ($salting==9) { echo "
					   <li><a class='menuitem style1'>Dewaruchi C&C</a>
                            <ul class='submenu'>
                                <li><a href='panel.php?module=comregis' >Computer Register</a> </li>
                                
                            </ul>
                      </li>" ; }
					  
					  ?>
                    </ul>
					-->
                </div>
				
            </div>
			
        </div>
        <div class="grid_10">
           <?php if ($_GET['module']=='lisproj'  ) { include "rules/listproj.php" ;}
		   elseif ($_GET['module']=='home'){	include "dashboard.php" ; }
		   elseif ($_GET['module']=='crules'){	include "rules/r_awal.php" ; }
		   elseif ($_GET['module']=='ccorigenda'){	include "rules/corrigenda.php" ; }
		   elseif ($_GET['module']=='rule_guard'){	include "rules/rule_guadr.php" ; }
		   elseif ($_GET['module']=='Rule_promot'){	include "rules/rule_promote.php" ; }
		   elseif ($_GET['module']=='ed_cek'){	include "rules/cek_po.php" ; }
		   elseif ($_GET['module']=='sipat'){	include "rules/sipat.php" ; }
		   elseif ($_GET['module']=='lengkap'){	include "rules/cek_kelengkapan.php" ; }
		   elseif ($_GET['module']=='clistrules'){	include "rules_sup/crrules.php" ; }
		   elseif ($_GET['module']=='createlistrules'){	include "rules_sup/crete_rules_list.php" ; }
		   
		   elseif ($_GET['module']=='cliterature'){	include "rules_sup/n_oth_literatur.php" ; }
		   elseif ($_GET['module']=='kamus'){	include "rules_sup/kamus.php" ; }
		   elseif ($_GET['module']=='master'){	include "rules_sup/exploer.php" ; }
		   elseif ($_GET['module']=='publish'){	include "rules_sup/exploer.php" ; }
		   elseif ($_GET['module']=='profile'){	include "people/profil.php" ; }
		   elseif ($_GET['module']=='editprofile'){	include "people/profile_edit.php" ; }
		   elseif ($_GET['module']=='listrule'){	include "rules_sup/listruler.php" ; }
		   elseif ($_GET['module']=='viewrules'){	include "rules/tom.php" ; }
		   elseif ($_GET['module']=='friendlist'){	include "people/friendlist.php" ; }
		   elseif ($_GET['module']=='whiteboard'){	include "people/whiteboard.php" ; }
		   elseif ($_GET['module']=='message'){	include "people/inbox.php" ; }
		   elseif ($_GET['module']=='wisdom'){	include "people/wisdom.php" ; }
		   elseif ($_GET['module']=='administratif'){	include "lain32/tambahorang.php" ; }
		   elseif ($_GET['module']=='viewinbox'){	include "people/viewmesa.php" ; }
		   elseif ($_GET['module']=='planman'){	include "lain32/plan_man.php" ; }
		   elseif ($_GET['module']=='rulesrelation'){	include "rules/rules_relation.php" ; }
		   elseif ($_GET['module']=='rulepub'){	include "rules/rule_pub.php" ; }
		    elseif ($_GET['module']=='email'){	include "people/email.php" ; }
		   
		   elseif ($_GET['module']=='monserver'){	include "rules_sup/mon_stat_server.php" ; }
		   
		   
		   
		   elseif ($_GET['module']=='synk'){	include "synk/synk_man.php" ; }
		   
		   elseif ($_GET['module']=='diary'){	include "people/diary.php" ; }
		   elseif ($_GET['module']=='vkpi'){	include "people/man_show_diary.php" ; }
		   
		   
		    elseif ($_GET['module']=='man_taskrules'){	include "rules/man_monitor_rule.php" ; }
		   
		   elseif ($_GET['module']=='damageStatistik'){	include "rules_sup/damageStatistik.php" ; }

		   elseif ($_GET['module']=='format'){	include "rules_sup/format.php" ; }
		    elseif ($_GET['module']=='comregis'){	include "dcc/com_register.php" ; }
			
		   else {die;}
			
			
		   ?>
		   
		      <script>
function openWin()
{
myWindow=window.open('people/new_message.php','','width=600,height=220');
myWindow.focus();
}

function openWin2()
{
myWindow=window.open('people/res_pass.php','','width=600,height=220');
myWindow.focus();
}

function openWin3()
{
myWindow=window.open('lain32/change_use_pas.php','','width=600,height=220');
myWindow.focus();
}

</script>
        <div class="clear">
        </div>
    </div>
    <div class="clear">
    </div>
    <div id="site_info">
        <p>
            Copyright <a href="#">Batosai007</a>. All Rights Reserved.
        </p>
    </div>
    
	<style>

.noti_bubble {
    position:absolute;
    top: -10px;
	left:25px;
    

    background-color:red;
    color:white;
    font-weight:bold;
    font-size:1.55em;
    
    border-radius:100px;
    box-shadow:1px 1px 1px gray;

}
	</style>
	
</body>
</html>

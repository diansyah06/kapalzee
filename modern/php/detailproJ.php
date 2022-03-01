<?php
$pagenum_id = 8;
$Users->cekSecuritypeage($user_id, $pagenum_id);
echo set_java_script_plugin_load("profile");
echo set_java_script_plugin_load("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
echo set_java_script_plugin_load("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
echo set_java_script_plugin_load("button");
echo set_java_script_plugin_load("table");
echo set_java_script_plugin_load("getProjectdkk");
echo set_java_script_plugin_load("summer");


$objectid      = $_GET['id'];
$getTipeobject = $obj->getTipeObject($objectid);
//security cek trash

if ($obj->Cektrash($objectid) == false) {
    
    if ($getTipeobject == "ProjectTasks") {
        $idprogresstask = 100;
        $obj->updateprogressTaskobj($user_id, $idprogresstask, $objectid);
        
    }
    echo "<script>    if (window.confirm('object has been remove')) {
        window.location.href='http://rnd.bki.co.id/rms/modern/panel.php?module=home';
        }</script>";
    
    die;
}

//call read function
$obj->updateDatabasereaddetail($objectid, $user_id);
$unicid      = $objectid;
$nameRelated = $obj->GetCorelationname($objectid);
foreach ($nameRelated as $namedsd) {
    $nameRela  = $namedsd['project'];
    $projectID = $namedsd['object_id'];
    $contract  = $namedsd['id_kontrak'];
}

//update notification
$obj->updateNotftable(1, $user_id, $objectid);



$listSubscribers = $obj->getSubcriber($objectid);
$listcommens     = $obj->getcommentbyobj($objectid);
foreach ($listSubscribers as $listSubscriber) {
    $subcriber      = $subcriber . "<li><a href=''>$listSubscriber[nama]</a></li>";
    $isicombo       = $isicombo . "<option value='$listSubscriber[contact_id]' selected>$listSubscriber[nama]</option>";
    $arrasubscriber = $arrasubscriber . "," . $listSubscriber['contact_id'];
}
$noteds = $obj->GetmessageByid($objectid);
foreach ($noteds as $noted) {
    $caption     = $noted['name'];
    $textmessage = $noted['text'];
    $updateon    = $noted['updated_on'];
    $updateBy    = $noted['updated_by_id'];
    $createby    = $noted['nama'];
    $createon    = $noted['created_on'];
    $taskmessage = $noted['task'];
    $taskdue = $noted['due_date'];
}

$tambhanTypograpy = " On Project " . $nameRela . " [$contract]";
if ($getTipeobject == "ProjectMessages") {
    
    $Typography = $tambhanTypograpy . " Note : ";
    $actionMenu = "                <li>
                                            <a href='#' onclick='slideAddnoted();'>Edit</a>
                                        </li>
                                        <li>
                                            <a href='#' onclick='movetotrash($objectid);'>Move to trash</a>
                                        </li>
                                        <li>
                                            Archive
                                        </li>
                                        <li>
                                            <a href='printMessage.php?id=$objectid' target='_blank'>Print view</a>
                                        </li>
                                        <li>
                                            <a href='panel.php?module=viewhistory&id=$objectid' target='_blank'> View History</a>
                                        </li>";
    
} elseif ($getTipeobject == "ProjectFiles") {
    
    $listrevisions = $obj->Getfilerevison($objectid);
    $Typography    = $tambhanTypograpy . " File : ";
    $actionMenu    = "                <li>
                                            <a href='link.php?module=download&id=$objectid' target='_blank'>Download</a>
                                        </li>
                                        <li>
                                            <a href='#updateFile' data-toggle='modal' >Update file</a>
                                        </li>
                                        <li>
                                            <a href='#' onclick='movetotrash($objectid);'>Move to trash</a>
                                        </li>
                                        <li>
                                            Archive
                                        </li>
                                        <li>
                                            Copy this file
                                        </li>
                                        <li>
                                            <a href='panel.php?module=viewhistory&id=$objectid' target='_blank'> View History</a>
                                        </li>";
    
    //listrevision    
    $coloor = "background-color:#FFD39F";
    foreach ($listrevisions as $listrevisions) {
        
        $Docsize  = formatSizeUnits($listrevisions['filesize']);
        $updateOn = date("d/m/Y H:i", strtotime($listrevisions['updated_on']));
        $mimeFile = $listrevisions['type_string'];
        
        $listREvisionn = $listREvisionn . "
        <tr>
	        <td rowspan='2' class='number' style='$coloor'>
		        <a target='_self' class='downloadLink' href='$listrevisions[repository_id]' title='Download ($Docsize)'>
		        <span style='font-size:12px'>#</span>$listrevisions[revision_number]</a>
	        </td>
		        <td class='line_header' style='background-color:#FFD39F;'>
		        <b><a target='overview-panel' class='internalLink' href=''>$listrevisions[nama]</a></b> on $updateOn
	        </td>
	        <td class='line_header_icons' style='background-color:#FFD39F;width:50px;'>
		        <a target='_self' class='downloadLink coViewAction ico-download' href='$listrevisions[repository_id]' title='Download ($Docsize)'>&nbsp;</a>
		        <a target='overview-panel' onclick='movetotrash($listrevisions[id])' href='#' class='internalLink coViewAction ico-trash' title='Move to trash'>&nbsp;</a>
	        </td>
	    </tr>
	    <tr>
	    	<td class='line_comments'><div style='padding:2px;padding-left:6px;padding-right:6px;min-height:24px;'>
	        	$listrevisions[comment]&nbsp;</div>
	        </td>
	        <td class='line_comments_icons'>
	        	<a target='overview-panel' href='#changeInitialname' data-toggle='modal' class='internalLink coViewAction ico-edit' title='Edit revision comment' onClick='setobjectidcomenfile($listrevisions[id]) ;'>&nbsp;</a>
	        </td>
        </tr>

    ";
        
        $lastlink       = $listrevisions['repository_id'];
        $revisionnumber = $listrevisions['revision_number'];
        $windowsString  = "Last revision:Revision #" . $revisionnumber . " (by" . $listrevisions['nama'] . " on " . date("F j, Y, g:i a", strtotime($listrevisions['updated_on'])) . ")";
        $coloor         = "background-color:#EEE";
    }
    
    if ($mimeFile == "application/pdf") {
        
        $iconFile="<img src='assets/images/filetypes/pdf.png' width='20px' alt='image'>";
        //$writePDf = "<embed width='100%' height='900px' name='plugin' src='$lastlink' type='application/pdf'>";
    	$lastlink= base64_encode($lastlink) ;
    	//echo $lastlink ;
        $writePDf = "<iframe src='./enginerrview.php?module=readDoc&pathh=$lastlink' height='900px'' width='100%'></iframe>" ; 




    } elseif (substr($mimeFile, 0, 5) == "image") {
        $iconFile="<img src='assets/images/filetypes/psd.png' width='20px' alt='image'>";
        $writeimage = "<div id='imagedispalay' class='imagedispalay' style='overflow: auto; width: 100%; height: 500px;' >  <img src='$lastlink' alt='test image' /></div>";
        
    } elseif ($mimeFile == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
        
        $iconFile="<img src='assets/images/msword.png' width='20px' alt='image'>";

        // $content = read_file_docx($lastlink);
        // if ($content !== false) {
            
        //     $writeoffice = nl2br($content);
        // } else {
        //     $writeoffice = 'Couldn\'t the file. Please check that file.';
        // }

        $lastlink= base64_encode($lastlink);
    	$writeoffice="<a href='./docviewaspdf.php?filetype=.docx&pathh=$lastlink' target=_blank > View Document as PDF {experimental} </a>";    
        
        
    } elseif ($mimeFile == "application/msword") {
        
        $iconFile="<img src='assets/images/filetypes/doc.png' width='20px' alt='image'>";
        // $content = readWord($lastlink);
        // if ($content !== false) {
            
        //     $writeoffice = nl2br($content);
        // } else {
        //     $writeoffice = 'Couldn\'t the file. Please check that file.';
        // }

   		$lastlink= base64_encode($lastlink);
    	$writeoffice="<a href='./docviewaspdf.php?filetype=.doc&pathh=$lastlink' target=_blank > View Document as PDF {experimental} </a>";     
        
    } elseif ($mimeFile == "text/html") {
    	$iconFile="<img src='assets/images/filetypes/html.png' width='20px' alt='image'>";
        
        $textmessage = $obj->ReadDoc($lastlink);
        
        
        
        $stringLinkEdit = "<li><a href='#' onclick='slideEditDocument();'>Edit</a></li>";
        
        
        $ext = pathinfo($lastlink, PATHINFO_EXTENSION);
        
        //special for slim
        if ($ext == "slim") {
            
            $stringLinkEdit = "<li><a href='#' onClick='editSlideshow($objectid);'>Edit</a></li>
                         <li><a href='#' onclick='Slideshow(dataSlide);'>Slideshow</a></li>";
            echo "<script>var dataSlide='$textmessage' ; </script>";
            $textmessage = "";
        }
        
        $actionMenu = $stringLinkEdit . $actionMenu;

    }elseif($mimeFile == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"){
    	$iconFile="<img src='assets/images/msexcel.png' width='20px' alt='image'>";

    }elseif($mimeFile == "application/vnd.openxmlformats-officedocument.presentationml.presentation"){
    	$iconFile="<img src='assets/images/mspoerpoint.png' width='20px' alt='image'>";
		$lastlink= base64_encode($lastlink);
    	$writeoffice="<a href='./docviewaspdf.php?filetype=.pptx&pathh=$lastlink' target=_blank > View Document as PDF {experimental} </a>";
    }
    
    //echo $mimeFile ;
    
} elseif ($getTipeobject == "ProjectTasks") {
    
    $Taskobjects = $obj->get_projectTaskbyid($objectid);
    
    foreach ($Taskobjects as $Taskobject) {
        
        $assigmentto       = $Taskobject['assigned_to_contact_id'];
        $assigmenton       = $Taskobject['assigned_on'];
        $assigmentby       = $Taskobject['assigned_by_id'];
        $percent_completed = $Taskobject['percent_completed'];
        
    }
    
    if ($percent_completed >= 100) {
        $progressString = "<span class='label label-sm label-success'>Complete 100% </span>";
    } else {
        $progressString = "<span class='label label-sm label-danger'>incomplete  " . $percent_completed . "% </span>";
    }
    
    $windowsString = $progressString . "  &nbsp; &nbsp; Assigned to: " . $alluserArray[$assigmentto] . " By: " . $alluserArray[$assigmentby] . " On: " . date("F j, Y, g:i a", strtotime($assigmenton)) . ", due : <strong>" . date("F j, Y, g:i a", strtotime($taskdue)) . "</strong>" ;
    
    $Typography  = $tambhanTypograpy . " Task : ";
    $textmessage = $taskmessage;
    $actionMenu  = "                    <li>
                                        <a href='#Completetask' data-toggle='modal' >Progress</a>
                                        </li>

                                        <li>
                                            <a href='#' onclick='movetotrash($objectid);'>Move to trash</a>
                                        </li>
                                        <li>
                                            Archive
                                        </li>
                                        <li>
                                            <a href='printMessage.php?id=$objectid' target='_blank'>Print view</a>
                                        </li>
                                        <li>
                                            <a href='panel.php?module=viewhistory&id=$objectid' target='_blank'>View History</a>
                                        </li>";
    
    
}




?>


<style>
	
	element.style {
	}
	.toggle_expanded {
	background-repeat: no-repeat;
	background-image: url(assets/images/minus.gif);
	padding-left: 20px;
	cursor: pointer;
	}

	.toggle_collapse{
	background-repeat: no-repeat;
	background-image: url(assets/images/plus.gif);
	padding-left: 20px;
	cursor: pointer;
	}

	fieldset legenda {
	font-size: 120%;
	font-weight: bolder;

	}



	.ico-edit {
	background: transparent url(assets/images/all_16_16_vertical.png) no-repeat scroll 0 -378px !important;
	}
	.coViewAction {
	background-position: 0pt 2px;
	background-repeat: no-repeat;
	padding: 3px 0pt 2px 18px;
	}

	a.downloadLink {
	font-weight: bolder;
	color: #003562;
	text-decoration: none;
	}

	a.internalLink{
	color: #003562;
	text-decoration: none;
	}

	.ico-download {
	background-image: url(assets/images/download.png) !important;
	}

	.ico-trash {
	background: transparent url(assets/images/all_16_16_vertical.png) no-repeat scroll 0 -138px !important;
	}




	table tr td.number {
	vertical-align: middle;
	text-align: center;
	width: 50px;
	padding: 6px;
	border: 2px solid #CCC;
	border-right: 0px solid;
	color: #888;
	font-size: 24px;
	font-weight: bold;
	}



	fieldset {
	margin: 10px 0;
	padding: 10px;
	padding-top: 5px;
	border: 1px solid #ccc;
	}


	table.revisions {
	width: 100%;
	border: 2px solid #CCC;
	}
	table {
	border-collapse: collapse;
	border-spacing: 0;
	}


	.expand {

	}

	span.member-path {
	font-size: 10px;
	margin: 0 2px;
	padding: 1px 2px;
	white-space: nowrap;
	border-radius: 3px;
	}

	.og-wsname-color-22, .og-wsname-color-22 a {
	color: #636330;
	background-color: #E8E8C0;
	border-color: #636330;
	}


</style>
<script src="js/ogs.js" type="text/javascript"></script>


							<div class="page-header">
								 <h2><?php echo "<a href='panel.php?module=projectMod&idproj=$projectID'>" . $Typography  . "</a>"; ?><small><?php echo $caption ?></small></h2>
								
							</div>
<div class="row">
						<div class="col-md-10">
							<!-- start: BLOCKQUOTES PANEL -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-quote-left"></i>
									<i class="fa -left"><?php echo $iconFile ; ?> </i>
									<div id="mainwindow" class="mainwindow">
										<?php

											if ($windowsString!=""){echo $windowsString ;}else{echo "Main Window" ;} 
										?>									
									</div>
									<div class="panel-tools">
										<a class="btn btn-xs btn-link panel-expand" href="#">
											<i class="icon-resize-full"></i>
										</a>
									</div>
								</div>
								<div class="panel-body">
								<div id="viewordoffice" class="viewordoffice">
									<?php 
										if($writeoffice!=""){
										echo substr($writeoffice,0,2000) . " <p></p>... <strong> Download File for read More </strong>" ; 
										}
									?>
									
								</div>
								<?php echo $writeimage ;?>
								<div id="contentpdf" class="contentpdf">
								<?php echo $writePDf ;?>
								</div>
								
								<div id="inputnotes" class="inputnotes">
									
									<form >
										<div class="row">
										<div class="col-sm-12">
														<div class="form-group">
															<label class="control-label">
																Title <span class="symbol required"></span>
															</label>
															<input class="form-control tooltips" type="text" data-original-title="Please write the caption Here" data-rel="tooltip"  title="" data-placement="top" name="captionmessage" id="captionmessage" value="<?php echo $caption ; ?>">
														</div>
													</div>
										</div>			
													
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<label class="control-label">
													Text
												</label>
												<textarea class="ckeditor form-control" cols="10" rows="10" id="pesannn" name='pesannn' ><?php echo $textmessage ; ?></textarea>
											</div>
										</div>
									</div>
									<button type="button" class="btn btn-primary" onclick="updatenotes_obj(<?php echo  $objectid ; ?>);">
											Update
										</button>
									<p>
									</p>
									
									</form>	
									
									
									
									</div>
									
									<div id="updateWordFile" class="updateWordFile">
									
									<form >
		
													
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">

												<textarea class="ckeditor form-control" cols="10" rows="10" id="datafileword" name='datafileword' ><?php echo $textmessage ; ?></textarea>
											</div>
										</div>
									</div>
									<button type="button" class="btn btn-primary" onclick="UpdateDocu();">
											Update
										</button>
									<p>
									</p>
									
									</form>	
									
									
									
									</div>
								
								
								
								<div id="messageText" class="messageText">
								
								<?php echo $textmessage ; ?>
								
								
								
								</div>	
									<hr>
									</hr>
									<div id="revison" class="revison">
										<?php 
											if ($listREvisionn!=""){ echo "									
												<fieldset>
													<legenda id='legenda' class='toggle_collapse' onclick='sliderevision();'>Revisions ( $revisionnumber )</legenda>
													<div id='og_1410866239_313568revisions'>
													<table class='revisions'>
														<tbody>
															$listREvisionn 
														</tbody>
													</table>
													</div>
												</fieldset>";
											}
										?>
									</div>

									<hr>
									</hr>

						<strong>Related to:</strong> <?php echo "<span class='member-path og-wsname-color-22'><a href='panel.php?module=projectMod&idproj=$projectID' >$nameRela</a></span>" ;?>
								<hr>
									</hr>
						<strong>Comments: </strong>
						<p>
						<div id="commenting" class="commenting">
						<ol class="discussion">
						
						<?php 
							$n=1 ;
							foreach($listcommens as $listcommen){

								if ($n % 2) { $classs="other";
									}else{
									$classs="self"; 
								}
								echo "
														<li class='$classs'>
															<div class='avatar'>
																<img width='50px' alt='' src='" . "../" . $listcommen['path'] . "'>
															</div>
															<div class='messages'>
																<p>
																	$listcommen[text]
																</p>
																<span class='time'><small>Posted on ". date("d/m/Y H:i",strtotime($listcommen['created_on'])) . " by  <a href:'' >$listcommen[nama]</a></small></span>
															</div>
														</li>";
										$n++;				
							}					
						?>						
												
						</ol>
						</div>	
						<hr>
						</hr>
									
						<strong>Post comment </strong>
					<textarea placeholder="Insert Comment Here" id="messageComment" class="form-control expand" required></textarea>	
					<p>
					</p>
					<button type="button" class="btn btn-green" onclick="Addcomentobj(<?php echo $objectid ;?>);">
											Post Comment
					</button>					

							
									
									
									
								</div>
							</div>
							<!-- end: BLOCKQUOTES PANEL -->
							
						</div>
						<div class="col-md-2">
							<!-- start: UNORDERED LISTS PANEL -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-reorder"></i>
									Actions

								</div>
								<div class="panel-body">
									
										<?php echo $actionMenu ;?>
	
								</div>
							</div>
							<!-- end: UNORDERED LISTS PANEL -->
							<!-- start: ORDERED LISTS PANEL -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-reorder"></i>
									Property

								</div>
								<div class="panel-body">
										<li>
											<strong >Unique id: </strong> <?php echo $objectid ;?>
										</li>
										<hr>
										</hr>
									<li>
											<strong >Subscribers: </strong>
									</li>	
										
									<ol>
									<div id="alistsubscriber" class="alistsubscriber">
										<?php echo $subcriber ; ?>
									
									</div>	
									</ol>
									
									<li>
											<a href='#Subscriberr' data-toggle='modal' >Modify subscriber</a>
									</li>
									<hr>
									</hr>
									<li>
											<strong>Created by:</strong>
									</li>
									
									<?php echo "<a href='#'>" .$createby . "</a>, on " . date("d/m/Y",strtotime($createon)); 
									
									if ($mimeFile!=""){ echo "
									<li>
											<strong>Mime type:</strong>
									</li>$mimeFile";
									}
									?>
									
								</div>
							</div>
							<!-- end: ORDERED LISTS PANEL -->
						
						</div>
					</div>
					
		<div id="updateFile" class="modal fade" tabindex="-1" data-width="560" style="display: none;">
			<form id="updatefileform" class="updatefileform">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Update File</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
					<div class="form-group">
					<label class="control-label">
															File Name
														</label>
														<input type="text" placeholder="Clark" class="form-control" id="filenamee" name="filenamee" value="<?php echo $caption ;?>" required>	
						<label class="checkbox-inline"  >
		
										<input type="checkbox" id="c1" name="c1" value="c1" onChange="showMe('formupdatefile');"  >
										
										Update File 
									</label>
						<label>
						You can replace an existing file by specifying a new one. If you don't want to replace it simply leave this field blank.
						</label>
						</div>
							<div id="formupdatefile" class="formupdatefile" style="display:none;" >		
					<label>
													Select file update
												</label>
												<div data-provides="fileupload" class="fileupload fileupload-new">
													<span class="btn btn-file btn-light-grey"><i class="fa fa-folder-open-o"></i> <span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span>
														<input type="file" id="fileupdate" name="fileupdate" >
													</span>
													<span class="fileupload-preview"></span>
													<a style="float: none" data-dismiss="fileupload" class="close fileupload-exists" href="#">
														&times;
													</a>
												</div>
												<div class="form-group">
										<label for="form-field-22">
											Comment / reason update
										</label>
										<textarea placeholder="Reason" id="comment" name="comment" class="form-control" ></textarea>
									</div>
									
							</div>				
						
						<input name="idobject" id="idobject" type="hidden" value="<?php echo $objectid ;?>"  />
						<input name="modul" id="modul" type="hidden" value="updatefile" />
						<input name="act" id="act" type="hidden" value="updatename" />
						<input name="idKegiatansnnn" id="idKegiatansnnn" type="hidden" value='<?php echo $projectID ;?>' />
					</div>

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-light-grey">
					Close
				</button>
				<button type="submit" class="btn btn-blue"  >
					Save changes
				</button>	
				
			</div>
			</form>	
		</div>
		<div id="Subscriberr" class="modal fade" tabindex="-1" data-width="560" style="display: none;">
			<form id="updatefileform" class="updatefileform">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Subscriberr</h4>
			</div>
			<div class="modal-body">
				
			<div class="row">
					<div class="col-md-12">
						<h4>Subscrib</h4>
						<p>
									<select multiple="multiple" id="subscriber" class="form-control search-select" name="sapi[]">
									<?php 
											$listtemamembers=$obj->getTeamMember($projectID);
											
											$pieces = explode(",", $listtemamembers);
											$pieces2=explode(",",$arrasubscriber);
											//echo $listtemamembers . " sapi ". $arrasubscriber;
											$results = array_diff($pieces, $pieces2);
											foreach ($results as $result){
											
											$biodata_users= $Users->getUser_biodata($result);
											$nama_uservs=$Users->get_users_with_title($result);

												echo "<option value='$result'>$nama_uservs</option>"   ;
											}
											echo $isicombo ;
									
									
									 ?>
											
										</select>
						</p>
						
						
					</div>

				</div>
				
				
				
				<input name="objectidcomenfile" id="objectidcomenfile" type="hidden"  />
				
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-light-grey">
					Close
				</button>
				<button type="button" data-dismiss="modal" class="btn btn-blue"  onclick="updateSubscriber(<?php echo $objectid ;?>);">
					Save changes
				</button>	
				
			</div>
			</form>	
		</div>
		
		<div id="changeInitialname" class="modal fade" tabindex="-1" data-width="560" style="display: none;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Edit comment file</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
										<label for="form-field-22">
											Default
										</label>
										<textarea placeholder="Default Text" id="filecommentt" class="form-control"></textarea>
									</div>
						
						<input name="objectidcomenfile" id="objectidcomenfile" type="hidden"  />
					</div>

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-light-grey">
					Close
				</button>
				<button type="button" class="btn btn-blue" data-dismiss="modal" onClick="updateCommentrevision(<?php echo $objectid ;?>);">
					Save changes
				</button>
			</div>
		</div>
		
		<div id="Completetask" class="modal fade" tabindex="-1" data-width="260" style="display: none;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Task Complete</h4>
			</div>
			<div class="modal-body">
				<div class="row">
										<div class="form-group">
											<label class="col-md-12 control-label">
												Fill 100 if complete
											</label>
											<div class="col-md-12">
												<input placeholder="ex 100" id="idprogresstask" class="form-control" type="number" >
											</div>
											
										</div>

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-light-grey">
					Close
				</button>
				<button type="button" class="btn btn-blue" data-dismiss="modal" onClick="updateprogresstaskobj(<?php echo $objectid ;?>);">
					Save changes
				</button>
			</div>
		</div>
		
					


<script>

function slideAddnoted() {

    if ($("#inputnotes:first").is(":hidden")) {

        $("#messageText").hide();

        $("#inputnotes").slideDown("slow");


    } else {
        $('#inputnotes').slideUp('slow');




        $("#messageText").show();

    }


}


function slideEditDocument() {

    if ($("#updateWordFile:first").is(":hidden")) {

        $("#messageText").hide();

        $("#updateWordFile").slideDown("slow");


    } else {
        $('#updateWordFile').slideUp('slow');




        $("#messageText").show();

    }


}


jQuery(document).ready(function() {
    Main.init();



    $("#inputnotes").hide();
    $("#updateWordFile").hide();


    $(".search-select").select2({
        placeholder: "Select a Participant",
        allowClear: true
    });




    //Program a custom submit function for the form
    $("form#updatefileform").submit(function(event) {

        //disable the default form submission
        event.preventDefault();

        //grab all form data  
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: 'process.php',
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function(html) {
                $('.revison').html(html);
                $(".revison").hide();
                $(".revison").fadeIn(400);
            }
        });

        return false;
    });
});

function showMe(box) {

    var chboxs = document.getElementsByName("c1");
    var vis = "block";

    if (document.getElementById('c1').checked) {

    } else {
        vis = "none";
    }

    document.getElementById(box).style.display = vis;

    if (document.getElementById('c1').checked) {
        //alert("unchecked");

        document.getElementById("fileupdate").required = true;
        document.getElementById("comment").required = true;
        document.getElementById('act').value = 'update';

    } else {
        //alert("checked");


        document.getElementById("fileupdate").required = false;
        document.getElementById("comment").required = false;
        document.getElementById('act').value = 'updatename';
    }


}



function sliderevision() {

    if ($("#og_1410866239_313568revisions:first").is(":hidden")) {


        $("#legenda").toggleClass('toggle_collapse toggle_expanded');

        $("#og_1410866239_313568revisions").slideDown("slow");
    } else {
        $('#og_1410866239_313568revisions').slideUp('slow');

        $("#legenda").toggleClass('toggle_expanded toggle_collapse');

    }




}


jQuery(document).ready(function() {


    $("#og_1410866239_313568revisions").hide();

    $('textarea.expand').focus(function() {
        $(this).animate({
            height: "10em"
        }, 500);
    });


});

</script>		
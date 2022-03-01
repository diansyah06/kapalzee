<?php
$pagenum_id=11;
$Users->cekSecuritypeage($user_id,$pagenum_id);
$listTimelines=$kpi->getRealizationEvent(2015);

?>


<div class="page-header">
								<h1>Timeline <small>capturing all of your important moments</small></h1>
							</div>
							<!-- end: PAGE TITLE & BREADCRUMB -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->
					<!-- start: PAGE CONTENT -->
					<div class="row">
						<div class="col-md-12">
							<!-- start: TIMELINE PANEL -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Timeline
									<div class="panel-tools">
										<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
										</a>
										<a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
											<i class="fa fa-wrench"></i>
										</a>
										<a class="btn btn-xs btn-link panel-refresh" href="#">
											<i class="fa fa-refresh"></i>
										</a>
										<a class="btn btn-xs btn-link panel-expand" href="#">
											<i class="fa fa-resize-full"></i>
										</a>
										<a class="btn btn-xs btn-link panel-close" href="#">
											<i class="fa fa-times"></i>
										</a>
									</div>
								</div>
								<div class="panel-body">
									<div id="timeline" class="demo1">
										<div class="timeline">
											<div class="spine"></div>
											
											<?php 
											$bulanTahun="";
											
											foreach($listTimelines as $listTimeline){
												
											$getYear=date("Y",strtotime($listTimeline['realisasiStart']));	
											$getMonth=date("F",strtotime($listTimeline['realisasiStart']));
											$bulantahuun=$getMonth . " " . $getYear;
											if ($bulanTahun !=$bulantahuun){
												if($bulantahuun !=""){
												echo "</ul>";
												}
												echo "<div class='date_separator'>
													<span>$bulantahuun</span>
												</div>
												<ul class='columns'>";
											$bulanTahun = $bulantahuun;
											}
											

											$nameEvent=$namakegiatan[$listTimeline['typeOfevent']];
											$tanggalPlan= date("d F Y",strtotime($listTimeline['realisasiStart']));
											$elementStaile=RandomStyletimeline();
											$buttonStyle=MatchingButtonTimeline($elementStaile);
											if ((strlen($listTimeline[description])<1500) || CekImageDatabase($listTimeline[description]) ){
											$textdescription=$listTimeline[description];
											}else{
											
											$textdescription=substr($listTimeline[description],0,1500) . "..." ;
											}
											
											echo "<li>
													<div class='timeline_element $elementStaile'>
														<div class='timeline_title'>
															<span class='timeline_label'>$nameEvent $listTimeline[training] </span><span class='timeline_date'> $tanggalPlan</span>
														</div>
														<div class='content'>
															<b>$nameEvent</b> $textdescription
														</div>
														<div class='readmore'>
															<a href='./panel.php?module=dEvent&id=$listTimeline[id]' target='_blank' class='btn btn-$buttonStyle'>
																Read More <i class='fa fa-arrow-circle-right'></i>
															</a>
														</div>
													</div>
												</li>";
											}
											
											
											
											?>
												
												

											</ul>
											
										</div>
									</div>
								</div>
							</div>
							<!-- end: TIMELINE PANEL -->
						</div>
					</div>
					<!-- end: PAGE CONTENT-->
				</div>
			</div>
			
					<script>
			jQuery(document).ready(function() {
				Main.init();
		
			});
			
			
		</script>	
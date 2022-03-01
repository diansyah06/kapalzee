<?php
$pagenum_id=16;
$Users->cekSecuritypeage($user_id,$pagenum_id);
			echo set_java_script_plugin_load ("table"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("getProjectdkk");
			echo set_java_script_plugin_load ("maskinputmoney");		

		$periode =$kpi->GetActivePlanPeriode();
			
?>
	

					
<script src='js/modern.js'></script>
<script src="js/plan.js"></script>
					<div class="page-header">
								<h1>Event <small>Cost</small></h1>
							</div>
							<!-- end: PAGE TITLE & BREADCRUMB -->
						</div>
					</div>
			<!-- end: PAGE HEADER -->
					<!-- start: PAGE CONTENT -->
					
					<div class="row">
						
							
							<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("Insert Cost"); ?>
								<div class="panel-body">
								
										<form role="form" class="form-horizontal">

										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Tittle :											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Name of Cost" id="nameCost" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Event / Investasi :	</label>
											<div class="col-sm-9">
											<label class="radio-inline">
												<input type="radio" value="0" name="optionsRadios" class="grey" checked>
												Event
											</label>
											<label class="radio-inline">
												<input type="radio" value="1" name="optionsRadios" class="grey">
												Investasi
											</label>											
											</div>
										</div>										
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Amount :
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Total Amount" id="jmlcost" class="form-control currency">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Currency :
											</label>
											<div class="col-sm-9">
												<select id="form-field-select-1" class="form-control" >
										
											<option value="1">Rupiah</option>
											<option value="2">US Dollar</option>
											<option value="3">SING Dollar</option>
											<option value="4">Poundsterling</option>
											<option value="5">Euro</option>

										</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Kurs :
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Kurs prediction" id="invet_kurs" class="form-control currency">
											</div>
										</div>										
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Associated :
											</label>
											<div class="col-sm-9">
												<input name="textfield32" type="text" class="country form-control" id="textfield3" onblur="fill();" onkeyup="suggestEvent(this.value);" size="100"  autocomplete="off">      	
	  <div class="suggestionsBox" id="suggestions" style="display: none;"></div>
	
        <div class="suggestionList" id="suggestionsList"> &nbsp; </div>
		
		<input type="text" name="textfield" id="textfield"  class="form-control" disabled="disabled" required/>
										<input type="hidden" name="tipekegiatan" id="tipekegiatan" />
										<input type="hidden" name="idKegiatan" id="idKegiatan" />
											</div>
											
										</div>
										
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Realization :											</label>
											<div class="col-sm-9">
											<span class="col-sm-9-addon"> <i class="fa fa-calendar"></i> </span>	
												<input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="realization">
												
											</div>
										</div>
										
										
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Description :
											</label>
										  <div class="col-sm-9">
												<textarea placeholder="Cost Description" id="form-field-22" name="form-field-22" class="ckeditor form-control"></textarea>
											    <label>
											   
											    </label>
												<p>
										<a class="btn btn-blue"  onclick="tambahCost();"><i class="fa fa-plus"></i>
											Submit Entry</a> <button type="button" class="btn btn-green" onclick="clearFrom();">
											Reset
										</button>		
											</p>
											
										  </div>
											
										</div>
										
										
										
									</form>	
											
									</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>				
							
							
							<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("Cost List"); ?>
								<div class="panel-body">
			
									<label class="radio-inline" onclick="refreshCosttt(0);" >
										<input type="radio" value="" name="optionsRadioss" checked="checked"  onclick="refreshCosttt(0);">
										Event
									</label>
									<label class="radio-inline"  onclick="refreshCostii(0);"  >
										<input type="radio" value="" name="optionsRadioss"  onclick="refreshCostii(0);" >
										Invest
									</label>
									<p>
								<div id="cost" class="cost">
								<?php 
								
								echo "
									<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
										<thead>
											<tr>
												<th > ID</th>
												<th > Cost Name</th>
												<th > currency</th>
												<th > cost </th>
												<th > Assosiated </th> 
												<th > Realization</th>
												<th class='center'> Action</th>

											</tr>
										</thead>
										<tbody>"; 
										$n=1;
										$listCosts= $kpi->getCost($periode);
										foreach($listCosts as $listCost ){
										//$label= labelStyle($listTraining[status],$listTraining[status]);
										$currency=$currencyarray[$listCost['currency']];
										$dateRealization=date("d M Y",strtotime($listCost[realisation]));
										$costformat=number_format($listCost[cost]);
										echo " <tr>
												<td>$n</td>
												<td>$listCost[nam]</td>
												<td>$currency</td>
												<td>$costformat </td>
												<td >$listCost[training]</td>
												<td>$dateRealization</td>
												<td class='center'>
												<div class='visible-md visible-lg hidden-sm hidden-xs'>
													
												
													<a  onclick='dellCosttt($listCost[id]);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
												</div>
												
												
												
												</td>
												
											</tr>";
										
										$n++;
										}
											
										
										?>		
											</tr>
										</tbody>
									</table>
								</div>
								</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>
					</div>
					<!-- end: PAGE CONTENT-->
				</div>
			</div>
			
			<!-- start: BOOTSTRAP EXTENDED MODALS -->
		<div id="responsive" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Responsive</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<h4>Some Input</h4>
						<p>
							<input class="form-control" type="text">
						</p>
						<p>
							<input class="form-control" type="text">
						</p>
						<p>
							<input class="form-control" type="text">
						</p>
						<p>
							<input class="form-control" type="text">
						</p>
						<p>
							<input class="form-control" type="text">
						</p>
						<p>
							<input class="form-control" type="text">
						</p>
						<p>
							<input class="form-control" type="text">
						</p>
					</div>
					<div class="col-md-6">
						<h4>Some More Input</h4>
						<p>
							<input class="form-control" type="text">
						</p>
						<p>
							<input class="form-control" type="text">
						</p>
						<p>
							<input class="form-control" type="text">
						</p>
						<p>
							<input class="form-control" type="text">
						</p>
						<p>
							<input class="form-control" type="text">
						</p>
						<p>
							<input class="form-control" type="text">
						</p>
						<p>
							<input class="form-control" type="text">
						</p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-light-grey">
					Close
				</button>
				<button type="button" class="btn btn-blue">
					Save changes
				</button>
			</div>
		</div>
			<!-- end: PAGE -->
	<script>
			jQuery(document).ready(function() {

				Main.init();
			    FormElements.init();
				TableData.init();
				$('textarea.ckeditor').ckeditor();
				CKEDITOR.disableAutoInline = true;

        $(".search-select").select2({
            placeholder: "Select a Participant",
            allowClear: true
        });

		    //function to initiate daterangepicker
  
        $('.date-picker').datepicker({
            autoclose: true
        });

		
				
			});
		</script>					
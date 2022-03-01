<?php

require_once "BaseClass.php";

class TankFormClass extends BaseClass
{
	protected $headers = array("Name", "Frame No.", "Corrosion Protection", "Coating Extent", 
							"Cargo Heating", "Common Plane");
	protected $formChild = array(
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Name :
					</label>
					<div class='col-sm-10'>
						<input type='text' id='tankName' name='input-field' placeholder='Tank Name' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Frame No :
					</label>
					<div class='col-sm-4'>
						<input type='number' id='frameStart' name='input-field' placeholder='Start' class='form-control'>
					</div>
					<label class='col-sm-2'>
						to
					</label>
					<div class='col-sm-4'>
						<input type='number' id='frameEnd' name='input-field' placeholder='End' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Protection :
					</label>
					<div class='col-sm-10'>
						<label class='checkbox-inline'>
							<input type='checkbox' id='HC' value='HC' name='protection' class='grey'>
							Hard Coating
						</label>
						<label class='checkbox-inline'>
							<input type='checkbox' id='SC' value='SC' name='protection' class='grey'>
							Soft Coating
						</label>
						<label class='checkbox-inline'>
							<input type='checkbox' id='A' value='A' name='protection' class='grey'>
							Anode
						</label>
						<label class='checkbox-inline'>
							<input type='checkbox' id='NP' value='NP' name='protection' class='grey'>
							No Protection
						</label>
						<span class='help-block'>
							<i class='fa fa-info-circle'></i> 
							Type of corrosion protection
						</span>
					</div>
				</div>
				",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Coating :
					</label>
					<div class='col-sm-10'>
						<select id='coating' class='form-control'>
							<option value='-'>--Coating Extent--</option>
							<option value='U'>Upper Part</option>
							<option value='M'>Middle Part</option>
							<option value='L'>Lower Part</option>
							<option value='C'>Complete</option>
						</select>
					</div>
				</div>
				",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Cargo Heating :
					</label>
					<div class='col-sm-10'>
						<label class='radio-inline'>
							<input type='radio' id='heatingA' value='A' name='cargoHeating' class='grey'>
							Applicable
						</label>
						<label class='radio-inline'>
							<input type='radio' id='heatingNA' value='N/A' name='cargoHeating' class='grey'>
							Not Applicable
						</label>
					</div>
				</div>
				",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Common Plane :
					</label>
					<div class='col-sm-10'>
						<label class='radio-inline'>
							<input type='radio' id='planeA' value='A' name='commonPlane' class='grey'>
							Applicable
						</label>
						<label class='radio-inline'>
							<input type='radio' id='planeNA' value='N/A' name='commonPlane' class='grey'>
							Not Applicable
						</label>
						<span class='help-block'>
							<i class='fa fa-info-circle'></i> 
							Common plane boundary with cargo tank equipped with any means of heating
						</span>
					</div>
				</div>"
				);
	protected $formParent = "
				<p id='user-log'></p>
				<form id='tank-check'>
				<table class='table table-hover'>
					<thead>
						<tr>
							<th>Tank</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Cargo Hold</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' id='crh' name='tank-field' value='crh' class='flat-grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Cargo Tank</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' id='crt' name='tank-field' value='crt' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Ballast Tank</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' id='blt' name='tank-field' value='blt' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Fore Peak Tank</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' id='fpt' name='tank-field' value='fpt' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>After Peak Tank</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' id='apt' name='tank-field' value='apt' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Slop Tank</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' id='spt' name='tank-field' value='spt' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Void Tank</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' id='vot' name='tank-field' value='vot' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Fresh Water Tank</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' id='fwt' name='tank-field' value='fwt' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Fuel Oil Tank</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' id='fot' name='tank-field' value='fot' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Lubricating Oil Tank</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' id='lot' name='tank-field' value='lot' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Sludge Tank</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' id='sdt' name='tank-field' value='sdt' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Cofferdam</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' id='cfd' name='tank-field' value='cfd' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Other Tank</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' id='ott' name='tank-field' value='ott' class='grey'>
									</label>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				</form>
			";

	public function __construct($input)
	{
		$this->helper = $input['helper'];
		$this->code = $input['code'];
		$this->parent = $input['parent'];
		$this->project = $input['projId'];
		$this->user = $input['user'];
		$this->usersArr = $input['usersArr'];
		$this->datId = $input['datId'];
		$this->family = $input['family'];
	}

	public function showForm()
	{
		if($this->parent == 'root')
		{	
			$htmlStr = $this->constructParentForm('tank-check');
		}else
		{
			$fieldStr = $this->constructChildForm('tank-form');
			$tableStr = $this->generateTable();
			$htmlStr = $fieldStr.$tableStr;
		}

		return $htmlStr;
	}

	protected function generateTable()
	{
		$all = $this->helper->JSONDataGet($this->project, $this->code);
		$rowStr = "";

		$headStr="";
		for($i=0; $i<count($this->opt); $i++)
		{
			$head = $this->headers[$this->opt[$i]];
			$headStr = $headStr.  "<th>$head</th>";
		}
		$headStr = $headStr. "		<th>Update by</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>"; 

		foreach($all['content'] as $dat)
		{
			$data = json_decode($dat['data'], true);
			$frame = "$data[frameStart] ~ $data[frameEnd]";
			$usrName = $this->usersArr[$dat['update_by']];
			$data['frameStart'] = $frame;
			$name = $data['tankName'];

			unset($data['frameEnd']);
			unset($data['tankName']);
			
			$rowStr = $rowStr. "	<tr>
							<td><a onclick='sendUpdate(&#39;$this->code&#39;, &#39;$this->parent&#39;, $this->project, &#39;$this->family&#39;, $dat[id]);'>$name</a></td>
					  ";
			
			foreach($data as $k=>$v)
			{
				if(strpos($v, "@@") !== false)
				{
					$tmp = explode("@@", $v);
					unset($tmp[0]);
					$v = implode("+", $tmp);
				}
				$rowStr = $rowStr."<td>$v</td>";
			}
			
			$rowStr = $rowStr."		<td>$usrName</td>
									<td><a  onclick='deleteData(&#39;$this->code&#39;, &#39;$this->parent&#39;, $this->project, &#39;$this->family&#39;, $dat[id]);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Cancel Event'><i class='fa fa-times fa fa-white'></i></a></td>
								</tr>";
		}

		$htmlStr = $headStr.$rowStr."</tbody>
					</table>
				</div>";

		return $htmlStr;
	}
	
}

?>
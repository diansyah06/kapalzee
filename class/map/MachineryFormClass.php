<?php

require_once "BaseClass.php";

class MachineryFormClass extends BaseClass
{
	protected $headers = array("Qty", "Brand", "Year", "Certificate", "Type", "Type", "Delivery Head", "Capacity", "Power","Area", "Working Pressure", "Propeller size", "Blade Num", "Dimension", "Prime Mover","Prime Mover Type", "Serial Number", "Location", "Heat Protection", "Level Gauge", "Setting Pressure");

	protected $formChild = array(
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Qty :
					</label>
					<div class='col-sm-10'>
						<input type='number' id='qty' name='common-field' placeholder='Quantity' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Brand :
					</label>
					<div class='col-sm-10'>
						<input type='text' id='brand' name='common-field' placeholder='Brand' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Year :
					</label>
					<div class='col-sm-10'>
						<input type='text' id='yearBuilt' name='common-field' placeholder='Year of Built' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Certificate No :
					</label>
					<div class='col-sm-10'>
						<input type='text' id='certificate' name='common-field' placeholder='Certificate Number' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Type :
					</label>
					<div class='col-sm-10'>
						<input type='text' id='type' name='char-field' placeholder='Type' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Type :
					</label>
					<div class='col-sm-10'>
						<select id='heating' class='form-control'>
							<option value='-'>--Heater Type--</option>
							<option value='EH'>Electric Heater</option>
							<option value='SH'>Steam Heater</option>
							<option value='TH'>Thermal Oil Heater</option>
						</select>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Head :
					</label>
					<div class='col-sm-10'>
						<input type='text' id='deliveryHead' name='char-field' placeholder='Delivery Head (in m)' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Capacity :
					</label>
					<div class='col-sm-10'>
						<input type='text' id='capacity' name='char-field' placeholder='Capacity' class='form-control'>
						<span class='help-block'>
							<i class='fa fa-info-circle'></i> 
							Input for capacity, volume, max torque, pulling capacity
						</span>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Power :
					</label>
					<div class='col-sm-10'>
						<input type='text' id='electroPower' name='char-field' placeholder='Electromotor Power (in kW)' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Area :
					</label>
					<div class='col-sm-10'>
						<input type='text' id='heatingSurfaceArea' name='char-field' placeholder='Heating Surface Area' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Pressure :
					</label>
					<div class='col-sm-10'>
						<input type='text' id='workingPressure' name='char-field' placeholder='Working Pressure' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Propeller :
					</label>
					<div class='col-sm-10'>
						<input type='text' id='propellerSize' name='char-field' placeholder='Propeller size' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Blade :
					</label>
					<div class='col-sm-10'>
						<input type='text' id='bladeNumber' name='char-field' placeholder='Blade number' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Dimension :
					</label>
					<div class='col-sm-10'>
						<input type='text' id='dimension' name='char-field' placeholder='Dimension' class='form-control'>
						<span class='help-block'>
							<i class='fa fa-info-circle'></i> 
							Input for rudder stock diameter, dia x pitch
						</span>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Prime Mover :
					</label>
					<div class='col-sm-10'>
						<input type='text' id='primeMover' name='char-field' placeholder='Power and/or revolution of prime mover' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Prime Mover Type :
					</label>
					<div class='col-sm-10'>
						<select id='primeMoverType' class='form-control'>
							<option value='-'>--Prime Mover Type--</option>
							<option value='HD'>Hydraulic</option>
							<option value='ME'>Mechanical</option>
						</select>
						<span class='help-block'>
							<i class='fa fa-info-circle'></i> 
							Input for prime mover type or emergency steering system
						</span>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Serial No. :
					</label>
					<div class='col-sm-10'>
						<input type='text' id='serialNum' name='char-field' placeholder='Serial number' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Location :
					</label>
					<div class='col-sm-10'>
						<input type='text' id='location' name='char-field' placeholder='Location of equipment' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Protection :
					</label>
					<div class='col-sm-10'>
						<input type='text' id='heatProtection' name='char-field' placeholder='Heat protection' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Level Gauge :
					</label>
					<div class='col-sm-10'>
						<input type='text' id='levelGauge' name='char-field' placeholder='Level gauge' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Setting Pressure :
					</label>
					<div class='col-sm-10'>
						<input type='text' id='settingPressure' name='char-field' placeholder='Setting pressure' class='form-control'>
					</div>
				</div>"
				);

	protected $formParent;

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

		$menuData = $this->helper->getChecklist($this->project, $this->code);
		$count = $menuData['row'];
		
		$items = $this->helper->getMenu($this->code);
		foreach($items as $dat)
		{
			$menuStr = $dat['menu'];
		}
		$menuArr = explode("+", $menuStr);
		
		$rows = "";
		for($i=0; $i<count($menuArr); $i++)
		{
			$childNames = $this->helper->getChildMenu("id", $menuArr[$i], $this->code);
			$childIdentifier = $menuArr[$i];
			foreach($childNames as $dat)
			{
				$name = str_replace("+", " ", $dat['title']);
			}
			$rows = $rows. "<tr>
							<td>$name</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' id='$childIdentifier' name='item-field' value='$childIdentifier' class='flat-grey'>
									</label>
								</div>
							</td>
						</tr>";
		}
		
		$this->formParent = "
				<p id='user-log'></p>
				<form id='mach-check'>
				<table class='table table-hover'>
					<thead>
						<tr>
							<th>Item</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						$rows
					</tbody>
				</table>
				</form>
				<input type='hidden' id='parent-field' value=$this->parent>
			";
	}

	public function showForm()
	{
		if($this->parent == 'root')
		{	
			if($this->code == 'vts')
			{
				$this->parent = $this->code;
				$fieldStr = $this->constructChildForm('mach-form');
				$tableStr = $this->generateTable();
				$htmlStr = $fieldStr.$tableStr;		
			}else
			{
				$htmlStr = $this->constructParentForm('mach-check');
			}
		}else
		{
			$fieldStr = $this->constructChildForm('mach-form');
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
			$usrName = $this->usersArr[$dat['update_by']];
			
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
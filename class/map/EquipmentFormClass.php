<?php

require_once "BaseChildlessClass.php";

class EquipmentFormClass extends BaseChildlessClass
{
	protected $form = "<h4>Equipment Number</h4>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Z number :	
					</label>
					<div class='col-sm-8'>
						<input type='number' id='znum' name='input-field1' placeholder='Z number' class='form-control'>
					</div>
					<div class='col-sm-2'>
						<a class='btn btn-blue' onClick='sendZnum()'>
						<i  id='tomboltask' class='fa fa-plus' ></i>
						Submit
					</a>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Reg number :	
					</label>
					<div class='col-sm-10'>
						<input type='number' id='reg' name='input-field1' placeholder='Reg number' class='form-control' readonly>
					</div>
				</div>
				<h4>Bower Anchors</h4>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Quantity :	
					</label>
					<div class='col-sm-10'>
						<input type='number' id='nb_bower' name='input-field1' placeholder='Quantity of anchor' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Type :	
					</label>
					<div class='col-sm-10'>
						<select id='type_bower' class='form-control'>
							<option value='-'>--Anchor Type--</option>
							<option value='Stock'>Stock Anchor</option>
							<option value='Stockless'>Stockless Anchor</option>
							<option value='HHP'>High Holding Power</option>
							<option value='VHHP'>Very High Holding Power</option>
						</select>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Weight :	
					</label>
					<div class='col-sm-10'>
						<input type='number' id='mass_bower' name='input-field1' placeholder='Weight of anchor (in kg)' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Manufacturer :	
					</label>
					<div class='col-sm-10'>
						<input type='text' id='manuf_bower' name='input-field1' placeholder='Manufacturer' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Certificate No :	
					</label>
					<div class='col-sm-10'>
						<input type='text' id='certno_bower' name='input-field1' placeholder='Certificate number' class='form-control'>
					</div>
				</div>
			
			<h4>Stream Anchors</h4>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Quantity :	
					</label>
					<div class='col-sm-10'>
						<input type='number' id='nb_stream' name='input-field2' placeholder='Quantity of anchor' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Type :	
					</label>
					<div class='col-sm-10'>
						<select id='type_stream' class='form-control'>
							<option value='-'>--Anchor Type--</option>
							<option value='Stock'>Stock Anchor</option>
							<option value='Stockless'>Stockless Anchor</option>
							<option value='HHP'>High Holding Power</option>
							<option value='VHHP'>Very High Holding Power</option>
						</select>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Weight :	
					</label>
					<div class='col-sm-10'>
						<input type='number' id='mass_stream' name='input-field2' placeholder='Weight of anchor (in kg)' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Manufacturer :	
					</label>
					<div class='col-sm-10'>
						<input type='text' id='manuf_stream' name='input-field2' placeholder='Manufacturer' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Certificate No :	
					</label>
					<div class='col-sm-10'>
						<input type='text' id='certno_stream' name='input-field2' placeholder='Certificate number' class='form-control'>
					</div>
				</div>
			
			<h4>Bower Anchor Chain Cables</h4>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Length :	
					</label>
					<div class='col-sm-10'>
						<input type='number' id='length_bower' name='input-field3' placeholder='Total length of chain cable (in m)' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Grade :	
					</label>
					<div class='col-sm-10'>
						<select id='bower_chain_grade' class='form-control' onchange=''>
							<option value='-'>--Chain Cable Grade--</option>
							<option value='K1'>K1</option>
							<option value='K2'>K2</option>
							<option value='K3'>K3</option>
						</select>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						DIAMETER	
					</label>
					<div class='col-sm-10'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						d1 :	
					</label>
					<div class='col-sm-2'>
						<input type='number' id='d1_bower' name='input-field3' placeholder='mm' class='form-control'>
					</div>
					<label class='col-sm-2 control-label' for='form-field-1'>
						d2 :	
					</label>
					<div class='col-sm-2'>
						<input type='number' id='d2_bower' name='input-field3' placeholder='mm' class='form-control'>
					</div>
					<label class='col-sm-2 control-label' for='form-field-1'>
						d3 :	
					</label>
					<div class='col-sm-2'>
						<input type='number' id='d3_bower' name='input-field3' placeholder='mm' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Stud :	
					</label>
					<div class='col-sm-10'>
						<label class='radio-inline'>
							<input type='radio' id='with' value='with' name='stud' class='grey' checked>
							With Stud
						</label>
						<label class='radio-inline'>
							<input type='radio' id='without' value='without' name='stud' class='grey'>
							Without Stud
						</label>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Manufacturer :	
					</label>
					<div class='col-sm-10'>
						<input type='text' id='manuf_chain_bower' name='input-field3' placeholder='Manufacturer of chain cable' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Certificate No :	
					</label>
					<div class='col-sm-10'>
						<input type='text' id='certno_chain_bower' name='input-field3' placeholder='Certificate number' class='form-control'>
					</div>
				</div>
			
			<h4>Stream Anchor Chain Cables</h4>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Length :	
					</label>
					<div class='col-sm-10'>
						<input type='number' id='length_stream' name='input-field4' placeholder='Length of chain cable (in m)' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Break Load :	
					</label>
					<div class='col-sm-10'>
						<input type='number' id='load_stream' name='input-field4' placeholder='Break load (in kN)' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Grade :	
					</label>
					<div class='col-sm-10'>
						<input type='text' id='grade_stream' name='input-field4' placeholder='Grade of chain cable, eg : K3' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Diameter :	
					</label>
					<div class='col-sm-10'>
						<input type='number' id='dia_stream' name='input-field4' placeholder='Diameter of chain cable (in mm)' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Type :	
					</label>
					<div class='col-sm-10'>
						<label class='radio-inline'>
							<input id='chain' type='radio' value='chain' name='stream_chaintype' class='grey' checked>
							Chain Cable
						</label>
						<label class='radio-inline'>
							<input id='wire' type='radio' value='wire' name='stream_chaintype' class='grey'>
							Steel Wire Rope
						</label>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Manufacturer :	
					</label>
					<div class='col-sm-10'>
						<input type='text' id='manuf_chain_stream' name='input-field4' placeholder='Manufacturer of chain cable' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Certificate No :	
					</label>
					<div class='col-sm-10'>
						<input type='text' id='certno_chain_stream' name='input-field4' placeholder='Certificate number' class='form-control'>
					</div>
				</div>
			
			<h4>Tow Line</h4>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Qty :
					</label>
					<div class='col-sm-4'>
						<input type='number' id='nb_towline' name='input-field5' placeholder='Quantity' class='form-control' value=1>
					</div>
					<label class='col-sm-2'>
						x Total Length
					</label>
					<div class='col-sm-4'>
						<input type='number' id='length_towline' name='input-field5' placeholder='in m' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Break Load :	
					</label>
					<div class='col-sm-10'>
						<input type='text' id='load_towline' name='input-field5' placeholder='in kN' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Material :	
					</label>
					<div class='col-sm-10'>
						<input type='text' id='material_towline' name='input-field5' placeholder='Material' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Diameter :	
					</label>
					<div class='col-sm-10'>
						<input type='number' id='dia_towline' name='input-field5' placeholder='Diameter of tow line (in mm)' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Manufacturer :	
					</label>
					<div class='col-sm-10'>
						<input type='text' id='manuf_towline' name='input-field5' placeholder='Manufacturer of tow line' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Certificate No :	
					</label>
					<div class='col-sm-10'>
						<input type='text' id='certno_towline' name='input-field5' placeholder='Certificate number' class='form-control'>
					</div>
				</div>
			
			<h4>Mooring Line</h4>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Qty :
					</label>
					<div class='col-sm-4'>
						<input type='number' id='nb_mooring' name='input-field6' placeholder='Quantity' class='form-control'>
					</div>
					<label class='col-sm-2'>
						x Total Length
					</label>
					<div class='col-sm-4'>
						<input type='number' id='length_mooring' name='input-field6' placeholder='in m' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Break Load :	
					</label>
					<div class='col-sm-10'>
						<input type='text' id='load_mooring' name='input-field6' placeholder='in kN' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Material :	
					</label>
					<div class='col-sm-10'>
						<input type='text' id='material_mooring' name='input-field6' placeholder='Material of mooring line' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Diameter :	
					</label>
					<div class='col-sm-10'>
						<input type='number' id='dia_mooring' name='input-field6' placeholder='Diameter of mooring line (in mm)' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Manufacturer :	
					</label>
					<div class='col-sm-10'>
						<input type='text' id='manuf_mooring' name='input-field6' placeholder='Manufacturer of mooring line' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Certificate No :	
					</label>
					<div class='col-sm-10'>
						<input type='text' id='certno_mooring' name='input-field6' placeholder='Certificate number' class='form-control'>
					</div>
				</div>
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
		$htmlStr = $this->constructForm('eqp-form');
		return $htmlStr;
	}


}

?>
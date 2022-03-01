<?php

require_once "BaseChildlessClass.php";

class GeneralDataFormClass extends BaseChildlessClass
{
	protected $form = "<h3>General Information</h3>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Ship Status :	
				</label>
				<div class='col-sm-10'>
				<label class='radio-inline'>
					<input type='radio' value='NB' id='NB' name='status' class='grey'>
					New Building
				</label>
				<label class='radio-inline'>
					<input type='radio' value='Ex' id='Ex' name='status' class='grey'>
					Existing
				</label>											
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Place of Survey :
				</label>
				<div class='col-sm-10'>
					<input type='text' id='surveyPlace' name='input-field' placeholder='Place of Survey' class='form-control'>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Survey Date :
				</label>
				<div class='col-sm-10'>
				<span class='col-sm-9-addon'> <i class='fa fa-calendar'></i> </span>
				<input type='text' id='surveyDate' name='input-field' placeholder='Date of Survey' class='form-control date-time-range'>
			</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Name :
				</label>
				<div class='col-sm-10'>
					<input type='text' id='shipName' name='input-field' placeholder='Name of Ship' class='form-control'>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Previous Name :
				</label>
				<div class='col-sm-10'>
					<input type='text' id='prevName' name='input-field' placeholder='Previous Name of Ship' class='form-control'>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Type of Ship :
				</label>
				<div class='col-sm-10'>
					<input type='text' id='typeShip' name='input-field' placeholder='Type of Ship' class='form-control'>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Hull Material :	
				</label>
				<div class='col-sm-10'>
				<label class='radio-inline'>
					<input type='radio' id='steel' value='steel' name='materialRadios' class='grey'>
					Steel
				</label>
				<label class='radio-inline'>
					<input type='radio' id='alum' value='alum' name='materialRadios' class='grey'>
					Aluminium
				</label>
				<label class='radio-inline'>
					<input type='radio' id='wood' value='wood' name='materialRadios' class='grey'>
					Wood
				</label>
				<label class='radio-inline'>
					<input type='radio' id=fiber' value='fiber' name='materialRadios' class='grey'>
					FRP
				</label>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Flag :
				</label>
				<div class='col-sm-10'>
					<input type='text' id='flag' name='input-field' placeholder='Flag of Ship' class='form-control'>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Call Sign :
				</label>
				<div class='col-sm-10'>
					<input type='text' id='callSign' name='input-field' placeholder='Call Sign of Ship' class='form-control'>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Port of Registry :
				</label>
				<div class='col-sm-10'>
					<input type='text' id='portRegistry' name='input-field' placeholder='Port of Registry' class='form-control'>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Contract :											
				</label>
				<div class='col-sm-10'>
				<span class='col-sm-9-addon'> <i class='fa fa-calendar'></i> </span>	
					<input type='text' id='contractDate' name='input-field' placeholder='Date of Contract' data-date-format='dd-mm-yyyy' data-date-viewmode='years' class='form-control date-picker'>	
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Builder Yard :
				</label>
				<div class='col-sm-10'>
					<input type='text' id='builder' name='input-field' placeholder='Name of Builder Yard' class='form-control'>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Keel Laying :											
				</label>
				<div class='col-sm-10'>
				<span class='col-sm-9-addon'> <i class='fa fa-calendar'></i> </span>	
					<input type='text' id='keelLay' name='input-field' placeholder='Date of Keel Laying' data-date-format='dd-mm-yyyy' data-date-viewmode='years' class='form-control date-picker'>	
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Hull Number :
				</label>
				<div class='col-sm-10'>
					<input type='text' id='hullNumber' name='input-field' placeholder='Hull Number' class='form-control'>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Launching :											
				</label>
				<div class='col-sm-10'>
				<span class='col-sm-9-addon'> <i class='fa fa-calendar'></i> </span>	
					<input type='text' id='launching' name='input-field' placeholder='Date of Launching' data-date-format='dd-mm-yyyy' data-date-viewmode='years' class='form-control date-picker'>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Completion :											
				</label>
				<div class='col-sm-10'>
				<span class='col-sm-9-addon'> <i class='fa fa-calendar'></i> </span>	
					<input type='text' id='completion' name='input-field' placeholder='Date of Completion' data-date-format='dd-mm-yyyy' data-date-viewmode='years' class='form-control date-picker'>	
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Previous Class :
				</label>
				<div class='col-sm-10'>
					<input type='text' id='prevClass' name='input-field' placeholder='Previous class of the ship' class='form-control'>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Character and Notation :
				</label>
				<div class='col-sm-10'>
					<input type='text' id='charNotation' name='input-field' placeholder='Previous Class Character and Notation' class='form-control'>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Other Class :
				</label>
				<div class='col-sm-10'>
					<input type='text' id='otherClass' name='input-field' placeholder='Other class of the ship(in case of dual class)' class='form-control'>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Character and Notation :
				</label>
				<div class='col-sm-10'>
					<input type='text' id='otherChar' name='input-field' placeholder='Other Class Character and Notation' class='form-control'>
				</div>
			</div>
			
			
			<h3>Hull Particular</h3>
			
			
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					LOA :
				</label>
				<div class='col-sm-10'>
					<input type='text' id='loa' name='input-field2' placeholder='in meter' class='form-control'>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					LPP :
				</label>
				<div class='col-sm-10'>
					<input type='text' id='lpp' name='input-field2' placeholder='in meter' class='form-control'>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Lf :
				</label>
				<div class='col-sm-10'>
					<input type='text' id='lf' name='input-field2' placeholder='in meter' class='form-control'>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Bmld :
				</label>
				<div class='col-sm-10'>
					<input type='text' id='bmld' name='input-field2' placeholder='in meter' class='form-control'>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Hmld :
				</label>
				<div class='col-sm-10'>
					<input type='text' id='hmld' name='input-field2' placeholder='in meter' class='form-control'>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					T :
				</label>
				<div class='col-sm-10'>
					<input type='text' id='draft' name='input-field2' placeholder='in meter' class='form-control'>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Freeboard :
				</label>
				<div class='col-sm-10'>
					<input type='text' id='freeboard' name='input-field2' placeholder='summer freeboard (in mm)' class='form-control'>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					GT :
				</label>
				<div class='col-sm-10'>
					<input type='text' id='grossTon' name='input-field2' placeholder='Gross Tonnage (in m3/RT)' class='form-control'>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Nett :
				</label>
				<div class='col-sm-10'>
					<input type='text' id='netTon' name='input-field2' placeholder='Nett Tonnage (in m3/RT)' class='form-control'>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Dead Weight :
				</label>
				<div class='col-sm-10'>
					<input type='text' id='dwt' name='input-field2' placeholder='Deadweight corresponding to assigned summer freeboard draught' class='form-control'>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Displacement :
				</label>
				<div class='col-sm-10'>
					<input type='text' id='displacement' name='input-field2' placeholder='Displacement corresponding to assigned summer freeboard draught' class='form-control'>
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
		$htmlStr = $this->constructForm('gen-form');
		return $htmlStr;
	}


}

?>
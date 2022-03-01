<?php

class BaseClass
{
	protected $helper;
	protected $code;
	protected $parent;
	protected $project;
	protected $user;
	protected $usersArr;
	protected $datId;
	protected $headers;
	protected $formChild;
	protected $formParent;
	protected $opt;
	protected $family;

	protected function generateField($obj, $code, $parent, $forms)
	{
		$childMenu = $obj->getChildMenu("id", $code, $parent);
		foreach($childMenu as $menu)
		{
			$this->opt = explode("-", $menu['menu']);
		}
		$fields = "";
		for($i=0; $i<count($this->opt); $i++)
		{
			$fields = $fields.$forms[$this->opt[$i]]; 
		}

		return $fields;
	}

	protected function constructParentForm($formId)
	{
		$field = $this->formParent;
		$checklists = $this->helper->getChecklist($this->project, $this->code);
		if($checklists['row'] == 0)
		{
			$button = "Submit";
			
			$htmlStr = "	
				$field
				<a class='btn btn-blue' onClick='sendTree(&#39;$formId&#39;, &#39;$this->code&#39;, $this->project);' >
					<i  id='tomboltask' class='fa fa-plus' ></i>
					$button
				</a>
			";
		}else
		{
			$button = "Update";
			foreach($checklists['content'] as $dat)
			{
				$checkStr = $dat['checklist'];
			}			
			$checkArr = explode("#", $checkStr);
			$check = json_encode($checkArr);

			$htmlStr = "	
				$field
				<a class='btn btn-blue' onClick='sendTree(&#39;$formId&#39;, &#39;$this->code&#39;, $this->project);' >
					<i  id='tomboltask' class='fa fa-plus' ></i>
					$button
				</a>

				<script>
					assignCheck('$formId', $check);
				</script>
			";
		}

		return $htmlStr;
	}

	protected function constructChildForm($formId)
	{
		$fields = $this->generateField($this->helper, $this->code, $this->parent, $this->formChild);

		$script = "";
		$button = "Submit";

		if(!empty($this->datId))
		{
			//get data here
			$all = $this->helper->JSONDataGetById($this->datId);
			foreach($all['content'] as $a)
			{
				$data = $a['data'];
			}

			$script = "<script>
							assignElem('$formId', $data);
						</script>";
			$button = "Update";
		}

		$htmlStr = "<input id='parent-field' type='hidden' value=$this->parent></input>
			  		<input id='dataid-field' type='hidden' value=$this->datId></input>
					<form id='$formId' role='form' class='form-horizontal'>
				$fields
			  <div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
				</label>
				<div class='col-sm-10'>
					<a class='btn btn-blue' onClick='sendData(&#39;$formId&#39;, &#39;$this->code&#39;, &#39;$this->parent&#39;, $this->project, &#39;$this->family&#39;);' >
						<i  id='tomboltask' class='fa fa-plus' ></i>
						$button
					</a>
				</div>
			</div>
			</form>
			$script		
			<hr>
				<div class='panel-table'>
					<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
						<thead>
							<tr>
								
			";

		return $htmlStr;	
	}

}

?>
<?php

class BaseChildlessClass
{
	protected $helper;
	protected $code;
	protected $parent;
	protected $project;
	protected $user;
	protected $usersArr;
	protected $datId;
	protected $form;
	protected $opt;
	protected $family;

	protected function constructForm($formId)
	{
		$all = $this->helper->JSONDataGet($this->project, $this->code);
		$formHead = "<form id='$formId' role='form' class='form-horizontal'>";
		if($all['row'] == 0)
		{
			$datIdField = "<input id='dataid-field' type='hidden' value=''>";
			$button = "<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
				</label>
				<div class='col-sm-10'>
					<a class='btn btn-blue' onClick='sendData(&#39;$formId&#39;, &#39;$this->code&#39;, &#39;$this->parent&#39;, $this->project, &#39;$this->family&#39;);'>
						<i  id='tomboltask' class='fa fa-plus' ></i>
						Submit
					</a>
				</div>
			</div>
			</form>";
			$htmlStr = $datIdField.$formHead.$this->form.$button;
		}else
		{
			foreach($all['content'] as $dat)
			{
				$data = $dat['data'];
				$id = $dat['id'];
			}
			$datIdField = "<input id='dataid-field' type='hidden' value='$id'>";
			$button = "<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
				</label>
				<div class='col-sm-10'>
					<a class='btn btn-blue' onClick='sendData(&#39;$formId&#39;, &#39;$this->code&#39;, &#39;$this->parent&#39;, $this->project, &#39;$this->family&#39;, $id);'>
						<i  id='tomboltask' class='fa fa-plus' ></i>
						Update
					</a>
				</div>
			</div>
			</form>";
			$script = "<script>
							assignElem('$formId', $data);
						</script>";
			$htmlStr = $datIdField.$formHead.$this->form.$button.$script;
		}

		return $htmlStr;
	}

}

?>
var UITreeview = function (childData, projId) {
    //function to initiate jquery.dynatree
	var runTreeView = function (childData, projId) {
        //Default Tree
        //Init from JS object 
        var nodes = $("#tree").dynatree({
            onActivate: function (node) {
                // A DynaTreeNode object is passed to the activation handler
                // Note: we also get this event, if persistence is on, and the page is reloaded.
                //alert("You activated " + node.data.value);
				sendCode(node.data.key, projId, node.data.family, node);
            },
            children: childData
        });
		
    };
    return {
        //main function to initiate template pages
        init: function (childData, projId) {
            runTreeView(childData, projId);
        }
    };
}();

function test()
{
	/*var element = document.getElementById("tree");
	element.parentNode.removeChild(element);

	var parent = document.getElementById("tree-parent");
	var newElem = document.createElement("div");
	newElem.setAttribute("id", 'tree');
	parent.appendChild(newElem);*/

	var idProj = document.getElementById("project-id").value;
	var childData = [{"title":"General and hull particular","key":"gen","isFolder":true,"family":"-","tooltip":null},{"title":"Cargo Capacity","key":"cpc","isFolder":true,"family":"-","tooltip":null}];
	UITreeview.init(childData, idProj);

	$("#tree").dynatree("getTree").reload();
}

function sendCode(id, projId, family, node)
{
	var page = "shipProcess.php";
	var modul = "getForm";
	var par = node.getParent();

	if(par.data.key != "_1")
	{
		var parentKey = par.data.key;
	}else
	{
		var parentKey = "root";
	}
	
	$.post(page, {modul:modul, id:id, projId:projId, family:family, parentKey:parentKey} , function(html) {
			$('.panel-input').html(html);
			$(".panel-input").hide();
			$(".panel-input").fadeIn(400);});
}

function sendTree(formId, code, projId)
{
	var data = getFormData(formId);
	var dataStr = JSON.stringify(data);
	console.log(dataStr);
	var page = "shipProcess.php";
	var modul = "updateTree";

	$.post(page, {modul:modul, data:dataStr, code:code, projId:projId} , function(resp) {
			//console.log(resp);
			resp = resp.split("+").join(" ");
			var data = JSON.parse(resp);
			UITreeview.init(data, projId);
			$("#tree").dynatree("getTree").reload();
			$(".panel-menu").hide();
			$(".panel-menu").fadeIn(400);
		});
}

function sendData(formId, code, parent, projId, family)
{
	var data = getFormData(formId);
	console.log(data);
	var dataStr = JSON.stringify(data);
	var page = "shipProcess.php";
	var modul = "dataOps";
	var dataId = document.getElementById("dataid-field").value;
	if(dataId == 'undefined')
	{
		dataId = null;
	}

	$.post(page, {modul:modul, data:dataStr, code:code, parent:parent, family:family, projId:projId, dataId:dataId, act:"edit"} , function(html) {
			console.log(html);
			$('.panel-input').html(html);
			$(".panel-input").hide();
			$(".panel-input").fadeIn(400);
		});
}

function sendUpdate(code, parent, projId, family, datId)
{
	var page = "shipProcess.php";
	var modul = "getForm";
	
	$.post(page, {modul:modul, id:code, projId:projId, family:family, parentKey:parent, datId:datId} , function(html) {
			$('.panel-input').html(html);
			$(".panel-input").hide();
			$(".panel-input").fadeIn(400);});
}

function deleteData(code, parent, projId, family, dataId)
{
	var page = "shipProcess.php";
	var modul = "dataOps";

	$.post(page, {modul:modul, code:code, parent:parent, family:family, projId:projId, dataId:dataId, act:"del"} , function(html) {
			console.log(html);
			$('.panel-input').html(html);
			$(".panel-input").hide();
			$(".panel-input").fadeIn(400);
		});
}

function sendZnum()
{
	var page = "shipProcess.php";
	var modul = "znum";
	var znum = document.getElementById('znum').value;

	$.post(page, {modul:modul, znum:znum} , function(resp) {
			console.log(resp);
			var data = JSON.parse(resp);
			assignElem('eqp-form', data);
		});
}

function addItem()
{
	var table = document.getElementById("option-table");
	var rowData = document.getElementById("row-data");
	var cells = rowData.getElementsByTagName("td");
	var row = table.insertRow(table.rows.length);
	var cell1 = row.insertCell(0);
	var cell2 = row.insertCell(1);
	var cell3 = row.insertCell(2);

	var latest = parseInt(document.getElementById("latest").value) + 1;
	document.getElementById("latest").value = latest
	
	cells[0].children[0].setAttribute('id', "cap-type-"+latest);
	cells[1].children[0].setAttribute('id', "cap-"+latest);
	cells[2].children[0].setAttribute('id', "id-"+latest);

	cell1.innerHTML = cells[0].innerHTML;
	cell2.innerHTML = cells[1].innerHTML;
	cell3.innerHTML = cells[2].innerHTML;
}

function addItem2()
{
	var table = document.getElementById("option-table");
	var rowData = document.getElementById("row-data");
	var cells = rowData.getElementsByTagName("td");
	var row = table.insertRow(table.rows.length);
	var cell1 = row.insertCell(0);
	var cell2 = row.insertCell(1);
	var cell3 = row.insertCell(2);
	var cell4 = row.insertCell(3);
	
	cell1.innerHTML = cells[0].innerHTML;
	cell2.innerHTML = cells[1].innerHTML;
	cell3.innerHTML = cells[2].innerHTML;
	cell4.innerHTML = cells[3].innerHTML;
}

function assignElem(formId, data)
{
	var elem = $("form#"+formId+" :input");
	for(i in data)
	{
		if(data[i].indexOf("@@") != -1)
		{
			data[i] = data[i].split("@@");
			data[i].shift();
		}
	}

	[].forEach.call(elem, function(el){
		if(el.type == "checkbox")
		{
			for(i in data)
			{
				if(Array.isArray(data[i]))
				{
					for(k in data[i])
					{
						if(el.value == data[i][k])
						{
							el.setAttribute("checked", "");
						}
					}
				}
			}
		}else if(el.type == "radio")
		{
			for(i in data)
			{
				if(el.value == data[i])
				{
					el.setAttribute("checked", "");
				}
			}
		}else
		{
			for(i in data)
			{
				if(el.id == i)
				{
					el.value = data[i];
				}
			}
		}
	});
}

function assignCheck(formId, check)
{
	var elem = $("form#"+formId+" :input");
	checkboxFill(elem, check);
}

function getFormData(formId)
{
	var elem = $("form#"+formId+" :input");
	var data = elementsToJSON(elem);
	return data;
}

function elementsToJSON(elements)
{
    var out = Array.prototype.reduce.call(elements, function(data, element){
                    data[element.id] =  {
                                            name: element.name,
                                            type: element.type,
                                            value: element.value,
                                            check: element.checked
                                         };
                    return data;
                }, {});
    
    var data = initObject(out);
    data = parseData(out, data);
    
    return data;
}

function initObject(obj)
{
    var data = {}
    for(item in obj)
    {
        if(obj[item].type == "checkbox" || obj[item].type == "radio")
        {
            data[obj[item].name] = "";
        }else
        {
            data[item] = "";
        }
    }
    
    return data;
}

function parseData(obj, data)
{
    for(item in obj)
    {
        if(obj[item].type == "checkbox")
        {
            if(obj[item].check)
            {
                data[obj[item].name] = data[obj[item].name]+"@@"+obj[item].value;
            }
        }else if(obj[item].type == "radio")
        {
            if(obj[item].check)
            {
                data[obj[item].name] = obj[item].value;
            }
        }else
        {
            data[item] = obj[item].value;
        }
    }

    return data;
}

function checkboxFill(elem, arr)
{
	[].forEach.call(elem, function(el){
		for(i in arr)
		{
			if(arr[i] == el.id)
			{
				el.setAttribute("checked", "");
			}		
		}
	});
}

function radioFill(id)
{
	var elem = $("#"+id);
	elem.setAttribute("checked", "");
}

//------------------old functions------------------------------

function sendCodeOld(id, projId, family, node)
{
	var page = "projProcess.php";
	var modul = "updateField";
	var par = node.getParent();

	if(par.data.key != "_1")
	{
		var parentKey = par.data.key;
	}else
	{
		var parentKey = "root";
	}
	
	$.post(page, {modul:modul, id:id, projId:projId, family:family, parentKey:parentKey} , function(html) {
			$('.panel-input').html(html);
			$(".panel-input").hide();
			$(".panel-input").fadeIn(400);});
}

function sendUpdateOld(id, projId, dataId, family)
{
	var page = "projProcess.php";
	var modul = "updateField";
	var parentKey = document.getElementById("parent-field").value;
	
	console.log(dataId);
	
	$.post(page, {modul:modul, id:id, dataId:dataId, projId:projId, parentKey:parentKey, family:family} , function(html) {
			$('.panel-input').html(html);
			$(".panel-input").hide();
			$(".panel-input").fadeIn(400);});
}

function sendMenu(id, family)
{
	var page = "projProcess.php";
	var modul = "updateMenu";
	var childData = document.getElementById("child-input").value;
	var projId = document.getElementById("project-id").value;
	var uId = document.getElementById("user-id").value;
	var stringCommand = id + "~" + childData + "~" + uId + "~" + projId;
	if(family != "-")
	{
		id = family;
	}
	if(id == "gen")
	{
		var strDat = genInput(stringCommand);
		stringCommand = strDat;
	}else if(id == "cpc")
	{
		var strDat = capInput(stringCommand);
		stringCommand = strDat;
	}else if(id == "tnk")
	{
		var strDat = tankInput(stringCommand);
		stringCommand = strDat;
	}else if(id == "crh" || id == "crt" ||  id == "blt" || id == "fpt" || id=="apt" || id=="spt" || id=="vot" || id=="fwt" || id=="fot" || id=="lot" || id=="sdt" || id=="cfd" || id=="ott")
	{
		var strDat = tankTypeInput(stringCommand, family);
		stringCommand = strDat;
	}
	else if(id == "blh")
	{
		var strDat = bulkInput(stringCommand);
		stringCommand = strDat;
	}
	else if(id == "tbl" || id == "lbl")
	{
		var strDat = bulkTypeInput(stringCommand, family);
		stringCommand = strDat;
	}
	else if(id == "dck")
	{
		var strDat = deckInput(stringCommand);
		stringCommand = strDat;
	}else if(id == "dec" || id == "spc")
	{
		var strDat = deckTypeInput(stringCommand, family);
		stringCommand = strDat;
	}else if(id == "eqp")
	{
		var strDat = equipmentInput(stringCommand);
		stringCommand = strDat;
	}else if(id == "rdc")
	{
		var strDat = rudderInput(stringCommand);
		stringCommand = strDat;
	}
	else if(id == "cgh")
	{
		var strDat = cargoInput(stringCommand);
		stringCommand = strDat;
	}else if(id == "meg")
	{
		var strDat = mainEngineInput(stringCommand);
		stringCommand = strDat;
	}else if(id == "mac")
	{
		var strDat = machineryInput(stringCommand);
		stringCommand = strDat;
	}else if(id == "pmp")
	{
		var strDat = machineryTypeInput(stringCommand, family);
		stringCommand = strDat;
	}else if(id == "trs")
	{
		var strDat = transmissionInput(stringCommand, family);
		stringCommand = strDat;
	}else if(id == "ims" || id == "rvg" || id == "tfb" || id == "fgf" || id == "cob")
	{
		var strDat = transmissionTypeInput(stringCommand, family);
		stringCommand = strDat;
	}else if(id == "prs")
	{
		var strDat = shaftPropInput(stringCommand, family);
		stringCommand = strDat;
	}else if(id == "prp")
	{
		var strDat = propInput(stringCommand, family);
		stringCommand = strDat;
	}else if(id == "aeg")
	{
		var strDat = auxEngineInput(stringCommand, family);
		stringCommand = strDat;
	}else if(id == "axu" || id == "grt" || id == "egn" || id == "sfo" || id == "cpd" || id == "cpb")
	{
		var strDat = auxEngineTypeInput(stringCommand, family, id);
		stringCommand = strDat;
	}else if(id == "eln")
	{
		var strDat = electricalInput(stringCommand, family);
		stringCommand = strDat;
	}else if(id == "msb" || id == "esb" || id == "ecb")
	{
		var strDat = electricalTypeInput(stringCommand, family, id);
		stringCommand = strDat;
	}else if(id == "frf")
	{
		var strDat = firefightInput(stringCommand, family);
		stringCommand = strDat;
	}else if(id == "xfx" || id == "pfx" || id == "fsz")
	{
		var strDat = firefightTypeInput(stringCommand, family, id);
		stringCommand = strDat;
	}
	console.log(stringCommand);
	$.post(page, {modul:modul, stringCommand:stringCommand, family:family} , function(html) {
		$('.panel-menu').html(html);
		$(".panel-menu").hide();
		$(".panel-menu").fadeIn(400);});
}

function updateTree()
{
	var root = $('#tree').dynatree('getRoot');
	root.addChild
	({
		title: 'Item 4',
		key: 'g'
	});
}

function getChildData()
{
	var childData = document.getElementById("child-input").value;
	console.log(JSON.parse(childData));
	return JSON.parse(childData);

}

function deleteOpt(btn)
{
	var row = btn.parentNode.parentNode;
	row.parentNode.removeChild(row);
}

function genInput(stringCommand)
{
	var genData = document.getElementsByName("input-field");
	var particularData = document.getElementsByName("input-field2");
	var materials = document.getElementsByName("statusRadios");
	var statuses = document.getElementsByName("materialRadios");
	stringCommand = stringCommand + "~";
	for(i=0;i<genData.length;i++)
	{
		stringCommand = stringCommand + genData[i].value + "#";
	}
	for(i=0;i<materials.length;i++)
	{
		if(materials[i].checked)
		{
			stringCommand = stringCommand + materials[i].value + "#";
		}
	}
	for(i=0;i<statuses.length;i++)
	{
		if(statuses[i].checked)
		{
			stringCommand = stringCommand + statuses[i].value;
		}
	}
	stringCommand = stringCommand + "~";
	for(i=0;i<particularData.length;i++)
	{
		stringCommand = stringCommand + particularData[i].value + "#";
	}
	stringCommand = stringCommand.slice(0,-1);
	
	return stringCommand;
}

function capInput(stringCommand)
{
	var type = document.getElementsByName("select-field");
	var cap = document.getElementsByName("input-field");
	var id = document.getElementsByName("id-field");
	
	stringCommand = stringCommand + "~";
	
	for(i=0;i<type.length;i++)
	{
		stringCommand = stringCommand + id[i].value + "#" + type[i].value + "#" + cap[i].value + "@"; 
	}
	stringCommand = stringCommand.slice(0,-1);
	
	return stringCommand;
}

function tankInput(stringCommand)
{
	var tank = document.getElementsByName("tank-field");
	var checker = tank.length;
	stringCommand = stringCommand + "~";
	
	for(i=0;i<tank.length;i++)
	{
		if(tank[i].checked)
		{
			stringCommand = stringCommand + tank[i].value + "#";
			checker--;
		}
	}
	if(checker == tank.length)
	{
		stringCommand = stringCommand + "---";
	}else
	{
		stringCommand = stringCommand.slice(0,-1);
	}
	
	return stringCommand;
}

function bulkInput(stringCommand)
{
	var bulk = document.getElementsByName("bulk-field");
	var checker = bulk.length;
	stringCommand = stringCommand + "~";
	
	for(i=0;i<bulk.length;i++)
	{
		if(bulk[i].checked)
		{
			stringCommand = stringCommand + bulk[i].value + "#";
			checker--;
		}
	}
	if(checker == bulk.length)
	{
		stringCommand = stringCommand + "---";
	}else
	{
		stringCommand = stringCommand.slice(0,-1);
	}
	
	return stringCommand;
}

function deckInput(stringCommand)
{
	var deck = document.getElementsByName("deck-field");
	var checker = deck.length;
	stringCommand = stringCommand + "~";
	
	for(i=0;i<deck.length;i++)
	{
		if(deck[i].checked)
		{
			stringCommand = stringCommand + deck[i].value + "#";
			checker--;
		}
	}
	if(checker == deck.length)
	{
		stringCommand = stringCommand + "---";
	}else
	{
		stringCommand = stringCommand.slice(0,-1);
	}
	
	return stringCommand;
}

function machineryInput(stringCommand)
{
	var mach = document.getElementsByName("item-field");
	var checker = mach.length;
	var parentId = document.getElementById("parent-field").value;
	stringCommand = stringCommand + "~";
	
	for(i=0;i<mach.length;i++)
	{
		if(mach[i].checked)
		{
			stringCommand = stringCommand + mach[i].value + "#";
			checker--;
		}
	}
	if(checker == mach.length)
	{
		stringCommand = stringCommand + "---~" + parentId;
	}else
	{
		stringCommand = stringCommand.slice(0,-1) + "~" + parentId;
	}
	
	return stringCommand;
}

function transmissionInput(stringCommand)
{
	var transm = document.getElementsByName("transm-field");
	var checker = transm.length;
	stringCommand = stringCommand + "~";
	
	for(i=0;i<transm.length;i++)
	{
		if(transm[i].checked)
		{
			stringCommand = stringCommand + transm[i].value + "#";
			checker--;
		}
	}
	if(checker == transm.length)
	{
		stringCommand = stringCommand + "---";
	}else
	{
		stringCommand = stringCommand.slice(0,-1);
	}
	
	return stringCommand;
}

function auxEngineInput(stringCommand)
{
	var checklist = document.getElementsByName("chk-field");
	var checker = checklist.length;
	stringCommand = stringCommand + "~";
	
	for(i=0;i<checklist.length;i++)
	{
		if(checklist[i].checked)
		{
			stringCommand = stringCommand + checklist[i].value + "#";
			checker--;
		}
	}
	if(checker == checklist.length)
	{
		stringCommand = stringCommand + "---";
	}else
	{
		stringCommand = stringCommand.slice(0,-1);
	}
	
	return stringCommand;
}

function electricalInput(stringCommand)
{
	var checklist = document.getElementsByName("chk-field");
	var checker = checklist.length;
	stringCommand = stringCommand + "~";
	
	for(i=0;i<checklist.length;i++)
	{
		if(checklist[i].checked)
		{
			stringCommand = stringCommand + checklist[i].value + "#";
			checker--;
		}
	}
	if(checker == checklist.length)
	{
		stringCommand = stringCommand + "---";
	}else
	{
		stringCommand = stringCommand.slice(0,-1);
	}
	
	return stringCommand;
}

function firefightInput(stringCommand)
{
	var checklist = document.getElementsByName("chk-field");
	var checker = checklist.length;
	stringCommand = stringCommand + "~";
	
	for(i=0;i<checklist.length;i++)
	{
		if(checklist[i].checked)
		{
			stringCommand = stringCommand + checklist[i].value + "#";
			checker--;
		}
	}
	if(checker == checklist.length)
	{
		stringCommand = stringCommand + "---";
	}else
	{
		stringCommand = stringCommand.slice(0,-1);
	}
	
	return stringCommand;
}

function tankTypeInput(stringCommand, family)
{
	var common = document.getElementsByName("input-field");
	var protection = document.getElementsByName("cp-field");
	var extent = document.getElementById("coat-field");
	var heating = document.getElementsByName("ch-field");
	var plane = document.getElementsByName("plane-field");
	var parentId = document.getElementById("parent-field").value;
	var dataId = document.getElementById("dataid-field").value;
	
	var modul = "updateTable";
	var page = "projProcess.php";
	var stringCommandOri = stringCommand;
	
	stringCommand = stringCommand + "~";
	
	//common data: name, start frame and end frame
	for(i=0; i<common.length; i++)
	{
		stringCommand = stringCommand + common[i].value + "#";
	}
	//corrosion protection
	if(protection.length != 0)
	{
		var checker = protection.length;
		for(i=0; i<protection.length; i++)
		{
			if(protection[i].checked)
			{
				checker--;
				stringCommand = stringCommand + protection[i].value + "@";
			}
		}
		if(checker == protection.length)
		{
			stringCommand = stringCommand + "+";
		}else
		{
			stringCommand = stringCommand.slice(0,-1) + "+";
		}
	}else
	{
		stringCommand = stringCommand + "-+";
	}
	//protection extent
	if(extent != null)
	{
		stringCommand = stringCommand + extent.value + "+";
	}else
	{
		stringCommand = stringCommand + "-+";
	}
	//availability of cargo heating
	if(heating.length != 0)
	{
		for(i=0; i<heating.length; i++)
		{
			if(heating[i].checked)
			{
				stringCommand = stringCommand + heating[i].value + "+";
			}
		}
	}else
	{
		stringCommand = stringCommand + "-+";
	}
	//common plane boundary
	if(plane.length != 0)
	{
		for(i=0; i<plane.length; i++)
		{
			if(plane[i].checked)
			{
				stringCommand = stringCommand + plane[i].value + "+";
			}
		}
	}else
	{
		stringCommand = stringCommand + "-+";
	}
	
	stringCommand = stringCommand.slice(0,-1);
	
	$.post(page, {modul:modul, stringCommand:stringCommand, parentId:parentId, dataId:dataId, family:family} , function(html) {
			$('.panel-table').html(html);
			$(".panel-table").hide();
			$(".panel-table").fadeIn(400);});
	
	return stringCommandOri;
}

function equipmentInput(stringCommand)
{
	var equip1 = document.getElementsByName("input-field1");
	var equip2 = document.getElementsByName("input-field2");
	var equip3 = document.getElementsByName("input-field3");
	var equip4 = document.getElementsByName("input-field4");
	var equip5 = document.getElementsByName("input-field5");
	var equip6 = document.getElementsByName("input-field6");
	
	stringCommand = stringCommand + "~";
	for(i=0; i<equip1.length; i++)
	{
		stringCommand = stringCommand + equip1[i].value + "#";
	}
	stringCommand = stringCommand.slice(0,-1) + "@";
	
	for(i=0; i<equip2.length; i++)
	{
		stringCommand = stringCommand + equip2[i].value + "#";
	}
	stringCommand = stringCommand.slice(0,-1) + "@";
	
	for(i=0; i<equip3.length; i++)
	{
		if(equip3[i].id == "radio-field")
		{
			if(equip3[i].checked)
			{
				stringCommand = stringCommand + equip3[i].value + "#";
			}
		}else
		{
			stringCommand = stringCommand + equip3[i].value + "#";
		}
		
	}
	stringCommand = stringCommand.slice(0,-1) + "@";
	
	for(i=0; i<equip4.length; i++)
	{
		if(equip4[i].id == "radio-field")
		{
			if(equip4[i].checked)
			{
				stringCommand = stringCommand + equip4[i].value + "#";
			}
		}else
		{
			stringCommand = stringCommand + equip4[i].value + "#";
		}
		
	}
	stringCommand = stringCommand.slice(0,-1) + "@";
	
	for(i=0; i<equip5.length; i++)
	{
		stringCommand = stringCommand + equip5[i].value + "#";
	}
	stringCommand = stringCommand.slice(0,-1) + "@";
	
	for(i=0; i<equip6.length; i++)
	{
		stringCommand = stringCommand + equip6[i].value + "#";
	}
	stringCommand = stringCommand.slice(0,-1);
	
	return stringCommand;
}

function rudderInput(stringCommand)
{
	stringCommand = stringCommand + "~";
	for(i=1; i<=9; i++)
	{
		var name = "input-field"+i;
		var elem = document.getElementsByName(name);
		
		for(j=0; j<elem.length; j++)
		{
			stringCommand = stringCommand + elem[j].value + "#";
		}
		stringCommand = stringCommand.slice(0,-1) + "@";
	}
	stringCommand = stringCommand.slice(0,-1);
	
	return stringCommand;
}

function cargoInput(stringCommand)
{
	stringCommand = stringCommand + "~";
	for(i=1; i<=3; i++)
	{
		var name = "input-field"+i;
		var elem = document.getElementsByName(name);
		console.log(elem);
		for(j=0; j<elem.length; j++)
		{
			stringCommand = stringCommand + elem[j].value + "#";
		}
		stringCommand = stringCommand.slice(0,-1) + "@";
	}
	stringCommand = stringCommand.slice(0,-1);
	
	return stringCommand;
}

function mainEngineInput(stringCommand)
{
	var mainData = document.getElementsByName("input-field");
	var radios = document.getElementsByName("radio-field");
	var sel = document.getElementsByName("select-field");
	var type = document.getElementsByName("type-field");
	var num = document.getElementsByName("num-field");
	
	stringCommand = stringCommand + "~";
	
	for(i=0; i<mainData.length; i++)
	{
		stringCommand = stringCommand + mainData[i].value + "#";
	}
		
	for(i=0; i<radios.length; i++)
	{
		if(radios[i].checked)
		{
			stringCommand = stringCommand + radios[i].value; 
		}
	}
	stringCommand = stringCommand + "#";
	
	for(i=0; i<sel.length; i++)
	{
		stringCommand = stringCommand + sel[i].value + "+" + type[i].value + "+" + num[i].value + "@";
	}
	stringCommand = stringCommand.slice(0,-1);
	
	return stringCommand;
}

function bulkTypeInput(stringCommand, family)
{
	var common = document.getElementsByName("input-field");
	var parentId = document.getElementById("parent-field").value;
	var dataId = document.getElementById("dataid-field").value;
	
	var modul = "updateTable";
	var page = "projProcess.php";
	var stringCommandOri = stringCommand;
	
	stringCommand = stringCommand + "~";
	
	//only common data is present
	if(common.length == 2)
	{
		for(i=0; i<common.length; i++)
		{
			stringCommand = stringCommand + common[i].value + "#";
		}
		stringCommand = stringCommand + "-#-#"
	}else
	{
		for(i=0; i<common.length; i++)
		{
			stringCommand = stringCommand + common[i].value + "#";
		}
	}
	
	stringCommand = stringCommand.slice(0,-1);
	
	$.post(page, {modul:modul, stringCommand:stringCommand, parentId:parentId, dataId:dataId, family:family} , function(html) {
			$('.panel-table').html(html);
			$(".panel-table").hide();
			$(".panel-table").fadeIn(400);});
	
	return stringCommandOri;
}

function deckTypeInput(stringCommand, family)
{
	var common = document.getElementsByName("input-field");
	var parentId = document.getElementById("parent-field").value;
	var dataId = document.getElementById("dataid-field").value;
	var modul = "updateTable";
	var page = "projProcess.php";
	var stringCommandOri = stringCommand;
	
	stringCommand = stringCommand + "~";
	
	for(i=0; i<common.length; i++)
	{
		stringCommand = stringCommand + common[i].value + "#";
	}
	stringCommand = stringCommand.slice(0,-1);
	
	$.post(page, {modul:modul, stringCommand:stringCommand, parentId:parentId, dataId:dataId, family:family} , function(html) {
			$('.panel-table').html(html);
			$(".panel-table").hide();
			$(".panel-table").fadeIn(400);});
	
	return stringCommandOri;
}

function machineryTypeInput(stringCommand, family)
{
	var common = document.getElementsByName("common-field");
	var chara = document.getElementsByName("char-field");
	var parentId = document.getElementById("parent-field").value;
	var dataId = document.getElementById("dataid-field").value;
	var modul = "updateTable";
	var page = "projProcess.php";
	var stringCommandOri = stringCommand;
	
	stringCommand = stringCommand + "~";
	
	for(i=0; i<common.length; i++)
	{
		stringCommand = stringCommand + common[i].value + "#";
	}
	
	for(j=0; j<chara.length; j++)
	{
		stringCommand = stringCommand + chara[j].value + "+";
	}
	
	stringCommand = stringCommand.slice(0,-1);
	
	$.post(page, {modul:modul, stringCommand:stringCommand, parentId:parentId, dataId:dataId, family:family} , function(html) {
			$('.panel-table').html(html);
			$(".panel-table").hide();
			$(".panel-table").fadeIn(400);});
	
	return stringCommandOri;
}

function transmissionTypeInput(stringCommand, family)
{
	var input = document.getElementsByName("input-field");
	var mapStr = document.getElementById("map-field").value;
	var parentId = document.getElementById("parent-field").value;
	var dataId = document.getElementById("dataid-field").value;
	
	var map = mapStr.split("-");
	
	var modul = "updateTable";
	var page = "projProcess.php";
	var stringCommandOri = stringCommand;
	
	var value = "";
	var match = false;

	stringCommand = stringCommand + "~";
	
	//common data: name, start frame and end frame
	for(i=1; i<=14; i++)
	{
		match = false;
		for(j=0; j<map.length; j++)
		{
			if(map[j] == i)
			{
				value = input[j].value;
				match = true;
			}
		}
		
		if(!match)
		{
			value = "-";
		}
		
		stringCommand = stringCommand + value + "#";
	}
	
	stringCommand = stringCommand.slice(0,-1);
	
	$.post(page, {modul:modul, stringCommand:stringCommand, parentId:parentId, dataId:dataId, family:family} , function(html) {
			$('.panel-table').html(html);
			$(".panel-table").hide();
			$(".panel-table").fadeIn(400);});
	
	return stringCommandOri;
}

function auxEngineTypeInput(stringCommand, family, id)
{
	var parentId = document.getElementById("parent-field").value;
	var dataId = document.getElementById("dataid-field").value;
	var modul = "updateTable";
	var page = "projProcess.php";
	var stringCommandOri = stringCommand;
	
	stringCommand = stringCommand + "~";

	var input = document.getElementsByName("input-field");
	var additional = document.getElementsByName("additional-field");
	for(i=0; i<input.length; i++)
	{
		stringCommand = stringCommand + input[i].value + "#"; 
	}
	stringCommand = stringCommand.slice(0,-1) + "@";
	for(i=0; i<additional.length; i++)
	{
		stringCommand = stringCommand + additional[i].value + "#"; 
	}
	stringCommand = stringCommand.slice(0,-1);

	$.post(page, {modul:modul, stringCommand:stringCommand, parentId:parentId, dataId:dataId, family:family} , function(html) {
		$('.panel-table').html(html);
		$(".panel-table").hide();
		$(".panel-table").fadeIn(400);});

	return stringCommandOri;
}

function electricalTypeInput(stringCommand, family, id)
{
	var parentId = document.getElementById("parent-field").value;
	var dataId = document.getElementById("dataid-field").value;
	var map = document.getElementById("map-field").value;
	var input = document.getElementsByName("input-field");
	var mapArr = map.split("-");
	var modul = "updateTable";
	var page = "projProcess.php";
	var stringCommandOri = stringCommand;
	var j = 0;
	var k = 0;
	
	stringCommand = stringCommand + "~";
	
	for(i=1; i<=9; i++)
	{
		if(i == mapArr[j])
		{
			stringCommand = stringCommand + input[k].value + "#";
			j++;
			k++;
		}else
		{
			stringCommand = stringCommand + "-#";
		}			
	}
	
	stringCommand = stringCommand.slice(0,-1);
	
	$.post(page, {modul:modul, stringCommand:stringCommand, parentId:parentId, dataId:dataId, family:family} , function(html) {
		$('.panel-table').html(html);
		$(".panel-table").hide();
		$(".panel-table").fadeIn(400);});

	return stringCommandOri;
}

function firefightTypeInput(stringCommand, family, id)
{
	var parentId = document.getElementById("parent-field").value;
	var dataId = document.getElementById("dataid-field").value;
	var input = document.getElementsByName("input-field");

	var modul = "updateTable";
	var page = "projProcess.php";
	var stringCommandOri = stringCommand;
	
	stringCommand = stringCommand + "~";
	
	for(i=0; i<input.length; i++)
	{
		stringCommand = stringCommand + input[i].value + "#";			
	}
	
	stringCommand = stringCommand.slice(0,-1);
	
	console.log(stringCommand);

	$.post(page, {modul:modul, stringCommand:stringCommand, parentId:parentId, dataId:dataId, family:family} , function(html) {
		$('.panel-table').html(html);
		$(".panel-table").hide();
		$(".panel-table").fadeIn(400);});

	return stringCommandOri;
}

function shaftPropInput(stringCommand, family)
{
	var stat = document.getElementsByName("statusRadios");
	var input = "";
	var statVal = "";
	for(i=0;i<stat.length;i++)
	{
		if(stat[i].checked)
		{
			statVal = stat[i].value;
		}
	}
	
	var value = "";
	var match = false;

	stringCommand = stringCommand + "~";
	
	for(i=1; i<=3; i++)
	{
		input = document.getElementsByName("input-field"+i);
		for(j=0; j<input.length; j++)
		{
			stringCommand = stringCommand + input[j].value + "#"
		}
		stringCommand = stringCommand.slice(0,-1) + "~";
	}
	
	stringCommand = stringCommand.slice(0,-1) + "#" + statVal;
	
	return stringCommand;
}

function propInput(stringCommand, family)
{
	var input = document.getElementsByName("input-field");
	stringCommand = stringCommand + "~";
	
	for(i=0; i<input.length; i++)
	{
		stringCommand = stringCommand + input[i].value + "#"
	}
	
	stringCommand = stringCommand.slice(0,-1);
	return stringCommand;
}

function deleteDat(dataId, projId, id, family)
{
	var page = "projProcess.php";
	var modul = "updateField";
	var act = "del";
	var parentEl = document.getElementById("parent-field");
	if(parentEl != undefined)
	{
		var parentKey = parentEl.value;
	}
	
	if(confirm("Are you sure you want to delete this data?"))
	{
		$.post(page, {modul:modul, id:id, projId:projId, dataId:dataId, act:act, family:family, parentKey:parentKey} , function(html) {
			$('.panel-input').html(html);
			$(".panel-input").hide();
			$(".panel-input").fadeIn(400);});
	}

}
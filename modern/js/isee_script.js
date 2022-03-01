function WebAddUser(divname){

	var nup = document.getElementById("nup").value;
	var hp =document.getElementById("phone").value;
	var rpass =document.getElementById("password").value;
	var pass= hex_sha512(rpass);
	var modul ="ManUser" ;

	var act = "add";
		$.post("process-ogs.php", {nup:nup, act: act , modul: modul, hp:hp, pass:pass} , function(html) {
				$('.' + divname).html(html);
				$('.' + divname).hide();
				$('.' + divname).fadeIn(400);});
			
}

function AddTableU (divname) {
	
	var modul = "ManUser"; //menjalankan modul di iseeprocess
	var act = "refresh"; //menjalankan coding act di iseeprocess
		$.post("process-ogs.php", {act: act , modul: modul} , function(html) {
			$('.' + divname).html(html);
			$('.' + divname).hide();
			$('.' + divname).fadeIn(400);});
}

function WebActivateUser (divname, nup) { 
	
	var modul = "ManUser";
	var act = "activate";
		$.post("process-ogs.php", {nup:nup, act: act , modul: modul} , function(html) {
			$('.' + divname).html(html);
			$('.' + divname).hide();
			$('.' + divname).fadeIn(400);});
}

function WebShowEditUser (divname, nup, name, phone, email) {
	
	document.getElementById("nupedit").value = nup ;
	document.getElementById("nameedit").value = name ;
	document.getElementById("newphone").value = phone ;
	document.getElementById("newemail").value = email ;

}

function WebEditUser (divname) {
	var nup = document.getElementById("nupedit").value;
	var nhp = document.getElementById("newphone").value;
	var nemail = document.getElementById("newemail").value;
	var modul = "ManUser";
	var act = "edit";

	
	//alert(nhp); // buat ngecek datanya masuk atau ndak
	
		$.post("process-ogs.php", {nhp:nhp, nemail:nemail, nup:nup, act: act , modul: modul} , function(html) {
			$('.' + divname).html(html);
			$('.' + divname).hide();
			$('.' + divname).fadeIn(400);});
			
	// membersihkan kolom
	document.getElementById("newphone").value = "";
	document.getElementById("newemail").value = "";
}

function WebDeleteUser (divname, nup) {
	if(confirm("Are you sure that you want to delete this account?"))
	{
	var modul = "ManUser";
	var act = "delete";
		$.post("process-ogs.php", {nup:nup, act: act , modul: modul} , function(html) {
			$('.' + divname).html(html);
			$('.' + divname).hide();
			$('.' + divname).fadeIn(400);});
	alert("The account has been deleted");		
	}	
}

function WebLockUser (divname, status, nup) {
	
	var modul = "ManUser";
	var act = "lock";
		$.post("process-ogs.php", {nup:nup, status:status, act: act , modul: modul} , function(html) {
			$('.' + divname).html(html);
			$('.' + divname).hide();
			$('.' + divname).fadeIn(400);});
}

function WebShowResetUser (divname, nup, name) {
	
	document.getElementById("nupreset").value = nup ;
	document.getElementById("namereset").value = name ;

}

function WebResetUser (divname) {
	var nup = document.getElementById("nupreset").value;
	var nwpass = document.getElementById("newpass").value;
	var npass= hex_sha512(nwpass);	
	var cpass = document.getElementById("conpass").value;
	var modul = "ManUser";
	var act = "resetpass";
	

	
//	alert(nwpass+" "+npass); //memunculkan peringatan

	if (nwpass==cpass){
		$.post("process-ogs.php", {nup:nup, npass:npass, act: act , modul: modul} , function(html) {
			$('.' + divname).html(html);
			$('.' + divname).hide();
			$('.' + divname).fadeIn(400);});
	}
	else {
		alert ("Please re-enter your new password and make sure to fill confirm password correctly");
	}	

			
	document.getElementById("newpass").value = "";
	document.getElementById("conpass").value = "";
	
		alert ("The password has been reset");
}

function AddTableS (divname) {
	
	var modul = "SpecialUser";
	var act = "refreshS";
		$.post("process-ogs.php", {act: act , modul: modul} , function(html) {
			$('.' + divname).html(html);
			$('.' + divname).hide();
			$('.' + divname).fadeIn(400);});
}

function WebDeleteSessionUser (divname, id) {
	var modul = "SpecialUser";
	var act = "deletesession";
		$.post("process-ogs.php", {id:id, act:act, modul: modul} , function(html) {
			$('.' + divname).html(html);
			$('.' + divname).hide();
			$('.' + divname).fadeIn(400);});
}

function setspecialuser(divname, statusn, id ){
	var modul = "SpecialUser";
	var act = "add";
		$.post("process-ogs.php", {id:id, act:act, modul: modul, statusn:statusn} , function(html) {
			$('.' + divname).html(html);
			$('.' + divname).hide();
			$('.' + divname).fadeIn(400);});
}

//buat searching tabel
function generatedTable(indx){
	var namtable = "#sample_" + indx ; 
	
	      var oTable = $(namtable).dataTable({
            "aoColumnDefs": [{
                "aTargets": [0]
            }],
            "oLanguage": {
                "sLengthMenu": "Show _MENU_ Rows",
                "sSearch": "",
                "oPaginate": {
                    "sPrevious": "",
                    "sNext": ""
                }
            },
            "aLengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "iDisplayLength": 10,
        });
        $(namtable + '_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
        // modify table search input
        $(namtable + '_wrapper .dataTables_length select').addClass("m-wrap small");
        // modify table per page dropdown
        $(namtable + '_wrapper .dataTables_length select').select2();
        // initialzie select2 dropdown
        $(namtable + '_column_toggler input[type="checkbox"]').change(function () {
            /* Get the DataTables object again - this is not a recreation, just a get of the object */
            var iCol = parseInt($(this).attr("data-column"));
            var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
            oTable.fnSetColumnVis(iCol, (bVis ? false : true));
        });
}

function AddTable10 (divname) {
	
	var modul = "SpecialUser";
	var act = "refreshS";
		$.post("process-ogs.php", {act: act , modul: modul} , function(html) {
			$('.' + divname).html(html);
			$('.' + divname).hide();
			$('.' + divname).fadeIn(400);});
}

 //---preparing data for "accident by year" graph (tambahan eka utk dasboard)
function FuncAjaxRequest(page , nameClass,modul,stringCommand,richtext1,richtext2){
	
	$.post(page, {modul:modul, stringCommand:stringCommand,richtext1:richtext1,richtext2:richtext2} , function(html) {
			$('.' + nameClass ).html(html);
			$("." + nameClass).hide();
			$("." + nameClass).fadeIn(400);
			});
	
}

function setpreviluser(divname, posisi, id ){
	var modul = "ManUser";
	var act = "changeprevil";
		$.post("process-ogs.php", {id:id, act:act, modul: modul, posisi:posisi} , function(html) {
			$('.' + divname).html(html);
			$('.' + divname).hide();
			$('.' + divname).fadeIn(400);});
}

 


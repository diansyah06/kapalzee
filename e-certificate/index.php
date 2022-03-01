<!DOCTYPE html>
<html lang="en">
<head>
	<title>BKI E-certificate | Digital Signature</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
	<style>
		.fakeimg {
			height: 200px;
			background: #aaa;
		}


	</style>
</head>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script>

<body>

	<div class="jumbotron text-center" style="margin-bottom:0">
		<h1>BKI e-Certificate</h1>
		<p>Digital Signature</p> 
	</div>



	<div class="container" style="margin-top:30px">
		<div class="row">
			<div class="col-sm-12"> 
				<form id="uploadbulks">
					<div class="form-group">
						<label for="departemen">Departemen</label>
						<select class="form-control departemen" id="departemen" name="departemen" required >
							<option ></option>
						</select>
					</div>

					<div class="form-group">
						<label for="departemen">Identification Number </label>
						<input class="form-control" type="number" placeholder="Register / apa aja" id="idnumber" name="idnumber" autocomplete="off" required >
					</div>

					<div class="form-group">
						<div id="informasi" name="informasi" > </div>
					</div>
					<div class="form-group">
						<label for="jenis">Jenis</label>
						<select class="form-control jenis" id="jenis" name="jenis" required>
							<option></option>
						</select>
						<input type="hidden" name="modul" value="upload">
					</div>


					<div class="form-group">
						<label for="exampleFormControlFile1">PDF Sertifikate</label>
						<input type="file" class="form-control-file upload" id="upload" name="upload" required>
					</div>

					<button type="submit" class="btn btn-primary" id="tblsubmit" name="tblsubmit" disabled >Submit</button>
				</form> 
					<div id="listuploadbulks" class="listuploadbulks">
			</div>

		</div>
	</div>


<script type="text/javascript" src="script.js"></script>
<script >
				//Program a custom submit function for the form
			$("form#uploadbulks").submit(function(event){
			 
			  //disable the default form submission
			  event.preventDefault();
			 
			  //grab all form data  
			  var formData = new FormData($(this)[0]);

			  $.ajax({
				url: 'api.php',
				type: 'POST',
				data: formData,
				async: false,
				cache: false,
				contentType: false,
				processData: false,
				success: function (html) {
			$('.listuploadbulks').html(html);
			$(".listuploadbulks").hide();
			$(".listuploadbulks").fadeIn(400);}
			  });
			 
			  return false;
			});	



</script>
</body>

</html>

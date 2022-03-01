function formhash(form, password) {
   // Create a new element input, this will be out hashed password field.
   var p = document.createElement("input");
   // Add the new element to our form.
   form.appendChild(p);
   p.name = "p";
   p.type = "hidden"
   p.value = hex_sha512(password.value);
   // Make sure the plaintext password doesn't get sent.
password.value = "rahasia123";
   
   
   //var elem = document.getElementById("password");
   //elem.value = hex_sha512(password.value);


   
   // Finally submit the form.
  /* form.submit();*/
}

function formhasha(form, password,password1) {
   // Create a new element input, this will be out hashed password field.
   var p = document.createElement("input");
   var p1 = document.createElement("input");
   // Add the new element to our form.
   form.appendChild(p);
   p.name = "p";
   p.type = "hidden"
   p.value = hex_sha512(password.value);
   
   form.appendChild(p1);
   p1.name = "p1";
   p1.type = "hidden"
   p1.value = hex_sha512(password1.value);
   // Make sure the plaintext password doesn't get sent.
	 password.value = "c";
	 password1.value = "c";
   

   
   // Finally submit the form.
  form.submit();

}

function formhashb(form, password) {
   // Create a new element input, this will be out hashed password field.
   var p = document.createElement("input");
   // Add the new element to our form.
   form.appendChild(p);
   p.name = "p";
   p.type = "hidden"
   p.value = hex_sha512(password.value);
   // Make sure the plaintext password doesn't get sent.
 	password.value = "";
   
   
   var elem = document.getElementById("password");
   elem.value = hex_sha512(password.value);
   
   // Finally submit the form.
form.submit();
}

function refreshCaptcha()
{
   $.post( "process_login.php", {modul:"refreshCaptcha"} , function(html) {
         $('.captcha-container').html(html);
         $('#img-captcha').attr("src", "captcha.jpg?"+new Date().getTime())
         $(".captcha-container").hide();
         $(".captcha-container").fadeIn(400);});
}

function formhashreg(form, password) {
   // Create a new element input, this will be out hashed password field.
   var p = document.createElement("input");
   // Add the new element to our form.
   form.appendChild(p);
   p.name = "p";
   p.type = "hidden"
   p.value = hex_sha512(password.value);
   // Make sure the plaintext password doesn't get sent.
password.value = "rahasia123";
   
   
   var elem = document.getElementById("password");
   elem.value = hex_sha512(password.value);


   
   // Finally submit the form.
  /* form.submit();*/
}

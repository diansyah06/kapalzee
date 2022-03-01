<?php
date_default_timezone_set('Asia/Jakarta');

require_once "class/captcha/CaptchaBuilder.php";
//use Gregwar\Captcha\CaptchaBuilder;

function sec_session_start() {
        $session_name = 'sec_session_id'; // Set a custom session name
        $secure = false; // Set to true if using https.
        $httponly = true; // This stops javascript being able to access the session id. 
 
        ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies. 
        $cookieParams = session_get_cookie_params(); // Gets current cookies params.
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
        session_name($session_name); // Sets the session name to the one set above.
        session_start(); // Start the php session
        session_regenerate_id(true); // regenerated the session, delete the old one. 
        return $output;    
}

function sec_session_startcapcay() {
        $session_name = 'sec_session_id'; // Set a custom session name
        $secure = false; // Set to true if using https.
        $httponly = true; // This stops javascript being able to access the session id. 
 
        ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies. 
        $cookieParams = session_get_cookie_params(); // Gets current cookies params.
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
        session_name($session_name); // Sets the session name to the one set above.
        session_start(); // Start the php session
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }

        if(empty($_SESSION['phrase']))
        {
          $_SESSION['phrase'] = generateCaptcha();
        }

        $phrase = $_SESSION['phrase'];
        $token = $_SESSION['token'];

        $output = array("phrase"=>$phrase, "token"=>$token);

        session_regenerate_id(true); // regenerated the session, delete the old one. 
        return $output;    
}



function login($email, $password, $mysqli) {
   // Using prepared Statements means that SQL injection is not possible. 
   if ($stmt = $mysqli->prepare("SELECT id_user, nick, sandi, garam ,nama ,previl FROM og_user WHERE email = ? or nick = ?  LIMIT 1")) { 
      $stmt->bind_param('ss', $email,$email); // Bind "$email" to parameter.
      $stmt->execute(); // Execute the prepared query.
      $stmt->store_result();
      $stmt->bind_result($user_id, $username, $db_password, $salt,$nama ,$previll); // get variables from result.
      $stmt->fetch();
      $password = hash('sha512', $password.$salt); // hash the password with the unique salt.
 
      if($stmt->num_rows == 1) { // If the user exists
         // We check if the account is locked from too many login attempts
         if(checkbrute($user_id, $mysqli) == true) { 
            // Account is locked
            // Send an email to user saying their account is locked
			  $mysqli->query("UPDATE og_user set locked='1' where id_user='$user_id'");
			  
            return false;
         } else {
         if($db_password == $password) { // Check if the password in the database matches the password the user submitted. 
            // Password is correct!
 
               //$ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user. 
               $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
 
               $user_id = preg_replace("/[^0-9]+/", "", $user_id); // XSS protection as we might print this value
               $_SESSION['user_id'] = $user_id; 
               $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username); // XSS protection as we might print this value
               $_SESSION['username'] = $username;
			   $_SESSION['salt'] = $previll;
			   $_SESSION['usernama'] = $nama;
               $_SESSION['login_string'] = hash('sha512', $password.$user_browser);
			   
			   //set cookies
			    $timeDellay=30*24*60*60;
				
				setcookie('user_id', $user_id, time() +  $timeDellay);
                setcookie('username', $username, time() +  $timeDellay);
				setcookie('salt', $previll, time() +  $timeDellay);
				setcookie('usernama', $nama, time() +  $timeDellay);
				setcookie('login_string',hash('sha512', $password.$user_browser), time() +  $timeDellay);
			   			   
               // Login successful.
               return true;    
         } else {
            // Password is not correct
            // We record this attempt in the database
            $now = time();
            $mysqli->query("INSERT INTO login_attempts (user_id, time) VALUES ('$user_id', '$now')");
            return false;
         }
      }
      } else {
         // No user exists. 
         return false;
      }
   }
}


function checkbrute($user_id, $mysqli) {
   // Get timestamp of current time
   $now = time();
   // All login attempts are counted from the past 2 hours. 
   $valid_attempts = $now - (2 * 60 * 60); 
 
   if ($stmt = $mysqli->prepare("SELECT time FROM login_attempts WHERE user_id = ? AND time > '$valid_attempts'")) { 
      $stmt->bind_param('i', $user_id); 
      // Execute the prepared query.
      $stmt->execute();
      $stmt->store_result();
      // If there has been more than 5 failed logins
      if($stmt->num_rows > 5) {
         return true;
      } else {
         return false;
      }
   }
}


function login_check($mysqli) {

   // Check if all session variables are set
   if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'], $_SESSION['token'])) {
     $user_id = $_SESSION['user_id'];
     $login_string = $_SESSION['login_string'];
     $username = $_SESSION['username'];
    // $ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user. 
     $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.

     if ($stmt = $mysqli->prepare("SELECT sandi FROM og_user WHERE id_user = ? LIMIT 1")) { 
        $stmt->bind_param('i', $user_id); // Bind "$user_id" to parameter.
        $stmt->execute(); // Execute the prepared query.
        $stmt->store_result();
	
 
								if($stmt->num_rows == 1) { // If the user exists
								   $stmt->bind_result($password); // get variables from result.
								   $stmt->fetch();
								   $login_check = hash('sha512', $password.$user_browser);
										   if($login_check == $login_string) {
											  // Logged In!!!!
											  return true;
										   } else {
											  // Not logged in
											  return false;
										   }
								} else {
									// Not logged in
									return false;
       								   }
     } else {
        // Not logged in
        return false;
     }//cek cookies
   } elseif (isset($_COOKIE['user_id'], $_COOKIE['username'], $_COOKIE['login_string'])){
     $user_id = $_COOKIE['user_id'];
     $login_string = $_COOKIE['login_string'];
     $username = $_COOKIE['username'];
	 $previll= $_COOKIE['salt'];
	 $nama= $_COOKIE['usernama'];
    // $ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user. 
     $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.

     if ($stmt = $mysqli->prepare("SELECT sandi FROM og_user WHERE id_user = ? LIMIT 1")) { 
        $stmt->bind_param('i', $user_id); // Bind "$user_id" to parameter.
        $stmt->execute(); // Execute the prepared query.
        $stmt->store_result();
	
 
								if($stmt->num_rows == 1) { // If the user exists
								   $stmt->bind_result($password); // get variables from result.
								   $stmt->fetch();
								   $login_check = hash('sha512', $password.$user_browser);
										   if($login_check == $login_string) {

											  //set session
 
									   $user_id = preg_replace("/[^0-9]+/", "", $user_id); // XSS protection as we might print this value
									   $_SESSION['user_id'] = $user_id; 
									   $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username); // XSS protection as we might print this value
									   $_SESSION['username'] = $username;
									   $_SESSION['salt'] = $previll;
									   $_SESSION['usernama'] = $nama;
									   $_SESSION['login_string'] = hash('sha512', $password.$user_browser);											  
											  
											  // Logged In!!!!
											   return true;
										   } else {
											  // Not logged in
											  return false;
										   }
								} else {
									// Not logged in
									return false;
       								   }
     } else {
        // Not logged in
        return false;
     }
   
   }else{
   
     // Not logged in
     return false;
   }
}

function ceksuper($mysqli) {

   // Check if all session variables are set
   if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
     $user_id = $_SESSION['user_id'];
     $login_string = $_SESSION['login_string'];
     $username = $_SESSION['username'];
     //$ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user. 
     $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.

     if ($stmt = $mysqli->prepare("SELECT previl  FROM og_user WHERE id_user = ? LIMIT 1")) { 
        $stmt->bind_param('i',  $user_id ); // Bind "$user_id" to parameter.
        $stmt->execute(); // Execute the prepared query.
        $stmt->store_result();
		$stmt->bind_result($db_previl); // get variables from result.
		$stmt->fetch();
 				 				if($db_previl == '9') { // Check if super user. 
								
								   return true;
								
								} else {
									// Not logged in
									return false;
       								   }
     } else {
        // Not logged in
        return false;
     }
   } else {
     // Not logged in
     return false;
   }
}


function cekprevil($mysqli) {

   // Check if all session variables are set
   if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
     $user_id = $_SESSION['user_id'];
     $login_string = $_SESSION['login_string'];
     $username = $_SESSION['username'];
    // $ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user. 
     $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.

     if ($stmt = $mysqli->prepare("SELECT previl  FROM og_user WHERE id_user = ? LIMIT 1")) { 
        $stmt->bind_param('i',  $user_id ); // Bind "$user_id" to parameter.
        $stmt->execute(); // Execute the prepared query.
        $stmt->store_result();
		$stmt->bind_result($db_previl); // get variables from result.
		$stmt->fetch();
 				 				
								
								   return $db_previl;
								
								
     } else {
        // Not logged in
        return false;
     }
   } else {
     // Not logged in
     return false;
   }
}

function ceknama($mysqli) {

   // Check if all session variables are set
   if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
     $user_id = $_SESSION['user_id'];
     $login_string = $_SESSION['login_string'];
     $username = $_SESSION['username'];
     //$ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user. 
     $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.

     if ($stmt = $mysqli->prepare("SELECT nama , previl  FROM og_user WHERE nick = ? LIMIT 1")) { 
        $stmt->bind_param('i',  $username  ); // Bind "$user_id" to parameter.
        $stmt->execute(); // Execute the prepared query.
        $stmt->store_result();
		$stmt->bind_result($db_user,$db_previl); // get variables from result.
		$stmt->fetch();
 				 				
								$datauser=array($db_user,$db_previl);
								
								   return $datauser;
								
								
     } else {
        // Not logged in
        return false;
     }
   } else {
     // Not logged in
     return false;
   }
}


function get_profil_pic($mysqli) {

   // Check if all session variables are set
   if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
     $user_id = $_SESSION['user_id'];
     $login_string = $_SESSION['login_string'];
     $username = $_SESSION['username'];
     //$ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user. 
     $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.

     if ($stmt = $mysqli->prepare("SELECT path  FROM rm_biodata WHERE id_user = ? LIMIT 1")) { 
        $stmt->bind_param('i',  $user_id ); // Bind "$user_id" to parameter.
        $stmt->execute(); // Execute the prepared query.
        $stmt->store_result();
		$stmt->bind_result($db_previl); // get variables from result.
		$stmt->fetch();
 				 				
								
								   return $db_previl;
								
								
     } else {
        // Not logged in
        return false;
     }
   } else {
     // Not logged in
     return false;
   }
}


function Cek_user_lock($email, $password, $mysqli) {
  // Using prepared Statements means that SQL injection is not possible. 
  if ($stmt = $mysqli->prepare("SELECT id_user, nick, sandi, garam ,nama ,previl FROM og_user WHERE email = ? or nick = ?  LIMIT 1")) { 
    $stmt->bind_param('ss', $email,$email); // Bind "$email" to parameter.
    $stmt->execute(); // Execute the prepared query.
    $stmt->store_result();
    $stmt->bind_result($user_id, $username, $db_password, $salt,$nama ,$previll); // get variables from result.
    $stmt->fetch();
    $password = hash('sha512', $password.$salt); // hash the password with the unique salt.

    if($stmt->num_rows == 1) { // If the user exists
      // We check if the account is locked from too many login attempts
      if(checkbrute($user_id, $mysqli) == true) { 
        // Account is locked
        // Send an email to user saying their account is locked
        $mysqli->query("UPDATE og_user set locked='1' where id_user='$user_id'");
        return true;
      }else {
        return false;
      }
    }
	} 
}

function login_comp($email, $password, $mysqli) {
   // Using prepared Statements means that SQL injection is not possible. 
   if ($stmt = $mysqli->prepare("SELECT id_user, nick, sandi, garam ,nama ,previl FROM og_user WHERE email = ? or nick = ?  LIMIT 1")) { 
      $stmt->bind_param('ss', $email,$email); // Bind "$email" to parameter.
      $stmt->execute(); // Execute the prepared query.
      $stmt->store_result();
      $stmt->bind_result($user_id, $username, $db_password, $salt,$nama ,$previll); // get variables from result.
      $stmt->fetch();
      $password = hash('sha512', $password.$salt); // hash the password with the unique salt.
 
      if($stmt->num_rows == 1) { // If the user exists
         // We check if the account is locked from too many login attempts

         if($db_password == $password) { // Check if the password in the database matches the password the user submitted. 
            // Password is correct!
               // Login successful.
               return true;    
         } else {
            // Password is not correct
            // We record this attempt in the database
            $now = time();
            $mysqli->query("INSERT INTO login_attempts (user_id, time) VALUES ('$user_id', '$now')");
            return false;
         }

      } else {
         // No user exists. 
         return false;
      }
   }
}

function login_comp2($email, $password, $mysqli) {
 $sda = $password;
   // Using prepared Statements means that SQL injection is not possible. 
   if ($stmt = $mysqli->prepare("SELECT nup,sandi,garam  FROM dc_user WHERE nup = ?  LIMIT 1")) { 
      $stmt->bind_param('s', $email); // Bind "$email" to parameter.
      $stmt->execute(); // Execute the prepared query.
      $stmt->store_result();
      $stmt->bind_result($user_id, $db_password, $salt); // get variables from result.
      $stmt->fetch();
      $password = hash('sha512', $password.$salt); // hash the password with the unique salt.

      if($stmt->num_rows == 1) { // If the user exists
         // We check if the account is locked from too many login attempts

         if($db_password == $password) { // Check if the password in the database matches the password the user submitted. 
            // Password is correct!
               // Login successful.
               return true;    
         } else {
		
		  //echo "sapi" . $sda ;
            // Password is not correct
            // We record this attempt in the database
            $now = time();
            $mysqli->query("INSERT INTO login_attempts (user_id, time) VALUES ('$user_id', '$now')");
            return false;
         }

      } else {
         // No user exists. 
         return false;
      }
   }
}
function ht($str){
	
	$strdummy=htmlentities($str, ENT_QUOTES);
	return $strdummy ;
}

function getInitials($name,$tambahan=1){
//split name using spaces
$words=explode(" ",$name);
$inits='';
//loop through array extracting initial letters
  if (count($words)> 1) 
  {
    foreach($words as $word){
    $inits.=strtoupper(substr($word,0,1));
    }
  }else
  {
    $inits.=strtoupper(substr($name,0,2));
    
  }
    if ($tambahan!=1) {
      return $inits . $tambahan ;  
    }else
    {
      return $inits;  
    }

}

function GetDatetimeADD($startdate,$numDays){
  
  $strparam_construct= "+" . $numDays . "days"; 
  
  $next = date('Y-m-d',strtotime($startdate . $strparam_construct));
  
  return $next;
}

function FormatDate($tanggal){

  $tanggal=date('d-M-Y H:i',strtotime($tanggal));


  return $tanggal;

}

function CreateNameRules($part,$vol,$name,$tipe,$tahun){
  $nama_vol_romawi=array("Vol.0","Vol.I","Vol.II","Vol.III","Vol.IV","Vol.V","Vol.VI","Vol.VII","Vol.VIII","Vol.IX","Vol.X","Vol.XI","Vol.XII","Vol.XIII","Vol.XIV","Vol.XV","Vol.XVI","Vol.XVII","Vol.XVIII","Vol.XIX","Vol.XX","Vol.XI","Vol.XXII","Vol.XXIII","Vol.XXIV","Vol.XXV","Vol.XXVI","Vol.XXVII","Vol.XXVIII","Vol.XXIX","Vol.XXX","Vol.XXXI","Vol.XXXII","Vol.XXXIII","Vol.XXXIV","Vol.XXXV","Vol.XXXVI","Vol.XXXVII","Vol.XXXVIII","Vol.XXXIX","Vol.XL","Vol.XLI","Vol.XLII","Vol.XLIII","Vol.XLIV","Vol.XLV");

  $nama_vol_alpabet=array("Vol.0","Vol.A","Vol.B","Vol.C","Vol.D","Vol.E","Vol.F","Vol.G","Vol.H","Vol.I","Vol.J","Vol.K","Vol.L","Vol.M","Vol.N","Vol.O","Vol.P","Vol.Q","Vol.R","Vol.S","Vol.T","Vol.U","Vol.V","Vol.W","Vol.X","Vol.Y","Vol.Z","Vol.AA","Vol.AB","Vol.AC","Vol.AD","Vol.AF","Vol.AG","Vol.AH","Vol.AI","Vol.AJ","Vol.AK","Vol.AL","Vol.AM","Vol.AN","Vol.AO","Vol.AP","Vol.AQ","Vol.AR","Vol.AS","Vol.AT");  


  if ($tipe==1) {
    $strVolume= $nama_vol_romawi[$vol];
  }elseif ($tipe==2) {
    $strVolume= 'Vol.' . $vol ;
  }elseif ($tipe==3) {
    $strVolume= $nama_vol_alpabet[$vol];
  }

  $strCodenameRules= "(Pt." . $part .','. $strVolume . "). $tahun " .  $name ;

  return $strCodenameRules ;

}

function Renametablenumber($strHtml,$NewNum,$oldNum){

  $str_idtable= "id='sample_$oldNum'" ;
  $str_idtable_repl= "id='sample_$NewNum'" ;

  $str_Gentable= "generatedTable($oldNum)" ;
  $str_Gentable_repl= "generatedTable($NewNum)" ;

  $strHtml=str_replace($str_idtable,$str_idtable_repl,$strHtml);

  $strHtml=str_replace($str_Gentable,$str_Gentable_repl,$strHtml);

  return $strHtml ;

}

function generateCaptcha()
{  
  // Creating the captcha instance and setting the phrase in the session to store
  // it for check when the form is submitted
  $captcha = new CaptchaBuilder;
 
  // Running the actual rendering of the captcha image
  $captcha->buildAgainstOCR();
  $captcha->save('captcha.jpg');

  return $captcha->getPhrase();
}

function checkActive($email, $mysqli) {
  // Using prepared Statements means that SQL injection is not possible. 
  if ($stmt = $mysqli->prepare("SELECT noactive FROM og_user WHERE email = ? or nick = ?  LIMIT 1")) { 
    $stmt->bind_param('ss', $email,$email); // Bind "$email" to parameter.
    $stmt->execute(); // Execute the prepared query.
    $stmt->store_result();
    $stmt->bind_result($noactive); // get variables from result.
    $stmt->fetch();

    if($stmt->num_rows == 1) { // If the user exists
      // We check if the account is locked from too many login attempts
      if($noactive == 0) { 
        // Account is active
        return true;
      }else {
        return false;
      }
    }
  } 
}

function resizeImage($sourceImage, $targetImage, $maxWidth, $maxHeight, $quality = 80)
{
    // Obtain image from given source file.
    if (!$image = @imagecreatefromjpeg($sourceImage))
    {
        return false;
    }

    // Get dimensions of source image.
    list($origWidth, $origHeight) = getimagesize($sourceImage);

    if ($maxWidth == 0)
    {
        $maxWidth  = $origWidth;
    }

    if ($maxHeight == 0)
    {
        $maxHeight = $origHeight;
    }

    // Calculate ratio of desired maximum sizes and original sizes.
    $widthRatio = $maxWidth / $origWidth;
    $heightRatio = $maxHeight / $origHeight;

    // Ratio used for calculating new image dimensions.
    $ratio = min($widthRatio, $heightRatio);

    // Calculate new image dimensions.
    $newWidth  = (int)$origWidth  * $ratio;
    $newHeight = (int)$origHeight * $ratio;

    // Create final image with new dimensions.
    $newImage = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
    imagejpeg($newImage, $targetImage, $quality);

    // Free up the memory.
    imagedestroy($image);
    imagedestroy($newImage);

    return true;
}

/**
 * Example
 * resizeImage('image.jpg', 'resized.jpg', 200, 200);
 */


/*
    Function to prepare data (in JSON form) and container for chart
*/
 function pieDataPrepare($header, $data, $divId, $colWidth)
 {
    $datArray = array($header);
    foreach($data as $key=>$value)
    {
      array_push($datArray, array($key, $value));
    }

    $datJs = json_encode($datArray);

    $html = "
              <div class='col-md-$colWidth'>
                <div id='$divId'></div>
              </div>
    ";

    return array("id"=>$divId, "data"=>$datJs, "container"=>$html);
 }

//Function to prepare data for bar data
//accepts variable number of arguments
//format : barData(header, div, data, ....)

function barDataPrepare()
{
  $num = func_num_args();
  $args = func_get_args();

  $header = $args[0];
  $divId = $args[1];
  $input = array();

  for($i=2; $i<$num; $i++)
  {
    $input[] = $args[$i];
  }

  $datArray = array($header);
  $boundary = getBoundary($input);
  $monthList = getMonthList($boundary);
  
  /*echo "<pre>";
  print_r($input);
  print_r($boundary);
  print_r($monthList);
  echo "</pre>";*/

  //arranging data array with master array as reference
  foreach($monthList as $m)
  {
    $in = array();
    $n = 0;
    foreach($input as $dat)
    { 
      if(!empty($dat))
      { 
        foreach($dat as $d)
        {
          if(!empty($d))
          {
            $dateStr = $d["month"]." ".$d["year"];
            if(strtotime($dateStr) == strtotime($m))
            {
              $in[$n] = intval($d["jml"]);
              break;
            }else
            {
              $in[$n] = 0;
            }
          }else
          {
            $in[$n] = 0;
          }
        }
      }
      else
      {
        $in[$n] = 0;
      }
      $n++;
    }

    $merge = array_merge(array(date("M y", strtotime($m))), $in);
    array_push($datArray, $merge);
  }

  $datJs = json_encode($datArray);
  
  $html = "<div id='$divId'></div>";

  return array("id"=>$divId, "data"=>$datJs, "container"=>$html);
}

function getBoundary($args)
{
  $num = count($args);
  $min = " ";
  $startM = $args[0][0]["month"];
  $startY = $args[0][0]["year"];
  
  $n = count($args[0])-1;
  $max = "January 1970";
  $endM = $args[0][$n]["month"];
  $endY = $args[0][$n]["year"];

  for($i=0; $i<$num; $i++)
  {
    if(!empty($args[$i]))
    {
      $start = $args[$i][0]["month"]." ".$args[$i][0]["year"];
      $n = count($args[$i])-1;
      $end = $args[$i][$n]["month"]." ".$args[$i][$n]["year"];

      if(strtotime($start) < strtotime($min))
      {
        $min = $start;
        $startM = $args[$i][0]["month"];
        $startY = $args[$i][0]["year"];
      }

      if(strtotime($end) > strtotime($max))
      {
        $max = $end;
        $endM = $args[$i][$n]["month"];
        $endY = $args[$i][$n]["year"];
      }
    }
  }

  return array("lower"=>array("month"=>$startM, "year"=>$startY), "upper"=>array("month"=>$endM, "year"=>$endY));
}

function getMonthList($boundary)
{
  $lower = $boundary['lower']['month']." ".$boundary['lower']['year'];
  if(!empty($boundary['upper']['month']) || !empty($boundary['upper']['year']))
  {
    $upper = $boundary['upper']['month']." ".$boundary['upper']['year'];
  }else
  {
    return array($lower);
  }

  $monthList = array();
  $month = strtotime($lower);
  $end = strtotime($upper);
  while($month <= $end)
  {
       $monthList[] = date('F Y', $month);
       $month = strtotime("+1 month", $month);
  }

  return $monthList;
}

/*function getMonthList($boundary)
{
  $monthArray = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
  $lower = $boundary['lower']['month']." ".$boundary['lower']['year'];
  if(!empty($boundary['upper']['month']) || !empty($boundary['upper']['year']))
  {
    $upper = $boundary['upper']['month']." ".$boundary['upper']['year'];
  }else
  {
    return array($lower);
  }
  $date1 = new DateTime($lower);
  $date2 = new DateTime($upper);
  $interval = $date1->diff($date2);

  $start = $month = strtotime('2009-02-01');
  $end = strtotime('2011-01-01');
  while($month <= $end)
  {
       echo date('F Y', $month), PHP_EOL;
       $month = strtotime("+1 month", $month);
  }
  
  //preparing values for master array
  $yearArr = range($boundary["lower"]["year"], $boundary["upper"]["year"]);
  $yearCount = count($yearArr) - 1;
  $counter = 0;
  $monthList = array();
  $begin = array_search($boundary["lower"]["month"], $monthArray);

  //generating master array
  for($i=0; $i<=$yearCount; $i++)
  {
    for($j=$begin; $j<=count($monthArray)-1; $j++)
    {
      $monthList[] = "$monthArray[$j] $yearArr[$i]";
      if($counter == $range)
      {
        break;
      }
      $counter++;
    }
    $begin = 0;
  }

  return $monthList;
}*/

 
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getWorkingDays($startDate,$endDate,$holidays){
    // do strtotime calculations just once
    $endDate = strtotime($endDate);
    $startDate = strtotime($startDate);


    //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
    //We add one to inlude both dates in the interval.
    $days = ($endDate - $startDate) / 86400 + 1;

    $no_full_weeks = floor($days / 7);
    $no_remaining_days = fmod($days, 7);

    //It will return 1 if it's Monday,.. ,7 for Sunday
    $the_first_day_of_week = date("N", $startDate);
    $the_last_day_of_week = date("N", $endDate);

    //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
    //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
    if ($the_first_day_of_week <= $the_last_day_of_week) {
        if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
        if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
    }
    else {
        // (edit by Tokes to fix an edge case where the start day was a Sunday
        // and the end day was NOT a Saturday)

        // the day of the week for start is later than the day of the week for end
        if ($the_first_day_of_week == 7) {
            // if the start date is a Sunday, then we definitely subtract 1 day
            $no_remaining_days--;

            if ($the_last_day_of_week == 6) {
                // if the end date is a Saturday, then we subtract another day
                $no_remaining_days--;
            }
        }
        else {
            // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
            // so we skip an entire weekend and subtract 2 days
            $no_remaining_days -= 2;
        }
    }

    //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
//---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
   $workingDays = $no_full_weeks * 5;
    if ($no_remaining_days > 0 )
    {
      $workingDays += $no_remaining_days;
    }

    //We subtract the holidays
    foreach($holidays as $holiday){
        $time_stamp=strtotime($holiday);
        //If the holiday doesn't fall in weekend
        if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7)
            $workingDays--;
    }

    return $workingDays;
}




?>
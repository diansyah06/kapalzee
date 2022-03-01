<?php 
  include("sis32/db_connect.php");
  include 'functions.php';
  require 'class/user.php';
  require 'class/object.php';
  require 'sis32/data_pdo.php';

  sec_session_start(); // Our custom secure way of starting a php session. 
  
//check module to determine the action that will be taken
$module = htmlspecialchars(strip_tags($_POST['modul']), ENT_QUOTES, 'UTF-8');

switch($module)
{
  case "login":
    $Users = new Users($db);
    loginProcess($mysqli, $Users);
    break;
  case "refreshCaptcha":
    refreshCaptcha();
    break;
  case "register":
    $Users = new Users($db);
    $object = new obj($db);
    createUser($Users, $object);
    break;
  case "lock-screen":
    loginfromLockScreen($mysqli);
    break;
  default:
    echo "No such module: $module";
    break;
}

//function to handle login mechanism
//made by rizky
//Update:
//1. 13/03/2019 --> initial (rizky)
function loginProcess($mysqli, $Users)
{
  //check if CSRF token is present
  if(isset($_POST['token']))
  {
    //check if posted token is the same with token saved in session
    if(hash_equals($_SESSION['token'], $_POST['token']))
    {
      //check if username and password are present
      if(isset($_POST['email'], $_POST['p'])) { 
      //check if captcha is inputted correctly
        $email = $_POST['email'];
        $password = $_POST['p']; // The hashed password.
        //cek account

        if(checkActive($email, $mysqli))
        {
          if(Cek_user_lock($email, $password, $mysqli) == false) { 
            // Account is locked
            if(login($email, $password, $mysqli) == true) {
              if(strtolower($_POST['captcha']) == $_SESSION['phrase'])
              {  
                // Login success
                $db = new PDO('mysql:host=' . "localhost" . ';dbname=' . "ogs", "serverOfshore", "3twhvjttbm");
                 
                #Setting the error mode of our db object, which is very important for debugging.
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $Users = new Users($db);

                $previlage = $Users->Get_previlagebynick($email);

                if ($previlage < 4 ){
                  header('Location: ./modern/panel.php?module=home');
                }else{
                  header('Location: ./modern/panel.php?module=home');
                }
              }else
              {
                //captcha is not inputted correctly
                header('Location: ./index.php?error=3');
              }      
            } else {
              // Login failed
              header('Location: ./index.php?error=1');
            }
          }else{
            header('Location: ./index.php?error=2');
          } 
        }else
        {
          header('Location: ./index.php?error=4');
        }
         
      }else {
         // The correct POST variables were not sent to this page.
         header('Location: ./index.php');
      }
    }else
    {
      //token mismatch
      //echo "Authentication failed. Token mismatch";
      header('Location: ./index.php');
    }
  }else
  {
    //valid CRSF Token cannot be found
    //echo "Authentication failed. Token is missing";
    header('Location: ./index.php');
  }
}

//function to refresh captcha
//made by rizky
//Update:
//1. 11/03/2019 --> initial (rizky)
function refreshCaptcha()
{
  // Creating the captcha instance 
  require_once "class/captcha/CaptchaBuilder.php";
  $captcha = new CaptchaBuilder;

  // Running the actual rendering of the captcha image
  $captcha->buildAgainstOCR();
  $captcha->save('captcha.jpg');

  $_SESSION['phrase'] = $captcha->getPhrase();
  echo '<img id="img-captcha"></img>';
}


function createUser($User, $object)
{
  // The hashed password from the form
  $nup = $_POST['nup'];
  $phone = $_POST['phone'];
  $nick = $_POST['username'];
  $pass = $_POST['p'];
  $fake = $_POST['password'];
  $create = date("Y-m-d");

  $userDat = $User->get_users_nup($nup);

  if(empty($userDat))
  {
    //----password creation----
    // Create a random salt
    $salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
    // Create salted password (Careful not to over season)
    $pass = hash('sha512', $pass.$salt);
    
    //----get data from ogs database----
    $response = file_get_contents("http://ds.bki.co.id:7777/interface/register/reg.php?key=bA3S2iZ4RqgEiP3AYgt&nup=$nup");
   
    $arr = json_decode($response, TRUE);

    if($arr['code']=="Succeed")
    {
      $name = $arr['data']['name'];
      $div = $arr['data']['division'];
      $email = $arr['data']['email'];
      $position = $arr['data']['position'];  
    }else
    {
      $target = 'Location: ./index.php?note=fail';
    }
    
    if(isAllowed($position))
    {
      // Add your insert to database script here. 
      $User->insertUser($nick, $email, $pass, $salt, $name, $nup, $div, $phone, $create);
      $userid = $User->lastInsertId();
      $User->insertBio($userid);
      
      // Make activation key and send to email
      $activation = $User->generateRandomString();
      $User-> storeKey($nup, $activation);

      $params = array(
            "name" => $name,
            "address" => $email,
            "message" => "Thank you for registering account for our service. To activate your account, please click this link ( <a href= 'https://bahtera-zee.bki.co.id:8888/activation.php?key=$activation'>https://bahtera-zee.bki.co.id:8888/activation.php?key=$activation</a> )",
            "subject" => "Dewaruci PM Activation",
            "sender" => "Dewaruci PM",
            "key"=> "bA3S2iZ4RqgEiP3AYgt"
          );

      $response = $object->httpPost("http://ds.bki.co.id:7777/interface/email/mailcentral.php",$params);
      $respArr = json_decode($response, TRUE);

      if($respArr['code']=="success")
      {
        $target = 'Location: ./index.php?note=succeed';
      }else
      {
        $target = 'Location: ./index.php?note=fail&resp=$response';
      }
    }else
    {
      $target = 'Location: ./index.php?note=notallowed';
    }
  }else
  {
    $target = 'Location: ./index.php?note=exists';
  }

  header($target);     
}



function loginfromLockScreen($mysqli)
{
  //check if CSRF token is present

    //check if posted token is the same with token saved in session
      //check if username and password are present
      if(isset($_POST['email'], $_POST['p'])) { 
      //check if captcha is inputted correctly
        $email = $_POST['email'];
        $password = $_POST['p']; // The hashed password.
        //cek account

          if(Cek_user_lock($email, $password, $mysqli) == false) { 
            // Account is locked
            if(login($email, $password, $mysqli) == true) {

                // Login success
                $db = new PDO('mysql:host=' . "localhost" . ';dbname=' . "ogs", "serverOfshore", "3twhvjttbm");
                 
                #Setting the error mode of our db object, which is very important for debugging.
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                header('Location: ./modern/panel.php?module=home');
     
            } else {
              // Login failed
              header('Location: ./index.php?error=1');
            }
          }else{
            header('Location: ./index.php?error=2');
          } 

         
      }else {
         // The correct POST variables were not sent to this page.
         header('Location: ./index.php');
      }


}


function isAllowed($position)
{
  $positionArr = array(
                        "SURVEYOR",
                        "PENGKAJI",
                        "PENELITI",
                        "MANAGER",
                        "KEPALA"
                        );
  foreach($positionArr as $pos)
  {
    if(strpos($position, $pos) !== false)
    {
      $result = true;
      break;
    }else
    {
      $result = false;
    }
  }

  return $result;
}

?>

<?php
// Page ini digunakan untuk convert langsung dari html di url 
// menjadi Pdf dan disimpan langsung ke-server ftp










function ChecCOnnectionFrom(){

    $IpwhitelistArray= Array("localhost","127.0.0.1");
    $ip= $_SERVER['REMOTE_ADDR'];
    
    if (in_array($ip, $IpwhitelistArray)){
         return  true ;
    }else{
        return false;
    }
}

function StoreFileFTP(){
    // connect and login to FTP server
    $ftp_server = "ftp.example.com";
    $ftp_username = "";
    $ftp_userpass = "" ;

    $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
    $login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);

    $file = "localfile.txt";

    // upload file
    if (ftp_put($ftp_conn, "serverfile.txt", $file, FTP_ASCII))
    {
    echo "Successfully uploaded $file.";
    }
    else
    {
    echo "Error uploading $file.";
    }

    // close connection
    ftp_close($ftp_conn);
}


header("Content-Type: application/json; charset=UTF-8");
$obj = json_decode($_GET["x"], false);

$conn = new mysqli("myServer", "myUser", "myPassword", "Northwind");
$stmt = $conn->prepare("SELECT name FROM customers LIMIT ?");
$stmt->bind_param("s", $obj->limit);
$stmt->execute();
$result = $stmt->get_result();
$outp = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($outp);



?>
<?php
include("../sis32/db_connect.php");
include "../functions.php";
include "../class/init3.php";
include "../modern.php" ;
date_default_timezone_set('Asia/Jakarta');
$C_client = new client();
$today = date("Y-m-d");

if(isset($_GET['projid']))
{
	$projId = $_GET['projid'];	
}else
{
	$projId = array();
	$allProject = $obj->get_wokspaceUndone(0);
	foreach($allProject as $all)
	{
		array_push($projId, $all['object_id']);
	}
}

$project = 0;
if(!empty($projId))
{
    if(is_array($projId))
    {
        foreach($projId as $proj)
        {
            createMail($proj, $today, $obj, $kontrak, $drawing);
            //$date = "2020-02-19";
            //createMail($proj, $date, $obj, $kontrak, $drawing);
        }
        $tanggal=date("Y-m-d H:i:s");         
    }else
    {
        createMail($projId, $today, $obj, $kontrak, $drawing);
        //$date = "2020-02-19";
        //createMail($projId, $date, $obj, $kontrak, $drawing);
        $tanggal=date("Y-m-d H:i:s"); 
    }
}

//------------------------function to construct mail-----------------------------------

function createMail($projId, $sendDate, $obj, $kontrak, $drawing)
{
    $statu_s = array(
        "Open",
        "Closed",
        "Info"
    );
    $strTypecomment= array('To be dealt with', 'Accepted', 'To be re-submitted', 'Note', 'Recommendation');

    $tipe_approval = $drawing->GetTipeapprovalDrawing();

    foreach($tipe_approval as $tapp)
    {
        // simbol gambar
        $simb_gam[$tapp['id_status']] = $tapp['desck'];
    }

    //----------------get contract number--------------------------
    $con = $obj->get_wokspaceByid($projId);
    foreach($con as $c)
    {
        $connum = $c['id_kontrak'];
        $object = $c['project'];
        $applicant = $c['submited'];
    }

    $objectAlt = implode("+",explode(" ", $object));
    //echo $mailBody;

    //get comments
    $val = 0;
    for($i=1; $i<=7; $i++)
    {
        //----------------get booked mail number-----------------------
        $letter = $kontrak->getMailNumber($projId, $sendDate, $i);
        if($letter['exists'])
        {
            $num = $letter['data'];
            $year = date("y");
            //$fullNum = "B.4949/SV.001/PRB/KI-19";
            //$fullNum = "B.$num/SV.001/PRB/KI-$year";
            if($i == 5)
            {
                $fullNum = "B.$num/SV.001/STA/KI-$year";
                $divCode = "STA";
            }else
            {
                $fullNum = "B.$num/SV.001/PRB/KI-$year";
                $divCode = "PRB";
            }

            //----------------construct mail-------------------------------
            //mail body
            $arrContextOptions=array(
                            "ssl"=>array(
                                "verify_peer"=>false,
                                "verify_peer_name"=>false,
                            ),
                        ); 
            $mailBody = file_get_contents("https://armada.bki.co.id/modul/mod_drawing/cetaksurat_zee.php?noapl=$connum&no_surat=$fullNum&no=$num&nmobj=$objectAlt&kodediv=$divCode", false, stream_context_create($arrContextOptions));    
        }
        
        $comments = $drawing->allDrawingAndCommentGrouped($projId, $i, $sendDate);

        /*echo "<pre>";
        print_r($comments);
        echo "</pre>";*/

        if(!empty($comments))
        {
            $n=1;
            $attBody = "";
            foreach($comments as $k=>$val)
            {
                $commentBody = "<tr>
                                    <td colspan='10'>
                                        <ol>";
                foreach($val as $v)
                {
                    $statusDraw = $simb_gam[$v['drawingstatus']];
                    $statusComm = $statu_s[$v['commentstatus']];
                    $typeComm = $strTypecomment[$v['commentcategory']];
                    $commentTitle = "<tr>
                                    <td>$n</td>
                                    <td>$v[revisi]</td>
                                    <td>$v[judul]</td>
                                    <td>$k</td>
                                    <td>$statusDraw</td>
                                    <td>$sendDate</td>
                                </tr>";
                    $commentBody = $commentBody."
                                                    <li>
                                                        <table>
                                                        <tr>
                                                            <td>Comment: <b>[$v[nomer_comment]]</b></td>
                                                            <td>Type: <b>$typeComm</b></td>
                                                            <td>Status: <b>$statusComm</b></td>
                                                        </tr>
                                                        </table>
                                                        $v[comment]

                                                    </li>
                                                ";
                }
                $attBody = $attBody.$commentTitle.$commentBody."</ol></td></tr>";
                $n++;
            }


            $attHead = "<table width='800px' align='center' style='border-color:black;border-bottom:solid;border-top:solid;border-right:solid;border-left:solid;'>
                <tr>
                    <td>
                        <table width='99.5%'>
                            <tr>

                                <td align='center'>
                                    <b>LIST OF DRAWING STATUS<br/>- PLAN APPROVAL -<br/>
                                                                    PT. BIRO KLASIFIKASI INDONESIA (PERSERO)</b>

                                </td>

                            </tr>

                        </table>
                        <br/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <!--<HR color='black' SIZE='10' align='center' NOSHADE>-->
                        <table width='99.5%'>
                            <tr>
                                <td>No. Aplication</td>
                                <td>:</td>
                                <td>$connum</td>
                                <td></td>
                                <td>$fullNum</td>
                            </tr>
                            <tr>
                                <td>No. Register</td>
                                <td>:</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Object Name</td>
                                <td>:</td>
                                <td>$object</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Owner</td>
                                <td>:</td>
                                <td>$applicant </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Ship Type</td>
                                <td>:</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br/>
                        <b>Comment type * :</b>
                        <br/>
                        <p style='margin-bottom: -5px; font-size: 10px;'> Note : Design document with recommendations that are as information. </p>
                        <p style='margin-bottom: -5px; font-size: 10px;'>Accepted : Design document without recommendation. </p>
                        <p style='margin-bottom: -5px; font-size: 10px;'>To be dealt with : Design document with recommendations that needs explanation enclosing with evidence without having to re-submitted design document revision. </p>
                        <p style='margin-bottom: -5px; font-size: 10px;'>To be re-submitted : Design document with recommendations and need to revision.</p>
                        <br/>

                        <table width='100%' border='1' style='border-collapse: collapse'>

                            <thead>
                                <tr style='background-color: #0099cc;'>
                                    <th>No.</th>
                                    <th>No.
                                        <br/> Rev</th>
                                    <th>Title</th>
                                    <th>No.
                                        <br/>Drawing</th>
                                    <th>Drawing Status</th>
                                    <th>Approval Date</th>
                                </tr>
                            </thead>
                            <tbody>";

            $attFoot=                    
            "
                            </tbody>
                        </table>
                        <br/>
                    </td>
                </tr>
            </table>";

            $attachment = $attHead.$attBody.$attFoot;
            $fullMail = $mailBody.$attachment;
            $mailStr = base64_encode($fullMail);
            $result = $kontrak->insertOrUpdateMail($projId, $i, $mailStr, $sendDate, $num, $fullNum);

            echo $result;
            //echo $fullMail;

            //test send email
            /*$formEmail = "zee@bki.co.id";
            $nameSender = "Bahtera Zee";
            $addresses = array(array('email'=>"rizky.pan@bki.co.id", 'nama'=>"rizky"));
            $subject = "Drawing has been reviewed";
            $alternative = "Your mail client cannot display HTML. Please follow this link(by copy and pasting it to your browser) to read your email";

            $mail = $obj->htmlEmail($formEmail, $nameSender, $addresses, $fullMail, $subject, $alternative);
            echo $mail;*/        
        }
        
    }
    
}
?>

<style type="text/css">
            /* Customizable font and colors */
            html {
                background: #000000;
            }
            #clocktext {
                font-family: sans-serif;
                font-weight: bold;
                color: #FFFFFF;
            }
        </style>
        </style>
    <body style="display:table; width:100%; height:100%; margin:0; padding:0">
        <div style="display:table-cell; width:100%; height:100%; text-align:center; vertical-align:middle">
            <span id="clocktext" style="font-size:24pt; font-kerning:none"></span>
            <br>
            <span style="color:#FFFFFF">Last Synch : <?php echo $tanggal ?></span>
        </div>
        <script type="text/javascript">
            "use strict";
            
            var textElem = document.getElementById("clocktext");
            var textNode = document.createTextNode("");
            textElem.appendChild(textNode);
            var curFontSize = 24;  // Do not change
            
            function updateClock() {
                var d = new Date();
                var s = "";
                s += (10 > d.getHours  () ? "0" : "") + d.getHours  () + ":";
                s += (10 > d.getMinutes() ? "0" : "") + d.getMinutes() + ":";
                s += (10 > d.getSeconds() ? "0" : "") + d.getSeconds();
                textNode.data = s;
                synch(s);
                setTimeout(updateClock, 1000 );
            }
            
            function updateTextSize() {
                var targetWidth = 0.9;  // Proportion of full screen width
                for (var i = 0; 3 > i; i++) {  // Iterate for better better convergence
                    var newFontSize = textElem.parentNode.offsetWidth * targetWidth / textElem.offsetWidth * curFontSize;
                    textElem.style.fontSize = newFontSize.toFixed(3) + "pt";
                    curFontSize = newFontSize;
                }
            }
            
            function synch(strclock){
                
                if ((strclock=="06:00:00")||(strclock=="09:00:00")||(strclock=="12:15:00")||(strclock=="14:00:00")||(strclock=="15:30:00")||(strclock=="17:00:00")||(strclock=="20:00:00")||(strclock=="23:00:00")) {
                    location.reload(); 
                }
                
            } 
            
            updateClock();
            updateTextSize();
            window.addEventListener("resize", updateTextSize);
        </script>
 <?php
include("../sis32/db_connect.php");
include "../functions.php";
sec_session_start();
//get var from post
include "../class/init3.php";
include "../modern.php";
date_default_timezone_set('Asia/Jakarta');


cekLoginStatus($mysqli);

//get profile user login
$user_id       = $_SESSION['user_id'];
$nama_user     = $Users->get_users_with_title($user_id); //nama 
$biodata_users = $Users->getUser_biodata($user_id);
//$salting       = $_SESSION['salt'];

$salting = $Users->get_previl($_SESSION['user_id']);

foreach ($biodata_users as $biodata_user) {
    $displayPicture = "../" . $biodata_user['path']; //wajah
    $jabatanUser    = $biodata_user['jabatan'];
    $emailUser      = $biodata_user['email'];
    $hpUer          = $biodata_user['handphone'];
}
//getalluser
$listUsers = $Users->get_users();

$alluserArray = array(); // store alluseronarray
foreach ($listUsers as $listUser) {
    $idusernya                = $listUser['id_user'];
    $alluserArray[$idusernya] = $listUser['nama'];
}
$typebidangArray = array(
    " ",
    "Structure",
    "Stability",
    "Machinery",
    "Offshore",
    "Other"
);

//array kegiatan
$namakegiatan = array(
    "uncategory",
    "Training",
    "Schooling",
    "Sidang",
    "Meeting",
    "Committee",
    "Attendance",
    "Presentation",
    "Project or Research",
    "launcing",
    "Other"
);

//curency
$currencyarray = array(
    "error",
    "IDR",
    "USD",
    "SGD",
    "GDB",
    "EUR"
);

$typeStatus = array(
    "Preparation",
    "Discussion",
    "Reject",
    "Approve"
);

$modul = $_POST['modul'];

switch ($modul) {
    case "training":
        training($kpi, $user_id, $alluserArray, $namakegiatan, $Activity);
        break;
    case "trainingInlineedit":
        inlineUpdateTraining($kpi, $user_id, $alluserArray);
        break;
    case "cost":
        cost($kpi, $user_id, $currencyarray);
        break;
    case "task":
        task($Activity, $user_id);
        break;
    case "galery":
        galery($Activity, $user_id);
        break;
    case "document":
        document($Activity, $user_id);
        break;
    case "rules_pub":
        rules_pub($rms, $user_id, $salting, $mysqli);
        break;
    case "documentproj":
        document_obj($obj, $user_id);
        break;
    case "createproject":
        project_obj($obj, $user_id, $kontrak, $salting, $alluserArray);
        break;
    case "projectMan_obj":
        projectMan_obj($obj, $user_id, $kontrak, $salting, $alluserArray,$Users);
        break;
    case "notes_obj":
        notes_obj($obj, $user_id);
        break;
    case "notes_objPagedetail":
        notes_objPagedetail($obj, $user_id);
        break;
    case "costobj":
        costobj($kpi, $user_id);
        break;
    case "commentobj":
        commentobj($obj, $user_id);
        break;
    case "updatefile":
        updatefile($obj, $user_id);
        break;
    case "updateSubscriber":
        updateSubscriber($obj, $user_id);
        break;
    case "movetotrash":
        Trash_obj($obj, $user_id);
        break;
    case "taskobj":
        taskobj($obj, $user_id, $alluserArray);
        break;
    case "activityProje":
        activyProj($obj, $user_id, $alluserArray);
        break;
    case "notification":
        notification($obj, $user_id, $alluserArray);
        break;
    case "message":
        message($obj, $user_id, $alluserArray, $Activity);
        break;
    case "lain":
        break;
    case "makearchip":
        makearchip($obj, $user_id, $alluserArray);
        break;
    case "meeting":
        meeting($obj, $user_id, $alluserArray, $rms, $drawing);
        break;
    case "planPeriode":
        planPeriode($kpi, $user_id, $alluserArray);
        break;
    case "inserbudguet":
        inserbudguet($kpi, $user_id, $alluserArray, $namakegiatan, $Activity);
        break;
    case "inserbudguetInvest":
        inserbudguetInvest($kpi, $user_id, $alluserArray, $namakegiatan, $Activity);
        break;
    case "GetPeoplePlan":
        GetPeoplePlan($kpi, $user_id, $alluserArray, $namakegiatan);
        break;
    case "researchbank":
        researchbank($kpi, $user_id, $alluserArray, $namakegiatan, $typebidangArray);
        break;
    case "planresearch":
        planresearch($kpi, $user_id, $alluserArray, $namakegiatan, $typebidangArray);
        break;
    case "resultreserach":
        resultreserach($kpi, $user_id, $alluserArray, $namakegiatan, $typebidangArray);
        break;
    case "proposalresearch":
        proposalresearch($kpi, $user_id, $alluserArray, $namakegiatan, $typebidangArray, $typeStatus, $salting, $Activity, $obj);
        break;
    case "propdiscus":
        propdiscus($kpi, $user_id, $alluserArray, $namakegiatan, $typebidangArray, $salting);
        break;
    case "updateBio":
        updateBio($Users);
        break;
    case "MarknotifReadAll":
        MarknotifReadAll($user_id,$obj);
        break;      
        
        
}


if (isSet($_POST['activity'])) {
    
    $lastmsg   = $_POST['activity'];
    $lastmsgs  = explode("#", $lastmsg);
    $lastmsg   = $lastmsgs[0];
    $projectID = $lastmsgs[1];
    $timelines = $obj->getActivity($lastmsg, 100, $projectID);
    
    $emboh = $obj->getNumActivity($lastmsg, 100); //salah mestine ditambahi kondisi project apa
    
    // cek bila sudah habiss
    if (intval($emboh) > 0) {
        foreach ($timelines as $timeline) {
            
            //kegiatan
            if ($timeline['trashed_on'] != "0000-00-00 00:00:00") {
                
                $stringkegiatan = " has send to trash ";
                
            } elseif ($timeline['updated_on'] != $timeline['created_on']) {
                
                $stringkegiatan = " has edited the ";
                
            } else {
                
                $stringkegiatan = " has added the ";
                
            }
            
            //object
            
            if ($timeline['object_type_id'] == 14) {
                
                $lisindukComents = $obj->getObjtcommenbyid($timeline['id']);
                
                foreach ($lisindukComents as $lisindukComent) {
                    $namakegiatan = Maxcaracter($lisindukComent['name']);
                    $objekdanLink = "href='panel.php?module=projectDetail&id=$lisindukComent[rel_object_id]'><strong> $namakegiatan</strong>";
                    
                }
                
                
                
            } else {
                $namakegiatan = Maxcaracter($timeline['name']);
                $objekdanLink = "href='panel.php?module=projectDetail&id=$timeline[id]'><strong> $namakegiatan</strong>";
            }
            

            
            $sesuaiformat = $Activity->format_tanggal($timeline['updated_on']);
            
            echo "<div title='$timeline[nick]' class='friends_area' ><img src='../$timeline[path]' height='65' style='float:left;' alt=''> 
                    <label style='float:left' class='name'>
                            <b>$timeline[nick] </b>
                            <br> 
                                <span class='aktifitas'>$timeline[jeneng] $stringkegiatan $timeline[nama] </span>
                                <br> 
                                <span style='padding: 4px 10 30px 18px; width:30' class='db-ico ico-$timeline[handler_class]'> </span> 
                                <a class='terusan-$timeline[handler_class]' style='font-weight:bold;' $objekdanLink </a>
                                </br>
                                <span class='tanggalfeed'>$sesuaiformat </span>
                            </br>
                    </label>
                </div>";
            
            $last_id = $timeline['updated_on'];
            
        }
        


        echo "</ol></ol>";
        echo "<p> </p></div><div id='more' style='margin-top: 20px;' class='load_more'><a  id='$last_id' class='load_more' href='#' onClick='GetmoreActivity($projectID,&#34;$last_id&#34;);'>more</a>  </div>";


    } else {
        
        echo "<p><div id='more'><a  id='end' class='load_more' href='#' onClick='GetmoreActivity($projectID,&#34;end&#34;);'>no more post</a>  </div>";
        
    }
    
    
    
}



function training($kpi, $user_id, $alluserArray, $namakegiatan, $Activity)
{
    //get input
    $act          = $_POST['act'];
    $trainingname = htmlentities($_POST['nameTraining']);
    $tipeTraining = $_POST['tipeTraining'];
    $schedule     = $_POST['scheduleTraining'];
    $realization  = $_POST['realization'];
    $partisipant  = $_POST['particpanTraining'];
    $location     = $_POST['locationTraining'];
    $description  = $_POST['descriptionTraining'];
    $idTraining   = $_POST['idTraining'];
    $typeEvent    = $_POST['typeEvent'];
    
    if ($act == "add") {
        
        $pieces       = explode("-", $schedule);
        $tanggalStart = date("Y-m-d H:i:s", strtotime($pieces[0]));
        $tanggalEnd   = date("Y-m-d H:i:s", strtotime($pieces[1]));
        if ($realization != "") {
            $pieces2        = explode("-", $realization);
            $realisasiStart = date("Y-m-d H:i:s", strtotime($pieces2[0]));
            $realisasiEnd   = date("Y-m-d H:i:s", strtotime($pieces2[1]));
            $status         = 1;
        } else {
            $realisasiStart = "0000-00-00 00:00:00";
            $realisasiEnd   = "0000-00-00 00:00:00";
            $status         = 0;
        }
        
        
        //cek if picture underdatabase
        if (CekImageDatabase($description) == true) {
            
            $paterrn = 'src="data:image/jpeg;base64';
            
            $description = str_replace($paterrn, "style=\"width:100%\" src=\"data:image/jpeg;base64", $description);
            
        }
        
        
        $kpi->InsertTraining($tanggalStart, $tanggalEnd, $trainingname, $tipeTraining, $realisasiStart, $realisasiEnd, $partisipant, $user_id, $description, $location, $status, "", $typeEvent);
        $Activity->Insert_activity(30, $user_id, $trainingname, './panel.php?module=timeline');
    } elseif ($act == "dell") {
        
        $kpi->dellTrainingId($idTraining);
        
    }
    
    
    
    
    
    
    //nilai balik
    echo "
                                    <table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
                                        <thead>
                                            <tr>
                                                <th > ID</th>
                                                <th > Title</th>
                                                <th > Event</th>
                                                <th > Plan</th>
                                                <th > Participant</th>
                                                <th > Status</th>
                                                <th width='100px'> Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>";
    $listTrainings = $kpi->getTraining();
    $namakegiatan  = array(
        "error",
        "Training",
        "Conference",
        "GlaD",
        "Schoolarship",
        "Committee",
        "Seminar",
        "Presentation",
        "Other"
    );
    $n             = 1;
    foreach ($listTrainings as $listTraining) {
        
        $peserta      = Extractusername($alluserArray, $listTraining[peserta]);
        $titlePeserta = $peserta;
        if (strlen($peserta) > 50) {
            
            $peserta = substr($peserta, 0, 50) . "..";
        }
        $label       = labelStyle($listTraining['status'], $listTraining['tanggalStart']);
        $tanggalPlan = date("d M Y", strtotime($listTraining['tanggalStart']));
        $nameEvent   = $namakegiatan[$listTraining['typeOfevent']];
        echo " <tr>
                                                <td>$n</td>
                                                <td title='$listTraining[description]' > <a href='panel.php?module=dEvent&id=$listTraining[id]' >  $listTraining[training]</a></td>
                                                <td>$nameEvent</td>
                                                <td>$tanggalPlan</td>
                                                <td title='$titlePeserta'>$peserta</td>
                                                <td>$label</td>
                                                <td >
                                                <div class='visible-md visible-lg hidden-sm hidden-xs'>
                                                    <a href='#' class='btn btn-xs btn-teal tooltips' data-placement='top' data-original-title='Edit'><i class='fa fa-edit'></i></a>
                                                
                                                    <a  onclick='dellTraining($listTraining[id]);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
                                                </div>
                                                
                                                
                                                
                                                </td>
                                                
                                            </tr>";
        
        $n++;
    }
    echo "    </tr>
                                        </tbody>
                                    </table>";
    
    
    echo "<script>
            jQuery(document).ready(function() {

                TableData.init();
            });
        </script>";
    
    
    
    
}

function inlineUpdateTraining($kpi, $user_id, $alluserArray)
{
    
    $description = $_POST['content'];
    $idTraining  = $_POST['content_id'];
    
    $kpi->UpdateTrainingDescriptByid($description, $idTraining, $user_id);
    
    
}


function cost($kpi, $user_id, $currencyarray)
{
    //get input
    
    $stringCommand = $_POST['stringCommand'];
    $pieces        = explode("#", $stringCommand);
    
    $act     = $pieces[0];
    $periode = $kpi->GetActivePlanPeriode();
    
    
    
    
    if ($act == "add") {
        
        $nameCost = $pieces[1];
        $cost     = str_replace(",", "", $pieces[2]);
        
        $currency        = $pieces[3];
        $kurs            = str_replace(",", "", $pieces[4]);
        $tipekegiatan    = $pieces[5];
        $investorOrEvent = $pieces[6];
        
        $idKegiatan      = $pieces[7];
        $realization     = $pieces[8];
        $descriptionCost = $_POST['richtext1'];
        
        if ($currency != 1) {
            
            $total = $cost * $kurs;
            
        } else {
            
            $total = $cost;
            
        }
        
        if ($tipekegiatan == "") {
            $tipekegiatan = 0;
        }
        
        
        if ($investorOrEvent == 0) {
            $kpi->Insertcost($nameCost, $cost, $currency, $tipekegiatan, $idKegiatan, $descriptionCost, $realization, $periode, $kurs, $total);
        } else {
            
            $kpi->InsertcostInvest($nameCost, $cost, $currency, $tipekegiatan, $idKegiatan, $descriptionCost, $realization, $periode, $kurs, $total);
        }
        
        
    } elseif ($act == "del") {
        
        $idCost = $pieces[1];
        $kpi->dellCost($idCost);
        $investorOrEvent = 0;
    } elseif ($act == "dell") {
        
        $idCost = $pieces[1];
        $kpi->dellCostInvest($idCost);
        $investorOrEvent = 1;
    } elseif ($act == "refresh1") {
        $investorOrEvent = 0;
        
    } elseif ($act == "refresh2") {
        $investorOrEvent = 1;
        
    }
    
    
    //nilai balik
    echo "<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
                                        <thead>
                                            <tr>
                                                <th > ID</th>
                                                <th > Cost Name</th>
                                                <th > currency</th>
                                                <th > cost </th>
                                                <th > Assosiated </th> 
                                                <th > Realization</th>
                                                <th > Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>";
    $n = 1;
    if ($investorOrEvent == 0) {
        $listCosts = $kpi->getCost($periode);
    } else {
        $listCosts = $kpi->getCostInvest($periode);
    }
    
    foreach ($listCosts as $listCost) {
        //$label= labelStyle($listTraining[status],$listTraining[status]);
        $currency        = $currencyarray[$listCost['currency']];
        $dateRealization = date("d M Y", strtotime($listCost[realisation]));
        $costformat      = number_format($listCost[cost]);
        
        echo " <tr>
                                                <td>$n</td>
                                                <td>$listCost[nam]</td>
                                                <td>$currency</td>
                                                <td>$costformat </td>
                                                <td >$listCost[training]$listCost[item]</td>
                                                <td>$dateRealization</td>
                                                <td class='center' >
                                                <div class='visible-md visible-lg hidden-sm hidden-xs'>
                                            ";
        
        if ($investorOrEvent == 0) {
            echo "<a  onclick='dellCostttii($listCost[id]);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>";
        } else {
            echo "<a  onclick='dellCosttt($listCost[id]);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>";
        }
        echo "        
                                                    
                                                </div>
                                                
                                                
                                                
                                                </td>
                                                
                                            </tr>";
        
        $n++;
    }
    
    
    echo "        
                                            </tr>
                                        </tbody>";
    echo "<script>
            jQuery(document).ready(function() {

                TableData.init();
            });
        </script>";
    
    
    
    
}

function costobj($kpi, $user_id)
{
    //get input
    $act             = $_POST['act'];
    $nameCost        = $_POST['nameCost'];
    $tanggal         = $_POST['tanggal'];
    $cost            = $_POST['cost'];
    $currency        = $_POST['currency'];
    $tipeKegiatan    = $_POST['tipekegiatan'];
    $idKegiatan      = $_POST['idKegiatan'];
    $realization     = $_POST['realization'];
    $descriptionCost = $_POST['descriptionCost'];
    
    if ($act == "add") {
        
        
        
        $kpi->Insertcost($nameCost, $cost, $currency, 3, $idKegiatan, $descriptionCost, $realization, $tanggal);
    }
    
    
    //nilai balik
    echo "
                                    <table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
                                        <thead>
                                            <tr>
                                                <th > Title</th>
                                                <th > Cost</th>
                                                <th > Associated</th>
                                                <th > Realization</th>
                                                <th > Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>";
    $listCosts = $kpi->getCostbyid($idKegiatan, 3);
    foreach ($listCosts as $listCost) {
        //$label= labelStyle($listTraining[status],$listTraining[status]);
        echo " <tr>
                                                <td>$listCost[nam]</td>
                                                <td>$listCost[cost]</td>
                                                <td >$listCost[idKegiatan]</td>
                                                <td>$listCost[realisation]</td>
                                                <td >
                                                <div class='visible-md visible-lg hidden-sm hidden-xs'>
                                                    <a href='#' class='btn btn-xs btn-teal tooltips' data-placement='top' data-original-title='Edit'><i class='fa fa-edit'></i></a>
                                                
                                                    <a href='#' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
                                                </div>
                                                
                                                
                                                
                                                </td>
                                                
                                            </tr>";
        
        
    }
    echo "<script>
            jQuery(document).ready(function() {

                TableData.init();
            });
        </script>";
    
    
    
    
}

function task($Activity, $user_id)
{
    //get input
    $act = $_POST['act'];
    
    $todo         = $_POST['todo'];
    $tipeKegiatan = $_POST['tipeKegiatan'];
    $idKegiatan   = $_POST['idKegiatan'];
    $description  = $_POST['description'];
    $tanggalan    = $_POST['tanggalan'];
    $idTask       = $_POST['idTask'];
    
    if ($tipeKegiatan == "") {
        $tipeKegiatan = 0;
    }
    
    if ($act == "add") {
        
        $tanggalan = date('Y-m-d', strtotime($tanggalan));
        $Activity->InsertTask($todo, $user_id, $tanggalan, '0000-00-00 00:00:00', $tipeKegiatan, $idKegiatan, 0, $description, $user_id);
        
    } elseif ($act == "dell") {
        
        $Activity->dellTask($idTask);
    } elseif ($act == "oneclickupdate") {
        
        $realization = date('Y-m-d H:i:s');
        $Activity->UpdateTaskDone($realization, $idTask);
    } elseif ($act == "refreshTask") {
        
        $listUrgents = $Activity->getTaskbyidUserUrgent($user_id);
        
        
        
        
        
        
        foreach ($listUrgents as $listUrgent) {
            
            
            
            echo StyleTask($listUrgent['due'], $listUrgent['id'], $listUrgent['pekerjaan'], $listUrgent['tipeKegiatan'], $listUrgent['idKegiatan']);
            
        }
        
        
        
        echo "<script>
            jQuery(document).ready(function() {

                //Main.init();
                
                
    $('.drop-down-wrapper').perfectScrollbar({
        wheelSpeed: 50,
        minScrollbarLength: 20,
        suppressScrollX: true
    });
    $('.navbar-tools .dropdown').on('shown.bs.dropdown', function () {
        $(this).find('.drop-down-wrapper').scrollTop(0).perfectScrollbar('update');
    });
    
    //function to activate the ToDo list, if present
    var runToDoAction = function () {
        if ($('.todo-actions').length) {
            $('.todo-actions').click(function () {
                if ($(this).find('i').hasClass('fa-square-o') || $(this).find('i').hasClass('icon-check-empty')) {
                    if ($(this).find('i').hasClass('fa')) {
                        $(this).find('i').removeClass('fa-square-o').addClass('fa-check-square-o');
                    } else {
                        $(this).find('i').removeClass('icon-check-empty').addClass('fa fa-check-square-o');
                    };
                    $(this).parent().find('span').css({
                        opacity: .25
                    });
                    $(this).parent().find('.desc').css('text-decoration', 'line-through');
                } else {
                    $(this).find('i').removeClass('fa-check-square-o').addClass('fa-square-o');
                    $(this).parent().find('span').css({
                        opacity: 1
                    });
                    $(this).parent().find('.desc').css('text-decoration', 'none');
                }
                return !1;
            });
        }
    };
    
    runToDoAction();
                
            });
        </script>";
        
        die;
        
        
    } elseif ($act == "getTaskNotification") {
        
        $getJumlaTask = $Activity->getJmlTaskbyidUserUrgent($user_id);
        
        if ($getJumlaTask != 0) {
            
            echo "<span class='badge'> $getJumlaTask  </span>";
        }
        
        die;
    }
    
    //nilai balik
    
    echo "
                                    <table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
                                        <thead>
                                            <tr>
                                                <th > ID</th>
                                                <th > To do </th>
                                                <th > Related </th>
                                                <th > due</th>
                                                
                                                <th > Action</th

                                            </tr>
                                        </thead>
                                        <tbody>";
    $n         = 1;
    $listTodos = $Activity->getTaskbyidUser($user_id, 1000);
    foreach ($listTodos as $listTodo) {
        //$label= labelStyle($listTraining[status],$listTraining[status]);
        
        //$taskStart = date("M d , Y", strtotime($listTodo[finish]));
        
        $taskEnd = date("M d , Y", strtotime($listTodo[due]));
        
        if ($listTodo[finish] == "0000-00-00 00:00:00") {
            $taskEnd = Getbadge($taskEnd, 0);
        } else {
            $taskEnd = Getbadge($taskEnd, 1);
        }
        
        if ($listTodo[tipeKegiatan] == "3") {
            $relatedProject = "project : " . $listTodo[project];
        } elseif ($listTodo[tipeKegiatan] == "2") {
            $relatedProject = $listTodo[training];
        } else {
            
            $relatedProject = "no related";
        }
        
        echo " <tr>
                                                <td>$n</td>
                                                <td title='$listTodo[desck]'>$listTodo[pekerjaan]</td>
                                                <td >$relatedProject</td>
                                                <td title='done at $listTodo[finish]'>$taskEnd</td>
                                                
                                                <td >
                                                <div class='visible-md visible-lg hidden-sm hidden-xs'>
                                                    <a href='#' class='btn btn-xs btn-teal tooltips' data-placement='top' data-original-title='Edit'><i class='fa fa-edit'></i></a>
                                                
                                                    <a href='' onclick='dellTask($listTodo[id]);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
                                                </div>
                                                
                                                
                                                
                                                </td>
                                                
                                            </tr>";
        
        $n++;
    }
    
    
    echo "        
                                            </tr>
                                        </tbody>";
    echo "<script>
            jQuery(document).ready(function() {

                TableData.init();
                
            });
        </script>";
    
    
}

function galery($Activity, $user_id)
{
    $tipeKegiatan = $_POST['tipekegiatan'];
    $idKegiatan   = $_POST['idKegiatan'];
    $act          = $_POST['act'];
    $nama         = $_POST['nama'];
    $idgaleri     = $_POST['idgaleri'];
    
    if ($act == "add") {
        $dir_dest = "data";
        $files    = array();
        foreach ($_FILES['item_file'] as $k => $l) {
            foreach ($l as $i => $v) {
                if (!array_key_exists($i, $files))
                    $files[$i] = array();
                $files[$i][$k] = $v;
            }
        }
        
        // now we can loop through $files, and feed each element to the class
        foreach ($files as $file) {
            
            // we instanciate the class for each element of $file
            $handle = new uploadd($file);
            
            // then we check if the file has been uploaded properly
            // in its *temporary* location in the server (often, it is /tmp)
            if ($handle->uploadd) {
                
                $handle->allowed            = array(
                    'image/*'
                );
                $randomname                 = getRandomFilename();
                $handle->file_name_body_add = $randomname . '_uploaded';
                
                
                
                // now, we start the upload 'process'. That is, to copy the uploaded file
                // from its temporary location to the wanted location
                // It could be something like $handle->Process('/home/www/my_uploads/');
                $handle->Process($dir_dest);
                
                // we check if everything went OK
                if ($handle->processed) {
                    
                    //update database
                    
                    //$handle->createTubnail( $dir_dest.'/' . $handle->file_dst_name, $dir_dest.'/Thumbs'  , 100 );
                    
                    $handle->makeThumbnails($dir_dest, $dir_dest . '/' . $handle->file_dst_name, 2);
                    
                    $Activity->Insert_docGalery($handle->file_dst_name, 1, $idKegiatan, $tipeKegiatan, $dir_dest . '/' . $handle->file_dst_name);
                    
                } else {
                    // one error occured
                    echo '<p class="result">';
                    echo '  <b>File not uploaded to the wanted location</b><br />';
                    echo '  Error: ' . $handle->error . '';
                    echo '</p>';
                }
                
            } else {
                // if we're here, the upload file failed for some reasons
                // i.e. the server didn't receive the file
                echo '<p class="result">';
                echo '  <b>File not uploaded on the server</b><br />';
                echo '  Error: ' . $handle->error . '';
                echo '</p>';
            }
        }
    } elseif ($act == "del") {
        
        
        $alamat = $Activity->get_docGalerybyId($idgaleri);
        unlink($alamat);
        
        $alamatthumbnail = "data/Thumbdata/" . basename($alamat);
        unlink($alamatthumbnail);
        
        $Activity->delldocGalerybyId($idgaleri);
        
        
    } elseif ($act == "update") {
        
        $Activity->UpdatedocGalerybyId($nama, $idgaleri);
        
        
    }
    
    //nilai balik
    
    $PictureLists = $Activity->getdocGalery(1);
    
    foreach ($PictureLists as $PictureList) {
        $thumbnail = basename($PictureList[path]);
        echo "<div class='col-md-3 col-sm-4 gallery-img'>
                            <div class='wrap-image'>
                                <a class='group1' href='$PictureList[path]' title='$PictureList[nama]'>
                                    <img src='data/Thumbdata/$thumbnail'  alt='' class='img-responsive'>
                                </a>
                                <div class='chkbox'></div>
                                <div class='tools tools-bottom'>
                                    <a href='#'>
                                        <i class='clip-link-4'></i>
                                    </a>
                                    <a href='#responsive' data-toggle='modal' onClick='changeModalGalery($PictureList[id], &#39;$PictureList[nama]&#39;);'>
                                        <i class='clip-pencil-3 '></i>
                                    </a>
                                    <a  onClick='Delgalery($PictureList[id]);'>
                                        <i class='clip-close-2'></i>
                                    </a>
                                </div>
                            </div>
                        </div>";
        
    }
    echo "            <script>
            jQuery(document).ready(function() {
                
                PagesGallery.init();
            });
            </script>            ";
    
}

function document($Activity, $user_id)
{
    $tipeKegiatan = $_POST['tipekegiatan'];
    $idKegiatan   = $_POST['idKegiatan'];
    $act          = $_POST['act'];
    $nama         = $_POST['nama'];
    $idgaleri     = $_POST['iddocument'];
    
    if ($act == "add") {
        $dir_dest = "document";
        $files    = array();
        foreach ($_FILES['item_file'] as $k => $l) {
            foreach ($l as $i => $v) {
                if (!array_key_exists($i, $files))
                    $files[$i] = array();
                $files[$i][$k] = $v;
            }
        }
        
        // now we can loop through $files, and feed each element to the class
        foreach ($files as $file) {
            
            // we instanciate the class for each element of $file
            $handle = new uploadd($file);
            
            // then we check if the file has been uploaded properly
            // in its *temporary* location in the server (often, it is /tmp)
            if ($handle->uploadd) {
                
                $handle->allowed            = array(
                    'application/pdf'
                );
                $handle->file_name_body_add = '_uploaded';
                
                
                
                // now, we start the upload 'process'. That is, to copy the uploaded file
                // from its temporary location to the wanted location
                // It could be something like $handle->Process('/home/www/my_uploads/');
                $handle->Process($dir_dest);
                
                // we check if everything went OK
                if ($handle->processed) {
                    
                    //update database
                    
                    
                    $Activity->Insert_docGalery($handle->file_dst_name, 2, $idKegiatan, $tipeKegiatan, $dir_dest . '/' . $handle->file_dst_name);
                    
                } else {
                    // one error occured
                    echo '<p class="result">';
                    echo '  <b>File not uploaded to the wanted location</b><br />';
                    echo '  Error: ' . $handle->error . '';
                    echo '</p>';
                }
                
            } else {
                // if we're here, the upload file failed for some reasons
                // i.e. the server didn't receive the file
                echo '<p class="result">';
                echo '  <b>File not uploaded on the server</b><br />';
                echo '  Error: ' . $handle->error . '';
                echo '</p>';
            }
        }
        
        
        
        
        
        
        
    } elseif ($act == "update") {
        
        $Activity->UpdatedocGalerybyId($nama, $idgaleri);
        
    } elseif ($act == "del") {
        
        $alamat = $Activity->get_docGalerybyId($idgaleri);
        unlink($alamat);
        
        $Activity->delldocGalerybyId($idgaleri);
        
    }
    
    
    //nilai balik
    
    echo "                                    <table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
                                        <thead>
                                            <tr>
                                                <th > No</th>
                                                <th > Name</th>
                                                <th > Type</th>
                                                
                                                <th > Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>";
    $n             = 1;
    $DocumentLists = $Activity->getdocGalery(2);
    foreach ($DocumentLists as $DocumentList) {
        
        
        echo " <tr>
                                                <td>$n</td>
                                                <td><a href='$DocumentList[path]' target='_blank' > $DocumentList[nama]</a></td>
                                                <td >Document</td>
                                            
                                                <td >
                                                <div class='visible-md visible-lg hidden-sm hidden-xs'>
                                                    <a onClick='changeModalDocument($DocumentList[id], &#39;$DocumentList[nama]&#39;);' href='#responsive' data-toggle='modal' class='btn btn-xs btn-teal tooltips' data-placement='top' data-original-title='Edit'><i class='fa fa-edit'></i></a>
                                                
                                                    <a onClick='Deldocument($DocumentList[id])' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
                                                </div>
                                                </td>
                                                
                                            </tr>";
        $n++;
    }
    
    
    echo "        
                                            </tr>
                                        </tbody>
                                    </table>";
    echo "<script>
                                        jQuery(document).ready(function() {

                                            TableData.init();
                                            
                                        });
                                    </script>";
    
    
    
}

function rules_pub($rms, $user_id, $salting, $mysqli)
{
    
    $jenis_Technical      = $_POST['act'];
    $Load_tipe            = $_POST['tipe'];
    $Load_all             = $_POST['alll'];
    $Statuss              = array(
        "Error",
        "Active",
        "No  Publish",
        "Obsolete"
    );
    $JenisTechnical_paper = array(
        "Error",
        "Rules",
        "Guidelines",
        "Guidance",
        "Reference Note"
    );
    
    if ($jenis_Technical == "update_status") {
        
        if ($salting > 4) {
            $update_status = $_POST['status'];
            $ids           = $_POST['ids'];
            if ($insert_stmt = $mysqli->prepare("UPDATE rm_rulepub SET  status = ?  where id= ?")) {
                $insert_stmt->bind_param('ii', $update_status, $ids);
                // Execute the prepared query.
                $insert_stmt->execute();
                echo "<script type='text/javascript'>
                       load_rulepub();
                       </script>";
            }
            
            
        } else {
            echo "<script type='text/javascript'>
                       load_rulepub();
                       alert('Only manager and above can change it');
                       </script>";
        }
        
        
    } elseif ($jenis_Technical == "dell_status") {
        $salting = $_SESSION['salt'];
        if ($salting == 9) {
            
            $ids = $_POST['ids'];
            if ($insert_stmt = $mysqli->prepare("DELETE FROM  rm_rulepub  where id =?  LIMIT 1")) {
                $insert_stmt->bind_param('i', $ids);
                // Execute the prepared query.
                $insert_stmt->execute();
                
                
            }
            
            //hapus file
            if ($load_friend = $mysqli->prepare("SELECT path FROM  rm_upload_tanpa_rms where id_rules_pub = ? ")) {
                // Execute the prepared query.
                $load_friend->bind_param('i', $ids); // Bind "$id_rules" to parameter.
                $load_friend->execute();
                $load_friend->bind_result($path);
                $buang = array();
                while ($load_friend->fetch()) {
                    
                    unlink("../" . $path);
                    
                }
            }
            
            
            //hapus database file
            if ($insert_stmt = $mysqli->prepare("DELETE FROM  rm_upload_tanpa_rms  where id_rules_pub =?  ")) {
                $insert_stmt->bind_param('i', $ids);
                // Execute the prepared query.
                $insert_stmt->execute();
                
                
            }
            
            echo "<script type='text/javascript'>
                   load_rulepub();
                   </script>";
            
        } else {
            echo "<script type='text/javascript'>
                   load_rulepub();
                   alert('Only Super Admin and above can change it);
                   </script>";
        }
    }
    
    
    
    //nilai balik
    $rulepubss = $rms->list_rules_pub($Load_tipe, $Load_all);
    
    echo "<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
                                        <thead>
                                            <tr>
    <th>No </th>
    <th>ID </th>
    <th>Rules ID</th>
    <th>Technical Papaer </th>
    <th>Year </th>
    <th>Part</th>
    <th>Vol </th>
    <th>Type </th>
    <th>Link </th>
    <th>Status</th>
    <th>Action</th>
    </tr></thead><tbody>";
    
    $no = 1;
    foreach ($rulepubss as $rulepubs) {
        echo "<tr>
                                    <td >$no</td>
                                    
                                    <td><a href='panel.php?module=viewrules&id=$rulepubs[id]'>" . $rulepubs['id'] . "</a></td>
                                    <td><a href='panel.php?module=viewrules&id=$rulepubs[id]'>" . $rulepubs['id_rules'] . "</a></td>
                                    <td><a href='panel.php?module=viewrules&id=$rulepubs[id]'  target='_blank' >" . $rulepubs['nama'] . "</a></td>
                                    <td>" . $rulepubs['tahun'] . "</td>
                                    <td>" . $rulepubs['part'] . "</td>
                                    <td>" . $rulepubs['vol'] . "</td>
                                    <td>" . $JenisTechnical_paper[$rulepubs['tipe']] . "</td>
                                    <td>" . $rulepubs['link'] . "</td>
                                    <td>" . $Statuss[$rulepubs['status']] . "</td>
                                    <td><a href=# onclick='Update_status(" . $rulepubs['id'] . ",1);'>P </a> <a href=# onclick='Update_status(" . $rulepubs['id'] . ",2);'>N </a> <a href=# onclick='Update_status(" . $rulepubs['id'] . ",3);'>O </a> <a href=# onclick='dell_status(" . $rulepubs['id'] . ");'>D </a></td>
                                    
                                    </tr>";
        
        
        $no++;
    }
    
    
    
    
    echo "        
                                            </tr>
                                        </tbody>
                                    </table>";
    echo "<script>
                                        jQuery(document).ready(function() {

                                            TableData.init();
                                            
                                        });
                                    </script>";
    
    
}

function document_obj($obj, $created_by_id)
{
    
    $act           = $_POST['act'];
    $listsubcriber = $_POST['subscr'];
    $idgaleri      = $_POST['iddocument'];
    $idProject     = $_POST['idKegiatans'];
    
    if (isset($act) && !empty($act)) {
        
    } else {
        $stringCommand = $_POST['stringCommand'];
        $pieces        = explode("#", $stringCommand);
        $act           = $pieces[0];
        $idProject     = $pieces[1];
    }
    
    if ($act == "upload") {
        
        $dir_dest = "../data/" . $idProject . "/document";
        
        cekFolderexist_obj($dir_dest); //makesure folder exist
        
        $files = array();
        foreach ($_FILES['item_file'] as $k => $l) {
            foreach ($l as $i => $v) {
                if (!array_key_exists($i, $files))
                    $files[$i] = array();
                $files[$i][$k] = $v;
            }
        }
        
        // now we can loop through $files, and feed each element to the class
        foreach ($files as $file) {
            
            // we instanciate the class for each element of $file
            $handle = new uploadd($file);
            
            $mimefile = $file["type"];
            $filesize = $file["size"];
            
            $filename   = $file["name"];
            $ext        = pathinfo($filename, PATHINFO_EXTENSION);
            $tipeFileid = $obj->getTipeFilebyExt($ext);
            
            if ($tipeFileid == "") {
                $tipeFileid = 29;
            }
            //echo $filename . "saaaaaaaaaaaaaaa";
            // then we check if the file has been uploaded properly
            // in its *temporary* location in the server (often, it is /tmp)
            if ($handle->uploadd) {
                //echo "sapi";
                //$handle->allowed = array('image/*');
                $nameRandom                 = getRandomFilename();
                $handle->file_new_name_body = $nameRandom;
                
                $handle->Process($dir_dest);
                
                // we check if everything went OK
                if ($handle->processed) {
                    
                    //update database
                    if ($listsubcriber == "") {
                        $listsubcriber = "," . $created_by_id;
                    }else{
                         $listsubcriber = $listsubcriber .  "," . $created_by_id;
                    }
                    $obj->uploadFileobj($filename, $created_by_id, $tipeFileid, $dir_dest . '/' . $handle->file_dst_name, $mimefile, $filesize, $listsubcriber, $idProject);
                    
                } else {
                    
                    echo '  Error: ' . $handle->error . '';
                    
                }
                
            } else {
                echo '  Error: ' . $handle->error . '';
                
            }
        }
    } elseif ($act == "WriteDocument") {
        
        $ext        = $_POST['ext'];
        $stringdata = $_POST['dataFile'];
        $dir_dest   = "../data/" . $idProject . "/document" ;
        $mimefile   = "text/html";
        $fileName   = $_POST['nama'];
        
        cekFolderexist_obj($dir_dest); //makesure folder exist
        
        //$ext = "html"
        $tipeFileid = $obj->getTipeFilebyExt($ext);
        if ($tipeFileid == "") {
            $tipeFileid = 29;
        }
        
        $nameRandom = getRandomFilename();
        $dir_dest   = $dir_dest . "/" . $nameRandom . "." . $ext;
        
        
        
        $obj->WriteDoc($dir_dest, $stringdata);
        
        
        $filesize = filesize($dir_dest);
        
        if ($listsubcriber == "") {
            $listsubcriber = "," . $created_by_id;
        }
        $obj->uploadFileobj($fileName, $created_by_id, $tipeFileid, $dir_dest, $mimefile, $filesize, $listsubcriber, $idProject);
        
    }
    
    
    //nilai balik
    
    echo "
                                    <table class='table table-striped table-bordered table-hover' id='sample_1'>
                                        <thead>
                                            <tr>
                                                <th class='center' width='16px' >
                                                <div class='checkbox-table'>
                                                    <label>
                                                        <input type='checkbox' class='flat-grey'>
                                                    </label>
                                                </div></th>
                                                <th class='center'  width='16px'></th>
                                                <th class='hidden-xs' width='16px' ></th>
                                                <th>Name</th>
                                                <th class='hidden-xs' width='100px'>Size</th>
                                                <th class='hidden-xs' width='270px' >Last update</th>
                                                <th class='hidden-xs' width='100px' >status</th>
                                                <th width='50px'>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
    
    $DocumentLists = $obj->GetObjectbyproject($idProject, '6', 200);
    foreach ($DocumentLists as $DocumentList) {
        $ukuranFile = formatSizeUnits($DocumentList['filesize']);
        if ($DocumentList['is_read'] == 1) {
            $readunread = "read";
        } else {
            $readunread = "unread";
        }
        echo "    <tr>
                                                <td class='center'>
                                                <div class='checkbox-table'>
                                                    <label>
                                                        <input type='checkbox' name='checkbox[]' value='$DocumentList[id]' class='flat-grey'>
                                                    </label>
                                                </div></td>
                                            
                                                <td class='center'><img src='assets/images/filetypes/$DocumentList[icon]' width='20px' alt='image'/></td>
                                                <td class='hidden-xs'><div class='ico-$readunread' title='$readunread'>&nbsp;&nbsp;&nbsp;</div></td>
                                                <td ><a href='panel.php?module=projectDetail&id=$DocumentList[id]' target=_blank>$DocumentList[name]</a></td>
                                                <td class='hidden-xs'>
                                                $ukuranFile</td>
                                                <td class='hidden-xs'><a href='panel.php?module=profile&id=$DocumentList[updated_by_id]' >$DocumentList[nama]</a>, on $DocumentList[updated_on]</td>
                                                
                                                <td class='hidden-xs'>Avaible</td>
                                                <td class='center'>
                                                <a href='link.php?module=download&id=$DocumentList[id]' target='_blank'>
                                                <img src='assets/images/download.png' alt='image'/></a>
                                                </td>
                                            </tr>";
        
    }
    
    echo "
                                        </tbody>
                                    </table>";
    
    echo "<script> TableData.init(); </script>";
    
    
    
}

function project_obj($obj, $created_by_id, $kontrak, $salting, $alluserArray)
{
    
    
    
    
    $act = $_POST['act'];
    
    if (isset($act) && !empty($act)) {
        
    } else {
        $stringCommand = $_POST['stringCommand'];
        $pieces        = explode("#", $stringCommand);
        $act           = $pieces[0];
        $code          = $pieces[1];
    }
    
    
    if ($act == 'add') {
        
        
        if ($salting < 5) {
            echo "<script>alert('Access denied');</script>";
            die;
        }
        $nokontract = $_POST['nokontract'];
        $Builder    = $_POST['Builder'];
        $Submited   = $_POST['Submited'];
        
        $projectname = $_POST['projectname'];
        $classno     = $_POST['classno'];
        
        $start             = date('Y-m-d', strtotime($_POST['start']));
        $due               = date('Y-m-d', strtotime($_POST['due']));
        $tipe              = $_POST['tipe'];
        $particpanTraining = $_POST['particpanTraining'];
        $location          = $_POST['locationv'];
        $pm                = $_POST['pm'];
        
        $target = $_POST['target'];
        
        $created_on = date("Y-m-d H:i:s");
        
        
        $obj->InsertObject(1, $projectname, $created_on, $created_by_id); //idObject
        $lastid = $obj->lastInsertId();
        
        $obj->tblinsertWorkspace($lastid, 0, $projectname, "," . $pm, $start, $due, 0, $nokontract, $classno, $tipe, $location, $Builder, $Submited, 0, "0000-00-00");
        $datetime = date('Y-m-d');
        //insert jabatan admin
        /*         foreach($TeamMembers as $TeamMember) {
        if ($TeamMember!="") { */
        

        $idJabatan= $obj->Get_idJabatan('Project Leader');

        $kontrak->Create_proj_team($lastid, $pm, $datetime, $idJabatan, "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29"); //create PM only
        /*             }
        }  */
        
        $act  = "refreshlist";
        $code = 0;
        
        
        
        
    } elseif ($act == 'update') {
        $datetime            = date('Y-m-d');
        $created_on          = date("Y-m-d H:i:s");
        $idproj              = $_POST['idproj'];
        $descriptionTraining = $_POST['descriptionTraining'];
        $particpanTraining   = $_POST['particpanTraining'];
        $kontractlink        = $_POST['kontractlink'];
        $projectname         = $_POST['projectname'];
        $target              = $_POST['target'];
        $start               = date('Y-m-d', strtotime($_POST['start']));
        $due                 = date('Y-m-d', strtotime($_POST['due']));
        $tipe                = $_POST['tipe'];
        $classno             = $_POST['classno'];
        $location            = $_POST['locationv'];
        $Builder             = $_POST['Builder'];
        $Submited            = $_POST['Submited'];
        $nokontract          = $_POST['nokontract'];
        $sistercontract      = $_POST['sistercontract'];



        $obj->tblupdateworkspace($idproj, $projectname, $target, $nokontract, $particpanTraining, $start, $due, $classno, $descriptionTraining, $tipe, $location, $Builder, $Submited, $kontractlink,$sistercontract);
        
        /*     $tim=$obj->getTeamMember($idproj);
        //if($tim!=$particpanTraining){
        //delmemeber
        $kontrak->delete_proj_Allteam($idproj);
        //insert jabatan admin
        foreach($TeamMembers as $TeamMember) {
        if ($TeamMember!="") {
        
        $kontrak->Create_proj_team($idproj, $TeamMember, $datetime, 1);
        }
        } */
        //}    
        
        //insertlogsAplikasi
        $obj->WriteLogAplicationLogs($created_by_id, $idproj, $projectname, $created_by_id, "edit", 0, 0, $descriptionTraining);
        //nilai balik
        echo "<script> alert('done') ; window.location.reload(); </script>";
        
        
    } elseif ($act == 'dell') {
        
        if ($salting < 5) {
            echo "<script>alert('Access denied');refreshProject(0);</script>";
            die;
        }
        
        $obj->TrashWorkspace($code, $created_by_id);
        $act  = "refreshlist";
        $code = 0;
    }
    
    if ($act == "refreshlist") {
        
        //nilai balik
        
        echo "        
<table class='table table-striped table-bordered table-hover' id='sample_1'>
                                    <thead>
                                        <tr>
                                                    <th>No</th>
                                                    <th>Project Name</th>
                                                    <th>contract</th>
                                                    <th class='hidden-xs'>Lead</th>
                                                    <th class='hidden-xs'>start</th>
                                                    <th>Proj Comp</th>
                                                    <th>Late Task</th>
                                                    <th class='hidden-xs'>%Comp</th>
                                                    <th class='hidden-xs' >target</th>
                                                    
                                                    <th>Act</th>                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                            ";
        $projectlists = $obj->get_wokspaceUndone($code);
        $no           = 1;
        foreach ($projectlists as $projectlist) {
            
            $tanggalselesai = date("d M Y", strtotime($projectlist['due']));
            
            $nokontrak = $projectlist['id_kontrak'];
            $start     = date("d M Y", strtotime($projectlist['starting']));
            $target    = 'Rp. ' . number_format($projectlist['target'], 0, '', ',');
            
            $idJabatan= $obj->Get_idJabatan('Project Leader');

            $lead = $kontrak->get_proj_PM_project($projectlist['object_id'],$idJabatan);
            
            $pemimpin = $alluserArray[$lead];

            if ($projectlist['latetask']==0) {
                $stringlatetask= "<span class='label label-sm label-info'>$projectlist[latetask] task</span>";
            }elseif ($projectlist['latetask'] < 7 ) {
                 $stringlatetask= "<span class='label label-sm label-warning'>$projectlist[latetask] task</span>";
            }else{
                 $stringlatetask= "<span class='label label-sm label-danger'>$projectlist[latetask] task</span>";
            }



            echo "
                                            
                                            
                                                <tr>
                                                    <td >$no</td>
                                                    <td><a href='panel.php?module=projectMod&idproj=$projectlist[object_id]'>$projectlist[project]</a></td>
                                                    <td > $nokontrak</td>
                                                    <td class='hidden-xs'> $pemimpin</td>
                                                    <td class='hidden-xs'> $start</td>
                                                    <td>$tanggalselesai</td>
                                                    <td>$stringlatetask</td>
                                                    <td class='hidden-xs'>
                                                    <div class='progress progress-striped active progress-sm'>
                                                        <div style='width: $projectlist[progress]%' aria-valuemax='100' aria-valuemin='0' aria-valuenow=' $projectlist[progress]' role='progressbar' class='progress-bar '>
                                                            <span class='sr-only'> 70% Complete (danger)</span>
                                                        </div>
                                                    </div></td>
                                                    <td class='hidden-xs'>$target</td>
                                            
                                                    <td class='center'>
                                                    <div class='visible-md visible-lg hidden-sm hidden-xs'>
                                                        <a href='#' onClick='delProject($projectlist[object_id]);'class='btn btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
                                                    </div>

                                                    </td>
                                                </tr>";
            $no++;
        }
        
        echo "
                                            </tbody>
                                        </table><script> generatedTable(1);</script>";
    }
    
    
    
    
}

function notes_objPagedetail($obj, $user_id)
{
    $act = $_POST['act'];
    
    $captionmessage = $_POST['captionmessage'];
    $pesan          = $_POST['pesan'];
    $idProject      = $_POST['idProject'];
    
    if ($act == "update") {
        
        
        
        $obj->updateNotes($idProject, $user_id, $pesan, $captionmessage);
        
        
        
        //nilai balik
        
        $noteds = $obj->GetmessageByid($idProject);
        foreach ($noteds as $noted) {
            $textmessage = $noted['text'];
        }
        echo $textmessage;
    }
    
    
}

function notes_obj($obj, $created_by_id)
{
    $act = $_POST['act'];
    
    $captionmessage = $_POST['captionmessage'];
    $pesan          = $_POST['pesan'];
    $idProject      = $_POST['idProject'];
    $listsubcriber  = $_POST['listsubscriber'];
    
    if (isset($act) && !empty($act)) {
        
    } else {
        $stringCommand = $_POST['stringCommand'];
        $pieces        = explode("#", $stringCommand);
        $act           = $pieces[0];
        $idProject     = $pieces[1];
    }
    
    
    
    if ($act == "add") {
        
        if ($listsubcriber == "") {
            $listsubcriber = "," . $created_by_id;
        }else{
            $listsubcriber = $listsubcriber . "," . $created_by_id; //tambai auto subscriber yang ngepost
        } 
        
        $obj->writeMessage($created_by_id, $captionmessage, 3, $pesan, 'html', $idProject, $listsubcriber);
        
        
    }
    //nilai balik
    echo "
                                    <table class='table table-striped table-bordered table-hover' id='sample_12'>
                                        <thead>
                                            <tr>
                                                <th class='center' width='16px' >
                                                <div class='checkbox-table'>
                                                    <label>
                                                        <input type='checkbox' class='flat-grey'>
                                                    </label>
                                                </div></th>
                                                <th  width='16px'></th>
                                                <th  width='16px' ></th>
                                                <th class='center' >Name</th>
                                                
                                                <th class='hidden-xs' width='270px' >Last update</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>";
    
    
    $messaLists = $obj->GetObjectbyproject($idProject, '3', 200);
    foreach ($messaLists as $messaList) {
        
        if ($messaList['is_read'] == 1) {
            $readunreadn = "read";
        } else {
            $readunreadn = "unread";
        }
        
        
        echo "    <tr>
                                                <td class='center'>
                                                <div class='checkbox-table'>
                                                    <label>
                                                        <input type='checkbox' class='flat-grey'>
                                                    </label>
                                                </div></td>
                                                <td class='center'><img src='assets/images/message.png' alt='image'/></td>
                                                <td><div class='ico-$readunreadn' title='$readunreadn'>&nbsp;&nbsp;&nbsp;</div></td>
                                                <td  ><a href='panel.php?module=projectDetail&id=$messaList[id]' target=_blank>$messaList[name]</a></td>
                                                
                                                <td class='hidden-xs'><a href='panel.php?module=profile&id=$messaList[updated_by_id]'>$messaList[nama]</a>, on $messaList[updated_on]</td>
                                                
                                                
                                            </tr>";
        
    }
    
    echo "
                                        </tbody>
                                    </table><script> generatedTable(12);</script>";
    
    
}

function commentobj($obj, $user_id)
{
    
    $act = $_POST['act'];
    
    $message     = $_POST['message'];
    $objctnumber = $_POST['objctnumber'];
    
    if ($act == "add") {
        
        
        $obj->insertComent($objctnumber, $message, $user_id);
        
        
        
    }
    
    
    //nilai balik
    echo "<ol class='discussion'>";
    
    $listcommens = $obj->getcommentbyobj($objctnumber);
    $n           = 1;
    foreach ($listcommens as $listcommen) {
        if ($n % 2) {
            $classs = "other";
        } else {
            $classs = "self";
        }
        echo "
                                                <li class='$classs'>
                                                    <div class='avatar'>
                                                        <img width='50px' alt='' src='" . "../" . $listcommen['path'] . "'>
                                                    </div>
                                                    <div class='messages'>
                                                        <p>
                                                            $listcommen[text]
                                                        </p>
                                                        <span class='time'><small>Posted on " . date("d/m/Y H:i", strtotime($listcommen['created_on'])) . " by  <a href:'' >$listcommen[nama]</a></small></span>
                                                    </div>
                                                </li>";
        $n++;
    }
    
    
    echo "</ol>";
    
    
    
    
    //send notification to subscriber
    
    $obj->sendNotificationAndEmail($objctnumber, $user_id, "comment", $message);
    
}
function updatefile($obj, $user_id)
{
    $act             = $_POST['act'];
    $comment         = $_POST['comment'];
    $idobject        = $_POST['idobject'];
    $idProject       = $_POST['idKegiatansnnn'];
    $filenameerename = $_POST['filenamee'];
    $cekbook         = $_POST['c1'];
    
    if ($act == "update") {
        
        //get folder 
        $idrelateds = $obj->GetCorelationname($idobject);
        foreach ($idrelateds as $idrelated) {
            $foldername = $idrelated['relatedobjectid'];
        }
        
        $dir_dest = "../data/" . $foldername . "/document";
        
        $handle = new uploadd($_FILES['fileupdate']);
        
        $mimefile = $_FILES['fileupdate']["type"];
        $filesize = $_FILES['fileupdate']["size"];
        
        $filename       = $_FILES['fileupdate']["name"];
        $ext            = pathinfo($filename, PATHINFO_EXTENSION);
        $tipeFileid     = $obj->getTipeFilebyExt($ext);
        $numberREvision = $obj->getNumberfilelastrevision($idobject);
        $numberREvision = $numberREvision + 1;
        
        if ($tipeFileid == "") {
            $tipeFileid = 29;
        }
        //echo $filename . "saaaaaaaaaaaaaaa";
        // then we check if the file has been uploaded properly
        // in its *temporary* location in the server (often, it is /tmp)
        if ($handle->uploadd) {
            
            //$handle->allowed = array('image/*');
            $nameRandom                 = getRandomFilename();
            $handle->file_new_name_body = $nameRandom;
            
            $handle->Process($dir_dest);
            
            // we check if everything went OK
            if ($handle->processed) {
                
                //update name baru
                $obj->updateObjectNama($filenameerename, $idobject);
                //update database
                $obj->updateFileDatabase($idobject, $user_id, $tipeFileid, $dir_dest . '/' . $handle->file_dst_name, $numberREvision, $comment, $mimefile, $filesize, $idProject);
                echo "<script>location.reload();</script>";
            } else {
                
                echo '  Error: ' . $handle->error . '';
                
            }
            
        } else {
            echo '  Error: ' . $handle->error . '';
            
        }
        
        
        
    } elseif ($act == "updatecommentfile") {
        $idobject = $_POST['objectFile'];
        
        $filecommentt = $_POST['filecommentt'];
        $objectFile   = $_POST['objectid'];
        
        //echo $idobject . "ssssssss" . $filecommentt ;
        $sapi = $obj->updateComentfilere($filecommentt, $objectFile);
        //insertlogsAplikasi
        $obj->WriteLogAplicationLogs($user_id, $idobject, "revision comment", $user_id, "edit", 0, 0, $filecommentt);
        
        
        
    } elseif ($act == "updatename") {
        
        $obj->updateObjectNama($filenameerename, $idobject);
        $updated_on = date("Y-m-d H:i:s");
        $obj->updateObject($updated_on, $user_id, $idobject);
        //insertlogsAplikasi
        $obj->WriteLogAplicationLogs($user_id, $idobject, "file name", $user_id, "edit", 0, 0, $filenameerename);
        
        echo "<script> alert('done');</script>";
        
    } elseif ($act == "updateDocFile") {
        
        //get folder 
        $idrelateds = $obj->GetCorelationname($idobject);
        foreach ($idrelateds as $idrelated) {
            $foldername = $idrelated['relatedobjectid'];
        }
        
        $dir_dest = "../data/" . $foldername . "/document";
        $mimefile = "text/html";
        
        
        $ext            = $_POST['ext'];
        $stringdata     = $_POST['dataFile'];
        $tipeFileid     = $obj->getTipeFilebyExt($ext);
        $numberREvision = $obj->getNumberfilelastrevision($idobject);
        $numberREvision = $numberREvision + 1;
        
        if ($tipeFileid == "") {
            $tipeFileid = 29;
        }
        $nameRandom                 = getRandomFilename();
        $handle->file_new_name_body = $nameRandom;
        $dir_dest                   = $dir_dest . "/" . $nameRandom . "." . $ext;
        //write html
        $obj->WriteDoc($dir_dest, $stringdata);
        $filesize = filesize($dir_dest);
        
        $obj->updateFileDatabase($idobject, $user_id, $tipeFileid, $dir_dest, $numberREvision, $comment, $mimefile, $filesize, $idProject);
        
        
    } elseif ($act == "refreshMessagetext") {
        
        $listrevisions = $obj->Getfilerevison($idobject);
        
        foreach ($listrevisions as $listrevisions) {
            $lastlink = $listrevisions['repository_id'];
        }
        
        $textmessage = $obj->ReadDoc($lastlink);
        
        echo $textmessage;
        
    }
    
    if ($act != "refreshMessagetext") {
        //nilai balik
        $listrevisions = $obj->Getfilerevison($idobject);
        //listrevision    
        $coloor        = "background-color:#FFD39F";
        foreach ($listrevisions as $listrevisions) {
            
            $Docsize  = formatSizeUnits($listrevisions['filesize']);
            $updateOn = date("d/m/Y H:i", strtotime($listrevisions['updated_on']));
            $mimeFile = $listrevisions['type_string'];
            
            $listREvisionn = $listREvisionn . "<tr>
        <td rowspan='2' class='number' style='$coloor'>
        <a target='_self' class='downloadLink' href='$listrevisions[repository_id]' title='Download ($Docsize)'>
        <span style='font-size:12px'>#</span>$listrevisions[revision_number]</a>
        </td>
        <td class='line_header' style='background-color:#FFD39F;'><b><a target='overview-panel' class='internalLink' href=''>$listrevisions[nama]</a></b> on $updateOn</td>
        <td class='line_header_icons' style='background-color:#FFD39F;width:50px;'>
        <a target='_self' class='downloadLink coViewAction ico-download' href='$listrevisions[repository_id]' title='Download ($Docsize)'>&nbsp;</a>
        <a target='overview-panel' onclick='movetotrash($listrevisions[id])' href='#' class='internalLink coViewAction ico-trash' title='Move to trash'>&nbsp;</a>
        </td></tr>
        <tr><td class='line_comments'><div style='padding:2px;padding-left:6px;padding-right:6px;min-height:24px;'>
        $listrevisions[comment]&nbsp;</div>
        </td>
        <td class='line_comments_icons'>
        <a target='overview-panel' href='#changeInitialname' data-toggle='modal' class='internalLink coViewAction ico-edit' title='Edit revision comment' onClick='setobjectidcomenfile($listrevisions[id]) ;'>&nbsp;</a>
        </td>
        </tr>

    ";
            
            $revisionnumber = $listrevisions['revision_number'];
            $windowsString  = "Last revision:Revision #" . $revisionnumber . " (by" . $listrevisions['nama'] . " on " . date("F j, Y, g:i a", strtotime($listrevisions['updated_on'])) . ")";
            $coloor         = "background-color:#EEE";
        }
        
        echo "                    
<fieldset>
 <legenda id='legenda' class='toggle_collapse' onclick='sliderevision();'>Revisions ( $revisionnumber )</legenda>
<div id='og_1410866239_313568revisions'>
<table class='revisions'>
    <tbody>
$listREvisionn 
    
</tbody></table>
</div>
</fieldset>";
        
        $obj->sendNotificationAndEmail($idobject, $user_id, "file", $comment);
    }
}

function updateSubscriber($obj, $user_id)
{
    $objctnumber       = $_POST['objctnumber'];
    $particpanTraining = $_POST['particpanTraining'];
    
    $obj->dellSubscriberbyobjt($objctnumber);
    
    $subscribers = substr($particpanTraining, 1); // hilangkan , dalam huruf pertama
    $pieces      = explode(",", $subscribers);
    $pieces      = array_unique($pieces);
    
    //insert tbl subscriber
    
    foreach ($pieces as $piece) {
        
        $obj->addSubcriber($objctnumber, $piece);
        
    }
    //insertlogsAplikasi
    $obj->WriteLogAplicationLogs($user_id, $objctnumber, $subscribers, $user_id, "subscribe", 0, 0, "");
    
    $created_on      = date("Y-m-d H:i:s");
    $listSubscribers = $obj->getSubcriber($objctnumber);
    foreach ($listSubscribers as $listSubscriber) {
        
        $subcriber = $subcriber . "<li><a href=''>$listSubscriber[nama]</a></li>";
        
        $obj->InsertNotftable($listSubscriber['contact_id'], $objctnumber, 0, $created_on, "panel.php?module=projectDetail&id=" . $objctnumber, 2, "add");
        
        //send notification email
    }
    echo $subcriber;
    
}

function Trash_obj($obj, $user_id)
{
    
    $objctnumber = $_POST['objectid'];
    
    
    
    $obj->movetrashObject($user_id, $objctnumber);
    
    //insertlogsAplikasi
    $obj->WriteLogAplicationLogs($user_id, $objctnumber, "", $user_id, "trash", 0, 0, "");
    
    //nilai balik
    $nameRelated = $obj->GetCorelationname($objctnumber);
    foreach ($nameRelated as $namedsd) {
        
        $projectID = $namedsd['object_id'];
    }
    echo "<script type='text/javascript'>
<!--
window.location = 'panel.php?module=projectMod&idproj=$projectID'
//-->
</script>";
    
    
    //
    
}

function taskobj($obj, $user_id, $alluserArray)
{
    
    $tasktitle     = $_POST['tasktitle'];
    $starttask     = $_POST['starttask'];
    $endtask       = $_POST['endtask'];
    $asigmentto    = $_POST['asigmentto'];
    $listsubcriber = $_POST['listsubcriber'];
    $pesan         = $_POST['pesan'];
    $act           = $_POST['act'];
    $corelation    = $_POST['projectid'];
    $starttask     = date('Y-m-d H:i:s', strtotime($starttask));
    $endtask       = date('Y-m-d H:i:s', strtotime($endtask));
    
    
    if (isset($act) && !empty($act)) {
        
    } else {
        $stringCommand = $_POST['stringCommand'];
        $pieces        = explode("#", $stringCommand);
        $act           = $pieces[0];
        $corelation    = $pieces[1];
        $tipe          = $pieces[2];
    }
    
    if ($act == "add") {
        
        if ($listsubcriber == "") {
            $listsubcriber = "," . $user_id;
        }
        
        if ($user_id != $asigmentto) {
            $listsubcriber = $listsubcriber . "," . $asigmentto . "," . $user_id; //tambai auto subscriber yang ngepo
        }
        
        
        
        $obj->addTaskobj(5, $tasktitle, $user_id, $corelation, 0, $pesan, $endtask, $starttask, $asigmentto, $listsubcriber);
        $act = "refreshlist";
        
        
    } elseif ($act == "progress") {
        
        $objectid       = $_POST['objectid'];
        $idprogresstask = $_POST['idprogresstask'];
        
        $obj->updateprogressTaskobj($user_id, $idprogresstask, $objectid);
        
        
        //nilai balik
        if ($idprogresstask >= 100) {
            $progressString = "<span class='label label-sm label-success'>Complete 100% </span>";
        } else {
            $progressString = "<span class='label label-sm label-danger'>incomplete  " . $idprogresstask . "% </span>";
        }
        
        $windowsString = $progressString;
        
        echo $windowsString;
        
    } elseif ($act == "addExpress") {
        
        if ($listsubcriber == "") {
            $listsubcriber = "," . $user_id;
        }

        if ($user_id != $asigmentto) {
            $listsubcriber = $listsubcriber . "," . $asigmentto;
        }

        $starttask = date('Y-m-d H:i:s');
        
        $obj->addTaskobj(5, $tasktitle, $user_id, $corelation, 0, "", $endtask, $starttask, $asigmentto, $listsubcriber);
        
        //nilaibalik express
        
        echo "<table class='table table-condensed table-hover' id='sample-table-3'>
                                                        <thead>
                                                            <tr>
                                                                
                                                                <th>Time</th>
                                                                
                                                                <th> Task </th>
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody>";
        
        $taskundone = $obj->gettaskbyProjectUndone($corelation, 25);
        foreach ($taskundone as $taskundon) {
            $dayLates = styleTaskObj($taskundon['due_date']);
            echo "<tr>

                                                                <td>
                                                                $dayLates
                                                                </td>

                                                                <td ><a href='panel.php?module=projectDetail&id=$taskundon[object_id]'><strong>$taskundon[nama]: </strong> $taskundon[name]</a></td>
                                                            </tr>";
            
        }
        
        echo "
                                                            
                                                        </tbody>
                                                    </table>";
        
        
    }
    
    //nilai balik
    if ($act == "refreshlist") {
        echo "
                                    <table class='table table-striped table-bordered table-hover' id='sample_15'>
                                        <thead>
                                            <tr>
                                                <th class='center' width='16px' >
                                                <div class='checkbox-table'>
                                                    <label>
                                                        <input type='checkbox' class='flat-grey'>
                                                    </label>
                                                </div></th>
                                                
                                                <th class='hidden-xs' width='16px' ></th>
                                                <th>Name</th>
                                                <th>Assign to</th>
                                                <th>By</th>
                                                <th class='hidden-xs' >Prog %</th>
                                                <th>Prog.</th>
                                                <th>status.</th>

                                                
                                                <th class='hidden-xs' width='300px' ></th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>";
        
        $TaskLists = $obj->GetObjectbyproject($corelation, '5', 500,$tipe);
        
        foreach ($TaskLists as $TaskList) {
            
            if ($TaskList['is_read'] == 1) {
                $readunread = "read";
            } else {
                $readunread = "unread";
            }
            
            $idassigment = $TaskList['assigned_to_contact_id'];
            $idassigmentby = $TaskList['assigned_by_id'];
            $taskStart   = date("M d , Y", strtotime($TaskList['start_date']));
            $taskEnd     = date("M d , Y", strtotime($TaskList['due_date']));
            
            if ($TaskList['percent_completed'] == 100) {
                $styletambahan = "style='opacity: 0.25; text-decoration: line-through;'";
                $taskEnd       = Getbadge($taskEnd, 1);
                $status="Complete";
            } else {
                
                $styletambahan = "";
                $taskEnd       = Getbadge($taskEnd, 0);
                $status="Onprogress";
            }
            
            
            echo "    <tr $styletambahan>
                                                <td class='center'>
                                                <div class='checkbox-table'>
                                                    <label>
                                                        <input type='checkbox' class='flat-grey'>
                                                    </label>
                                                </div></td>
                                                
                                                <td class='hidden-xs'><div class='ico-$readunread' title='$readunread'>&nbsp;&nbsp;&nbsp;</div></td>
                                                <td ><a href='panel.php?module=projectDetail&id=$TaskList[id]' target=_blank><strong>$alluserArray[$idassigment] </strong>: $TaskList[name]</a></td>
                                                <td>$alluserArray[$idassigment]</td>
                                                <td>$alluserArray[$idassigmentby]</td>
                                                <td class='hidden-xs'>
                                                <div class='progress  active progress-sm'>
                                                        <div style='width: $TaskList[percent_completed]%' aria-valuemax='100' aria-valuemin='0' aria-valuenow='$TaskList[percent_completed]' role='progressbar' class='progress-bar '>
                                                            <span class='sr-only'> $TaskList[percent_completed]% Complete (danger)</span>
                                                        </div>
                                                    </div>
                                                
                                                </td>
                                                <td>$TaskList[percent_completed]</td>
                                                <td>$status</td>
                                                
                                                
                                                <td class='hidden-xs'>Start: $taskStart | due : $taskEnd</td>
                                                
                                            </tr>";
            
        }
        
        
        echo "    </tbody>
                                    </table><script> generatedTable(15);</script>
                                    ";
        
    }
    //end nilai balik
    
    
    
}

function activyProj($obj, $user_id, $alluserArray)
{
    
    $lastmsg = $_POST['activity'];
    
    $aktivitys = $Activity->get_activity2($lastmsg);
    
    
    $emboh = $Activity->get_number_activity($lastmsg);
    
    
    // cek bila sudah habiss
    if ($emboh != 0) {

        foreach ($aktivitys as $aktivity) {
            
            $sesuaiformat = $Activity->format_tanggal($aktivity['date_hour']);
            
            echo "<div title='$aktivity[nick]' class='friends_area'><img src='$aktivity[path]' height='65' style='float:left;' alt=''> 
                    <label style='float:left' class='name'>
                               <b>$aktivity[nick] </b>
                               <br> 
                                    <span class='aktifitas'> $aktivity[name_activity] </span> 
                                    <b>
                                    <span style='padding: 4px 10 30px 18px; width:30' class='db-ico ico-$aktivity[icon]'></span> 
                                    <a class='terusan-$aktivity[icon]' style='font-weight:bold;' href='$aktivity[link]'> $aktivity[object] </a>
                                    </b>
                                    <span class='tanggalfeed'>$sesuaiformat </span>
                               </br>
                            
                    </label>
                </div>";
            
            
        }
        
        
        
        echo "<p><div id='more'><a  id='$aktivity[id]' class='load_more' href='#'>more</a>  </div>";
    } else {
        
        echo "<p><div id='more'><a  id='end' class='load_more' href='#'>no more post</a>  </div>";
        
    }
    
    
}

function notification($obj, $user_id, $alluserArray)
{
    $act = $_POST['act'];
    
    if ($act == "refreshNotifi") {
        
        $listnotefications = $obj->getNotifiObj($user_id);
        $getJumlahNotify   = $obj->getNotifiObjJml($user_id);
        
        echo "<li>
                                    <span class='dropdown-menu-title'> You have  $getJumlahNotify  notifications</span>
                                </li>
                                <li>
                                    <div class='drop-down-wrapper'>
                                        <ul>";
        
        
        $randomLabel = array(
            'label-success',
            'label-primary',
            'label-warning',
            'label-danger'
        );
        
        foreach ($listnotefications as $listnotefication) {
            $timeago           = TimeAgo($listnotefication['created_on']);
            $timeago           = str_replace("ago", "", $timeago);
            $noTogel           = rand(0, 3);
            $stringLabelRandom = $randomLabel[$noTogel];
            $linkNotify        = "onclick='location.href = &#39;$listnotefication[link] &#39; ;'";
            echo "<li>
                                                <a href='javascript:void(0)' $linkNotify >
                                                    <span class='label $stringLabelRandom'><i class='fa $listnotefication[class]'></i></span>
                                                    <span class='message'>New $listnotefication[nama] has been $listnotefication[action]ed</span>
                                                    <span class='time'>$timeago</span>
                                                </a>
                                            </li>";
            
        }
        echo "
                                        
                                        </ul>
                                    </div>
                                </li>
";
        
    } elseif ($act == "refreshbadgeNotifi") {
        
        $getJumlahNotify = $obj->getNotifiObjJml($user_id);
        if ($getJumlahNotify != 0) {
            echo "<span class='badge'> $getJumlahNotify</span>";
            echo "<script> $('#chatAudio')[0].play();</script>";
        }
        
        
        
    }
    
    
    
}

function message($obj, $user_id, $alluserArray, $Activity)
{
    date_default_timezone_set('Asia/Jakarta');
    $act   = $_POST['act'];
    $mid   = $_POST['mid'];
    $body  = $_POST['body'];
    $uidss = $_POST['uids'];
    if ($act == "show") {
        
        $listmeesage = $obj->ShowmessgaeMid($mid, $user_id);
        
        foreach ($listmeesage as $listcommen) {
            
            $userlist = $userlist . "," . $listcommen['created_by'];
            
        }
        
        $piece = explode(",", $userlist);
        $piece = array_unique($piece);
        
        foreach ($piece as $piec) {
            if ($piec != "") {
                $Convertionbetween = $Convertionbetween . ", " . $alluserArray[$piec];
            }
        }
        $tanggalsekarang   = date(" d M Y, H:i A");
        $Convertionbetween = substr($Convertionbetween, 1);
        
        
        echo "<div class='messages-content'>
                                        <div class='message-header'>
                                            <div class='message-time'>
                                                $tanggalsekarang
                                            </div>
                                            <div class='message-from'>
                                                Conversation between
                                            </div>
                                            <div class='message-to'>
                                                $Convertionbetween
                                            </div>
                                            <div class='message-subject'>
                                                Message Content
                                            </div>
                                            <div class='message-actions'>
                                                <a title='Move to trash' href='' onclick='deletedMessage($mid);'><i class='fa fa-trash-o'></i></a>
                                            </div>
                                        </div>
                                        <div class='message-content'>
                                            <div class='panel-body panel-scroll' style='height:420px'>
                                            <ol class='discussion'>";
        
        
        
        
        
        $n = 1;
        foreach ($listmeesage as $listcommen) {
            if ($n % 2) {
                $classs = "other";
            } else {
                $classs = "self";
            }
            $namaUser = $alluserArray[$listcommen['created_by']];
            echo "
                                                <li class='$classs'>
                                                    <div class='avatar'>
                                                        <img width='50px' alt='' src='" . "../" . $listcommen['path'] . "'>
                                                    </div>
                                                    <div class='messages'>
                                                        <p>
                                                            $listcommen[body]
                                                        </p>
                                                        <span class='time'><small>Posted on " . date("d/m/Y H:i", strtotime($listcommen['created_on'])) . " by  <a href:'' >$namaUser</a></small></span>
                                                    </div>
                                                </li>";
            $n++;
        }
        
        
        
        echo "</div>
                                            </ol>
                                        
                                    </div>
                                    <div class='col-sm-12'>
                                    <div class='chat-form'>
                                        <div class='input-group'>
                                            <input type='textarea' id='textreplay' class='form-control input-mask-date' placeholder='Type a message here...'>
                                            <span class='input-group-btn'>
                                                <button class='btn btn-teal' type='button' onClick='ReplayMessgae($mid);' >
                                                    <i class='fa fa-check'></i>
                                                </button> </span>
                                        </div>
                                    </div>
                                </div>
                                        ";
        echo "<script>
            
             if ($('.panel-scroll').length) {
            $('.panel-scroll').perfectScrollbar({
                wheelSpeed: 50,
                minScrollbarLength: 20,
                suppressScrollX: true
            });
        }
            
    document.getElementById('textreplay').addEventListener('keydown', function(e) {
    if (!e) { var e = window.event; }
  

    // Enter is pressed
    if (e.keyCode == 13) { ReplayMessgae($mid); }
    }, false);
            
            </script>";
        
        
        
        //set read
        $obj->updateMessageview($mid, $user_id);
        
    } elseif ($act == "replay") {
        
        
        $obj->PostMessage($mid, $body, 0, $user_id);
        
        echo "<script>Showmmessagee($mid);</script>";
        
        
        
    } elseif ($act == "deleted") {
        
        $obj->DeleteMessage($mid, $user_id);
        
        echo "<script> window.location.href= 'panel.php?module=message' ;</script>";
        
    } elseif ($act == "postMessage") {
        
        $uidss = substr($uidss, 1); // hilangkan , dalam huruf pertama
        
        $obj->PostMessage(0, $body, $uidss, $user_id);
        $pecahans = explode(",", $uidss);
        foreach ($pecahans as $pecahan) {
            
            if ($pecahan != $user_id) {
                $usernya = $usernya . "," . $alluserArray[$pecahan];
            }
            
        }
        $usernya = substr($usernya, 1); // hilangkan , dalam huruf pertama
        
        $Activity->Insert_activity(6, $user_id, " to user " . $usernya, './panel.php?module=message&sub=inbox');
        
        echo "<script> window.location.href= 'panel.php?module=message' ;</script>";
        
    }
    
    
    
    
}

function makearchip($obj, $user_id, $alluserArray)
{
    
    $listfileass     = $_POST['testring'];
    $namaCompression = $_POST['nama'];
    $listfileass     = substr($listfileass, 1); // hilangkan , dalam huruf pertama
    
    
    $obj->CreateCompression($listfileass, $namaCompression);
    //nilai balik
    echo "<script type='text/javascript'>

window.open('$namaCompression');

</script>";
    
}

function meeting($obj, $user_id, $alluserArray, $rms, $drawing)
{
    $act    = $_POST['act'];
    $sumary = htmlentities($_POST['subject']);
    
    $schedule  = $_POST['scheduleTraining'];
    $idProject = $_POST['idproj'];
    
    $projectID      = $idProject;
    $partisipant    = $_POST['particpanTraining'];
    //$partisipant= ltrim ($partisipant, ',');
    $partisipant    = $obj->getTeamMember($idProject);
    $partisipant    = ltrim($partisipant, ',');
    $location       = $_POST['locationTraining'];
    $description    = $_POST['descriptionTraining'];
    $external_email = $_POST['emailExternal'];
    $hasil_rapat    = "null";
    
    if (isset($act) && !empty($act)) {
        
    } else {
        $stringCommand = $_POST['stringCommand'];
        $pieces        = explode("#", $stringCommand);
        $act           = $pieces[0];
        $idProject     = $pieces[1];
    }
    
    if ($act == "add") {
        
        $pieces       = explode("-", $schedule);
        $tanggalStart = date("Y-m-d H:i:s", strtotime($pieces[0]));
        $tanggalEnd   = date("Y-m-d H:i:s", strtotime($pieces[1]));
        $waktu        = date("H:i:s", strtotime($pieces[0])) . " - Selesai";
        $formEmail    = $obj->Get_email_id($user_id);
        
        $obj->createEventCalenderEmail($formEmail, $partisipant, $description, $location, $tanggalStart, $tanggalEnd, $sumary, $external_email);
        
        $rms->insert_minute_meeting($tanggalStart, $sumary, $waktu, $hasil_rapat, $idProject, $partisipant, $location, 1, $external_email);
        
        
    } elseif ($act == "del") {
        
        $id_minutes = $_POST['id'];
        $rms->delete_minute_meeting($id_minutes);
        
    } elseif ($act == "uploadmom") {
        
        $id_kon     = $_POST['idproj'];
        $id_minutes = $_POST['idmom'];
        
        $randomname = getRandomFilename() . ".pdf";
        $alamat     = "../data/" . $id_kon . "/";
        if (!is_dir($alamat)) {
            mkdir($alamat, 0700);
        }
        if ($_FILES["file"]["error"] != 4) { //jika adafile di upload 
            if ($drawing->uploadfilePDF($_FILES["uploadAttacmentMOM"]["tmp_name"], $randomname, $alamat, "noencript")) {
                $file = $alamat . $randomname;
                
                $rms->update_FileMOM($file, $id_minutes); //update file mom 
                //insertlogsAplikasi
                $obj->WriteLogAplicationLogs($user_id, $id_kon, "upload file mom", $user_id, "", 0, 0, "" . $file);
                $act = "refreshreport";
            } else {
                $file = "none";
                $rms->update_FileMOM($file, $id_minutes); //update file mom
                //insertlogsAplikasi
                $obj->WriteLogAplicationLogs($user_id, $id_kon, "upload file mom", $user_id, "", 0, 0, "tanpa ATTACHMENTS" . $file);
                $act = "refreshreport";
            }
        }
        
        //echo "sapi";
        $datamunit = $rms->get_minute_meeting_id($id_kon, $id_minutes);
        
        foreach ($datamunit as $datamuni) {
            $filelink = $datamuni['file'];
        }
        
        echo "<a href='$filelink' target=_blank >ATTACHMENTS</a>";
        
        die;
        
    } elseif ($act == "update") {
        
        $idproject   = $_POST['idproj'];
        $id_mom      = $_POST['idmom'];
        $hasil_rapat = $_POST['descriptionTraining'];
        
        //echo  "jancuk" .$id_mom . $hasil_rapat ;
        
        $rms->update_minute_meeting($hasil_rapat, $id_mom);
        
        //nilai refresh
        echo "<script type='text/javascript'>

                $(document).ready(function () {
                    
                    
                window.location.reload();

                    

                });
        </script>";
        
        die;
    } elseif ($act == "addpeople") {
        
        $idproject  = $_POST['idproj'];
        $id_minutes = $_POST['idmom'];
        $idUserr    = $_POST['idUserr'];
        
        
        $data_rapats = $rms->get_minute_meeting_id($idproject, $id_minutes);
        
        foreach ($data_rapats as $data_rapat) {
            $kehadiran = $data_rapat['kehadiran'];
        }
        $kehadiran = $kehadiran . "," . $idUserr;
        $rms->update_person_meeting($kehadiran, $id_minutes);
        
        
        //nilaibalik
        $data_rapats = $rms->get_minute_meeting_id($idproject, $id_minutes);
        
        foreach ($data_rapats as $data_rapat) {
            $kehadiran = $data_rapat['kehadiran'];
        }
        
        echo "
                                    <table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
                                        <thead>
                                            <tr>
                                                <th > No</th>
                                                <th > Name</th>

                                                <th class='center' > Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>";
        $n = 1;
        
        $pieces = explode(",", $kehadiran);
        
        foreach ($pieces as $DocumentList) {
            
            //$nama
            
            echo " <tr>
                                                <td>$n</td>
                                                <td> $alluserArray[$DocumentList]</td>
                                                <td  class='center' >
                                                <div class='visible-md visible-lg hidden-sm hidden-xs'>
                                                    <a onClick='delpeople($idproject,$id_minutes,$DocumentList)' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
                                                </div>
                                                </td>
                                                
                                            </tr>";
            
            $n++;
        }
        
        echo "    
                                            </tr>
                                        </tbody>
                                        </table>";
        
        exit;
    } elseif ($act == "dellpeople") {
        
        $idproject  = $_POST['idproj'];
        $id_minutes = $_POST['idmom'];
        $idUserr    = $_POST['idUserr'];
        
        
        $data_rapats = $rms->get_minute_meeting_id($idproject, $id_minutes);
        
        foreach ($data_rapats as $data_rapat) {
            $kehadiran = $data_rapat['kehadiran'];
        }
        
        $kehadiran = str_replace("," . $idUserr, "", $kehadiran);
        $kehadiran = str_replace($idUserr, "", $kehadiran);
        $kehadiran = ltrim($kehadiran, ',');
        $rms->update_person_meeting($kehadiran, $id_minutes);
        
        
        //nilaibalik
        $data_rapats = $rms->get_minute_meeting_id($idproject, $id_minutes);
        
        foreach ($data_rapats as $data_rapat) {
            $kehadiran = $data_rapat['kehadiran'];
        }
        
        echo "
                                    <table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
                                        <thead>
                                            <tr>
                                                <th > No</th>
                                                <th > Name</th>

                                                <th class='center' > Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>";
        $n = 1;
        
        $pieces = explode(",", $kehadiran);
        
        foreach ($pieces as $DocumentList) {
            
            //$nama
            
            echo " <tr>
                                                <td>$n</td>
                                                <td> $alluserArray[$DocumentList]</td>
                                                <td  class='center' >
                                                <div class='visible-md visible-lg hidden-sm hidden-xs'>
                                                    <a onClick='delpeople($idproject,$id_minutes,$DocumentList)' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
                                                </div>
                                                </td>
                                                
                                            </tr>";
            
            $n++;
        }
        
        echo "    
                                            </tr>
                                        </tbody>
                                        </table>";
        
        exit;
    }
    
    
    
    
    
    //nilai balik
    echo "
                                    <table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
                                        <thead>
                                            <tr>
                                                <th > ID</th>
                                                <th > Date</th>
                                                <th > Agenda</th>
                                                <th class='center'> Action</th>


                                            </tr>
                                        </thead>
                                        <tbody>";
    $get_minutes = $rms->get_minute_meeting($idProject, 1);
    
    $no = 1;
    
    foreach ($get_minutes as $get_minute) {
        $nama_kehadiran = $rms->Parse_name_member_meeting($get_minute['kehadiran']);
        $nama_kehadiran = substr($nama_kehadiran, 2);
        
        
        echo " <tr>
                                                <td>$no</td>
                                    <td title='$nama_kehadiran'>" . $get_minute['tanggal'] . "</a></td>
                                    <td> " . $get_minute['agenda'] . "</td>
                                    <td class='center' ><a  onclick='dellMeeting(" . $get_minute['id'] . "," . $idProject . ");'>Dell <a href='panel.php?module=meeting&idproj=$idProject&idmom=$get_minute[id]' target=_blank> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; view <a href='../rules_sup/print_notulen.php?mom=" . $get_minute['id'] . "&cek_po=" . $idProject . "'  " . "target='_blank'" . "> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Print <a href='../rules_sup/print_notulen.php?mom=" . $get_minute['id'] . "&cek_po=" . $idProject . "&broadcast=yes'  " . "target='_blank'" . "> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Broadcast </td></td>
                                    
                                    </tr>";
        
        $n++;
    }
    
    
    echo "    
                                        </tbody>
                                    </table>";
    
    
}

function planPeriode($kpi, $user_id, $alluserArray)
{
    
    $stringCommand = $_POST['stringCommand'];
    $pieces        = explode("#", $stringCommand);
    
    
    $act = $pieces[0];
    
    
    if ($act == "add") {
        $start = $pieces[1];
        $end   = $pieces[2];
        
        $kpi->InsertPlanperiode($start, $end, $user_id);
        
    } elseif ($act == "del") {
        $id = $pieces[1];
        $kpi->DelPlanPeriode($id);
        
    } elseif ($act == "setOn") {
        $id = $pieces[1];
        $kpi->setOnplanPeriode($id);
    }
    
    //nilai balik
    echo "        
                                <table class='table table-striped table-bordered table-hover' id='projects'>
                                            <thead>
                                                <tr>
                                                    <th class='center'>Periode
                                                    </th>

                                                    <th class='center'>By    </th>
                                                    
                                                    <th class='center'>Status</th>
                                                    <th></th>
                                                    

                                                </tr>
                                            </thead>";
    $planbudgetlists = $kpi->GetPlanperiode();
    
    foreach ($planbudgetlists as $projectlist) {
        
        $tanggalstart   = date("d M Y", strtotime($projectlist['start']));
        $tanggalselesai = date("d M Y", strtotime($projectlist['end']));
        
        $oleh = $alluserArray[$projectlist['by']];
        
        if ($projectlist['status'] == 1) {
            
            $status = "On";
            
        } else {
            
            $status = "Off";
        }
        
        echo "
                                            
                                            <tbody>
                                                <tr>

                                                    <td class='center' >$tanggalstart until $tanggalselesai </td>
                                                    <td class='center' > $oleh</td>
                                                    <td class='center' > $status</td>
                                                    <td class='center'>
                                                    <a href='#' onclick='SetOnPlanPeriode($projectlist[id]);' class='btn btn-xs btn-green tooltips' data-placement='top' data-original-title='Set On'><i class='fa fa-share'></i></a>
                                                    <a href='#' onclick='DellPlanperiode($projectlist[id]);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
                                                </td>
                                                </tr>";
        
    }
    
    echo "        
                                            
                                        </tbody></table>";
    
    
    
    
    echo "<script>
            jQuery(document).ready(function() {

                TableData.init();
            });
        </script>";
    
    
}

function inserbudguet($kpi, $user_id, $alluserArray, $namakegiatan, $Activity)
{
    //get input
    $stringCommand = $_POST['stringCommand'];
    $pieces        = explode("#", $stringCommand);
    
    $act = $pieces[0];
    
    if ($act == "add") {
        $trainingname      = htmlentities($pieces[1]);
        $tipeTraining      = $pieces[2];
        $typeEvent         = $pieces[3];
        $schedule          = $pieces[4];
        $partisipant       = $pieces[5];
        $location          = $pieces[6];
        $country           = $pieces[7];
        $description       = $_POST['richtext1'];
        $anggaran          = str_replace(",", "", $pieces[8]);
        $typekurs          = $pieces[9];
        $perkiraanExchange = str_replace(",", "", $pieces[10]);
        $negara            = $country;
        
        $periode = $kpi->GetActivePlanPeriode();
        
        if ($typekurs != 1) {
            
            $total = $anggaran * $perkiraanExchange;
            
        } else {
            
            $total = $anggaran;
            
        }
        
        
        
        $piecees      = explode("-", $schedule);
        $tanggalStart = date("Y-m-d H:i:s", strtotime($piecees[0]));
        $tanggalEnd   = date("Y-m-d H:i:s", strtotime($piecees[1]));
        if ($realization != "") {
            $pieces2        = explode("-", $realization);
            $realisasiStart = date("Y-m-d H:i:s", strtotime($pieces2[0]));
            $realisasiEnd   = date("Y-m-d H:i:s", strtotime($pieces2[1]));
            $status         = 1;
        } else {
            $realisasiStart = "0000-00-00 00:00:00";
            $realisasiEnd   = "0000-00-00 00:00:00";
            $status         = 0;
        }
        
        
        //cek if picture underdatabase
        if (CekImageDatabase($description) == true) {
            
            $paterrn = 'src="data:image/jpeg;base64';
            
            $description = str_replace($paterrn, "style=\"width:100%\" src=\"data:image/jpeg;base64", $description);
            
        }
        
        
        $kpi->InsertTraining($tanggalStart, $tanggalEnd, $trainingname, $tipeTraining, $realisasiStart, $realisasiEnd, $partisipant, $user_id, $description, $location, $status, "", $typeEvent, $typekurs, $perkiraanExchange, $anggaran, $total, $periode, $negara);
        
    } elseif ($act == "del") {
        $idTraining = $pieces[1];
        $kpi->dellTrainingId($idTraining);
        
    }
    
    
    
    
    
    
    //nilai balik
    echo "
                                    <table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
                                        <thead>
                                            <tr>
                                                <th > ID</th>
                                                <th > Title</th>
                                                <th > Event</th>
                                                <th > Plan</th>
                                                <th > Participant</th>
                                                <th > Status</th>
                                                <th > Anggaran</th>
                                                <th class='center' width='100px'> Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>";
    $idperiode     = $kpi->GetActivePlanPeriode();
    $listTrainings = $kpi->getBudgetOf($idperiode);
    
    $n = 1;
    foreach ($listTrainings as $listTraining) {
        
        $peserta      = Extractusername($alluserArray, $listTraining[peserta]);
        $titlePeserta = $peserta;
        if (strlen($peserta) > 50) {
            
            $peserta = substr($peserta, 0, 50) . "..";
        }
        
        $label       = labelStyle($listTraining['status'], $listTraining['tanggalStart']);
        $tanggalPlan = date("d M Y", strtotime($listTraining['tanggalStart']));
        $nameEvent   = $namakegiatan[$listTraining['typeOfevent']];
        $anggaran    = "Rp " . number_format($listTraining['total'], 2, ',', '.');
        echo " <tr>
                                                <td>$n</td>
                                                <td title='$listTraining[description]' > <a href='panel.php?module=dEvent&id=$listTraining[id]' >  $listTraining[training]</a></td>
                                                <td>$nameEvent</td>
                                                <td>$tanggalPlan</td>
                                                <td title='$titlePeserta'>$peserta</td>
                                                <td title='held at : $listTraining[realisasiStart]'>$label</td>
                                                
                                                <td>$anggaran</td>
                                                <td class='center'>
                                                <div class='visible-md visible-lg hidden-sm hidden-xs'>
                                                
                                                    <a  onclick='dellPlan($listTraining[id]);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
                                                </div>
                                                
                                                
                                                
                                                </td>
                                                
                                            </tr>";
        
        $n++;
    }
    echo "    </tr>
                                        </tbody>
                                    </table>";
    
    
    echo "<script>
            jQuery(document).ready(function() {

                TableData.init();
            });
        </script>";
    
    
    
    
}

function inserbudguetInvest($kpi, $user_id, $alluserArray, $namakegiatan, $Activity)
{
    //get input
    $stringCommand = $_POST['stringCommand'];
    $pieces        = explode("#", $stringCommand);
    
    $act = $pieces[0];
    
    if ($act == "add") {
        $item     = $pieces[1];
        $type     = $pieces[2];
        $anggaran = str_replace(",", "", $pieces[3]);
        $Currency = $pieces[4];
        $kurs     = str_replace(",", "", $pieces[5]);
        
        if ($Currency != 1) {
            
            $total = $anggaran * $kurs;
            
        } else {
            
            $total = $anggaran;
            
        }
        
        $description = $_POST['richtext1'];
        $periode     = $kpi->GetActivePlanPeriode();
        $oleh        = $user_id;
        $realization = "0000-00-00";
        
        $kpi->InsertInvest($item, $type, $anggaran, $Currency, $kurs, $total, $description, $periode, $oleh, $realization);
        
    } elseif ($act == "del") {
        
        $idTraining = $pieces[1];
        $kpi->DelInvest($idTraining);
        
    }
    
    //nilai balik    
    echo "
                                    <table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>
                                        <thead>
                                            <tr>
                                                <th > ID</th>
                                                <th > Item</th>
                                                <th > Type </th>
                                                <th > anggaran</th>
                                                <th > Status</th>
                                                <th > By</th>
                                                <th width='100px' class='center' > Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>";
    
    $idperiode     = $kpi->GetActivePlanPeriode();
    $listTrainings = $kpi->getInvestation($idperiode);
    
    $n = 1;
    foreach ($listTrainings as $listTraining) {
        
        $peserta = $alluserArray[$listTraining['oleh']];
        ;
        $titlePeserta = $peserta;
        if (strlen($peserta) > 50) {
            
            $peserta = substr($peserta, 0, 50) . "..";
        }
        
        $label       = labelStyle($listTraining['status'], $listTraining['tanggalStart']);
        $tanggalPlan = date("d M Y", strtotime($listTraining['tanggalStart']));
        
        if ($listTraining['type'] == 1) {
            $nameEvent = "Barang";
        } else {
            $nameEvent = "Jasa";
        }
        if ($listTraining['realization'] != "0000-00-00") {
            $status = "Complete";
        } else {
            $status = "Not yet";
        }
        
        echo " <tr>
                                                <td>$n</td>
                                                <td title='$listTraining[description]' >   $listTraining[item]</td>
                                                <td>$nameEvent</td>
                                                <td>$listTraining[total]</td>
                                                <td >$status</td>
                                                <td >$peserta</td>
                                                <td class='center'>
                                                <div class='visible-md visible-lg hidden-sm hidden-xs'>
                                                    <a  onclick='dellInvest($listTraining[id]);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
                                                </div>
                                                
                                                
                                                
                                                </td>
                                                
                                            </tr>";
        
        $n++;
    }
    echo "</tr>
                                        </tbody>
                                    </table>";
    
    echo "<script>
            jQuery(document).ready(function() {

                tableiNvest();
            });
        </script>";
}

function GetPeoplePlan($kpi, $user_id, $alluserArray, $namakegiatan)
{
    $stringCommand = $_POST['stringCommand'];
    $pieces        = explode("#", $stringCommand);
    
    $act = $pieces[0];
    
    $periode    = $kpi->GetActivePlanPeriode();
    $listTriyan = $kpi->GetPlanPerPerson($pieces[1], $periode);
    
    echo "<table class='table table-hover' id='sample-table-1'>
                                        <thead>
                                            <tr>
                                                <th class='center'>#</th>
                                                <th class='hidden-xs'>Event</th>
                                                <th >Type</th>
                                                
                                                <th >Rp.</th>
                                                <th class='center hidden-xs' >Status</th>
                                            </tr>
                                        </thead><tbody>";
    $n = 1;
    foreach ($listTriyan as $listTriya) {
        $nameEvent   = $namakegiatan[$listTriya['typeOfevent']];
        $tanggalPlan = date("d M Y", strtotime($listTriya['tanggalStart']));
        if ($listTriya['status'] == 1) {
            $status = "DN";
        } else {
            $status = "NY";
        }
        $money = $kpi->custom_number_format($listTriya['total']);
        
        echo "<tr>
                                                <td class='center'>$n</td>
                                                <td class='hidden-xs'>$listTriya[training]</td>
                                                <td>$nameEvent</td>
                                                
                                                <td >$money</td>
                                                <td class='center hidden-xs'>$status</td>
                                                
                                            </tr>";
        $n++;
    }
    
    
    
    echo "</tbody></table>";
    
    
    
}
function researchbank($kpi, $user_id, $alluserArray, $namakegiatan, $typebidangArray)
{
    $stringCommand = $_POST['stringCommand'];
    $pieces        = explode("#", $stringCommand);
    
    $act = $pieces[0];
    
    if ($act == "add") {
        
        $inputan    = $pieces[1];
        $background = $pieces[2];
        $Objective  = $pieces[3];
        $resource   = $pieces[4];
        $mark       = $pieces[5];
        $oleh       = $user_id;
        
        
        $kpi->Insertbank($inputan, $background, $Objective, $resource, $mark, $oleh);
        
        
    } elseif ($act == "dell") {
        
        $idbank = $pieces[1];
        $kpi->DellbankResearch($idbank);
    }
    
    
    //nilai balik
    echo "        
                                        <table class='table table-striped table-bordered table-hover' id='projects'>
                                                    <thead>
                                                        <tr>
                                                            <th class='center'>
                                                            Input
                                                            </th>
                                                            <th>Problem Background</th>
                                                            <th class='hidden-xs'>Objective</th>
                                                            <th>Resource</th>
                                                            <th class='hidden-xs'>mark</th>
                                                            <th ></th>

                                                        </tr>
                                                    </thead>";
    $projectlists = $kpi->getbankdata();
    
    foreach ($projectlists as $projectlist) {
        
        echo "
                                                    
                                                    <tbody>
                                                        <tr>
                                                            <td class='center'>
                                                            $projectlist[inputan]</td>
                                                            <td>$projectlist[background]</td>
                                                            <td class='hidden-xs'> $projectlist[objective]</td>
                                                            <td>$projectlist[resource]</td>
                                                            <td class='hidden-xs'>
                                                            $projectlist[mark]</td>
                                                            
                                                            <td class='center'>
                                                            <div class='visible-md visible-lg hidden-sm hidden-xs'>
                                                                <a href='#' onclick= 'dellbank($projectlist[id]);' class='btn btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
                                                            </div>

                                                            </td>
                                                        </tr>";
        
    }
    echo "                                
                                                    </tbody>
                                                </table>";
    
    
    
}
function planresearch($kpi, $user_id, $alluserArray, $namakegiatan, $typebidangArray)
{
    $stringCommand = $_POST['stringCommand'];
    $pieces        = explode("#", $stringCommand);
    
    $act = $pieces[0];
    
    if ($act == "add") {
        
        $title         = $pieces[1];
        $objectiveplan = $pieces[2];
        $typeplan      = $pieces[3];
        $costplan      = $pieces[4];
        $peneliti      = $pieces[5];
        $resourceplan  = $pieces[6];
        $periodeplan   = $pieces[7];
        $prioritas     = $pieces[8];
        $ket           = $pieces[9];
        $oleh          = $user_id;
        
        
        $kpi->InsertPlanResearch($title, $objectiveplan, $typeplan, $costplan, $peneliti, $resourceplan, 0, $periodeplan, $prioritas, $ket, $oleh);
        
        
    } elseif ($act == "dell") {
        
        $idplan = $pieces[1];
        $kpi->DellPlanResearch($idplan);
    }
    
    
    //nilai balik    
    
    echo "        
                                <table class='table table-striped table-bordered table-hover' id='projects'>
                                            <thead>
                                                <tr>
                                                    <th class='center'>
                                                    Title
                                                    </th>
                                                    <th class='hidden-xs' >Objective</th>
                                                    <th class='hidden-xs' >Type</th>
                                                    <th >Dana</th>
                                                    <th>Resecher</th>
                                                    <th class='hidden-xs'>Resource</th>

                                                    <th >periode</th>
                                                    <th >prioritas</th>
                                                    <th ></th>                                                    
                                                    

                                                </tr>
                                            </thead>";
    $projectlists = $kpi->getPlanResearch();
    
    foreach ($projectlists as $projectlist) {
        $peserta      = Extractusername($alluserArray, $projectlist[peneliti]);
        $titlePeserta = $peserta;
        if (strlen($peserta) > 50) {
            
            $peserta = substr($peserta, 0, 50) . "..";
        }
        $dumb = $typebidangArray[$projectlist['type']];
        echo "
                                            
                                            <tbody>
                                                <tr>
                                                    <td title='$projectlist[ket]' class='center'>
                                                    $projectlist[judul]</td>
                                                    <td>$projectlist[objective]</td>
                                                    <td>$dumb</td>
                                                    <td class='hidden-xs'> $projectlist[dana]</td>
                                                    <td class='hidden-xs'> $peserta</td>
                                                    <td>$projectlist[resource]</td>
                                                    <td class='hidden-xs'>
                                                    $projectlist[periode]</td>
                                                    <td>$projectlist[prioritas]</td>
                                                    <td class='center'>
                                                    <div class='visible-md visible-lg hidden-sm hidden-xs'>
                                                        <a href='#' onclick='dellplanresearch($projectlist[id]);' class='btn btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
                                                    </div>

                                                    </td>
                                                </tr>";
        
    }
    echo "                                    
                                            </tbody>
                                        </table>";
    
}

function resultreserach($kpi, $user_id, $alluserArray, $namakegiatan, $typebidangArray)
{
    
    $stringCommand = $_POST['stringCommand'];
    $pieces        = explode("#", $stringCommand);
    
    $act = $pieces[0];
    
    if ($act == "add") {
        
        $titleresult   = $pieces[1];
        $result_result = $pieces[2];
        $typeresult    = $pieces[3];
        
        $peneliti = $pieces[4];
        
        $perioderesult  = $pieces[5];
        $followupresult = $pieces[6];
        
        $ket  = $pieces[7];
        $oleh = $user_id;
        
        
        $kpi->InsertResultResearch($titleresult, $result_result, $typeresult, $peneliti, $perioderesult, $followupresult, $ket, $oleh);
        
        
    } elseif ($act == "dell") {
        
        $idplan = $pieces[1];
        $kpi->DellResultResearch($idplan);
    }
    
    
    //nilai balik
    
    echo "        
                                <table class='table table-striped table-bordered table-hover' id='projects'>
                                            <thead>
                                                <tr>
                                                    <th class='center'>
                                                    Title
                                                    </th>
                                                    <th class='hidden-xs' >Result</th>
                                                    <th class='hidden-xs' >Type</th>
                                                    <th >followup</th>
                                                    <th>Resecher</th>
                                                    

                                                    <th >periode</th>
                                                    
                                                    <th ></th>                                                    
                                                    

                                                </tr>
                                            </thead>";
    $projectlists = $kpi->getResultResearch();
    
    foreach ($projectlists as $projectlist) {
        $peserta      = Extractusername($alluserArray, $projectlist[peneliti]);
        $titlePeserta = $peserta;
        if (strlen($peserta) > 50) {
            
            $peserta = substr($peserta, 0, 50) . "..";
        }
        $dumb = $typebidangArray[$projectlist['type']];
        
        echo "
                                            
                                            <tbody>
                                                <tr>
                                                    <td title='$projectlist[ket]' class='center'>
                                                    $projectlist[judul]</td>
                                                    <td>$projectlist[hasil]</td>
                                                    <td>$dumb</td>
                                                    <td class='hidden-xs'> $projectlist[followup]</td>
                                                    <td class='hidden-xs'> $peserta</td>
                                                    
                                                    <td class='hidden-xs'>
                                                    $projectlist[periode]</td>
                                                    
                                                    <td class='center'>
                                                    <div class='visible-md visible-lg hidden-sm hidden-xs'>
                                                        <a href='#' onclick='dellResultresearch($projectlist[id]);' class='btn btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
                                                    </div>

                                                    </td>
                                                </tr>";
        
    }
    echo "                                
                                            </tbody>
                                        </table>";
    
    
    
}

function proposalresearch($kpi, $user_id, $alluserArray, $namakegiatan, $typebidangArray, $typeStatus, $salting, $Activity, $obj)
{
    
    $stringCommand = $_POST['stringCommand'];
    $pieces        = explode("#", $stringCommand);
    
    $act  = $pieces[0];
    $info = 0;
    if ($act == "add") {
        
        $titleresult = $pieces[1];
        $typeresult  = $pieces[2];
        $cost        = $pieces[3];
        
        
        $peneliti = $pieces[4];
        
        $start = date("Y-m-d", strtotime($pieces[5]));
        $end   = date("Y-m-d", strtotime($pieces[6]));
        
        
        $approve  = 0;
        $oleh     = $user_id;
        $status   = 0;
        $proposal = file_get_contents('./php/template.txt', FILE_USE_INCLUDE_PATH);
        
        $kpi->InsertProposal($titleresult, $peneliti, $status, $start, $end, $approve, $proposal, $cost, $oleh, $typeresult);
        //log activity                
        $Activity->Insert_activity(31, $user_id, $titleresult, './panel.php?module=Seleksi');
        
    } elseif ($act == "dell") {
        
        $idplan        = $pieces[1];
        $getprpoposals = $kpi->getproposalbyID($idplan);
        foreach ($getprpoposals as $getprpoposal) {
            $createby = $getprpoposal['oleh'];
        }
        if (($user_id == $createby) || ($salting > 4)) {
            $kpi->Dellproposal($idplan);
            //log activity                
            $Activity->Insert_activity(32, $user_id, $idplan, './panel.php?module=Seleksi');
        }
    } elseif ($act == "edit") {
        
        $titleresult = $pieces[1];
        $typeresult  = $pieces[2];
        $cost        = $pieces[3];
        $peneliti    = $pieces[4];
        $start       = date("Y-m-d", strtotime($pieces[5]));
        $end         = date("Y-m-d", strtotime($pieces[6]));
        $idprop      = $pieces[7];
        
        $oleh = $user_id;
        $info = 1;
        
        $getprpoposals = $kpi->getproposalbyID($idprop);
        foreach ($getprpoposals as $getprpoposal) {
            $createby = $getprpoposal['oleh'];
        }
        if (($user_id == $createby) || ($salting > 4)) {
            $kpi->updateProposalId($titleresult, $peneliti, $start, $end, $cost, $idprop, $typeresult);
            //log activity                
            $Activity->Insert_activity(33, $user_id, $titleresult, "./panel.php?module=selesksipro&id=$idprop");
        } else {
            echo "<script>alert('you are not allow ');</script>";
        }
        
    } elseif ($act == "approve") {
        
        $id   = $pieces[1];
        $info = 1;
        if ($salting > 4) {
            $kpi->updateProposalStatusId($user_id, 3, $id);
            $Activity->Insert_activity(34, $user_id, $id, "./panel.php?module=selesksipro&id=$id");
        } else {
            echo "<script>alert('you are not allow ');</script>";
        }
        $idprop = $id;
        
    } elseif ($act == "unapprove") {
        
        $id   = $pieces[1];
        $info = 1;
        if ($salting > 4) {
            $kpi->updateProposalStatusId(0, 1, $id);
            $Activity->Insert_activity(34, $user_id, $id, "./panel.php?module=selesksipro&id=$id");
        } else {
            echo "<script>alert('you are not allow ');</script>";
        }
        $idprop = $id;
        
    } elseif ($act == "buzz") {
        
        $Message       = $pieces[1];
        $id            = $pieces[2];
        $getprpoposals = $kpi->getproposalbyID($id);
        foreach ($getprpoposals as $getprpoposal) {
            $createby      = $getprpoposal['oleh'];
            $peneliti      = $getprpoposal['peneliti'];
            $peneliti      = "57" . $peneliti;
            $judulProposal = $getprpoposal['judul'];
            $subject       = "[Buzz] Proposal " . $judulProposal . "Need your attention";
        }
        $formEmail = $obj->Get_email_id($user_id);
        
        $obj->sendEmail($formEmail, $peneliti, $Message, $subject);
        $info = 1;
        echo "<script>alert('Buzz has been send ');</script>";
        $idprop = $id;
        
    } elseif ($act == "addComment") {
        
        $Message = $pieces[1];
        $id      = $pieces[2];
        
        $kpi->InsertCommentProposal($Message, $user_id, $id);
        //nilai balik
        
        echo "<ol class='discussion'>";
        
        
        $listcommens = $kpi->getCommentproposal($id);
        $n           = 1;
        foreach ($listcommens as $listcommen) {
            if ($n % 2) {
                $classs = "other";
            } else {
                $classs = "self";
            }
            $namaPengirim = $alluserArray[$listcommen['oleh']];
            echo "
                                                <li class='$classs'>
                                                    <div class='avatar'>
                                                        <img width='50px' alt='' src='" . "../" . $listcommen['path'] . "'>
                                                    </div>
                                                    <div class='messages'>
                                                        <p>
                                                            $listcommen[text]
                                                        </p>
                                                        <span class='time'><small>Posted on " . date("d/m/Y H:i", strtotime($listcommen['created_on'])) . " by  <a href:'' >$namaPengirim</a></small></span>
                                                    </div>
                                                </li>";
            $n++;
        }
        echo "                    
                                                
                        </ol>";
        die;
    }
    
    
    
    if ($info == 1) {
        //get info Event
        $listEvents = $kpi->getproposalbyID($idprop);
        
        foreach ($listEvents as $listEvent) {
            $description = $listEvent['proposal'];
            $titleEvent  = $listEvent['judul'];
            $peoplelist  = $listEvent['peneliti'];
            $peoplelist  = substr($peoplelist, 1); // hilangkan , dalam huruf pertama
            $cost        = $listEvent['cost'];
            $status      = $listEvent['status'];
            
            $topic = $listEvent['type'];
            
            $dateStart = date("d M Y", strtotime($listEvent['start']));
            $dateEnd   = date("d M Y", strtotime($listEvent['end']));
        }
        
        $nilaiUang = thousandsCurrencyFormat($cost);
        
        echo "<table class='table table-bordered table-striped'>
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Info</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><span class='label label-default'> Title</span></td>
                                                <td><code>  $titleEvent </code></td>
                                            </tr>
                                            <tr>
                                                <td><span class='label label-success'> Topic</span></td>
                                                <td><code> $typebidangArray[$topic]  </code></td>
                                            </tr>
                                            <tr>
                                                <td><span class='label label-warning'> Duration</span></td>
                                                <td><code> $dateStart  $dateEnd </code></td>
                                            </tr>
                                            <tr>
                                                <td><span class='label label-danger'> Cost</span></td>
                                                <td><code>$nilaiUang </code></td>
                                            </tr>
                                            <tr>
                                                <td><span class='label label-info'> Status</span></td>
                                                <td><code> $typeStatus[$status] </code></td>
                                            </tr>
                                            <tr>
                                                <td><span class='label label-success'> Team</span></td>
                                                <td><code>";
        
        $pieces = explode(",", $peoplelist);
        
        foreach ($pieces as $piece) {
            
            echo "<li><a href='./panel.php?module=profile&id=$piece' >" . $alluserArray[$piece] . "</a> </li>";
        }
        echo "</code></td>
                                            </tr>

                                        </tbody>
                                    </table>";
        die;
        
    }
    
    //nilai balik
    echo "        
                                <table class='table table-striped table-bordered table-hover' id='projects'>
                                            <thead>
                                                <tr>
                                                    <th >Title</th>
                                                    <th class='hidden-xs' >type</th>
                                                    <th class='hidden-xs'>Researcher</th>
                                                    <th>cost</th>
                                                    <th  class='hidden-xs' >Duration</th>
                                                    <th >Status</th>
                                                    <th ></th>

                                                </tr>
                                            </thead>";
    $projectlists = $kpi->getproposal();
    
    foreach ($projectlists as $projectlist) {
        
        echo "
                                            
                                            <tbody>
                                                <tr>
                                                    <td ><a href='panel.php?module=selesksipro&id=$projectlist[id]'> $projectlist[judul]</a></td>
                                                    <td class='hidden-xs' >$projectlist[type]</td>
                                                    <td class='hidden-xs'> $projectlist[peneliti]</td>
                                                    <td>$projectlist[cost]</td>
                                                    <td class='hidden-xs'>
                                                    $projectlist[start] $projectlist[end]</td>
                                                    <td>$projectlist[status]</td>
                                                    <td class='center'>
                                                    <div class='visible-md visible-lg hidden-sm hidden-xs'>
                                                        <a href='#' onclick= 'dellproposal($projectlist[id]);' class='btn btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
                                                    </div>

                                                    </td>
                                                </tr>";
        
    }
    echo "</tbody>
                                        </table>";
    
    
}
function propdiscus($kpi, $user_id, $alluserArray, $namakegiatan, $typebidangArray, $salting)
{
    
    $proposal = $_POST['content'];
    $id       = $_POST['content_id'];
    $act      = $_POST['act'];
    if ($act == "proposal") {
        
        $getprpoposals = $kpi->getproposalbyID($id);
        foreach ($getprpoposals as $getprpoposal) {
            $createby = $getprpoposal['oleh'];
        }
        
        if (($user_id == $createby) || ($salting > 4)) {
            $kpi->updateProposalDescriponlyId($proposal, $id, $user_id);
            
        }
        
        
    }
    
    
}

//function to update user data
//made by rizky
//Update:
//1. 01/29/2018 --> initial (rizky)
function updateBio($User)
{
    $stringCommand = $_POST['stringCommand'];
    $pieces        = explode("#", $stringCommand);
    $id            = $pieces[0];
    $name          = $pieces[1];
    $position      = $pieces[2];
    $email         = $pieces[3];
    $phone         = $pieces[4];
    $address       = $pieces[5];
    $othermail     = $pieces[6];
    $facebook      = $pieces[7];
    $pass          = $pieces[8];
    
    $filePath = "../img/user";
    if (!is_dir($filePath)) {
        mkdir($filePath, 0700);
    }
    ;
    
    if (count($_FILES['chunks']['name'] > 0)) {
        for ($i = 0; $i < count($_FILES['chunks']['name']); $i++) {
            $temp      = explode(".", $_FILES["chunks"]['name']["$i"]);
            $extension = end($temp);
            
            $random_digit = rand(0000, 9999);
            $namabaru     = $random_digit . "_" . $id . "_" . "." . $extension;
            $fullPath     = $filePath . "/" . $namabaru;
            $namaTumbl    = $filePath . "/thumb_" . $namabaru;
            
            if (move_uploaded_file($_FILES["chunks"]['tmp_name']["$i"], $fullPath)) //upload the file
                {
                //$path = substr($fullPath, 3);

                resizeImage($fullPath, $namaTumbl, 0, 400);

                $path = substr($namaTumbl, 3);

                $User->updateBiodata($id, $position, $email, $phone, $address, $othermail, $facebook, $path);
            }
        }
    }
    $User->updateDataSingle("og_user", "nama", $name, $id);
    
    if ($pass != "") {
        // Create a random salt
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        // Create salted password (Careful not to over season)
        $password    = hash('sha512', $pass . $random_salt);
        
        $User->updateDataSingle("og_user", "sandi", $password, $id);
        $User->updateDataSingle("og_user", "garam", $random_salt, $id);
    }
    
    echo "Data has been successfully updated!";
}

function MarknotifReadAll($user_id,$obj)
{


    $obj->updateNotfAll(1, $user_id);

    echo "<script>refreshNotification()</script>" ;
}

function projectMan_obj($obj, $id_user, $kontrak, $salting, $alluserArray,$Users)
{
    
    
    
    
    $act = $_POST['act'];
    
    if (isset($act) && !empty($act)) {
        
    } else {
        $stringCommand = $_POST['stringCommand'];
        $pieces        = explode("#", $stringCommand);
        $act           = $pieces[0];
        $code          = $pieces[1];
    }
    
    
    if ($act=='Approvalsurveyprb') {
        $tipe     = $pieces[2];
        $id_kon   = $pieces[1];

        if ($tipe==1) {
            $obj->Aprrovekadivprb($id_user,$id_kon);
        }elseif ($tipe==2) {
            $obj->Aprrovekadivsurvey($id_user,$id_kon);
        }elseif ($tipe==3) {
            $obj->Aprrovekadivkemenko($id_user,$id_kon);
        }

        $act = "refreshlist";
        $code=0;

    }elseif ($act=='CancelApprovalsurveyprb') {
        $id_kon   = $pieces[1];
        $obj->CancelAprrovekadivkemenko($id_kon);
        $act = "refreshlist";
        $code=0;
    }

    
    if ($act == "refreshlist") {
        
        //nilai balik
        
        echo "        
<table class='table table-striped table-bordered table-hover' id='sample_1'>
                                    <thead>
                                        <tr>
                                                    <th>No</th>
                                                    <th>Project Name</th>
                                                    <th>contract</th>
                                                    <th class='hidden-xs'>Lead</th>
                                                    <th class='hidden-xs'>start</th>
                                                    <th>Proj Comp</th>
                                                    <th class='hidden-xs'>%Comp</th>
                                                    <th>target</th>
                                                    <th>PRB</th>
                                                    <th>Survey</th>
                                                    
                                                    <th>Act</th>                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                            ";
        $projectlists = $obj->get_wokspaceUndone($code);
        $no           = 1;
        //echo $id_user . "sapi" ;
        $jabatann = $Users->Get_strukturan_iduser($id_user); 

        if ($jabatann==1) {
            $strAction="<a href='#' onClick='delProject($projectlist[object_id]);'class='btn btn-primary tooltips' data-placement='top' data-original-title='Approve PRB'><i class='fa fa-share'></i></a>";
        }elseif ($jabatann==2) {
            $strAction="<a href='#' onClick='Approvalsurveyprb($projectlist[object_id],2);'class='btn btn-primary tooltips' data-placement='top' data-original-title='Approve Survey'><i class='fa fa-share'></i></a>";
        }elseif ($jabatann==3) {
            $strAction="<a href='#' onClick='Approvalsurveyprb($projectlist[object_id],3);'class='btn btn-primary tooltips' data-placement='top' data-original-title='Approve Kemenko'><i class='fa fa-share'></i></a>
            <a href='#' onClick='CancelApprovalsurveyprb($projectlist[object_id]);'class='btn btn-bricky tooltips' data-placement='top' data-original-title='Cancel Approval'><i class='fa fa-times fa fa-white'></i></a>";
        }

        foreach ($projectlists as $projectlist) {
            
            $tanggalselesai = date("d M Y", strtotime($projectlist['due']));
            
            $nokontrak = $projectlist['id_kontrak'];
            $start     = date("d M Y", strtotime($projectlist['starting']));
            $target    = 'Rp. ' . number_format($projectlist['target'], 0, '', ',');

            $idJabatan= $obj->Get_idJabatan('Project Leader');
            
            $lead = $kontrak->get_proj_PM_project($projectlist['object_id'],$idJabatan);
            
            $pemimpin = $alluserArray[$lead];

            if ($projectlist['kadivprb'] == 0 ){
                $prb= '-';
            }else{
                $prb= $alluserArray[$projectlist['kadivprb']] . " " . date("d M Y", strtotime($projectlist['kadivprbat']));
            }
            
            if ($projectlist['kadivprb'] == 0 ){
                $survey= '-';
            }else{
                $survey= $alluserArray[$projectlist['kadivsurvey']] . " " . date("d M Y", strtotime($projectlist['kadivsurveyat']));
            }

            //action button
        if ($jabatann==1) {
            $strAction="<a href='#' onClick='Approvalsurveyprb($projectlist[object_id],1);'class='btn btn-primary tooltips' data-placement='top' data-original-title='Approve PRB'><i class='fa fa-share'></i></a>";
        }elseif ($jabatann==2) {
            $strAction="<a href='#' onClick='Approvalsurveyprb($projectlist[object_id],2);'class='btn btn-primary tooltips' data-placement='top' data-original-title='Approve Survey'><i class='fa fa-share'></i></a>";
        }elseif ($jabatann==3) {
            $strAction="<a href='#' onClick='Approvalsurveyprb($projectlist[object_id],3);'class='btn btn-primary tooltips' data-placement='top' data-original-title='Approve Kemenko'><i class='fa fa-share'></i></a>
            <a href='#' onClick='CancelApprovalsurveyprb($projectlist[object_id]);'class='btn btn-bricky tooltips' data-placement='top' data-original-title='Cancel Approval'><i class='fa fa-times fa fa-white'></i></a>";
        }

            echo "
                                            
                                            
                                                <tr>
                                                    <td >$no</td>
                                                    <td><a href='panel.php?module=projectMod&idproj=$projectlist[object_id]'>$projectlist[project]</a></td>
                                                    <td class='hidden-xs'> $nokontrak</td>
                                                    <td class='hidden-xs'> $pemimpin</td>
                                                    <td class='hidden-xs'> $start</td>
                                                    <td>$tanggalselesai</td>
                                                    <td class='hidden-xs'>
                                                    <div class='progress progress-striped active progress-sm'>
                                                        <div style='width: $projectlist[progress]%' aria-valuemax='100' aria-valuemin='0' aria-valuenow=' $projectlist[progress]' role='progressbar' class='progress-bar '>
                                                            <span class='sr-only'> 70% Complete (danger)</span>
                                                        </div>
                                                    </div></td>
                                                    <td>$target</td>
                                                    <td>$prb</td>
                                                    <td>$survey</td>
                                            
                                                    <td class='center'>
                                                    <div class='visible-md visible-lg hidden-sm hidden-xs'>
                                                        $strAction
                                                    </div>

                                                    </td>
                                                </tr>";
            $no++;
        }
        
        echo "
                                            </tbody>
                                        </table><script> generatedTable(1);</script>";
    }
    
    
    
    
}







?> 
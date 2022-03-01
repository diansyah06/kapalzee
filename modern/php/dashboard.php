<?php
$pagenum_id=12;
//$Users->cekSecuritypeage($user_id,$pagenum_id);
   $lastaktifiti=$Activity->get_last_activity(); //get timelines
   foreach ($lastaktifiti as $lastaktifit) {
   $idlast= $lastaktifit['id'];
   }
   $aktivitys=$Activity->get_activity(3);
   $whiteboards=$Activity->getWhiteboard(); //get whiteboard
   	foreach ($whiteboards as $whiteboard) {
	$messageWithboard=$whiteboard['message'];
	$userWithboard=$whiteboard['nama'];
	}
	
	$getlistTraxyear=$kontrak->getCostAllprojectTheyear(date("Y"));
	
$mulai = $month = strtotime("01-01-" . date("Y"));
$akhir = strtotime("31-12-" . date("Y") );
$jumlahakumalasiBudget=0;
while($month < $akhir)
{
     //echo date('F Y', $month), PHP_EOL;
     $snamabulan= date('M y', $month);
	 $jumlahCostPerbulan=0 ;
	 $jumlahInvestPerbulan=0;
	 $nextmonth=strtotime("+1 month", $month);
	 //$nextmonth=strtotime("01" .  $nextmonth);
	 
	 foreach( $getlistTraxyear as  $listcost){
		 
		 
		 if ((strtotime($listcost['realisation'])>= strtotime("01" . $snamabulan))&& (strtotime($listcost['realisation'])< strtotime("01" . date('M y',$nextmonth)) )) {
			 
			 if ($listcost['tipeKegiatan']==1){
			 $jumlahCostPerbulan=($jumlahCostPerbulan + $listcost['total'])/1000000;
			 }else{
			 $jumlahInvestPerbulan=($jumlahInvestPerbulan + $listcost['total'])/1000000;
			 }
		 }
		 
	 }

	 $totalpencapainCost= $totalpencapainCost + $jumlahCostPerbulan ;
	 $totalpencapainIncome= $totalpencapainIncome + $jumlahInvestPerbulan ;
	 $sAcumulasi= $sAcumulasi . "['$snamabulan',  $jumlahCostPerbulan , $jumlahInvestPerbulan ,  ]," ; 

	 
	 
	 $month = $nextmonth ;
}

$strJsonMap2= "['Cost',$totalpencapainCost]," . "['Income',$totalpencapainIncome]";	

$projectlists=$obj->get_wokspaceUndone(0);
$strJsonMap3="";
foreach($projectlists as $projectlist){
	$costproject=floatval ($kontrak->sumCostPro($projectlist['object_id'],1));
	$namaproj=clean(strip_tags($projectlist['project']));
	$strJsonMap3=$strJsonMap3 . "['$namaproj' , $costproject ], " ;	
}		

$strJsonMap3= substr($strJsonMap3, 0, -1);	
	
	//calender from task this month

	$listEventTasks=$obj->getTaskByMonthbyuser($user_id);
	foreach($listEventTasks as $listEventTask){
	
	$y=date("Y",strtotime($listEventTask['due'])); // this month
	$m=date("m",strtotime($listEventTask['due'])); // this month
	$d=date("d",strtotime($listEventTask['due'])); // this month
	$start=date("Y-m-d ", strtotime($listEventTask['due'])) ;
	
	$m=$m -1 ; //javascript bulan itu 0 - 11
	if($listEventTask['tipeKegiatan']==3){
	$labelWarna="label-green";
	}else{
	$labelWarna="label-default";
	}
	$stringevent= $stringevent. "{
				allDay: '',
                title: '$listEventTask[pekerjaan]',
                start: '$start',
                className: '$labelWarna'
            },";
	
	}
	
	
	
	$listEventTasks=$rms->GetMeetingMontCalender(date("Y-m-d"));
	foreach($listEventTasks as $listEventTask){
	
/* 	$y=date("Y",strtotime($listEventTask['tanggal'])); // this month
	$m=date("m",strtotime($listEventTask['tanggal'])); // this month
	$d=date("d",strtotime($listEventTask['tanggal'])); // this month */
	
	
	$pieces=explode(" - ",$listEventTask['waktu']);
	
	$start=date("Y-m-d ", strtotime($listEventTask['tanggal'])) . $pieces[0] . ":00";
	$end=date("Y-m-d ", strtotime($listEventTask['tanggal'])) . $pieces[1] . ":00";
	
	
	$m=$m -1 ; //javascript bulan itu 0 - 11
	if(($listEventTask['project']==0)&& ($listEventTask['cek_po']==0)) {
	$title="Meeting " .$listEventTask['agenda'] ;
	$title=substr($title,0,100) ;		
	$labelWarna="label-yellow";
	}elseif($listEventTask['project']==0){
	$title="Meeting " .$listEventTask['Rules'] ;
	$title=substr($title,0,100) ;		
	$labelWarna="label-green";		
	}else{
	$labelWarna="label-default";
	$title="Meeting " .$listEventTask['namproject'] ;
	$title=substr($title,0,100) ;	
	}
	$stringevent= $stringevent. "{
		        allDay: '',
                title: '$title',
                start: '$start',
                className: '$labelWarna'
            },";
	
	}
	
	$stringevent= substr($stringevent, 0, -1);		


	
	


	
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
     
		
google.charts.load('current', {'packages':['corechart','gauge']});
      google.charts.setOnLoadCallback(drawVisualization);
	  

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
		['month','Cost', 'income'],
			<?php echo $sAcumulasi ; ?> 
			  ]);

			var options = {
			  title : ' ',
			  vAxis: {title: 'Money (k)'},
			  hAxis: {title: 'Month'},
			  seriesType: 'bars',
			  series: {5: {type: 'line'}}
			};

			var chart = new google.visualization.ComboChart(document.getElementById('chart_div3'));
			chart.draw(data, options);
		  }
		  
	  
  
	  google.setOnLoadCallback(drawChart2);
	  function drawChart2() {

        var datas = google.visualization.arrayToDataTable([
        ['Cost', 'Income'],
		<?php echo $strJsonMap2; ?>]);


        var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

        chart.draw(datas);
      }	  
	  
	  google.setOnLoadCallback(drawChart1);
	  function drawChart1() {

       var datas = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
		  <?php echo $strJsonMap3; ?>
        ]);

        var options = {
          title: 'My Daily Activities'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart1'));

        chart.draw(datas);
      }
	
    </script>		
<script type="text/javascript">
    //put array into javascript variable
var Index = function () {
    // function to initiate Chart 1
   
    // function to initiate Sparkline
    var runSparkline = function () {
        $(".sparkline_line_good span").sparkline("html", {
            type: "line",
            fillColor: "#B1FFA9",
            lineColor: "#459D1C",
            width: "50",
            height: "24"
        });
        $(".sparkline_line_bad span").sparkline("html", {
            type: "line",
            fillColor: "#FFC4C7",
            lineColor: "#BA1E20",
            width: "50",
            height: "24"
        });
        $(".sparkline_line_neutral span").sparkline("html", {
            type: "line",
            fillColor: "#CCCCCC",
            lineColor: "#757575",
            width: "50",
            height: "24"
        });
        $(".sparkline_bar_good span").sparkline('html', {
            type: "bar",
            barColor: "#459D1C",
            barWidth: "5",
            height: "24"
        });
        $(".sparkline_bar_bad span").sparkline('html', {
            type: "bar",
            barColor: "#BA1E20",
            barWidth: "5",
            height: "24"
        });
        $(".sparkline_bar_neutral span").sparkline('html', {
            type: "bar",
            barColor: "#757575",
            barWidth: "5",
            height: "24"
        });
    };
    // function to initiate EasyPieChart
    var runEasyPieChart = function () {
        if (isIE8 || isIE9) {
            if (!Function.prototype.bind) {
                Function.prototype.bind = function (oThis) {
                    if (typeof this !== "function") {
                        // closest thing possible to the ECMAScript 5 internal IsCallable function
                        throw new TypeError("Function.prototype.bind - what is trying to be bound is not callable");
                    }
                    var aArgs = Array.prototype.slice.call(arguments, 1),
                        fToBind = this,
                        fNOP = function () {}, fBound = function () {
                            return fToBind.apply(this instanceof fNOP && oThis ? this : oThis, aArgs.concat(Array.prototype.slice.call(arguments)));
                        };
                    fNOP.prototype = this.prototype;
                    fBound.prototype = new fNOP();
                    return fBound;
                };
            }
        }
        $('.easy-pie-chart .bounce').easyPieChart({
            animate: 1000,
            size: 70
        });
        $('.easy-pie-chart .cpu').easyPieChart({
            animate: 1000,
            lineWidth: 3,
            barColor: '#35aa47',
            size: 70
            
        });
    };
    // function to initiate Full Calendar
    var runFullCalendar = function () {
        //calendar
        /* initialize the calendar
		 -----------------------------------------------------------------*/
        var $modal = $('#event-management');
        $('#event-categories div.event-category').each(function () {
            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
                title: $.trim($(this).text()) // use the element's text as the event title
            };
            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject);
            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true, // will cause the event to go back to its
                revertDuration: 50 //  original position after the drag
            });
        });
        /* initialize the calendar
		 -----------------------------------------------------------------*/
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var form = '';
        var calendar = $('#calendar').fullCalendar({
            buttonText: {
                prev: '<i class="fa fa-chevron-left"></i>',
                next: '<i class="fa fa-chevron-right"></i>'
            },
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: [<?php echo $stringevent;?>]
			,
            editable: false,
            droppable: false, // this allows things to be dropped onto the calendar !!!
            drop: function (date, allDay) { // this function is called when something is dropped
                // retrieve the dropped element's stored Event Object
                var originalEventObject = $(this).data('eventObject');
                var $categoryClass = $(this).attr('data-class');
                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject);
                // assign it the date that was reported
                copiedEventObject.start = date;
                copiedEventObject.allDay = allDay;
                if ($categoryClass)
                    copiedEventObject['className'] = [$categoryClass];
                // render the event on the calendar
                // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }
            },
            selectable: true,
            selectHelper: true,
            select: function (start, end, allDay) {
                $modal.modal({
                    backdrop: 'static'
                });
                form = $("<form></form>");
                form.append("<div class='row'></div>");
                form.find(".row").append("<div class='col-md-6'><div class='form-group'><label class='control-label'>New Event Name</label><input class='form-control' placeholder='Insert Event Name' type=text name='title'/></div></div>").append("<div class='col-md-6'><div class='form-group'><label class='control-label'>Category</label><select class='form-control' name='category'></select></div></div>").find("select[name='category']").append("<option value='label-default'>Work</option>");
                $modal.find('.remove-event').hide().end().find('.save-event').show().end().find('.modal-body').empty().prepend(form).end().find('.save-event').unbind('click').click(function () {
                    form.submit();
                });
                $modal.find('form').on('submit', function () {
                    title = form.find("input[name='title']").val();
                    $categoryClass = form.find("select[name='category'] option:checked").val();

					var myDate = new Date(end);
					var time=new Date(end).toLocaleString();

					
					fung_Task(0,"add",title,0,0,"",time);
					
                    if (title !== null) {
                        calendar.fullCalendar('renderEvent', {
                                title: title,
                                start: start,
                                end: end,
                                allDay: allDay,
                                className: $categoryClass
                            }, true // make the event "stick"
                        );
                    }
                    $modal.modal('hide');
                    return false;
                });
                calendar.fullCalendar('unselect');
            },
/*             eventClick: function (calEvent, jsEvent, view) {
                var form = $("<form></form>");
                form.append("<label>Change event name</label>");
                form.append("<div class='input-group'><input class='form-control' type=text value='" + calEvent.title + "' /><span class='input-group-btn'><button type='submit' class='btn btn-success'><i class='fa fa-check'></i> Save</button></span></div>");
                $modal.modal({
                    backdrop: 'static'
                });
                $modal.find('.remove-event').show().end().find('.save-event').hide().end().find('.modal-body').empty().prepend(form).end().find('.remove-event').unbind('click').click(function () {
                    calendar.fullCalendar('removeEvents', function (ev) {
                        return (ev._id == calEvent._id);
                    });
                    $modal.modal('hide');
                });
                $modal.find('form').on('submit', function () {
                    calEvent.title = form.find("input[type=text]").val();
                    calendar.fullCalendar('updateEvent', calEvent);
                    $modal.modal('hide');
                    return false;
                });
            } */
        });
    };
    return {
        init: function () {

            runSparkline();
            runEasyPieChart();
            runFullCalendar();
        }
    };
}();
 
   
</script>
<?php
			echo set_java_script_plugin_load ("flot"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			
			echo set_java_script_plugin_load ("sparkline"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY 
			echo set_java_script_plugin_load ("calender"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
?>


<div class="page-header">
								<h1>Dashboard <small>overview &amp; stats </small></h1>
							</div>
							<!-- end: PAGE TITLE & BREADCRUMB -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->
					<!-- start: PAGE CONTENT -->
					<div class="row">
						<div class="col-sm-4">
							<div class="core-box">
								<div class="heading">
									<i class="clip-user-4 circle-icon circle-green"></i>
									<h2>RMS Users</h2>
								</div>
								<div class="content"><span id="result_box" lang="en">See the Friends network of friends who are members of the RMS, you can visit, send him a message and see the activity.</span></div>
								<a class="view-more" href="#">
									View More <i class="clip-arrow-right-2"></i>
								</a>
							</div>
						</div>
						<div class="col-sm-4">
						  <div class="core-box">
								<div class="heading">
									<i class="clip-clip circle-icon circle-teal"></i>
									<h2>Manage Task </h2>
								</div>
								<div class="content"><span id="result_box" lang="en">In In this menu you can see a list of rules development work you are doing and also you can make changes</span>.								</div>
								<a class="view-more" href="#">
									View More <i class="clip-arrow-right-2"></i>
								</a>
						  </div>
						</div>
						<div class="col-sm-4">
							<div class="core-box">
								<div class="heading">
									<i class="clip-database circle-icon circle-bricky"></i>
									<h2>Manage Rules </h2>
								</div>
								<div class="content"><span id="result_box" lang="en">Management the rules,  regarding distribution and publication. only users with certain pervilage can make changes in it</span>.</div>
								<a class="view-more" href="#">
									View More <i class="clip-arrow-right-2"></i>
								</a>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-7">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="clip-stats"></i>
									Cost / Income
									<div class="panel-tools">
										<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
										</a>
										<a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
											<i class="fa fa-wrench"></i>
										</a>
										<a class="btn btn-xs btn-link panel-refresh" href="#">
											<i class="fa fa-refresh"></i>
										</a>
										<a class="btn btn-xs btn-link panel-close" href="#">
											<i class="fa fa-times"></i>
										</a>
									</div>
								</div>
								<div class="panel-body">
									
										<div id="chart_div3" style="width:auto; height:400px;"></div>
									
								</div>
							</div>
						</div>
						<div class="col-sm-5">
							<div class="row">
								<div class="col-sm-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											<i class="clip-pie"></i>
											Map operasional
											<div class="panel-tools">
												<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
												</a>
												<a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
													<i class="fa fa-wrench"></i>
												</a>
												<a class="btn btn-xs btn-link panel-refresh" href="#">
													<i class="fa fa-refresh"></i>
												</a>
												<a class="btn btn-xs btn-link panel-close" href="#">
													<i class="fa fa-times"></i>
												</a>
											</div>
										</div>
										<div class="panel-body">
										<div id="piechart2" style="width: 100%; height:180px; "></div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											<i class="clip-bars"></i>
											Cost Distibution
											<div class="panel-tools">
												<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
												</a>
												<a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
													<i class="fa fa-wrench"></i>
												</a>
												<a class="btn btn-xs btn-link panel-refresh" href="#">
													<i class="fa fa-refresh"></i>
												</a>
												<a class="btn btn-xs btn-link panel-close" href="#">
													<i class="fa fa-times"></i>
												</a>
											</div>
										</div>
										<div class="panel-body">
											<div id="piechart1" style="width: 100%; height:180px; "></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-7">
							
						</div>
						
						<div class="col-sm-5">
						

								</div>
								
								</div>
								
					
					<div class="row">
						<div class="col-sm-7">
							
							                         <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <i class="clip-bars"></i>
                                            Whiteboard RnD
                                            <div class="panel-tools">
                                                <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                                </a>
                                                <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
                                                    <i class="fa fa-wrench"></i>
                                                </a>
                                                <a class="btn btn-xs btn-link panel-refresh" href="#">
                                                    <i class="fa fa-refresh"></i>
                                                </a>
                                                <a class="btn btn-xs btn-link panel-close" href="#">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="panel-body panel-scroll" style="height:75px"><div  class="content"><?php echo $messageWithboard ;?></div><br>
                                         <?php echo "<b>--" . $userWithboard  . "--</b>" ;?>  </div>
                            
                          </div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="clip-calendar"></i>
									Calendar
									<div class="panel-tools">
										<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
										</a>
										<a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
											<i class="fa fa-wrench"></i>
										</a>
										<a class="btn btn-xs btn-link panel-refresh" href="#">
											<i class="fa fa-refresh"></i>
										</a>
										<a class="btn btn-xs btn-link panel-expand" href="#">
											<i class="fa fa-resize-full"></i>
										</a>
										<a class="btn btn-xs btn-link panel-close" href="#">
											<i class="fa fa-times"></i>
										</a>
									</div>
								</div>
								<div class="panel-body">
									<div id='calendar'></div>
								</div>
							</div>
							
						</div>
						<div class="col-sm-5">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="clip-checkbox"></i>
									To Do
									<div class="panel-tools">
										<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
										</a>
										<a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
											<i class="fa fa-wrench"></i>
										</a>
										<a class="btn btn-xs btn-link panel-refresh" href="#">
											<i class="fa fa-refresh"></i>
										</a>
										<a class="btn btn-xs btn-link panel-close" href="#">
											<i class="fa fa-times"></i>
										</a>
									</div>
								</div>
								<div class="panel-body panel-scroll" style="height:300px">
									<ul class="todo">
								<div id="taskrefresh" class="taskrefresh">	
									<?php
								
									foreach($listUrgents as $listUrgent ){
									

									
									echo StyleTask($listUrgent['due'],$listUrgent['id'],$listUrgent['pekerjaan'],$listUrgent['tipeKegiatan'],$listUrgent['idKegiatan']);
										
									}
									
									?>
									
									</div>	
									</ul>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											<i class="clip-bubble-4"></i>
											Chat
											<div class="panel-tools">
												<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
												</a>
												<a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
													<i class="fa fa-wrench"></i>
												</a>
												<a class="btn btn-xs btn-link panel-refresh" href="#">
													<i class="fa fa-refresh"></i>
												</a>
												<a class="btn btn-xs btn-link panel-expand" href="#">
													<i class="fa fa-resize-full"></i>
												</a>
												<a class="btn btn-xs btn-link panel-close" href="#">
													<i class="fa fa-times"></i>
												</a>
											</div>
										</div>
										<div class="panel-body panel-scroll" style="height:460px">
											<link rel="stylesheet" type="text/css" href="../plugin/chat/chatfiles/chatstyle.css" />
											<?php include('../plugin/chat/chat.php'); ?>
											
											
											
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>

<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script>
		
		
			jQuery(document).ready(function() {
				enterChat();
				Main.init();
				Index.init();

			});
			
									//load more

$('.load_more').on("click",function() {//If user clicks on hyperlink with class name = load_more
var last_msg_id = $(this).attr("id");
//Get the id of this hyperlink 
//this id indicate the row id in the database 
if(last_msg_id!='end'){
    //if  the hyperlink id is not equal to "end"
		$.ajax({//Make the Ajax Request
		type: "POST",
		url: "../people/people_proc.php",
		data: "activity="+ last_msg_id, 
		beforeSend:  function() {
		$('a.load_more').html('<img src="../img/ajax-loader.gif" />');//Loading image during the Ajax Request
		  
		},
		success: function(html){//html = the server response html code
			$("#more").remove();//Remove the div with id=more 
		$("ol#update").append(html);//Append the html returned by the server .

		}
		});
  
}
return false;


});
			
		</script>
	
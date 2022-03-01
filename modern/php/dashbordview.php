<?php
$pagenum_id=12;
$Users->cekSecuritypeage($user_id,$pagenum_id);
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
	
	//Get data for grafik 1
	$getLisrRUles=$rms->getProgressYears(); //get Progress
	$dataset1 = array();
	$c=1;
		 foreach ($getLisrRUles as $getLisrRUle) {
							$nilaicek=array($getLisrRUle['preparation'],$getLisrRUle['teamup'],$getLisrRUle['ref'],$getLisrRUle['wg'],$getLisrRUle['konsenering'],$getLisrRUle['cetak'],$getLisrRUle['karakter'],$getLisrRUle['adminis'],$getLisrRUle['komite'],$getLisrRUle['scope'],$getLisrRUle['master'],$getLisrRUle['publikasi']);

							$n=0;
							
							 foreach ($nilaicek as $isi) { if ($isi!="0000-00-00"){ $n=$n+1;} ;} 
							 $n=($n/12 * 100)- 0.1 ;
							 $n=number_format($n,0);
							 
		  $simbolRules=$rms->createNamaSymbol($getLisrRUle['Part'], $getLisrRUle['volume'], $getLisrRUle['tipe'] );
		  $dataset1[]=array($n ,$c  );
		  
		  $datass = $getLisrRUle['Rules'] ;   
		  if (($pos = strpos($datass, "for ")) !== FALSE) { 
				$whatIWant = substr($datass, $pos+3); 
				$whatIWant= strtok($whatIWant,  ' ');
			}
		  
		  $tickLabels[] =array($c ,$simbolRules . " " . $whatIWant ) ; 
		  $c++ ;
 
	}
	////end data for grafik 1
	
	
	//Get data for grafik 2
	$projectGoing=$rms->GetNumProjectOngoing();
	$projectDone=$rms->GetNumProjectDone();
	$projectStack=$rms->getNumProjectStack();
	
	$data_pie = array( 
        array(
            "label" => "On Progress",
            "data" => $projectGoing,
			"color"=> "#D9DD81"
        ),
        array(
            "label" => "Done",
            "data" => $projectDone,
			"color"=> "#79D1CF"
        ),
        array(
            "label" => "Stack",
            "data" => $projectStack,
			"color"=> "#E67A77"
        ),

    );
	
	
	//calender from task this month

	$listEventTasks=$obj->getTaskByMonthbyuser($user_id);
	foreach($listEventTasks as $listEventTask){
	
	$y=date("Y",strtotime($listEventTask['due'])); // this month
	$m=date("m",strtotime($listEventTask['due'])); // this month
	$d=date("d",strtotime($listEventTask['due'])); // this month
	$m=$m -1 ; //javascript bulan itu 0 - 11
	if($listEventTask['tipeKegiatan']==3){
	$labelWarna="label-green";
	}else{
	$labelWarna="label-default";
	}
	$stringevent= $stringevent. "{
                title: '$listEventTask[pekerjaan]',
                start: new Date($y, $m, $d),
                className: '$labelWarna'
            },";
	
	}
	
	$stringevent= substr($stringevent, 0, -1);
	
	
			


	
	


	
?>

<script type="text/javascript">
    //put array into javascript variable
var Index = function () {
    // function to initiate Chart 1
    var runChart1 = function () {
       
 
$.plot($("#placeholder-h1"), [  
{  

    data: <?php echo json_encode($dataset1); ?> ,  label: "Rules Progress ",

    bars: {  
        show: true,  
        horizontal: true,
		barWidth: 0.6,
		fillColor: "#C83A2A",
		lineWidth: 0,
		align: "center"  
    }  
}  
		],  
			{  
				xaxis: {
				axisLabel: "Progress %"
			   
			},
			colors: ["#d12610", "#37b7f3", "#52e136"],
            grid: {
                hoverable: true,
                clickable: true,
                tickColor: "#eee",
                borderWidth: 0
            },
			legend: {
                show: false
            },
			

				yaxis: {  
				axisLabel: "Rules Symbols",
					ticks: <?php echo json_encode($tickLabels); ?>  
				}  
}  
);  
			
		    function showTooltip(x, y, contents) {
            $('<div id="tooltip">' + contents + '</div>').css({
                position: 'absolute',
                display: 'none',
                top: y + 5,
                left: x + 15,
                border: '1px solid #333',
                padding: '4px',
                color: '#fff',
                'border-radius': '3px',
                'background-color': '#333',
                opacity: 0.80
            }).appendTo("body").fadeIn(200);
        }
        var previousPoint = null;
        $("#placeholder-h1").bind("plothover", function (event, pos, item) {
            $("#x").text(pos.x.toFixed(2));
            $("#y").text(pos.y.toFixed(2));
            if (item) {
                if (previousPoint != item.dataIndex) {
                    previousPoint = item.dataIndex;
                    $("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1].toFixed(2);
                    showTooltip(item.pageX, item.pageY, item.series.label + " of " + x + " = " + y);
                }
            } else {
                $("#tooltip").remove();
                previousPoint = null;
            }
        });




			
			
			
		
 
 
 
    };
    // function to initiate Chart 2
    var runChart2 = function () {
       
		
		var data_pie = [
    {label: "Asia", data: 4119630000, color: "#005CDE" },
    { label: "Latin America", data: 590950000, color: "#00A36A" },
    { label: "Africa", data: 1012960000, color: "#7D0096" },
    { label: "Oceania", data: 35100000, color: "#992B00" },
    { label: "Europe", data: 727080000, color: "#DE000F" },
    { label: "North America", data: 344120000, color: "#ED7B00" }   
];


		
        $.plot('#placeholder-h2', <?php echo json_encode($data_pie); ?>, {
            series: {
                pie: {
                    show: true,
                    radius: 1,
                    tilt: 0.5,
                    label: {
                        show: true,
                        radius: 1,
                        formatter: labelFormatter,
                        background: {
                            opacity: 0.8
                        }
                    },
                    combine: {
                        color: '#999',
                        threshold: 0.1
                    }
                }
            },
            legend: {
                show: false
            }
        });

        function labelFormatter(label, series) {
            return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
        }
    };
    // function to initiate Chart 3
    var runChart3 = function () {
        var data = [],
            totalPoints = 300;

        function getRandomData() {
            if (data.length > 0)
                data = data.slice(1);
            // Do a random walk
            while (data.length < totalPoints) {
                var prev = data.length > 0 ? data[data.length - 1] : 50,
                    y = prev + Math.random() * 10 - 5;
                if (y < 0) {
                    y = 0;
                } else if (y > 100) {
                    y = 100;
                }
                data.push(y);
            }
            // Zip the generated y values with the x values
            var res = [];
            for (var i = 0; i < data.length; ++i) {
                res.push([i, data[i]]);
            }
            return res;
        }
        // Set up the control widget
        var updateInterval = 30;
        $("#updateInterval").val(updateInterval).change(function () {
            var v = $(this).val();
            if (v && !isNaN(+v)) {
                updateInterval = +v;
                if (updateInterval < 1) {
                    updateInterval = 1;
                } else if (updateInterval > 2000) {
                    updateInterval = 2000;
                }
                $(this).val("" + updateInterval);
            }
        });
		//alert(getRandomData());
        var plot = $.plot("#placeholder-h3", [getRandomData()], {
            grid: {
                borderWidth: 1,
                borderColor: '#eeeeee'
            },
            series: {
                shadowSize: 0 // Drawing is faster without shadows
            },
            yaxis: {
                min: 0,
                max: 100
            },
            xaxis: {
                show: false
            }
        });

        function update() {
            plot.setData([getRandomData()]);
            // Since the axes don't change, we don't need to call plot.setupGrid()
            plot.draw();
            setTimeout(update, updateInterval);
        }
        update();
    };
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
            runChart1();
			
            runChart2();
            runChart3();
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




<hr></hr>
<p>

					<div class="row">
						<div class="col-sm-7">
							<div class="row space12">
								<ul class="mini-stats col-sm-12">
									<li class="col-sm-4">
										<div class="sparkline_bar_good">
											<span>3,5,9,8,13,11,14</span>+10%
										</div>
										<div class="values">
											<strong>18304</strong>
											Visits
										</div>
									</li>
									<li class="col-sm-4">
										<div class="sparkline_bar_neutral">
											<span>20,15,18,14,10,12,15,20</span>0%
										</div>
										<div class="values">
											<strong>3833</strong>
											Unique Visitors
										</div>
									</li>
									<li class="col-sm-4">
										<div class="sparkline_bar_bad">
											<span>4,6,10,8,12,21,11</span>+50%
										</div>
										<div class="values">
											<strong>18304</strong>
											Pageviews
										</div>
									</li>
								</ul>
							</div>
						</div>
						
						<div class="col-sm-5">
							<div class="row space12">
								<ul class="mini-stats col-sm-12">
									<li class="col-sm-4">
										<div class="sparkline_bar_good">
											<span>3,5,9,8,13,11,14</span>+10%
										</div>
										<div class="values">
											<strong>18304</strong>
											Visits
										</div>
									</li>
									<li class="col-sm-4">
										<div class="sparkline_bar_neutral">
											<span>20,15,18,14,10,12,15,20</span>0%
										</div>
										<div class="values">
											<strong>3833</strong>
											Unique Visitors
										</div>
									</li>
									<li class="col-sm-4">
										<div class="sparkline_bar_bad">
											<span>4,6,10,8,12,21,11</span>+50%
										</div>
										<div class="values">
											<strong>18304</strong>
											Pageviews
										</div>
									</li>
								</ul>
							</div>
						</div>
								
								</div>
								
								<p></p>
				
					<div class="row">
						<div class="col-sm-7">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="clip-stats"></i>
									Rules Progress
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
									<div class="flot-medium-container">
										<div id="placeholder-h1" class="flot-placeholder"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-5">
							<div class="row">
								<div class="col-sm-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											<i class="clip-pie"></i>
											Rules Performace
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
											<div class="flot-mini-container">
												<div id="placeholder-h2" class="flot-placeholder"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											<i class="clip-bars"></i>
											Online User
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
											<div class="flot-mini-container">
												<div id="placeholder-h3" class="flot-placeholder"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-7">
							<div class="row space12">
								<ul class="mini-stats col-sm-12">
									<li class="col-sm-4">
										<div class="sparkline_bar_good">
											<span>3,5,9,8,13,11,14</span>+10%
										</div>
										<div class="values">
											<strong>18304</strong>
											Visits
										</div>
									</li>
									<li class="col-sm-4">
										<div class="sparkline_bar_neutral">
											<span>20,15,18,14,10,12,15,20</span>0%
										</div>
										<div class="values">
											<strong>3833</strong>
											Unique Visitors
										</div>
									</li>
									<li class="col-sm-4">
										<div class="sparkline_bar_bad">
											<span>4,6,10,8,12,21,11</span>+50%
										</div>
										<div class="values">
											<strong>18304</strong>
											Pageviews
										</div>
									</li>
								</ul>
							</div>
						</div>
						
						<div class="col-sm-5">
						
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
								</div>
								
								</div>
								
					
					<div class="row">
						<div class="col-sm-5">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="clip-users-2"></i>
									Activity
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
								
									<link href="../css/timeline.css" rel="stylesheet" type="text/css" />
									<?php
   

    								echo " <div style='overflow-y:scroll; height:632px; margin-top:3px; '> <input type='hidden' id='updatee' name='updatee' class='updatee' value=$idlast /> <ol  id='update' class='timeline'>	";
   									foreach ($aktivitys as $aktivity) {
										$aktifitiname=$aktivity['object'];
										
										if (strlen($aktifitiname)>100){
										
										$aktifitiname=substr($aktifitiname,0,100) . ".." ;
										}	
										
										
   										$sesuaiformat=$Activity->format_tanggal($aktivity['date_hour']);

					   					echo "<div title='$aktivity[nick]' class='friends_area' ><img src='../$aktivity[path]' height='45' style='float:left;' alt=''> 
		   									<label style='float:left' class='name'>
		   									<b>$aktivity[nick] </b><br> <span class='aktifitas'> $aktivity[name_activity] </span> <span style='padding: 4px 10 30px 18px; width:30' 				class='db-ico ico-$aktivity[icon]'> </span> <a class='terusan-$aktivity[icon]' style='font-weight:bold;' href='$aktivity[link]'> $aktifitiname </a><br>
											<span class='tanggalfeed'>
		    								$sesuaiformat </span></label></div>";
							
										$last_id= $aktivity['id'];
   
   									}
   
									echo "</ol>	<div id='more' style='margin-top: 20px;'> <a  id=$last_id class='load_more' href='#'>more</a> </div></div>";
	
				
?>
									
									
						
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
				
				//small menu
				document.body.className = document.body.className.replace(" pace-running","pace-done navigation-small");

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
	

$('html, body').animate({ scrollTop: $(document).height() - $(window).height() }, 50000, function() {
    $(this).animate({ scrollDown: 0 }, 1000);
});
		</script>					
<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> 
        <script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js?autoload=true&amp;skin=sunburst&amp;lang=css" defer></script>       
    <style>
        .top-margin-row{
            margin-top:70px;
        }
        table,th,tr,td{
            border:2px solid black !important;
        }
        .btn-style{
            background:#f2f2f2;
            position: relative;
            top: -15px;
            left: 464px;
        }
        .btn-2-style{
            background:#eee6ff;
            position: relative;
            left: 292px;
            top: 22px;
        }

        .btn-2-style:hover{
            background:#4d79ff;
            color:white;
        }
        .mt-15{
            margin-top:15px;
        }
        .btn-style-3{
            position: relative;
            background:#f2f2f2;
            top: 14px;
            left: 1064px;
        }

        table {
            border-collapse:separate;
            border:solid black 1px;
            border-radius:6px;
            -moz-border-radius:6px;
        }

        td, th {
            border-left:solid black 1px;
            border-top:solid black 1px;
        }

        th {
            background-color: #f2f2f2;
            border-top: none;
        }

        td:first-child, th:first-child {
            border-left: none;
        }

        .btn{
            border:solid black 2px;
        }

        input{
            border-radius:6px;
        }

        select{
            border-radius:6px;
            border:2px solid black;
        }

        #config-file-txt{
            display:none;
            border-radius:6px;
        }

        table > thead{
            display:inline-block;
        }

        #weekend{
            display:flex;
            flex-direction: column;
            flex-wrap: nowrap;
        }
        #weekday{
            display:flex;
            flex-direction: column;
            flex-wrap: nowrap;
        }
    </style>
     </head>
    <body>
        <?php
            $servername = "localhost";
            $username = "root";
            $password = "itspe";
            $dbname = "htms";
            $setJunctionValue = null;
            $count = 0;
            $junction=null;

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if(isset($_GET['id'])){

                $id = $_GET['id'];

                $scn = $_GET['scn1'];

                $sql1="DELETE FROM Weekday WHERE id = $id AND SignalSCN = '$scn'";

                if(!$conn->query($sql1)){
                    echo "error";
                }
            }

            if(isset($_GET['id2'])){

                $id = $_GET['id2'];

                $scn = $_GET['scn'];

                $sql1="DELETE FROM Weekend WHERE id = $id AND SignalSCN = '$scn'";

                if(!$conn->query($sql1)){
                    echo "error";
                }
            }
                 
        ?> 
        <div class = "container" id="conc">
        <div id="compact-on-click" style="width: 100% !important;">
            <div class = "row top-margin-row">
                <div class="col-md-9">
                   <div id = "junction-select" style="position: relative;top: -36px;left: -291px;">
                        <h2 style="display:inline">Select Junction : </h2>
                        <select name="junction" id="jun">
                        <option value='value' selected>Option Name</option>
                            <?php
                                  $sql = "SELECT DISTINCT SignalSCN,ShortDescription FROM `utmc_traffic_signal_static`";
                                  $result = $conn->query($sql);
                                  if ($result->num_rows > 0) { 
                                      while($row = $result->fetch_assoc()) {
                                         $junction = $row['SignalSCN'];
                                         $description = $row['ShortDescription'];
                                         echo "<option value='$junction'>$description</option>";                
                                      }
                                  } 
                            ?>
                        </select>
                   </div>
                </div>
            </div>
            <div class = "row mt-xs-4">
                <div class="col-md-9">
                     <!-- Stage -->
                        <table id="tab" style="position:relative;left:-300px;" class="table table-striped table-bordered table-responsive border-for-table">
                            <thead style='display:inline-block'>
                            <tr>
                                <th colspan="6" style="padding-left:523px;padding-right:523px;">
                                    <h6 style="text-align:center;font-weight:bold;">STAGE<h6>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="1" style="width:197px">
                                </th>
                                <th colspan="1" style="width:197px">
                                </th>
                                <th colspan="2" style="width:198px">
                                    <h6 style="text-align:center;font-weight:bold;">PEAK</h6>
                                </th>
                                <th colspan="2">
                                    <h6 style="text-align:center;font-weight:bold;">OFFPEAK</h6>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="1" style="width:197px">
                                    <h6 style="text-align:center;font-weight:bold;">STAGE_ORDER</h6>
                                </th>
                                <th colspan="1" style="width:197px">
                                    <h6 style="text-align:center;font-weight:bold;">INTER_STAGE_TIME</h6>
                                </th>
                                <th colspan="1" style="width:197px">
                                    <h6 style="text-align:center;font-weight:bold;">MIN_GREEN_PEAK</h6>
                                </th>
                                <th colspan="1" style="width:198px">
                                    <h6 style="text-align:center;font-weight:bold;">MAX_GREEN_PEAK</h6>
                                </th>
                                <th colspan="1" style="padding-left: 5px;">
                                    <h6 style="text-align:center;font-weight:bold;">MIN_GREEN_OFFPEAK</h6>
                                </th>
                                <th colspan="1">
                                    <h6 style="text-align:center;font-weight:bold;">MAX_GREEN_OFFPEAK</h6>
                                </th>
                            </tr>
                            </thead>
                            <tbody id="tb" style="display:inline-block;height:348px;overflow-y:scroll;width: 1100px;">
                            </tbody>
                        </table>
                </div>
                <div class="col-md-3">
                    <!-- dynamic -->
                    <table border="1" id="weekday" class="table table-striped table-bordered table-responsive"  style=" width: 89%">
                            <tr>
                                <th colspan="2">
                                    <h6 style="text-align:center;font-weight:bold;">WEEKDAY<h6>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    <h6 style="text-align:center;font-weight:bold;">PEAK START<h6>
                                </th>
                                <th>
                                    <h6 style="text-align:center;font-weight:bold;">PEAK END<h6>
                                </th>
                            </tr>
                            <tr>
                                    <td style="">
                                    <input style="position:relative;top: 16px;left: 1px;" id="peak-start" type="time" name="peakStart" placeholder="Enter Peak Start">
                                    </td>
                                    <td style="">
                                    <input style="position:relative;left: 11px;top: 16px;" id="peak-end" type="time" name="peakEnd" placeholder="Enter Peak End">
                                    <input id="junctionname2" type="text" name="junctionname2" style="display:none;">
                                    <input id="two" type="submit" class="mt-15" value="+" style="position: relative;left: 80px;top: -146px;">
                                    </td>
                            </tr>
                            <tbody id="tb2" style="display:block; height:100px; overflow:scroll; overflow-x:hidden">
                            </tbody>
                    </table>             
                </div>
            </div>
            <div class = "row">
            <div class = "col-md-9">
                        <!-- cumulative threshold -->
                        <div style="position: relative;left: -300px;width: 1095px;">
                        <table border="1" class="table table-striped table-bordered table-responsive">
                            <tr>
                                <th colspan="3">
                                    <h6 style="text-align:center;font-weight:bold;">THRESHOLD<h6>
                                </th>
                            </tr>
                            <tr>
                                <th>

                                </th>
                                <th>
                                    <h6 style="text-align:center;font-weight:bold;">PEAK</h6>
                                </th>
                                <th>
                                    <h6 style="text-align:center;font-weight:bold;">OFF-PEAK</h6>
                                </th>
                            </tr>
                            <tr id="cum">
                                <td>
                                    <h6 style="text-align:center;font-weight:bold;">Cumulative Threshold<h6>
                                </td>
                                <td>
                                    <input type="text" style="width:320px;position: relative;left: 59px;">
                                </td>
                                <td>
                                    <input type="text" style="width:320px;position: relative;left: 59px;">
                                </td>
                            </tr>
                            <tr id="noncum">
                                <td>
                                    <h6 style="text-align:center;font-weight:bold;">Threshold<h6>
                                </td>
                                <td>
                                    <input type="text" style="width:320px;position: relative;left: 59px;">
                                </td>
                                <td>
                                    <input type="text" style="width:320px;position: relative;left: 59px;">
                                </td>
                            </tr>
                        </table>
                        </div>
            </div>
            <div class="col-md-3">
                        <!-- dynamic -->
                        <div style="position: relative;top: -194px;">
                        <table border="1" id="weekend" style=" width: 89%" class="table table-striped table-bordered table-responsive">
                                <tr>
                                    <th colspan="2">
                                        <h6 style="text-align:center;font-weight:bold;">WEEKEND<h6>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <h6 style="text-align:center;font-weight:bold;">PEAK START<h6>
                                    </th>
                                    <th>
                                        <h6 style="text-align:center;font-weight:bold;">PEAK END<h6>
                                    </th>
                                </tr>
                                <tr>
                                        <td>
                                        <input  style="position:relative;top: 20px;left: 0px;" id="peak-start1" type="time" name="peakStart1" placeholder="Enter Peak Start">
                                        </td>
                                        <td>
                                        <input style="position:relative;left: 13px;top: 19px;" id="peak-end1" type="time" name="peakEnd1" placeholder="Enter Peak End">
                                        <input id="junctionname" type="text" name="junctionname" style="display:none;">
                                        <input id="one" type="submit" class="mt-15" value="+" style="position: relative;left: 82px;top: -147px;">
                                        </td>
                                </tr>
                                <tbody id="tb3" style="height:100px; overflow:scroll; overflow-x:hidden">
                                </tbody>
                        </table>
                        </div>
                </div>
            </div>
            <button id="jclick" type="button" class="btn btn-default btn-2-style" style="height: 47px;position: relative;top: -152px;left: 855px;">Submit</button>
            <button id="getConfigClick" type="button" class="btn btn-default btn-2-style" style="height: 47px;position: relative;top: -152px;left: 874px;">Create Configuration File</button>
        </div>
        <div id = "config-file-txt" style="position: relative;top: -899px;left: 1140px;width: 347px;height: 747px;border: 6px solid black;margin-left: 20px;">
        </div>
    </div>
        
        <script>
            $( document ).ready(function() {
                var weekends = null;
                var weekdays = null;
                var junction = null;
                var cumulative_threshold_peak = null;
                var cumulative_threshold_offpeak = null;
                var threshold_peak = null;
                var threshold_offpeak = null;
                var concatEndPeakStart = '';
                var concatEndPeakEnd = '';
                var concatStartPeakStart = '';
                var concatStartPeakEnd = '';
                $("#jclick").click(function(){
                    var concatEndPeakStart = '';
                    var concatEndPeakEnd = '';
                    var concatStartPeakStart = '';
                    var concatStartPeakEnd = '';
                    $('.rows').each(function (i, el) {
                        var input = $(this).find('td > input');
                        var stg = $(this).find('td > p');
                        var stageOrder = Number(stg.eq(0).text());
                        var interStageTime = Number(input.eq(0).val());
                        var minGreenPeak = Number(input.eq(1).val());
                        var maxGreenPeak = Number(input.eq(2).val());
                        var minGreenOffpeak = Number(input.eq(3).val());
                        var maxGreenOffpeak = Number(input.eq(4).val());
                        $.ajax({
                            url: "submit.php", 
                            method: "POST", 
                            data: { "stageOrder":stageOrder,"interStageTime":interStageTime,"minGreenPeak":minGreenPeak,"maxGreenPeak":maxGreenPeak,"minGreenOffpeak":minGreenOffpeak,"maxGreenOffpeak":maxGreenOffpeak},
                            success: function(data){
                                console.log(data)
                            }
                        });
                    });
                    var input2 = $('#cum').find('td > input');
                    var cumPeak = Number(input2.eq(0).val());
                    var cumOffPeak = Number(input2.eq(1).val());
                    var input3 = $('#noncum').find('td > input');
                    var nonCumPeak = Number(input3.eq(0).val());
                    var nonCumOffPeak = Number(input3.eq(1).val());
                    $.ajax({
                            url: "threshold.php", 
                            method: "POST", 
                            data: {"cumPeak":cumPeak,"cumOffPeak":cumOffPeak,"nonCumPeak":nonCumPeak,"nonCumOffPeak":nonCumOffPeak,"junction":junction},
                            success: function(data){
                                console.log(data)
                            }
                    });
                    $("#weekend > #tb3 tr").each(function (i, el) {
                        var input = $(this).find('td > p');
                        console.log(input.eq(0).text());
                        concatEndPeakStart+=input.eq(0).text().substring(0, 5)+',';
                        concatEndPeakEnd+=input.eq(1).text().substring(0, 5)+',';
                    });
                    concatEndPeakStart=concatEndPeakStart.substring(0, concatEndPeakStart.length-1);
                    concatEndPeakEnd=concatEndPeakEnd.substring(0, concatEndPeakEnd.length-1);
    
                    $("#weekday > #tb2 tr").each(function (i, el) {
                        var input1 = $(this).find('td > p');
                        console.log(input1.eq(0).text());
                        concatStartPeakStart+=input1.eq(0).text().substring(0, 5)+',';
                        concatStartPeakEnd+=input1.eq(1).text().substring(0, 5)+',';
                    });
                    concatStartPeakStart=concatStartPeakStart.substring(0, concatStartPeakStart.length-1);
                    concatStartPeakEnd=concatStartPeakEnd.substring(0, concatStartPeakEnd.length-1);
                    $.ajax({
                            url: "insert.php", 
                            method: "POST", 
                            data: {"junction":junction,"concatEndPeakStart":concatEndPeakStart,"concatEndPeakEnd":concatEndPeakEnd,"concatStartPeakStart":concatStartPeakStart,"concatStartPeakEnd":concatStartPeakEnd},
                            success: function(data){
                                console.log(data)
                            }
                    });
                }); 

                $("#jun").change(function() {
                    junction=$('option:selected', this).val();
                    console.log(junction);
                    $("#junctionname").val(junction);
                    $("#junctionname2").val(junction);
                    $("#tb").html('');
                    $("#tb2").html('');
                    $("#tb3").html('');
                    $.ajax({
                            url: "junction.php", 
                            method: "POST", 
                            data: {"junction":junction},
                            success: function(data){
                                //console.log(data);
                                $("#tb").append(data);  
                            }
                    });


                    $.ajax({
                            url: "getThresholdData.php", 
                            method: "POST", 
                            data: {"junction":junction},
                            dataType: 'json',
                            success: function(data){
                                cumulative_threshold_peak = data[0];
                                cumulative_threshold_offpeak = data[1];
                                threshold_peak = data[2];
                                threshold_offpeak = data[3];
                                var input = $('#cum').find('td > input');
                                input.eq(0).val(cumulative_threshold_peak);
                                input.eq(1).val(cumulative_threshold_offpeak);
                                var input1 = $('#noncum').find('td > input');
                                input1.eq(0).val(threshold_peak);
                                input1.eq(1).val(threshold_offpeak);
                            }
                    });

                    $.ajax({
                            url: "SelectWeekDay.php", 
                            method: "POST", 
                            data: {"junction":junction},
                            success: function(data){
                                for (var i=0;i<Math.max(data["weekday_peak_start"].length,data["weekday_peak_end"].length,data["weekend_peak_start"].length,data["weekend_peak_end"].length);i++) {
                                    console.log(data);
                                    if(data["weekday_peak_start"] && data["weekday_peak_end"]){
                                        $('#weekday > #tb2').append("<tr><td style='width:100px;'><p style='text-align:center;'>"+data["weekday_peak_start"][i]+"</p></td><td style='width:112px;'><p style='text-align:center;'>"+data["weekday_peak_end"][i]+"</p><span class='cross2 glyphicon glyphicon-remove' style='position:relative;left:80px;top:-28px;'></span></td></tr>");
                                    }
                                    if(data["weekend_peak_start"] && data["weekend_peak_end"]){
                                        $('#weekend > #tb3').append("<tr><td style='width:100px;'><p style='text-align:center;'>"+data["weekend_peak_start"][i]+"</p></td><td style='width:112px;'><p style='text-align:center;'>"+data["weekend_peak_end"][i]+"</p><span class='cross glyphicon glyphicon-remove' style='position:relative;left:80px;top:-28px;'></span></td></tr>");
                                    }
                                }

                                bind_click();
                            }
                    });
                });
                
                $('#getConfigClick').click(function(){
                    $('#config-file-txt').html('');
                    $("#config-file-txt").css("display", "block");
                    $("#config-file-txt").css("margin-left", "20px");
                    $('#conc').css('position','relative');
                    $('#conc').css('left','-31px');
                    $.ajax({
                            url: "configurations.php", 
                            method: "POST", 
                            data: {"junction":junction},
                            success: function(data){
                                var obj = JSON.parse(data);
                                console.log(data);
                                $('#config-file-txt').append("<div><p><pre style='width: 336px !important;height: 739px !important;position: relative;top: -12px;'><code>"+JSON.stringify(obj, null, 4)+"</code></pre></p></div>");
                            }
                    });
                });


                $('#one').click(function(e){
                    var peakstart = $('#peak-start1').val();
                    var peakend = $('#peak-end1').val();
                    if(peakstart && peakend){
                        $('#weekend > #tb3').append("<tr><td style='width:100px;'><p style='text-align:center;'>"+peakstart+"</p></td><td style='width:112px;'><p style='text-align:center;'>"+peakend+"</p><span class='cross glyphicon glyphicon-remove' style='position:relative;left:80px;top:-28px;'></span></td></tr>");
                        bind_click();
                    }
                    else{
                        alert("please enter values first then add");
                    }
                });


                $('#two').click(function(e){
                    var peakstart = $('#peak-start').val();
                    var peakend = $('#peak-end').val();

                    if(peakstart && peakend){
                        $('#weekday > #tb2').append("<tr><td style='width:100px;'><p style='text-align:center;'>"+peakstart+"</p></td><td style='width:112px;'><p style='text-align:center;'>"+peakend+"</p><span class='cross2 glyphicon glyphicon-remove' style='position:relative;left:80px;top:-28px;'></span></td></tr>");
                        bind_click();
                    }
                    else{
                        alert("please enter values first then add");
                    }
                });

                bind_click = function(){
                    $('.cross').unbind('click').click(function(){
                        $(this).closest('tr').remove();
                    }); 

                    $('.cross2').unbind('click').click(function(){
                        $(this).closest('tr').remove();
                    }); 
                }
                
            });
 
        </script>
    </body>
</html>
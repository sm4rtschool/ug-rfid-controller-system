<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Realtime Warning System</title>
  <link rel='icon' type='image/x-icon' href='<?php echo base_url(); ?>assets/img/logo_jasamarga_32x32.ico'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no' />

  <!-- Demo Dependencies -->
  <script src="<?php echo base_url(); ?>assets/js/jquery.min.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
  <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <script src="<?php echo base_url(); ?>assets/js/holder.min.js" type="text/javascript"></script>

  <script>
    Holder.add_theme("white", { background:"#fff", foreground:"#a7a7a7", size:10 });
  </script>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>


  <!-- keen-analysis@1.2.2 -->
  <script src="<?php echo base_url(); ?>assets/js/keen-analysis-1.2.2.js" type="text/javascript"></script>

  <!-- keen-dataviz@1.1.3 -->
  <link href="<?php echo base_url(); ?>assets/css/keen-dataviz-1.1.3.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet" type="text/css" />
  <script src="<?php echo base_url(); ?>assets/js/keen-dataviz-1.1.3.js" type="text/javascript"></script>

	<script type="text/javascript">

	function getData() {

    <?php
    //foreach ($ruas as $k => $v) {
    ?>
    
      /*
      $.getJSON('<?php echo site_url(); ?>/home/getdata/<?php echo $k; ?>/A', function(data) {

        for (var i in data) {
            var DeviceName = data[i].DeviceName;
            var ZoneLabel = data[i].ZoneLabel;
            var Speed = data[i].Speed;
            var total_volume = data[i].total_volume;
        }
        //document.getElementById("label_1").innerHTML=DeviceName;
        $('#va<?php //echo $k; ?>').html(total_volume);
        $('#ka<?php //echo $k; ?>').html(Speed);

      });
      */

      //$("#your_table_id tbody").append('');
      $('#your_table_id tbody tr').remove();

      $.getJSON('<?php echo site_url(); ?>/home/get_state', function(data) {

        let no_urut = 1;
        for (var i in data) {

            var nama_parameter = data[i].nama_parameter;
            var nama_variable = data[i].nama_variable;
            var state = data[i].state;
            var threshold_state_qty = data[i].threshold_state_qty;
            var threshold_state_persentase = data[i].threshold_state_persentase;

            // '<td style="text-align:left;">' + nama_parameter + '</td>' +
            // Append to HTML table
            var tableRow = '<tr>' +
              '<td style="text-align:center;">' + no_urut + '</td>' +
              '<td style="text-align:left;">' + nama_variable + '</td>' +
              '<td style="text-align:center;"><input type="checkbox"></td>' +
              '<td style="text-align:center;">' + state + '</td>' +
              '<td style="text-align:center;">' + threshold_state_qty + '</td>' +
              '<td style="text-align:center;">' + threshold_state_persentase + '%</td>' +
              '<td style="text-align:center;"><input type="checkbox"></td>' +
              '<td style="text-align:center;"><input type="checkbox"></td>' +
              '<td style="text-align:center;"><input type="checkbox"></td>' +
              '</tr>';

            //$('#your_table_id').append(tableRow);
            $("#your_table_id tbody").append(tableRow);

            no_urut=no_urut+1;
        }

      });

    <?php
    //}
    ?>

    $('.selectpicker').on('change', function(){

      var selected = $(this).find("option:selected").val();

      if (selected==1){
        window.location.replace("<?php echo site_url(); ?>");
      } else if (selected==2){
        //window.location.replace("<?php //echo site_url(); ?>/home/getListDalam");
      }

    });
  
  }

  setInterval(getData, 60000);

  $(function() {
    getData();
  });

	</script>

  <script type="text/javascript">

  function updateClock ( )
  {
    var currentTime = new Date();

    //var currentHours = currentTime.getHours ( );
    var currentHours = '00';

    var currentMinutes = currentTime.getMinutes ( );
    var currentSeconds = currentTime.getSeconds ( );

    var currentDate = currentTime.getDate();
    var currentMonth = currentTime.getMonth() + 1;
    var currentYear = currentTime.getFullYear();

    // Pad the minutes and seconds with leading zeros, if required
    currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
    currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;


    // Compose the string for display
    //var currentTimeString = "<i>Dari : "+currentHours + ":" + "00" + ":00 - " + currentHours + ":"+currentMinutes+":"+currentSeconds+" "+currentDate+"/"+currentMonth+"/"+currentYear+"</i>";
    var currentTimeString = "<i>Dari : "+currentHours + ":" + "00" + ":01 - " + currentHours + ":"+currentMinutes+":"+currentSeconds+" "+currentDate+"/"+currentMonth+"/"+currentYear+"</i>";

    // Update the time display
    //document.getElementById("clock").firstChild.nodeValue = currentTimeString;
    $('.time').html(currentTimeString);
  }

  function tanggal(){
    var currentTime = new Date();

    var currentDate = currentTime.getDate();
    var currentMonth = currentTime.getMonth() + 1;
    var currentYear = currentTime.getFullYear();

    var tanggal = currentDate + '/' + currentMonth + '/' + currentYear;
    $('#tanggal').html(tanggal);
  }

  function jam(){

      var currentTime = new Date ( );

      var currentHours = currentTime.getHours ( );
      var currentMinutes = currentTime.getMinutes ( ) + 1;
      var currentSeconds = currentTime.getSeconds ( );
      var jam = currentHours + ":" + "00" + ":00 - " + currentHours + ":59:59";

      $('#jam').html(jam);

  }

  $( document ).ready(function() {
    updateClock();
    tanggal();
    jam();
    setInterval('updateClock()', 1000 );
  });

  </script>

  <!-- Dashboard -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/keen-dashboards.css" />

  <style>

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        input[type="checkbox"] {
            transform: scale(1.5);
        }

        .blink-container {
            display: flex;
            justify-content: space-around;
            margin-top: 10px;
        }

        .blinking-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin: 0 5px; /* Reduced margin */
            animation: blinker 1s linear infinite;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }

        .yellow {
            background-color: #f1c40f; /* Yellow */
        }

        .red {
            background-color: #e74c3c; /* red */
        }
    </style>

</head>

<body class="keen-dashboard" style="padding-top: 80px;">

  <div class="navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">

      <div class="navbar-header">

        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

        <!--
        <a class="navbar-brand" href="#">
          <span class="glyphicon glyphicon-home"></span>
        </a>
        -->

        <a class="navbar-brand" href="#"><img style="width:20px;height:20px;" src="<?php echo base_url(); ?>assets/img/logo.png">&nbsp;&nbsp;Realtime Warning System</a>
      </div>

      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-left">
          <li><a href="<?php echo site_url(); ?>">Home</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Master Data <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <!-- Add your sub-menu items here -->
              <li><a href="<?php echo site_url(); ?>">Content</a></li>
            </ul>
          </li>
          <li><a href="<?php echo site_url(); ?>">History</a></li>
        </ul>
      </div>

    </div>
  </div>

  <script type="text/javascript">

  $('.selectpicker').selectpicker({
    style: 'btn-info',
    size: 5
  });

  </script>

  <div class="container-fluid">

    <div class="row">

      <div class="col-sm-12">

        <div class="chart-hd">
          
          <strong>Pilih Parameter : </strong>

          <select class="selectpicker" data-live-search="true">
            <?php foreach ($area as $k => $v) { ?>
              <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
            <?php } ?>
          </select>

        </div>
        <!-- <div class="chart-hd"> -->
        
      </div>
      <!-- <div class="col-sm-12"> -->
  
    </div>
    <!-- <div class="row"> -->

  </div>
  <!-- <div class="container-fluid"> -->


  <!--<div class="box-body">
  <div class="table-responsive">-->

  <!--<div class="row">

    <div class="col-sm-12">
      <div class="container-fluid">-->
        
          <div style="display: flex; justify-content: center;">
    <table width="100%" class="table table-bordered table-striped" id="your_table_id">

        <thead>
            <tr>
                <th style="text-align: center; width:5%;">No</th>
                <th style="text-align: center; width:25%;">Parameter</th>
                <th style="text-align: center; width:10%;">Status</th>
                <th style="text-align: center; width:10%;">State</th>
                <th style="text-align: center; width:10%;">Count</th>
                <th style="text-align: center; width:10%;">Persentase</th>
                <th style="text-align: center; width:10%;">Sound</th>
                <th style="text-align: center; width:10%;">Speech</th>
                <th style="text-align: center; width:10%;">Light Strobe</th>
            </tr>
        </thead>

        <tbody>
            <!-- Example Data -->
            <!--
            <tr>
                <td style="text-align: center;">1</td>
                <td>Parameter 1</td>
                <td>Indikator 1</td>
                <td>State 1</td>
                <td>Threshold 1</td>
                <td><input type="checkbox" checked></td>
                <td><input type="checkbox" checked></td>
            </tr>
            -->
        </tbody>

    </table>
</div>

      <!--</div>
    </div>
          
  </div>-->


  <!--</div>
    </div>-->
				
  

      </div>
    </div>
  </div>

  

  <div class="row">

    <div class="col-sm-12">
      <div class="container-fluid">
        <p class="small text-muted">STATUS : <b>CONNECTED</b></p>

        <!--<div class="blink-container">
          <div class="blinking-circle yellow"></div>
          <div class="blinking-circle red"></div>
        </div>-->

      </div>
    </div>
          
  </div>

  <style>
    .table-container {
        display: table;
        border: 0;
        width: 100%;
    }

    .table-row {
        display: table-row;
    }

    .table-cell {
        display: table-cell;
        width: 50%;
        text-align: center;
    }

    .table-cell-blink {
        display: table-cell;
        width: 25%;
        text-align: center;
    }

    .table-cell-warning {
        display: table-cell;
        width: 25%;
        text-align: center;
    }

    .table-cell-warning-text {
        background-color: white;
        text-align: center;
    }

    .blinking-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin: 0 auto;
        animation: blinker 1s linear infinite;
    }

    @keyframes blinker {
        50% {
            opacity: 0;
        }
    }

    .yellow {
        background-color: #f1c40f; /* Yellow */
    }

    .red {
        background-color: #e74c3c; /* Red */
    }
</style>

<div class="table-container">

    <div class="table-row">
        <div class="table-cell"></div>
        <div class="table-cell-blink"><div class="blinking-circle yellow"></div></div>
        <div class="table-cell-blink"><div class="blinking-circle red"></div></div>
    </div>

    <div class="table-row">
        <div class="table-cell"></div>
        <div class="table-cell-warning">Warning</div>
        <div class="table-cell-warning">Alarm On</div>
    </div>
    
</div>

  <!-- Project Analytics -->
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/keen-analytics.js"></script>

</body>
</html>

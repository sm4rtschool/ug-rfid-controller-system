<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>RFID Controller System</title>
  <link rel='icon' type='image/x-icon' href='<?php echo base_url(); ?>assets/img/logo.ico'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no' />

  <!-- Demo Dependencies -->
  <script src="<?php echo base_url(); ?>assets/js/jquery.min.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
  <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <script src="<?php echo base_url(); ?>assets/js/holder.min.js" type="text/javascript"></script>
  
  <!-- FontAwesome 4.3.0 -->
  <link href="<?php echo base_url(); ?>assets/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  
  <!-- Ionicons 2.0.0 -->
  <link href="<?php echo base_url(); ?>assets/bootstrap/css/ionicons.min.css" rel="stylesheet" type="text/css" />

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

  <!-- Dashboard -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/keen-dashboards.css" />

  <!-- SweetAlert CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

  <!-- SweetAlert JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

</head>

<body class="keen-dashboard" style="padding-top: 80px;">

  <!-- load file audio -->
  <audio id="tingtung" src="<?php echo base_url(); ?>assets/audio/tingtung.mp3"></audio>
  <audio id="buzzer" src="<?php echo base_url(); ?>assets/audio/buzzer.mp3"></audio>

  <audio id="global_sound" src="<?php echo base_url(); ?>assets/audio/global_sound.mp3"></audio>

  <?php
    foreach ($sound as $variable_data) {
      echo '<audio id="' . $variable_data->html_id . '" src="' . base_url() . 'assets/audio/' . $variable_data->nama_file . '"></audio>' . "\n";
    }
  ?>

  <!--
  <audio id="sound1" preload class="songs">
      <source src="<?php echo base_url(); ?>assets/audio/sound1.mp3" type="audio/mpeg" />
  </audio>
  <audio id="sound2" preload class="songs">
      <source src="<?php echo base_url(); ?>assets/audio/sound2.mp3" type="audio/mpeg" />
  </audio>
  <audio id="sound3" preload class="songs">
      <source src="<?php echo base_url(); ?>assets/audio/sound3.mp3" type="audio/mpeg" />
  </audio>
  -->

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

        <a class="navbar-brand" href="#"><img style="width:20px;height:20px;" src="<?php echo base_url(); ?>assets/img/logo.png">&nbsp;&nbsp;RFID Controller System</a>
      </div>

      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-left">
          <li><a href="<?php echo site_url(); ?>">Home</a></li>
          <li><a href="<?php echo site_url(); ?>controller">Controller</a></li>
          <li><a href="<?php echo site_url(); ?>handheld">Handheld</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Parameter<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <!-- Add your sub-menu items here -->
              <li><a href="<?php echo site_url(); ?>audio">Audio</a></li>
              <li><a href="<?php echo site_url(); ?>config">Config</a></li>
              <!-- <li><a href="<?php echo site_url(); ?>kategori">Kategori</a></li>
              <li><a href="<?php echo site_url(); ?>variable">Variabel</a></li> -->
              <li><a href="<?php echo site_url(); ?>content">Raw RFID Data</a></li>
            </ul>
          </li>
          <!--<li><a href="<?php echo site_url(); ?>">History</a></li>-->
        </ul>
      </div>

    </div>
  </div>
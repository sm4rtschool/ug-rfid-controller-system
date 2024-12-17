<style>
.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 34px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .slider {
    background-color: #2196F3;
}

input:checked + .slider:before {
    transform: translateX(26px);
}
</style>

  <div class="container-fluid">

    <div class="row">

      <div class="col-sm-12">

        <div class="chart-hd">
          
          <strong>&nbsp;&nbsp;Filter Data&nbsp;&nbsp;</strong>

          <select name="filter_id_parameter" id="filter_id_parameter" class="selectpicker" data-live-search="true">
            <option value="0">- All -</option>  
            <?php foreach ($kategori as $k => $v) { ?>
              <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
            <?php } ?>
          </select>

          <button type="button" class="btn btn-success" onClick="sendMessage()">Connect</button>
          <!--<button type="button" class="btn btn-primary" onClick="addTest()">Hit API</button>-->

          <button type="button" class="btn btn-primary" onclick="window.location.reload()">Refresh</button>
          <!-- <input type="text" id="messageInput" placeholder="Type a message"> -->
          
          
          <input type="text" id="liveClock" placeholder="" size="4" style="text-align: center; color: black;">
          <!-- <input type="text" id="startTime" placeholder=""> -->
          <input type="hidden" id="endTime" placeholder="">

          <!-- <strong id="lastSynchronized" class="pull-center">&nbsp;Last Synchronize : <?php //echo $this->fungsi->indonesian_date(date('Y-m-d H:i:s'), 'l, j F Y - H:i'); ?></strong> -->
          <strong style="font-size: 13px;" id="lastSynchronized" class="pull-center"></strong>
          <strong style="font-size: 13px;" id="info_interval_request" class="pull-center"></strong>

          <label class="switch" style="float: left;">
            <input type="checkbox" id="toggleSwitch">
            <span class="slider round"></span>
          </label>

          <strong id="toggleText" style="float: left; margin-left: 10px; margin-right: 5px; text-align: center; font-weight: small; font-size: 21px; font-style: italic;">Off</strong>

          <input type="hidden" name="is_system_on" id="is_system_on" value="<?php echo $qrypengaturan_sistem->is_system_on; ?>">
          <input type="hidden" name="field_for_comparison" id="field_for_comparison" value="<?php echo $qrypengaturan_sistem->field_for_comparison; ?>">
          <input type="hidden" name="global_integrasi_data" id="global_integrasi_data" value="<?php echo $qrypengaturan_sistem->global_integrasi_data; ?>">

          <input type="hidden" name="interval_get_data" id="interval_get_data" value="<?php echo $config_list_data->value; ?>">
          <input type="hidden" name="interval_trigger_alert" id="interval_trigger_alert" value="<?php echo $config_trigger->value; ?>">

          <input type="hidden" name="interval_global_sound" id="interval_global_sound" value="<?php echo $config_global_sound->value; ?>">
          <input type="hidden" name="variable_global_sound" id="variable_global_sound" value="<?php echo $config_global_sound->variable; ?>">

          <input type="hidden" name="interval_apis_url_play_sound" id="interval_apis_url_play_sound" value="<?php echo $config_apis_url_play_sound->value; ?>">
          <input type="hidden" name="variable_apis_url_play_sound" id="variable_apis_url_play_sound" value="<?php echo $config_apis_url_play_sound->variable; ?>">

          <input type="hidden" name="interval_apis_url_web_socket" id="interval_apis_url_web_socket" value="<?php echo $config_apis_url_web_socket->value; ?>">
          <input type="hidden" name="variable_apis_url_web_socket" id="variable_apis_url_web_socket" value="<?php echo $config_apis_url_web_socket->variable; ?>">

          <input type="hidden" name="interval_global_light_color" id="interval_global_light_color" value="<?php echo $config_global_light_color->value; ?>">
          <input type="hidden" name="variable_global_light_color" id="variable_global_light_color" value="<?php echo $config_global_light_color->variable; ?>">

          <input type="hidden" name="is_controller_on" id="is_controller_on" value="<?php echo $config_ip_address_controller->value; ?>">
          <input type="hidden" name="variable_ip_address_controller" id="variable_ip_address_controller" value="<?php echo $config_ip_address_controller->variable; ?>">

          <strong class="pull-right"><div id="is_data_ada" class="blinking-circle" style="width: 30px; height: 30px; border-radius: 50%; margin: 0 auto; animation: blinker 1s linear infinite; float: right; background-color: #e74c3c;"></div></strong>

        </div>
        <!-- <div class="chart-hd"> -->
        
      </div>
      <!-- <div class="col-sm-12"> -->
  
    </div>
    <!-- <div class="row"> -->

  </div>
  <!-- <div class="container-fluid"> -->

  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">

        <div id="slide-container">
            <div id="first-content">
                <span class="header-text"></span>
            </div>
        </div>

      </div>
    </div>
  </div>

  <!--<div class="box-body">
  <div class="table-responsive">-->

  <!--<div class="row">

    <div class="col-sm-12">
      <div class="container-fluid">-->

    <div style="display: flex; justify-content: center;">

    <table width="100%" class="table table-bordered table-striped" id="your_table_id">
        <thead>

            <tr>
              <th style="text-align: center;">Event</th>
              <th style="text-align: center;">Type</th>
              <th style="text-align: center;">Data</th>
              <th style="text-align: center;">Data TID</th>
              <th style="text-align: center;">PC</th>
              <th style="text-align: center;">User</th>
              <th style="text-align: center;">Ant</th>
              <th style="text-align: center;">RSSI</th>
              <th style="text-align: center;">Sensor</th>
              <th style="text-align: center;">RFID Valid</th>
            </tr>

        </thead>

        <tbody></tbody>

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
        <p class="small text-muted"><b><div id="messageArea"></div></b></p>
      </div>
    </div>
          
  </div>

  <div class="row">

    <div class="col-sm-12">
      <div class="container-fluid">
        <p class="text-center small text-muted">Powered By : <b>ITBS UG Mandiri@2024</b></p>
      </div>
    </div>
          
  </div>

  <br>

  <script src="<?php echo base_url(); ?>assets/js/socket.io.js"></script>

  <!-- Project Analytics -->
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/keen-analytics.js"></script>

  <!-- Responsivevoice -->
  <!-- Get API Key -> https://responsivevoice.org/ -->
  <script src="https://code.responsivevoice.org/responsivevoice.js?key=jQZ2zcdq"></script>

  <!-- Modal for Test Form -->
  <div class="modal fade" id="formTestModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                
              <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Form Test</h5>
              </div>

                <div class="modal-body">
                    <form name="form_test" id="form_test" action="<?php echo site_url() . 'content/hitApi' ?>" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="hitapi_parameter_id">Kategori</label>
                            <select class="form-control" id="hitapi_parameter_id" name="hitapi_parameter_id">
                                <!-- Add your select options here inez -->
                            </select>
                            
                            <input type="hidden" name="hitapi_hidden_id_content" id="hitapi_hidden_id_content" value="">
                            <!--<input type="hidden" name="hidden_edit_parameter_id" id="hidden_edit_parameter_id" value="">-->
                        </div>

                        <div class="form-group">
                            <label for="hitapi_variable_id">Variable</label>
                            <select class="form-control" id="hitapi_variable_id" name="hitapi_variable_id">
                                <!-- Add your select options here -->
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="hitapi_state">Set Count</label>
                            <div class="input-group">
                              <input type="text" class="form-control" id="hitapi_state" name="hitapi_state">
                              <span class="input-group-addon">Count</span>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button onclick="updateFormTest()" type="button" class="btn btn-primary" id="updateDatabase">Submit</button>
                </div>
            </div>
        </div>
    </div>

  <link rel="stylesheet" href="assets/css/animate.css" media="screen" type="text/css" />

  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 28px;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    input[type="checkbox"] {
      transform: scale(1.5);
    }

    #is_data_ada{
      display: none;
    }

    #messageInput{
      /* display: block; */
    }
  </style>

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

    /*
    .blinking-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin: 0 auto;
        animation: blinker 1s linear infinite;
        float: right;
        background-color: #e74c3c;
    }
    */

    @keyframes blinker {
        50% {
            opacity: 0;
        }
    }
  </style>

  <style>
  #slide-container {
    position: absolute;
    top: 0vh;
    width: 100%;
    height: 6vh;
    /*background: #004689;*/
    opacity: .9;
    z-index: 20;
    overflow: hidden;
    overscroll-behavior: contain;
    display: flex;
    justify-content: center;
  }

  #first-content {
      top: 0vh;
      position: absolute;
      z-index: 50;
      position: absolute;
      width: 100%;
      margin: 0;
      text-align: center;
      white-space: nowrap;
      -webkit-transform: translateX(100%);
      -webkit-animation: scroll-left 60s linear infinite;
  }

  .header-text {
    font-family: 'Helvetica', sans-serif;
    font-size: 1vw;
    color: #0D0D0D;
    width: 100vw;
  }
  </style>

  <script type="text/javascript">

  var interval = parseInt($('#interval_trigger_alert').val());
  var initialSecond = Math.floor(interval / 1000);
  var second = initialSecond;

  const messageArea = document.getElementById('messageArea');
  messageArea.innerHTML = '';

  $('#info_interval_request').html('');

  let isSystemOn = $('#is_system_on').val();

  function countDownRequest() {

        second = second - 1;

        if (isSystemOn == 1) {
          
          $('#info_interval_request').html('Interval Request Data : ' + second + ' seconds');        

        } else {
          $('#info_interval_request').html('System Off');
        }

        if (second == 0) {
            
          second = initialSecond; // Reset ke nilai awal

          // getRunningText();
          // getData();
          // getStateAlert();

          // getLastData();

          lastSynchronized();

        }

  }

    if(isSystemOn == 1){

      messageArea.innerHTML += 'Status : System On';
      console.log('System On');

      //getData();
      //getStateAlert();
      //getRunningText();

      // just for list data
      //setInterval(getData, $('#interval_get_data').val());
      
      // for alert light and sound socket.send('refresh');
      //setInterval(getStateAlert, $('#interval_trigger_alert').val());

      //socket.send('refresh');
      //console.log('web socket send refresh');

      // just for running text fitur
      //setInterval(getRunningText, $('#interval_trigger_alert').val());

    } else {

      messageArea.innerHTML += 'Status : System Off';
      console.log('System Off');
      
    }

    $('#is_data_ada').hide();

    let variable_apis_url_web_socket = $('#variable_apis_url_web_socket').val();

    if (isSystemOn == 1){
        //$('#info_system_on').html('System On');
        $('#info_interval_request').html('Interval Request Data : ' + second + ' seconds');
        let interval_count_down_request = 1000;
        var count_down_request = setInterval(countDownRequest, interval_count_down_request);
    } else {
        //$('#info_system_on').html('System Off');
        let interval_count_down_request = 0;
        $('#info_interval_request').html('');
    }

    // socket io

    // Buat koneksi socket dengan konfigurasi yang telah ditentukan
    // var socket = io('https://your_socket_io_server_address', socketConfig);

    // const socket = new WebSocket('ws://' + variable_apis_url_web_socket);
    // wss://itbs.slmugmandiri.co.id:3000
    // const socket = new WebSocket('wss://' + '38.47.76.231:3000');
    // const socket = new WebSocket('ws://192.168.99.1:3030');
    const socket = new WebSocket('ws://192.168.3.78:3030');

    socket.onopen = function(event) {

      console.log('Your Controller System Connected to WebSocket server');
      const messageArea = document.getElementById('messageArea');
      messageArea.innerHTML = '';
      messageArea.innerHTML += 'Status : Connected to Server';
      //socket.send('refresh');

    };

    $('.selectpicker').selectpicker({
      style: 'btn-info',
      size: 5
    });

    function sendMessage() {
      const inputElement = document.getElementById('messageInput');
      const message = inputElement.value;
      socket.send(message);
      inputElement.value = ''; // Clear input field
    }

    function playSoundSequence() {
        
        // Play sound1
        $('#sound1')[0].play();

        // Wait for sound1 to finish, then play sound2
        $('#sound1').on('ended', function() {
          $('#sound2')[0].play();
        });

        // Add more logic for additional sounds in the sequence

    }

    function separatorAngka(number) {
      return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function getLastLocation(rfid_tag_number) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url(); ?>home/get_last_location/',
                data: { rfid_tag_number: rfid_tag_number },
                success: function(response) {
                    var responseData = JSON.parse(response);
                    if (responseData.is_data_ada == true) {
                        resolve(responseData.data[0]);
                    } else {
                        resolve(null); // atau bisa menggunakan reject untuk handle data kosong
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                    reject(error);
                }
            });
        });
    }

    function getLastDetection(rfid_tag_number, room_id, reader_angle) {

      //alert('getLastDetection: rfid_tag_number: ' + rfid_tag_number + ', room_id: ' + room_id + ', reader_angle: ' + reader_angle);

        return new Promise(function(resolve, reject) {
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url(); ?>home/get_last_detection/',
                data: { 
                  rfid_tag_number: rfid_tag_number,
                  room_id: room_id,
                  reader_angle: reader_angle
                },
                success: function(response) {

                    var responseData = JSON.parse(response);

                    // alert('getLastDetection: responseData.is_data_ada: ' + responseData.is_data_ada);
                    
                    if (responseData.is_data_ada == true) {
                        resolve(responseData.data[0]);
                    } else {
                        resolve(null); // atau bisa menggunakan reject untuk handle data kosong
                    }

                },
                error: function(xhr, status, error) {
                    console.log(error);
                    reject(error);
                }
            });
        });

    }

    function updateStatus(id_temp_table, rfid_tag_number, output, room_id, reader_id, kategori_pergerakan, keterangan_pergerakan, lokasi_terakhir, nama_lokasi_terakhir) {

      // alert('Update Status: ' + rfid_tag_number + ' - ' + output + ' - ' + room_id + ' - ' + reader_id + ' - ' + kategori_pergerakan + ' - ' + keterangan_pergerakan + ' - ' + lokasi_terakhir + ' - ' + nama_lokasi_terakhir);

        return new Promise(function(resolve, reject) {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url(); ?>home/update_status/',
                data: { 
                  id_temp_table: id_temp_table, 
                  rfid_tag_number: rfid_tag_number, 
                  output: output, 
                  room_id: room_id, 
                  reader_id: reader_id,
                  kategori_pergerakan: kategori_pergerakan,
                  keterangan_pergerakan: keterangan_pergerakan,
                  lokasi_terakhir: lokasi_terakhir,
                  nama_lokasi_terakhir: nama_lokasi_terakhir
                },
                success: function(response) {
                    var responseData = JSON.parse(response);
                    if (responseData.is_success == true) {
                        resolve(responseData.message);
                    } else {
                        reject("Update failed.");
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                    reject(error);
                }
            });
        });
    }
    
    function ambilData(startTime, endTime) {
      
      // alert('ambilData: ' + startTime + ' - ' + endTime);
      // console.log('ambilData: ' + startTime + ' - ' + endTime);

      const payload = {
        "event": "report-logs",
        "value": {
          "conditions": {
            "start_date": startTime,
            "end_date": endTime
          }
        }
      };
      
      // socket.send(JSON.stringify(payload));

    }

    function getData() {

      <?php
        // foreach ($ruas as $k => $v) {
      ?>

        var $parameter_id = '0';
        $parameter_id = $('#filter_id_parameter').val();

        let field_for_comparison = $('#field_for_comparison').val();
        let parameter_threshold = 0;

        //$("#your_table_id tbody").append('');
        $('#your_table_id tbody tr').remove();

        $.getJSON('<?php echo site_url(); ?>home/get_state/'+$parameter_id, function(data) {

          /*
          $.each(data, function(index, element) {
            
            console.log(index + ": " + element.nama_parameter);
            console.log(index + ": " + element.nama_variable);
            console.log(index + ": " + element.total_data);

          });
          */

          //console.log(data);

          let no_urut = 1;
          //for (var i in data) {
          $.each(data, function(index, element) {

              var is_data_passive = element.is_data_passive;

              var integrasi_data = (is_data_passive == 1) ? 'Pasif' : 'Aktif';

              var waktu = element.waktu;
              var tanggal = new Date(waktu);
              var bulan = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
              
              var waktu_indonesia = tanggal.getDate() + '-' + bulan[tanggal.getMonth()] + '-' + tanggal.getFullYear() + ' ' + tanggal.getHours() + ':' + tanggal.getMinutes() + ':' + tanggal.getSeconds();

              var nama_parameter = element.nama_parameter;
              var nama_variable = element.nama_variable;

              var total_qty_parameter = element.total_data;
              total_qty_parameter = separatorAngka(total_qty_parameter);
              
              var is_parameter_active = element.is_parameter_active;
              var is_reverse_threshold = element.is_reverse_threshold;

              var mode_threshold = (is_reverse_threshold == 0) ? 'Normal' : 'Reverse';
              
              var state = parseFloat(element.state);
              //state = parseInt(state);

              var threshold_state_qty_proactive = element.threshold_state_qty_proactive;
              var threshold_state_persentase_proactive = element.threshold_state_persentase_proactive;
              var light_proactive = element.light_proactive;
              var sound_proactive = element.sound_proactive;
              
              var threshold_state_qty_active = parseFloat(element.threshold_state_qty_active);
              //threshold_state_qty_active = parseInt(threshold_state_qty_active);

              parameter_threshold = parseFloat(element[field_for_comparison]);
              //parameter_threshold = element[field_for_comparison];

              var threshold_state_persentase_active = element.threshold_state_persentase_active;
              var light_active = element.light_active;
              var sound_active = element.sound_active;
              var nama_sound = element.nama_sound;
              var light_color_code = element.light_color_code;

              var is_reverse_threshold = element.is_reverse_threshold;

              //var status = (is_reverse_threshold == 0 && state > parameter_threshold) ? 'bg-danger':'bg-success';

              if (is_data_passive == 1) {

                var status = 'bg-danger';

              } else if (is_data_passive == 0) {
              
                if (is_reverse_threshold == 0) {
                  var status = (state > parameter_threshold) ? 'bg-danger':'bg-success';
                } else {
                  var status = (state < parameter_threshold) ? 'bg-danger':'bg-success';
                }

              }

              /*
              var keterangan_status = (data[i].state < data[i].threshold_state_qty_proactive) ? 'Normal' 
              :(data[i].state >= data[i].threshold_state_qty_proactive && data[i].state < data[i].threshold_state_qty_active) ? 'Proactive' 
              :'Alert Active';
              */

              var keterangan_status = '';

              if (is_data_passive == 1) {
                keterangan_status = 'Alert Active';
              } else if (is_data_passive == 0) {
              
                if (is_reverse_threshold == 0){
                  keterangan_status = (state < parameter_threshold) ? 'Normal' : 'Alert Active';
                } else {
                  keterangan_status = (state < parameter_threshold) ? 'Alert Active' : 'Normal';
                }

              }

              // Append to HTML table
              var tableRow = '<tr>' +
                '<td style="text-align:center;">' + no_urut + '</td>' +
                '<td style="text-align:left;">' + nama_variable + '</td>' +
                
                //'<td style="text-align:center;">' + total_qty_parameter + '</td>' +
                //'<td style="text-align:center;"><input type="checkbox" value="' + is_parameter_active + '" ' + ((is_parameter_active == 1) ? 'checked' : '') + ' disabled></td>' +

                '<td style="text-align:center;">' + mode_threshold + '</td>' +
                '<td style="text-align:center;">' + waktu_indonesia + '</td>' +
                '<td style="text-align:center;">' + state + '</td>' +

                '<td style="text-align:center;">' + threshold_state_qty_active + '</td>' +
                '<td style="text-align:center;">' + parameter_threshold + '%</td>' +
                '<td style="text-align:center;">' + ((light_color_code != '')?light_color_code:'') + '</td>' +
                '<td style="text-align:center;">'+nama_sound+'</td>' +

                '<td style="text-align:center;"><div class="' + status + '">' + keterangan_status + '</div></td>' +
                '</tr>';

              $("#your_table_id tbody").append(tableRow);

              // jalanin voice disini
              //textToSpeech(nama_parameter + ', ' + nama_variable + ', ' + 'mati');

              /*
              setTimeout(function() {
                //your code to be executed after 1 second
              }, 500);
              */

              no_urut=no_urut+1;
          });

        });

      <?php
        // }
      ?>
    }

    function textToSpeech(buzzer, text) {

        // Code to convert text to speech
        console.log("Speaking: " + text);

        var bell = document.getElementById(buzzer);

        // mainkan suara bell antrian
        bell.src = bell.src + "?v=" + Math.random(); // Add a random query parameter to the URL to ensure the browser treats it as a new resource
        bell.type = "audio/wav"; // Set the correct "Content-Type" response header for the audio file
        bell.pause();
        bell.currentTime = 0;
        bell.play();
        //bell.play();

        // set delay antara suara bell dengan suara nomor antrian
        durasi_bell = bell.duration * 770;

        // mainkan suara nomor antrian
        setTimeout(function() {
            
          //responsiveVoice.speak("Nomor Antrian, " + data["jenis_klinik"] + data["no_antrian"] + ", menuju, " + nama_ruangan, "Indonesian Female", {
          responsiveVoice.speak(text, "Indonesian Female", {
            rate: 0.9,
            pitch: 1,
            volume: 1
          });
          
        }, durasi_bell);

    }

    function speakTextPeriodically(text, interval) {
        setInterval(function() {
            textToSpeech(text);
        }, interval);
    }

    // Append data to the table
    function appendDataToTable(data) {

      // $('#your_table_id tbody tr').remove();

      var parsedData = JSON.parse(data);

      $('#your_table_id tbody').append(`
              
            <tr>
              <td>${parsedData.event}</td>
              <td>${parsedData.type}</td>
              <td>${parsedData.data}</td>
              <td>${parsedData.data_tid}</td>
              <td>${parsedData.pc}</td>
              <td>${parsedData.user}</td>
              <td>${parsedData.ant}</td>
              <td>${parsedData.rssi}</td>
              <td>${parsedData.sensor}</td>
              <td>${parsedData.rfid_valid == 1 ? 'Valid' : 'Tidak Valid'}</td>
            </tr>

        `);

        
    }
  </script>

  <script type="text/javascript">

  $(document).ready(function() {

    $.get("<?= base_url('config/isSystemOn') ?>", function(data, status) {

      if(data == 1) {
        $("#toggleSwitch").prop('checked', true);
        $("#toggleText").text("On");
      } else {
        $("#toggleSwitch").prop('checked', false);
        $("#toggleText").text("Off");
      }

    });

    $("#toggleSwitch").change(function() {

      if(this.checked) {
        
        if (confirm("Apakah Anda yakin sistem ingin diaktifkan ?")) {

          $.get("<?= base_url('config/updateToggleSwitch/1') ?>", function(data, status) {

            var dataObj = JSON.parse(data);

            if(dataObj.is_success == true) {
              //$("#toggleText").text("On");
              alert("Sistem berhasil diaktifkan !!");
            } else {
              //$("#toggleText").text("Off");
              alert("Sistem gagal diaktifkan !!");
            }

            location.reload();

          });  

        } else {
          this.checked = false;
        }

      } else {

        if (confirm("Apakah Anda yakin sistem ingin dinonaktifkan ?")) {

          $('#lastSynchronized').html('');
          $('#info_interval_request').html('');

          $.get("<?= base_url('config/updateToggleSwitch/0') ?>", function(data, status) {

            var dataObj = JSON.parse(data);

            if(dataObj.is_success == true) {
              //$("#toggleText").text("On");
              alert("Sistem berhasil dinonaktifkan !!");
            } else {
              //$("#toggleText").text("Off");
              alert("Sistem gagal diaktifkan !!");
            }

            location.reload();

          });  

        } else {
          this.checked = true;
        }

      }

    });

    socket.onmessage = function(event) {

      var parsedData = JSON.parse(event.data);
      var event_name = parsedData.event;

      if (event_name == 'response-db-storage-rfid-list-check'){
        
        const messageArea = document.getElementById('messageArea');
        messageArea.innerHTML = '';
        messageArea.innerHTML += 'Receive Data from Server';
        console.log(event.data);

        appendDataToTable(event.data);

      }

    };

    var text = "Status ATM Down, " + "ada yang mati";
    var interval = 60000; // 60 seconds interval
    //speakTextPeriodically(text, interval);

    // separator

    //updateClock();
    // lastSynchronized();
    //tanggal();
    //jam();
    setInterval('updateClock()', 1000);
    // setInterval('lastSynchronized()', 1000);

    /*
    setInterval(function() {

      getStateAlert;
      console.log('refresh state alert');
      socket.send('refresh');
      console.log('web socket send refresh');

    }, $('#interval_trigger_alert').val());
    */

    $('#hitapi_parameter_id').on('change', function(){
      load_dropdown_variable(this.value);
    });

    $('#filter_id_parameter').on('change', function(){

      //var selected = $(this).find("option:selected").val();

      let selected = $(this).val();
      console.log(selected);

      // get data
      getData();

    });

  });

  </script>

  <script type="text/javascript">

    function getWaktuSekarang() {

      var d = new Date();
      var month = d.getMonth()+1;
      var day = d.getDate();
      var hour = d.getHours();
      var minute = d.getMinutes();
      var second = d.getSeconds();

      if(month < 10) {
        month = '0' + month;
      }

      if(day < 10) {
        day = '0' + day;
      }

      if(hour < 10) {
        hour = '0' + hour;
      }

      if(minute < 10) {
        minute = '0' + minute;
      }

      if(second < 10) {
        second = '0' + second;
      }

      // var start_date = "2024-11-13T08:00:01";
      // var end_date = "2024-11-14T16:00:00";

      var dateTime = d.getFullYear() + '-' + month + '-' + day + ' ' + hour + ':' + minute + ':' + second;

      return dateTime;
      
    }

    function lastSynchronized(){
      var dateTime = getWaktuSekarang();
      var startTime = new Date(dateTime);
      // startTime.setSeconds(startTime.getSeconds() - 300000); 5 menit terakhir
      startTime.setHours(startTime.getHours() - 1);
      $('#lastSynchronized').html('&nbsp;Last Synchronize : ' + dateTime);
      $('#endTime').val(dateTime);
      // ambilData(startTime, dateTime);
    }

    function updateClock()
    {

      var d = new Date();
      var month = d.getMonth()+1;
      var day = d.getDate();
      var hour = d.getHours();
      var minute = d.getMinutes();
      var second = d.getSeconds();

      if(month < 10) {
        month = '0' + month;
      }

      if(day < 10) {
        day = '0' + day;
      }

      if(hour < 10) {
        hour = '0' + hour;
      }

      if(minute < 10) {
        minute = '0' + minute;
      }

      if(second < 10) {
        second = '0' + second;
      }
      
      $('#liveClock').val(hour + ":" + minute + ":" + second);

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

    function addTest() {

      $('#formTestModal').modal('show');
      $('#hitapi_state').val('0');

      load_dropdown_parameter();

    }

    function resetData() {

      if(confirm("Are you sure you want to proceed?")){
        
        $.ajax({
          type: 'POST',
          url: '<?php echo site_url(); ?>content/resetData/',
          success: function(response) {
              // handle success response here
              console.log(response);
              var responseData = JSON.parse(response);

              if (responseData.is_success == true){
                alert(responseData.message);
                window.location.reload();
                return false;
              }

          },
          error: function(xhr, status, error) {
              // handle error here
          }
        });

      }

    }

    function updateFormTest(){

      // Add your button click logic here

      if ($('#hitapi_parameter_id').val() == '0'){
        alert('Parameter harus dipilih');
        return false;
      }

      if ($('#hitapi_variable_id').val() == '0'){
        alert('Variable harus dipilih');
        return false;
      }

      $.ajax({
        url: "<?php echo site_url(); ?>content/updateFormTest/",
        type: "POST",
        data: $('#form_test').serialize(),
        success: function(response){

            // handle success response here
            console.log(response);

            var responseData = JSON.parse(response);

            if (responseData.is_success == true){
              alert(responseData.message);
              location.reload();
              return false;
            } else {
              alert(responseData.message);
              return false;
            }

        },
        error: function(xhr, status, error){
            // handle error here
        }

      });

    }

  function load_dropdown_parameter(){
		
		//get a reference to the select element
		var $parameter_id = $('#hitapi_parameter_id');
    $("#hitapi_parameter_id").html('<option value="0">Loading...</option>');

		let hidden_parameter_id = $("#hidden_parameter_id").val();

		$.ajax({
		method: "POST",
		url:'<?php echo site_url() . 'content/load_dropdown_parameter'; ?>',
		dataType: 'JSON', 
		success: function(data){

			if (data.is_data_ada){

				//clear the current content of the select
				$parameter_id.html('');
				$parameter_id.append('<option value = "0">- Silahkan Pilih -</option>');

				//iterate over the data and append a select option

				$.each(data.list_data, function (key, val){

					if (hidden_parameter_id == val.id){
						$parameter_id.append('<option selected="selected" value = "' + val.id_parameter + '">' + val.nama_parameter + '</option>');
					} else {
						$parameter_id.append('<option value = "' + val.id_parameter + '">' + val.nama_parameter + '</option>');
					}

				});

        $parameter_id.val('0').change();

			} else {
				$parameter_id.html('<option value = "0">- Tidak Ada Data -</option>');
			}

		}, 				
		error: function(){
			//if there is an error append a 'none available' option
			$parameter_id.html('<option value = "0">- Tidak Ada Data -</option>');
		}

		});

	}

  function load_dropdown_variable(id_parameter){
		
		//get a reference to the select element
		var $variable_id = $('#hitapi_variable_id');
    $("#hitapi_variable_id").html('<option value="0">Loading...</option>');

		let hidden_variable_id = $("#hidden_variable_id").val();

		$.ajax({
		method: "POST",
		url:'<?php echo site_url() . 'content/load_dropdown_variable'; ?>',
		dataType: 'JSON', 
		data: {id_parameter: id_parameter},	
		success: function(data){

			if (data.is_data_ada){

				//clear the current content of the select
				$variable_id.html('');
				$variable_id.append('<option value = "0">- Silahkan Pilih -</option>');

				//iterate over the data and append a select option

				$.each(data.list_data, function (key, val){

					if (hidden_variable_id == val.id){
						$variable_id.append('<option selected="selected" value = "' + val.id_variable + '">' + val.nama_variable + '</option>');
					} else {
						$variable_id.append('<option value = "' + val.id_variable + '">' + val.nama_variable + '</option>');
					}

				});

        $variable_id.val('0').change();

			} else {
				$variable_id.html('<option value = "0">- Tidak Ada Data -</option>');
			}

		}, 				
		error: function(){
			//if there is an error append a 'none available' option
			$variable_id.html('<option value = "0">- Tidak Ada Data -</option>');
		}

		});

	}
  </script>

</body>
</html>

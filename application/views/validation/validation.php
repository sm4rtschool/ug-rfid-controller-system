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

          <label class="switch" style="float: left;">
            <input type="checkbox" id="toggleSwitch">
            <span class="slider round"></span>
          </label>

          <strong id="toggleText" style="float: left; margin-left: 10px; margin-right: 5px; text-align: center; font-weight: small; font-size: 21px; font-style: italic;">Off</strong>

          <input type="hidden" name="protocol_ws_server" id="protocol_ws_server" value="<?php echo $qrypengaturan_sistem->validation_protocol_ws_server; ?>">
          <input type="hidden" name="ip_address_server" id="ip_address_server" value="<?php echo $qrypengaturan_sistem->validation_ip_address_server; ?>">
          <input type="hidden" name="port_ws_server" id="port_ws_server" value="<?php echo $qrypengaturan_sistem->validation_port_ws_server; ?>">
          <input type="hidden" name="auto_reconnect" id="auto_reconnect" value="<?php echo $qrypengaturan_sistem->validation_auto_reconnect; ?>">

          <input type="hidden" name="timeout_duration" id="timeout_duration" value="<?php echo $qrypengaturan_sistem->timeout_duration; ?>">
          <input type="hidden" name="is_system_on" id="is_system_on" value="<?php echo $qrypengaturan_sistem->is_system_on; ?>">

          <!-- <input type="hidden" name="interval_get_data" id="interval_get_data" value="<?php echo $config_list_data->value; ?>">

          <input type="hidden" name="interval_global_sound" id="interval_global_sound" value="<?php echo $config_global_sound->value; ?>">
          <input type="hidden" name="variable_global_sound" id="variable_global_sound" value="<?php echo $config_global_sound->variable; ?>">

          <input type="hidden" name="interval_apis_url_play_sound" id="interval_apis_url_play_sound" value="<?php echo $config_apis_url_play_sound->value; ?>">
          <input type="hidden" name="variable_apis_url_play_sound" id="variable_apis_url_play_sound" value="<?php echo $config_apis_url_play_sound->variable; ?>">

          <input type="hidden" name="interval_apis_url_web_socket" id="interval_apis_url_web_socket" value="<?php echo $config_apis_url_web_socket->value; ?>">
          <input type="hidden" name="variable_apis_url_web_socket" id="variable_apis_url_web_socket" value="<?php echo $config_apis_url_web_socket->variable; ?>">

          <input type="hidden" name="interval_global_light_color" id="interval_global_light_color" value="<?php echo $config_global_light_color->value; ?>">
          <input type="hidden" name="variable_global_light_color" id="variable_global_light_color" value="<?php echo $config_global_light_color->variable; ?>">

          <input type="hidden" name="is_controller_on" id="is_controller_on" value="<?php echo $config_ip_address_controller->value; ?>">
          <input type="hidden" name="variable_ip_address_controller" id="variable_ip_address_controller" value="<?php echo $config_ip_address_controller->variable; ?>"> -->

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
              <th style="text-align: center;">No</th>
              <th style="text-align: center;">Ruangan</th>
              <th style="text-align: center;">Gate</th>
              <th style="text-align: center;">RFID Tag Number</th>
              <th style="text-align: center;">Nama Aset</th>
              <th style="text-align: center;">Kode Aset</th>
              <th style="text-align: center;">NUP</th>
              <th style="text-align: center;">Status</th>
              <th style="text-align: center;">Waktu</th>
              <th style="text-align: center;">Categori</th>
              <th style="text-align: center;">Description</th>
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
  <!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/keen-analytics.js"></script> -->

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

  const messageArea = document.getElementById('messageArea');
  messageArea.innerHTML = '';

  let isSystemOn = $('#is_system_on').val();

  if (isSystemOn == 1){
    messageArea.innerHTML += 'Status : System On';
    console.log('System On');
    //socket.send('refresh');
    //console.log('web socket send refresh');
  } else {
    messageArea.innerHTML += 'Status : System Off';
    console.log('System Off');
  }

  $('#is_data_ada').hide();

  var ip_address_server = $('#ip_address_server').val();
  var port_ws_server = $('#port_ws_server').val();
  var protocol_ws_server = $('#protocol_ws_server').val();
  var auto_reconnect = $('#auto_reconnect').val();

  // ws://localhost:8080
  // const socket = new WebSocket('ws' + '://' + 'localhost' + ':' + '8080');
  const socket = new WebSocket(protocol_ws_server + '://' + ip_address_server + ':' + port_ws_server);

  socket.onopen = function(event) {
      console.log('Your Controller System Connected to WebSocket server');
      const messageArea = document.getElementById('messageArea');
      messageArea.innerHTML = '';
      messageArea.innerHTML += 'Status : Connected to Server';
      //socket.send('refresh');
  };

  socket.onclose = function(e) {

    console.log('Socket is closed. Reconnect will be attempted in ', auto_reconnect, ' ms.', e.reason);

    const messageArea = document.getElementById('messageArea');
    messageArea.innerHTML = '';
    messageArea.innerHTML += 'Status : Disconnected from Server';

    setTimeout(function() {
      location.reload();
    }, auto_reconnect);

  };

  socket.onerror = function(err) {
    console.error('Socket encountered error: ', err.message, 'Closing socket');
    socket.close();
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

    // Append data to the table
    function appendDataToTable(data) {

      // $('#your_table_id tbody tr').remove();

      var parsedData = JSON.parse(data);

      $('#your_table_id tbody').append(`
              
            <tr>
              <td>${parsedData.value.id}</td>
              <td>${parsedData.value.tid}</td>
              <td>${parsedData.value.epc}</td>
              <td>${parsedData.value.status}</td>
              <td>${parsedData.value.created_time}</td>
              <td>${parsedData.value.description}</td>
              <td>${parsedData.value.category}</td>
              <td>${parsedData.value.flag_alarm}</td>
              <td>${parsedData.value.ant}</td>
              <td>${parsedData.value.alias_antenna}</td>
              <td>${parsedData.value.no_sku}</td>
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

    var uniqueDataArray = [];
    var postTimeout = null; // Timer untuk mendeteksi tidak ada data baru
    var timeoutDuration = $('#timeout_duration').val(); // Waktu tunggu (ms) untuk memposting data ke database

    let tidCount = {}; // Objek untuk menghitung frekuensi pembacaan TID
    const eventInterval = 60000; // 1 menit
    let lastCheckTime = Date.now();
    var no = 1;

    function resetPostTimer() {

      clearTimeout(postTimeout); // Hentikan timer sebelumnya
      
      postTimeout = setTimeout(() => {
          console.log('Memanggil postToDatabase...');
          postToDatabase();
      }, timeoutDuration);
      
      // console.log('Timer telah di-reset dengan durasi:', timeoutDuration);
  
    }


    socket.onmessage = function (event) {

      var parsedData = JSON.parse(event.data);
      var event_name = parsedData.event;

      if (event_name === 'assetUpdate') {

        const room_name = parsedData.data.room_name;
        const reader_gate = parsedData.data.reader_gate;
        const rfid_tag_number = parsedData.data.rfid_tag_number;
        const nama_aset = parsedData.data.nama_aset;
        const kode_aset = parsedData.data.kode_aset;
        const nup = parsedData.data.nup;
        const reader_angle = parsedData.data.reader_angle;
        const timestamp = parsedData.data.timestamp;
        const kategori_pergerakan = parsedData.data.kategori_pergerakan;
        const keterangan_pergerakan = parsedData.data.keterangan_pergerakan;

        $('#your_table_id tbody').prepend(`
          <tr>
              <td style="text-align: center;">${no++}</td>
              <td style="text-align: center;">${room_name}</td>
              <td style="text-align: center;">${reader_gate}</td>
              <td style="text-align: center;">${rfid_tag_number}</td>
              <td style="text-align: center;">${nama_aset}</td>
              <td style="text-align: center;">${kode_aset}</td>
              <td style="text-align: center;">${nup}</td>
              <td style="text-align: center;">${reader_angle}</td>
              <td style="text-align: center;">${timestamp}</td>
              <td style="text-align: center;">${kategori_pergerakan}</td>
              <td style="text-align: center;">${keterangan_pergerakan}</td>
          </tr>
        `);

        if ($('#your_table_id tbody tr').length > 20) {
            $('#your_table_id tbody tr:last').remove();
        }

      }

    };

    // Fungsi untuk memposting data ke database
    function postToDatabase() {

        if (uniqueDataArray.length > 0) {
            console.log('Posting data ke database:', uniqueDataArray);

            // Kirim data ke server menggunakan AJAX
            $.ajax({
                url: '<?= base_url('controller/postToDatabase') ?>', // Ganti dengan URL endpoint Anda
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ data: uniqueDataArray }),
                success: function (response) {

                    var response = JSON.parse(response);

                    if (response.is_success) {
                        
                      // console.log(response.message, response.data);
                      console.log('Data berhasil disimpan ke database:', response);
                      // Kosongkan array setelah data berhasil diposting
                      uniqueDataArray = [];
                      $('#your_table_id tbody').empty();
                      tidCount = {};

                    } else {
                        console.error(response.message, response.data);
                    }
                    
                },
                error: function (xhr, status, error) {
                    console.error('Gagal mengirim data ke database:', error);
                }
            });
            
        } else {
            console.log('Tidak ada data untuk diposting.');
        }

    }

    //updateClock();
    //tanggal();
    //jam();
    setInterval('updateClock()', 1000);

    $('#filter_id_parameter').on('change', function(){
      //var selected = $(this).find("option:selected").val();
      let selected = $(this).val();
      console.log(selected);
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
  </script>

</body>
</html>

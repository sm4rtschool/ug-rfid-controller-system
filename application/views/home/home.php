  <div class="container-fluid">

    <div class="row">

      <div class="col-sm-12">

        <div class="chart-hd">
          
          <strong>Pilih Kategori : </strong>

          <select name="filter_id_parameter" id="filter_id_parameter" class="selectpicker" data-live-search="true">
            <option value="0">- All -</option>  
            <?php foreach ($area as $k => $v) { ?>
              <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
            <?php } ?>
          </select>

          <!--<button type="button" class="btn btn-success" onClick="sendMessage()">Connect</button>-->
          <button type="button" class="btn btn-primary" onClick="addTest()">Add</button>
          <button type="button" class="btn btn-primary" onclick="window.location.reload()">Refresh</button>

          <input type="text" id="messageInput" placeholder="Type a message">

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

          <div id="is_data_ada" class="blinking-circle" style="width: 30px; height: 30px; border-radius: 50%; margin: 0 auto; animation: blinker 1s linear infinite; float: right; background-color: #e74c3c;"></div>

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
              
              <th style="width: 3%; text-align: center;">No.</th>
              <th style="width: 14%; text-align: center;">Nama Variable</th>
              <th style="width: 5%; text-align: center;">Total</th>
              <th style="width: 5%; text-align: center;">Active</th>
              <th style="width: 5%; text-align: center;">State</th>
              <th style="width: 10%; text-align: center;">Qty (Count)</th>
              <th style="width: 10%; text-align: center;">Qty (%)</th>
              <th style="width: 8%; text-align: center;">Light</th>
              <th style="width: 8%; text-align: center;">Sound</th>
              <th style="width: 7%; text-align: center;">Status</th>

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
      display: none;
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
    messageArea.innerHTML += 'Status : Trying to Connect to Server...';

    let variable_apis_url_web_socket = $('#variable_apis_url_web_socket').val();

    // socket io
    const socket = new WebSocket('ws://' + variable_apis_url_web_socket);

    socket.onopen = function(event) {
      console.log('Your Proactive Alert System Connected to WebSocket server');
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

    function getRunningText(){

      // textToSpeech(html_id, 'perhatian, ' + nama_variable + ', ' + 'saat ini mencapai ' + state + 'unit ATM');

      $.getJSON("<?php echo site_url(); ?>home/getRunningText", function(data){

        $rowCount = Object.keys(data).length;

        if ($rowCount > 0) {

          var items = '';
          var prefix = '';

          $.each(data, function( key, val ) {
            items += val.nama_variable + ' = ' + val.state + ' ~ ';
          });

          $('.header-text').text("Perhatian !! " + items);
          console.log("Perhatian !! " + items);

        } else {
          console.log('Saat ini kondisi terpantau aman !!');
          $('.header-text').text("Saat ini kondisi terpantau aman !!");
        }

      });

    }

    function separatorAngka(number) {
      return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function getStateAlert(){

      // config for sound and lamp

      $.getJSON('<?php echo site_url(); ?>home/get_state_alert', function(data) {

        var iCounter = 1;
        var iCounterNext = 1;
        var html_sound_prefix = 'sound';

        let interval_global_sound = $('#interval_global_sound').val();
        let variable_global_sound = $('#variable_global_sound').val();

        let interval_global_light_color = $('#interval_global_light_color').val();
        let variable_global_light_color = $('#variable_global_light_color').val();

        $rowCount = Object.keys(data).length;

        if ($rowCount > 0) {

          $('#is_data_ada').show();
          //console.log('alert light = on');

          for (var i in data){

            var nama_parameter = data[i].nama_parameter;
            var nama_variable = data[i].nama_variable;

            var is_tts = data[i].is_tts;
            var html_id = data[i].html_id;

            var state = data[i].state;
            var light_color_code = data[i].light_color_code;

            // config light color code

            // Add this jQuery code to change the CSS value of the div with class "blinking-circle red" background-color
            // <div id="is_data_ada" class="blinking-circle red" style="float: right; display: block;"></div>

            if (is_tts == 1) {
              // jalanin voice disini
              console.log('play text to speech');
              textToSpeech('buzzer', 'perhatian, ' + nama_variable + ', ' + 'saat ini mencapai ' + state + 'unit ATM');
            } else {

              if (interval_global_sound == '0') {
              
                var bell = document.getElementById(html_id);
                console.log('play sound = ' + html_id);

                // Ensure user interaction before playing the bell sound
                document.addEventListener('click', function() {
                    bell.play().catch(function(error) {
                        console.error('Audio playback was prevented:', error);
                    });
                });
                
              }

            }

            if (interval_global_light_color == '0') {
              $('.blinking-circle').css('background-color', light_color_code);
            }

          }
          // for (var i in data) {

          // cek apakah global sound aktif

          if (interval_global_sound == '1') {

            let variable_apis_url_play_sound = $('#variable_apis_url_play_sound').val();
            let interval_apis_url_play_sound = $('#interval_apis_url_play_sound').val();

            if (interval_apis_url_play_sound == '1') {
              
              $.get(variable_apis_url_play_sound, function(data){
                console.log('play sound global, hit apis');
              });

            }

            /*
            var bell_global_sound = document.getElementById(variable_global_sound);
            console.log('play sound = ' + variable_global_sound);

            // Ensure user interaction before playing the bell sound
            document.addEventListener('click', function() {
              
              bell_global_sound.play().catch(function(error) {
                console.error('Audio playback was prevented:', error);
              });
                  
            });
            */

          }

          // cek apakah global light color aktif

          if (interval_global_light_color == '1') {
            $('.blinking-circle').css('background-color', variable_global_light_color);
          }

        } else {
          
          $('#is_data_ada').hide();
          console.log('alert light = off');
          console.log('alert sound = off');

          // Ensure user interaction before playing the bell sound
          var audios = document.getElementsByTagName('audio');
          Array.prototype.forEach.call(audios, function(audio) {
              audio.pause();
          });

        }

      });

    }

    function getData() {

      <?php
        // foreach ($ruas as $k => $v) {
      ?>

        var $parameter_id = '0';
        $parameter_id = $('#filter_id_parameter').val();

        //$("#your_table_id tbody").append('');
        $('#your_table_id tbody tr').remove();

        $.getJSON('<?php echo site_url(); ?>home/get_state/'+$parameter_id, function(data) {

          let no_urut = 1;
          for (var i in data) {

              var nama_parameter = data[i].nama_parameter;
              var nama_variable = data[i].nama_variable;

              var total_qty_parameter = data[i].total_data;

              total_qty_parameter = separatorAngka(total_qty_parameter);
              
              var is_parameter_active = data[i].is_parameter_active;
              var state = data[i].state;
              state = parseInt(state);
              var threshold_state_qty_proactive = data[i].threshold_state_qty_proactive;
              var threshold_state_persentase_proactive = data[i].threshold_state_persentase_proactive;
              var light_proactive = data[i].light_proactive;
              var sound_proactive = data[i].sound_proactive;
              var threshold_state_qty_active = data[i].threshold_state_qty_active;
              threshold_state_qty_active = parseInt(threshold_state_qty_active);
              var threshold_state_persentase_active = data[i].threshold_state_persentase_active;
              var light_active = data[i].light_active;
              var sound_active = data[i].sound_active;
              var nama_sound = data[i].nama_sound;
              var light_color_code = data[i].light_color_code;

              var status = (state < threshold_state_qty_active) ? 'bg-success':'bg-danger';

              /*
              var keterangan_status = (data[i].state < data[i].threshold_state_qty_proactive) ? 'Normal' 
              :(data[i].state >= data[i].threshold_state_qty_proactive && data[i].state < data[i].threshold_state_qty_active) ? 'Proactive' 
              :'Alert Active';
              */

              var keterangan_status = '';

              if (state < threshold_state_qty_active){
                keterangan_status = 'Normal';
              } else {
                keterangan_status = 'Alert Active';
              }

              // Append to HTML table
              var tableRow = '<tr>' +
                '<td style="text-align:center;">' + no_urut + '</td>' +
                '<td style="text-align:left;">' + nama_variable + '</td>' +
                '<td style="text-align:center;">' + total_qty_parameter + '</td>' +
                
                '<td style="text-align:center;"><input type="checkbox" value="' + is_parameter_active + '" ' + ((is_parameter_active == 1) ? 'checked' : '') + ' disabled></td>' +

                '<td style="text-align:center;">' + state + '</td>' +

                '<td style="text-align:center;">' + threshold_state_qty_active + '</td>' +
                '<td style="text-align:center;">' + threshold_state_persentase_active + '%</td>' +
                '<td style="text-align:center;">' + ((light_color_code != '')?'<span style="background-color:'+light_color_code+';">Light Color</span>':'') + '</td>' +
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
          }

        });

      <?php
        // }
      ?>
    }
    // function getData() {

    function textToSpeech(buzzer, text) {

        // Code to convert text to speech
        console.log("Speaking: " + text);

        var bell = document.getElementById(buzzer);

        // mainkan suara bell antrian
        bell.pause();
        bell.currentTime = 0;
        bell.play();

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

      $('#your_table_id tbody tr').remove();

      var parsedData = JSON.parse(data);

      parsedData.forEach(function(item) {

        $('#your_table_id tbody').append(`
              
            <tr>
              <td>${item.id_content}</td>
              <td>${item.nama_parameter} - ${item.nama_variable}</td>
              <td>${item.state}</td>
            </tr>

        `);

      });
        
    }

  </script>

  <script type="text/javascript">

  $(document).ready(function() {

    socket.onmessage = function(event) {

      if (event.data == 'web_socket_online') {
        const messageArea = document.getElementById('messageArea');
        messageArea.innerHTML = '';
        messageArea.innerHTML += 'Status : Connected to Server';
      } else {
        const messageArea = document.getElementById('messageArea');
        messageArea.innerHTML = '';
        messageArea.innerHTML += 'Receive Data from Server';
        appendDataToTable(event.data);
      }

    };

    getData();
    getStateAlert();
    getRunningText();

    // just for list data
    setInterval(getData, $('#interval_get_data').val());
    
    // for alert light and sound socket.send('refresh');
    setInterval(getStateAlert, $('#interval_trigger_alert').val());

    //socket.send('refresh');
    //console.log('web socket send refresh');

    // just for running text fitur
    setInterval(getRunningText, $('#interval_trigger_alert').val());

    $('#is_data_ada').hide();

    var text = "Status ATM Down, " + "ada yang mati";
    var interval = 60000; // 60 seconds interval
    //speakTextPeriodically(text, interval);

    // separator

    updateClock();
    tanggal();
    jam();
    setInterval('updateClock()', 1000);

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

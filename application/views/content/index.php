<div class="container-fluid">

    <div class="row">

      <div class="col-sm-12">

        <div class="chart-hd">
          
          <strong>Pilih Kategori : </strong>

          <select name="filter_id_parameter" id="filter_id_parameter" class="selectpicker" data-live-search="true">

            <option value="0">- Pilih Kategori -</option>
            <?php foreach ($area as $k => $v) { ?>
              <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
            <?php } ?>

          </select>
     
          <button type="button" class="btn btn-success" onclick="get_datatables_checked()">Set State</button>

          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#databaseModal">Add</button>
          <!--<button type="button" class="btn btn-primary" onclick="window.location.reload()">Refresh</button>-->
          <button type="button" class="btn btn-primary" onclick="reload_datatables()">Refresh</button>

        </div>
        <!-- <div class="chart-hd"> -->
        
      </div>
      <!-- <div class="col-sm-12"> -->
  
    </div>
    <!-- <div class="row"> -->

</div>
<!-- <div class="container-fluid"> -->

<!-- Assuming you want to display the content table data in a datatable on the same page -->
<!-- Add the following code snippet after the <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script> line in your HTML file-->

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/functions.js" type="text/javascript"></script>

<script type="text/javascript">

  function clickColorAdd() {
      var color = $('#html5colorpickeradd').val();
      var hexColor = rgbToHex(color);
      console.log(hexColor);
      $('#light_color_code').val(hexColor);
  }

  function clickColor() {
      var color = $('#html5colorpicker').val();
      var hexColor = rgbToHex(color);
      console.log(hexColor);
      $('#edit_light_color_code').val(hexColor);
  }

  function componentToHex(c) {
      var hex = c.toString(16);
      return hex.length == 1 ? "0" + hex : hex;
  }

  function rgbToHex(rgb) {
      var match = /^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/.exec(rgb);
      if (match) {
          return "#" + componentToHex(parseInt(match[1])) + componentToHex(parseInt(match[2])) + componentToHex(parseInt(match[3]));
      }
      return rgb;
  }

  $('.selectpicker').selectpicker({
    style: 'btn-info',
    size: 5
  });

  function load_dropdown_parameter(id_parameter){
		
		//get a reference to the select element
		var $parameter_id = $('#parameter_id');
    $("#parameter_id").html('<option value="0">Loading...</option>');

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

        $parameter_id.val('0');

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

  function load_dropdown_parameter_edit(id_parameter){
		
    //get a reference to the select element
		var $edit_parameter_id = $('#edit_parameter_id');
    $("#edit_parameter_id").html('<option value="0">Loading...</option>');

		//let hidden_parameter_id = $("#hidden_parameter_id").val();
    let hidden_parameter_id = id_parameter;

		$.ajax({
		method: "POST",
		url:'<?php echo site_url() . 'content/load_dropdown_parameter'; ?>',
		dataType: 'JSON', 
		success: function(data){

			if (data.is_data_ada){

				//clear the current content of the select
				$edit_parameter_id.html('');
				$edit_parameter_id.append('<option value = "0">- Silahkan Pilih -</option>');

				//iterate over the data and append a select option

				$.each(data.list_data, function (key, val){

					if (hidden_parameter_id == val.id_parameter){
						$edit_parameter_id.append('<option selected="selected" value = "' + val.id_parameter + '">' + val.nama_parameter + '</option>');
					} else {
						$edit_parameter_id.append('<option value = "' + val.id_parameter + '">' + val.nama_parameter + '</option>');
					}

				});

			} else {
				$edit_parameter_id.html('<option value = "0">- Tidak Ada Data -</option>');
			}

		}, 				
		error: function(){
			//if there is an error append a 'none available' option
			$edit_parameter_id.html('<option value = "0">- Tidak Ada Data -</option>');
		}

		});

	}

  function load_dropdown_parameter_hitapi(id_parameter){
		
    //get a reference to the select element
		var $hitapi_parameter_id = $('#hitapi_parameter_id');
    $("#hitapi_parameter_id").html('<option value="0">Loading...</option>');

		//let hidden_parameter_id = $("#hidden_parameter_id").val();
    let hidden_parameter_id = id_parameter;

		$.ajax({
		method: "POST",
		url:'<?php echo site_url() . 'content/load_dropdown_parameter'; ?>',
		dataType: 'JSON', 
		success: function(data){

			if (data.is_data_ada){

				//clear the current content of the select
				$hitapi_parameter_id.html('');
				$hitapi_parameter_id.append('<option value = "0">- Silahkan Pilih -</option>');

				//iterate over the data and append a select option

				$.each(data.list_data, function (key, val){

					if (hidden_parameter_id == val.id_parameter){
						$hitapi_parameter_id.append('<option selected="selected" value = "' + val.id_parameter + '">' + val.nama_parameter + '</option>');
					} else {
						$hitapi_parameter_id.append('<option value = "' + val.id_parameter + '">' + val.nama_parameter + '</option>');
					}

				});

			} else {
				$hitapi_parameter_id.html('<option value = "0">- Tidak Ada Data -</option>');
			}

		}, 				
		error: function(){
			//if there is an error append a 'none available' option
			$hitapi_parameter_id.html('<option value = "0">- Tidak Ada Data -</option>');
		}

		});

	}

  function load_dropdown_variable(id_parameter){
		
		//get a reference to the select element
		var $variable_id = $('#variable_id');
    $("#variable_id").html('<option value="0">Loading...</option>');

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

        $variable_id.val('0');

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

  function load_dropdown_variable_edit(id_parameter, id_variable_old){
		
		//get a reference to the select element
		var $variable_id = $('#edit_variable_id');
    $("#edit_variable_id").html('<option value="0">Loading...</option>');

		let hidden_variable_id = id_variable_old;

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

					if (hidden_variable_id == val.id_variable){
						$variable_id.append('<option selected="selected" value = "' + val.id_variable + '">' + val.nama_variable + '</option>');
					} else {
						$variable_id.append('<option value = "' + val.id_variable + '">' + val.nama_variable + '</option>');
					}

				});

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

  function load_dropdown_variable_hitapi(id_parameter, id_variable_old){
		
		//get a reference to the select element
		var $variable_id = $('#hitapi_variable_id');
    $("#hitapi_variable_id").html('<option value="0">Loading...</option>');

		let hidden_variable_id = id_variable_old;

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

					if (hidden_variable_id == val.id_variable){
						$variable_id.append('<option selected="selected" value = "' + val.id_variable + '">' + val.nama_variable + '</option>');
					} else {
						$variable_id.append('<option value = "' + val.id_variable + '">' + val.nama_variable + '</option>');
					}

				});

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

  function load_dropdown_sound(id_sound){
		
		//get a reference to the select element
		var $parameter_id = $('#edit_sound_id');
    $("#edit_sound_id").html('<option value="0">Loading...</option>');

		let hidden_parameter_id = id_sound;

		$.ajax({
		method: "POST",
		url:'<?php echo site_url() . 'content/load_dropdown_sound'; ?>',
		dataType: 'JSON', 
		success: function(data){

			if (data.is_data_ada){

				//clear the current content of the select
				$parameter_id.html('');
				$parameter_id.append('<option value = "0">- Silahkan Pilih -</option>');

				//iterate over the data and append a select option

				$.each(data.list_data, function (key, val){

					if (hidden_parameter_id == val.id_sound){
						$parameter_id.append('<option selected="selected" value = "' + val.id_sound + '">' + val.nama_sound + '</option>');
					} else {
						$parameter_id.append('<option value = "' + val.id_sound + '">' + val.nama_sound + '</option>');
					}

				});

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

  function load_dropdown_sound_add(){
		
		//get a reference to the select element
		var $parameter_id = $('#sound_id');
    $("#sound_id").html('<option value="0">Loading...</option>');

		$.ajax({
		method: "POST",
		url:'<?php echo site_url() . 'content/load_dropdown_sound'; ?>',
		dataType: 'JSON', 
		success: function(data){

			if (data.is_data_ada){

				//clear the current content of the select
				$parameter_id.html('');
				$parameter_id.append('<option value = "0">- Silahkan Pilih -</option>');

				//iterate over the data and append a select option

				$.each(data.list_data, function (key, val){
					$parameter_id.append('<option value = "' + val.id_sound + '">' + val.nama_sound + '</option>');
				});

        $('#sound_id').val('0').change();

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

  function checkall(checkboxes){
    var checkbx = $("#check_all")[0];
    for (var i = 0; i < checkboxes.length; i++) {
      checkboxes[i].checked = checkbx.checked;
    }
  }

  function uncheck_all() {
    var checkboxes = document.getElementsByTagName('input');
    for (var i = 0; i < checkboxes.length; i++) {
      if (checkboxes[i].type == 'checkbox') {
        checkboxes[i].checked = false;
      }
    }
  }

  //get value from checkbox table
	function get_datatables_checked()
	{
    
    var table = $('#contentTable').DataTable();
		var rowcollection =  table.$(".cekbok:checked", {"page": "all"});
		var string_id = "";
		var string_kode_voucher = "";

		rowcollection.each(function(index,elem)
		{

		  var id = $(elem).val();
		  var kode_voucher = $(elem).data("id");

		  string_id = string_id + "~" + id;
		  string_kode_voucher = string_kode_voucher + kode_voucher + "~";

		  //console.log(string_kode_voucher + ' | ' + string_id);
      //console.log(string_id);

		});

    //delete_all_checklist(string_id);
    //alert(string_id);

    if (string_id == "") {
      alert('Pilih / Ceklis dulu data yang ingin di ubah statenya !!');
      return false;
    }

    setStateAll(string_id);
		
	}

  function setStateAll(id)
  {

    //alert(kdketidakhadiran);

    var input = prompt("Masukkan state yang ingin diubah :", "");

    if (input == null || input == "") {
      return false;
    }

    var number = /^\d+$/;

    if(input.match(number)) {
      //console.log("match");
    } else {
      alert("Please input only number !!");
      return false;
    }

    //alert(input);

    var snotif = '';
    var spesan_berhasil = '';

    snotif = 'Anda yakin ingin mengatur state semua data yang terceklis ?';
    spesan_berhasil = 'Set state data berhasil!!';

    var r = confirm(snotif);

    if (r == true)
    {

      $.ajax({
      type:'POST',
      url:'<?php echo site_url().'content/setStateAll'; ?>',
      data:{id:id, state:input},
      success: function(data)
      {

        var obj = jQuery.parseJSON(data);
   			status = obj['status'];
   			data_notif = obj['data_notif'];
   			msg = obj['msg'];

        if (status == 'success'){

          location.reload();
          alert(data_notif);
          return false;

   			}
   			else {
  				alert(data_notif);
   				return false;
   			}

      },
      error: function(){      
      alert('Set state data gagal!!');
      }

      }); // $.ajax({

    }
    
  }
</script>

<!-- Initialize DataTable on the table you want to display content data -->
<script>
$(document).ready(function() {

  load_dropdown_parameter();
  load_dropdown_sound_add();

  $('#filter_id_parameter').on('change', function(){

    //var selected = $(this).find("option:selected").val();

    let selected = $(this).val();
    console.log(selected);

    //window.location.replace("<?php echo site_url(); ?>");
    reload_datatables();

  });

  /*
  $('#sound3')[0].play();

  // Wait for sound1 to finish, then play sound2
  $('#sound3').on('ended', function() {
    $('#sound2')[0].play();
  });
  */

  /*
  var audioArray = document.getElementsByClassName('songs');
  var i = 0;
  audioArray[i].play();
  for (i = 0; i < audioArray.length - 1; ++i) {
      audioArray[i].addEventListener('ended', function(e){
          var currentSong = e.target;
          var next = $(currentSong).nextAll('audio');
          if (next.length) $(next[0]).trigger('play');
      });
  }
  */

  $('#parameter_id').change(function(){

    let id_parameter = $(this).val();

    $.getJSON("<?php echo site_url(); ?>content/getParameterById/" + id_parameter, function(response) {
      console.log(response);
      $('#total_qty_parameter').val(response.total_qty_parameter);
    });

  });

  $('#sound_id').change(function(){

    let id_sound = $(this).val();

    $.getJSON("<?php echo site_url(); ?>content/getSoundById/" + id_sound, function(response) {
        
      // code to handle the JSON data
      // Parse the JSON response here
      //var responseData = JSON.parse(response);
      console.log(response);
      //alert(response.is_tts);
                
      // Access the data from the response
      $('#is_tts').val(response.is_tts);
      $('#text_to_speech_active').val(response.text_tts);
      $('#html_id').val(response.html_id);

    });

  });

  $('#edit_sound_id').change(function(){

    let id_sound = $(this).val();

    $.getJSON("<?php echo site_url(); ?>content/getSoundById/" + id_sound, function(response) {
        
      // code to handle the JSON data
        // Parse the JSON response here
        //var responseData = JSON.parse(response);
        console.log(response);
                
        // Access the data from the response
        $('#edit_is_tts').val(response.is_tts);
        $('#edit_text_to_speech_active').val(response.text_tts);
        $('#edit_html_id').val(response.html_id);

    });

  });

  $('#edit_total_qty_parameter, #threshold_state_qty_active, #edit_threshold_state_qty_active, #threshold_state_qty_proactive, #edit_threshold_state_qty_proactive, #edit_interval').keyup(function(){
    FormNum(this);
  });

  // add data

  $('#is_parameter_active').change(function(){

    if (!this.checked) {
        // Code to execute when the checkbox is unchecked
        //alert('tidak ajib');
        $('#light_active').prop('checked', false);
        $('#sound_active').prop('checked', false);
        $('#light_proactive').prop('checked', false);
        $('#sound_proactive').prop('checked', false);
        $('#is_light_strobe_active').prop('checked', false);
        $('#label_is_parameter_active').html('Not Active');
    } else {
        //alert('ajib');
        $('#light_active').prop('checked', true);
        $('#sound_active').prop('checked', true);
        $('#light_proactive').prop('checked', true);
        $('#sound_proactive').prop('checked', true);
        $('#is_light_strobe_active').prop('checked', true);
        $('#label_is_parameter_active').html('Active');
    }

  });

  $('#threshold_state_qty_active').change(function(){
    let threshold_state_qty_active = $(this).val();
    let total_qty = $('#total_qty_parameter').val();
    let persen = (threshold_state_qty_active/total_qty)*100;
    $('#threshold_state_persentase_active').val(Math.round(persen));
  });

  $('#threshold_state_persentase_active').change(function(){
    let threshold_state_persentase_active = $(this).val();
    let total_qty = $('#total_qty_parameter').val();
    let qty = (threshold_state_persentase_active/100)*total_qty;
    $('#threshold_state_qty_active').val(Math.round(qty));
  });

  // pro active

  $('#threshold_state_qty_proactive').change(function(){
    let threshold_state_qty_proactive = $(this).val();
    let total_qty = $('#total_qty_parameter').val();
    let persen = (threshold_state_qty_proactive/total_qty)*100;
    $('#threshold_state_persentase_proactive').val(Math.round(persen));
  });

  $('#threshold_state_persentase_proactive').change(function(){

    let threshold_state_persentase_proactive = $(this).val();
    let total_qty = $('#total_qty_parameter').val();

    let qty = (threshold_state_persentase_proactive/100)*total_qty;
    $('#threshold_state_qty_proactive').val(Math.round(qty));

  });

  // edit data

  // active
  
  $('#edit_threshold_state_qty_active').change(function(){
    let threshold_state_qty_active = $(this).val();
    let total_qty = $('#edit_total_qty_parameter').val();
    let persen = (threshold_state_qty_active/total_qty)*100;
    $('#edit_threshold_state_persentase_active').val(Math.round(persen));
  });

  $('#edit_threshold_state_persentase_active').change(function(){
    let threshold_state_persentase_active = $(this).val();
    let total_qty = $('#edit_total_qty_parameter').val();
    let qty = (threshold_state_persentase_active/100)*total_qty;
    $('#edit_threshold_state_qty_active').val(Math.round(qty));
  });

  // pro active

  $('#edit_threshold_state_qty_proactive').change(function(){
    let threshold_state_qty_proactive = $(this).val();
    let total_qty = $('#edit_total_qty_parameter').val();
    let persen = (threshold_state_qty_proactive/total_qty)*100;
    $('#edit_threshold_state_persentase_proactive').val(Math.round(persen));
  });

  $('#edit_threshold_state_persentase_proactive').change(function(){

    let threshold_state_persentase_proactive = $(this).val();
    let total_qty = $('#edit_total_qty_parameter').val();

    let qty = (threshold_state_persentase_proactive/100)*total_qty;
    $('#edit_threshold_state_qty_proactive').val(Math.round(qty));

  });

  $('#edit_is_parameter_active').change(function(){

      if (!this.checked) {
          // Code to execute when the checkbox is unchecked
          //alert('tidak ajib');
          $('#edit_light_active').prop('checked', false);
          $('#edit_sound_active').prop('checked', false);
          $('#edit_light_proactive').prop('checked', false);
          $('#edit_sound_proactive').prop('checked', false);
          $('#edit_is_light_strobe_active').prop('checked', false);
          $('#label_edit_is_parameter_active').html('Not Active');
      } else {
          //alert('ajib');
          $('#edit_light_active').prop('checked', true);
          $('#edit_sound_active').prop('checked', true);
          $('#edit_light_proactive').prop('checked', true);
          $('#edit_sound_proactive').prop('checked', true);
          $('#edit_is_light_strobe_active').prop('checked', true);
          $('#label_edit_is_parameter_active').html('Active');
      }

  });

  $('#parameter_id').on('change', function(){
		load_dropdown_variable(this.value);
	});

  let variable_id = $('#variable_id').val();

	//if (variable_id != ''){
		//load_dropdown_variable(variable_id);
	//}

  // { "data": null, "defaultContent": '<input type="checkbox" class="checkbox">' }, // Checkbox column

    $('#contentTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: "<?php echo site_url(); ?>content/serverSideData",
            type: "POST",
            data: function (d) {
                d.filter_id_parameter = $('#filter_id_parameter').val();
            }
        },
        columns: [
            { data: "ID Content", className: "dt-center" },
            {
                "data": "checkbox_id_content",
                "className": "dt-center",
                "orderable": false,
                "searchable": false
            },
            { data: "nama_variable", className: "dt-left" },
            { data: "is_parameter_active", className: "dt-center" },
            { data: "threshold_state_qty_active", className: "dt-center" },
            { data: "threshold_state_persentase_active", className: "dt-center" },
            { data: "light_active", className: "dt-center" },
            { data: "sound_active", className: "dt-center" },
            { data: "Action", className: "dt-center" },
        ]
    });

    $('#checkall').change(function(){
      var cells = $('#contentTable').find('tbody > tr > td:nth-child(2)');
      $(cells).find(':checkbox').prop('checked', $(this).is(':checked'));
    });

});

function reload_datatables() {
  var table = $('#contentTable').DataTable();
  table.ajax.reload();
}

// Add your edit logic here

function editData(id) {

    $.ajax({
        url: "<?php echo site_url(); ?>content/edit/"+id,
        type: "GET",
        success: function(response){

            // handle success response here
            //console.log(response);
            var responseData = JSON.parse(response);
            
            // Populate modal with data
            $('#editModal').modal('show');

            $('#hidden_id_content').val(responseData.data.id_content);
          
            $('#edit_parameter_id').val(responseData.data.parameter_id);
            $('#edit_variable_id').val(responseData.data.variable_id);
            $('#old_variable_id').val(responseData.data.variable_id);

            $('#edit_total_qty_parameter').val(responseData.data.total_qty_parameter);

            if (responseData.data.is_parameter_active == 0) {
                $('#edit_is_parameter_active').prop('checked', false);
                $('#label_edit_is_parameter_active').html('Not Active');
            } else if (responseData.data.is_parameter_active == 1) {
                $('#edit_is_parameter_active').prop('checked', true);
                $('#label_edit_is_parameter_active').html('Active');
            }

            //$('#edit_state').val(responseData.data.state);

            // Alert Proactive

            $('#edit_threshold_state_qty_proactive').val(responseData.data.threshold_state_qty_proactive);
            $('#edit_threshold_state_persentase_proactive').val(responseData.data.threshold_state_persentase_proactive);
            $('#edit_light_proactive').prop('checked', responseData.data.light_proactive == 1);
            $('#edit_sound_proactive').prop('checked', responseData.data.sound_proactive == 1);
            $('#edit_text_to_speech_proactive').val(responseData.data.text_to_speech_proactive == '' ? 'Isi Text To Speech Proactive' : responseData.data.text_to_speech_proactive);

            // Alert Active

            $('#edit_threshold_state_qty_active').val(responseData.data.threshold_state_qty_active);
            $('#edit_threshold_state_persentase_active').val(responseData.data.threshold_state_persentase_active);
            $('#edit_light_active').prop('checked', responseData.data.light_active == 1);
            $('#edit_sound_active').prop('checked', responseData.data.sound_active == 1);
            $('#edit_text_to_speech_active').val(responseData.data.text_to_speech_active == 1 ? 'Isi Text To Speech Active' : responseData.data.text_to_speech_active);

            // Refactor the code to uncheck or check based on the value
            /*
            if (responseData.data.is_sound_active == 0) {
                $('#edit_is_sound_active').prop('checked', false);
            } else if (responseData.data.is_sound_active == 1) {
                $('#edit_is_sound_active').prop('checked', true);
            }
            */

            $('#edit_is_light_strobe_active').prop('checked', responseData.data.is_light_strobe_active == 1);
            $('#edit_interval').val(responseData.data.interval);

            $('#edit_is_threshold_confirm').prop('checked', responseData.data.is_threshold_confirm == 1);

            load_dropdown_parameter_edit(responseData.data.parameter_id);
            load_dropdown_variable_edit(responseData.data.parameter_id, responseData.data.variable_id);

            load_dropdown_sound(responseData.data.id_sound);
            $('edit_light_color_code').val(responseData.data.light_color_code);

        },
        error: function(xhr, status, error){
            // handle error here
        }

    });

}

// hit api

function hitApi(id) {

  $.ajax({
      method: "GET",
      url: "<?php echo site_url(); ?>content/edit/"+id,
      success: function(data) {

          // handle success response here
          console.log(data);

          var responseData = JSON.parse(data);
            
          // Populate modal with data
          $('#hitApiModal').modal('show');

          $('#hitapi_hidden_id_content').val(responseData.data.id_content);
          
          $('#hitapi_parameter_id').val(responseData.data.parameter_id);
          $('#hitapi_variable_id').val(responseData.data.variable_id);

          load_dropdown_parameter_hitapi(responseData.data.parameter_id);
          load_dropdown_variable_hitapi(responseData.data.parameter_id, responseData.data.variable_id);

          $('#hitapi_state').val(responseData.data.state);

      },
      error: function(xhr, status, error) {
          // handle error here
      }
  });
  
}

function deleteContent(id){

    // Ask for confirmation before proceeding with deletion
    if(confirm("Are you sure you want to delete this content?")){
        $.ajax({
            url: "<?php echo site_url(); ?>content/delete/"+id,
            type: "POST",
            success: function(response){
                // handle success response here
                //console.log(response);
                var responseData = JSON.parse(response);

                if (responseData.is_success == true){
                    alert(responseData.message);
                    location.reload();
                    return false;
                }
            },
            error: function(xhr, status, error){
                // handle error here
            }

        });
    }
    
}

function store() {

  // Add your button click logic here

  $.ajax({
    url: "<?php echo site_url(); ?>content/store",
    type: "POST",
    data: $('#form_database').serialize(),
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

function update() {

  // Add your button click logic here,

  if ($('#edit_parameter_id').val() == '0'){
    alert('Parameter harus dipilih');
    return false;
  }

  if ($('#edit_variable_id').val() == '0'){
    alert('Variable harus dipilih');
    return false;
  }

  $.ajax({
    url: "<?php echo site_url(); ?>content/update",
    type: "POST",
    data: $('#form_edit').serialize(),
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

function updateHitApi(){

  // Add your button click logic here

  if ($('#edit_parameter_id').val() == '0'){
    alert('Parameter harus dipilih');
    return false;
  }

  if ($('#edit_variable_id').val() == '0'){
    alert('Variable harus dipilih');
    return false;
  }

  $.ajax({
    url: "<?php echo site_url(); ?>content/update_hitapi",
    type: "POST",
    data: $('#form_hitapi').serialize(),
    success: function(response){

        // handle success response here
        console.log(response);
        var responseData = JSON.parse(response);

        if (responseData.is_success == true){
          alert(responseData.message);
          location.reload();
          return false;
        }

    },
    error: function(xhr, status, error){
        // handle error here
    }

  });
  
}

function playSound() {

  var id_sound = $('#edit_html_id').val();
  var bell = document.getElementById(id_sound);
	bell.play();

  // Play sound1
  /*
  $('#sound3')[0].play();

  // Wait for sound1 to finish, then play sound2
  $('#sound3').on('ended', function() {
    $('#sound2')[0].play();
  });
  */
  
}

function playSoundAdd() {

  var id_sound = $('#html_id').val();
  var bell = document.getElementById(id_sound);
  bell.play();

  // Play sound1
  /*
  $('#sound3')[0].play();

  // Wait for sound1 to finish, then play sound2
  $('#sound3').on('ended', function() {
    $('#sound2')[0].play();
  });
  */

}
</script>

  <!--display: flex; -->
  <div class="container-fluid" style="justify-content: center;">

    <table width="100%" class="table table-bordered table-striped" id="contentTable">
        <thead>

            <tr>
              <th>No.</th>
              <th style="text-align: center;" class="check"><input type="checkbox" id="checkall" value=""/></th>
              <th>Nama Variable</th>
              <th>Active</th>
              <th>Qty (Count)</th>
              <th>Qty (%)</th>
              <th>Light</th>
              <th>Sound</th>
              <th>Status</th>
            </tr>

        </thead>
        <tbody>
            <!-- DataTable will populate the rows automatically -->
        </tbody>
    </table>

  </div>

    </div>
  </div>

  <!-- Project Analytics -->
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/keen-analytics.js"></script>

  <!-- Responsivevoice -->
  <!-- Get API Key -> https://responsivevoice.org/ -->
  <script src="https://code.responsivevoice.org/responsivevoice.js?key=jQZ2zcdq"></script>

  <!-- Modal for Edit Form -->
  <div class="modal fade" id="databaseModal" tabindex="-1" role="dialog" aria-labelledby="databaseModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                
              <div class="modal-header">
                <h5 class="modal-title" id="databaseModalLabel">Form Add</h5>
              </div>

                <div class="modal-body">
                    <form name="form_database" id="form_database" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="parameter_id">Kategori</label>
                            <select class="form-control" id="parameter_id" name="parameter_id">
                                <!-- Add your select options here -->
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="variable_id">Variable</label>
                            <select class="form-control" id="variable_id" name="variable_id">
                                <!-- Add your select options here -->
                            </select>
                        </div>

                        <input type="hidden" class="form-control" id="total_qty_parameter" name="total_qty_parameter">

                        <div class="form-group">
                            <label for="is_parameter_active">Status</label>
                            <div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input" id="is_parameter_active" name="is_parameter_active" value="1" onchange="this.value = this.checked ? 1 : 0">
                              <label class="custom-control-label" for="is_parameter_active" id="label_is_parameter_active"></label>
                            </div>
                        </div>

                        <input type="hidden" class="form-control" id="state" name="state" value="0">

                        <h2>Parameter Set</h2>
                        <hr>

                          <div class="form-group">
                              <label for="threshold_state_qty_active">Trigger by</label>
                              <div class="input-group">
                                <input type="text" class="form-control" id="threshold_state_qty_active" name="threshold_state_qty_active">
                                <span class="input-group-addon">Count</span>
                                <span style="display: table-cell; width: 2%; text-align: center; vertical-align : middle; padding-left:20px; padding-right:20px;">OR</span>
                                <input type="text" class="form-control" id="threshold_state_persentase_active" name="threshold_state_persentase_active">
                                <span class="input-group-addon">%</span>
                              </div>
                          </div>

                        <h2>Alert Action</h2>
                        <hr>
                          
                          <div class="form-group">
                              <label for="light_active">Light Action</label>
                              <div class="custom-control custom-switch">
                                <input hidden type="checkbox" class="custom-control-input" id="light_active" name="light_active" value="1" onchange="this.value = this.checked ? 1 : 0">
                                <input type="color" id="html5colorpickeradd" onchange="clickColorAdd()" value="#ff0000" style="width:50%;">
                                <input type="hidden" name="light_color_code" id="light_color_code" value="">
                              </div>
                          </div>

                          <div class="form-group">
                              <label for="sound_active">Sound</label>
                              <select class="form-control" id="sound_id" name="sound_id">
                                  <!-- Add your select options here -->
                              </select>
                              <input type="hidden" name="is_tts" id="is_tts" value="0">
                              <input type="hidden" name="html_id" id="html_id" value="">
                              <br>
                              <input hidden type="checkbox" class="custom-control-input" id="sound_active" name="sound_active" value="1" onchange="this.value = this.checked ? 1 : 0">
                              <input type="hidden" class="form-control" id="text_to_speech_active" name="text_to_speech_active" value="">
                              <div style="text-align: right;">
                              <button type="button" class="btn btn-primary" onclick="playSoundAdd()">Play</button>
                              </div>
                          </div>

                          <input type="hidden" class="form-control" id="threshold_state_qty_proactive" name="threshold_state_qty_proactive">
                          <input type="hidden" class="form-control" id="threshold_state_persentase_proactive" name="threshold_state_persentase_proactive">
                          <input type="hidden" class="form-control" id="interval" name="interval" value="0">

                          <input hidden type="checkbox" class="custom-control-input" id="light_proactive" name="light_proactive" value="1" onchange="this.value = this.checked ? 1 : 0">
                          <input hidden type="checkbox" class="custom-control-input" id="sound_proactive" name="sound_proactive" value="1" onchange="this.value = this.checked ? 1 : 0">
                          <input hidden type="checkbox" class="custom-control-input" id="is_light_strobe_active" name="is_light_strobe_active" value="1" onchange="this.value = this.checked ? 1 : 0">

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button onclick="store()" type="button" class="btn btn-primary" id="saveDatabase">Save</button>
                </div>
            </div>
        </div>
    </div>

  <!-- Modal for Edit Form -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                
              <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Form Edit</h5>
              </div>

                <div class="modal-body">
                    <form name="form_edit" id="form_edit" action="<?php echo site_url().'content/update'?>" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="edit_parameter_id">Kategori</label>
                            <select class="form-control" id="edit_parameter_id" name="edit_parameter_id">
                                <!-- Add your select options here -->
                            </select>
                            <input type="hidden" name="hidden_id_content" id="hidden_id_content" value="">
                            <input type="hidden" name="hidden_edit_parameter_id" id="hidden_edit_parameter_id" value="">
                        </div>

                        <div class="form-group">
                            <label for="edit_variable_id">Variable</label>
                            <select class="form-control" id="edit_variable_id" name="edit_variable_id">
                                <!-- Add your select options here -->
                            </select>
                        </div>

                        <input type="hidden" class="form-control" id="old_variable_id" name="old_variable_id" value="">
                        <input type="hidden" class="form-control" id="edit_total_qty_parameter" name="edit_total_qty_parameter">

                        <div class="form-group">
                            <label for="edit_is_parameter_active">Status</label>
                            <div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input" id="edit_is_parameter_active" name="edit_is_parameter_active" value="1" onchange="this.value = this.checked ? 1 : 0">
                              <label class="custom-control-label" for="edit_is_parameter_active" id="label_edit_is_parameter_active"></label>
                            </div>
                        </div>

                        <input type="hidden" class="form-control" id="edit_state" name="edit_state" value="0">

                        <h2>Parameter Set</h2>
                        <hr>

                          <div class="form-group">
                              <label for="edit_threshold_state_qty_active">Trigger by</label>
                              <div class="input-group">
                                <input type="text" class="form-control" id="edit_threshold_state_qty_active" name="edit_threshold_state_qty_active">
                                <span class="input-group-addon">Count</span>
                                <span style="display: table-cell; width: 2%; text-align: center; vertical-align : middle; padding-left:20px; padding-right:20px;">OR</span>
                                <input type="text" class="form-control" id="edit_threshold_state_persentase_active" name="edit_threshold_state_persentase_active">
                                <span class="input-group-addon">%</span>
                              </div>
                          </div>

                        <h2>Alert Action</h2>
                        <hr>
                          
                          <div class="form-group">
                              <label for="edit_light_active">Light Action</label>
                              <div class="custom-control custom-switch">
                                <input hidden type="checkbox" class="custom-control-input" id="edit_light_active" name="edit_light_active" value="1" onchange="this.value = this.checked ? 1 : 0">
                                <input type="color" id="html5colorpicker" onchange="clickColor()" value="#ff0000" style="width:50%;">
                                <input type="hidden" name="edit_light_color_code" id="edit_light_color_code" value="#ff0000">
                              </div>
                          </div>

                          <div class="form-group">
                              <label for="edit_sound_active">Sound</label>
                              <select class="form-control" id="edit_sound_id" name="edit_sound_id">
                                  <!-- Add your select options here -->
                              </select>
                              <input type="hidden" name="edit_is_tts" id="edit_is_tts" value="0">
                              <input type="hidden" name="edit_html_id" id="edit_html_id" value="">
                              <br>
                              <input hidden type="checkbox" class="custom-control-input" id="edit_sound_active" name="edit_sound_active" value="1" onchange="this.value = this.checked ? 1 : 0">
                              <input type="hidden" class="form-control" id="edit_text_to_speech_active" name="edit_text_to_speech_active" value="">
                              <div style="text-align: right;">
                              <button type="button" class="btn btn-primary" onclick="playSound()">Play</button>
                              </div>
                          </div>

                          <?php 
                          /**
                           * 
                           * 
                        <h2>Alert Proactive</h2>
                        <hr>

                          <div class="form-group">
                              <label for="edit_threshold_state_qty_proactive">Alert Proactive Trigger by Count</label>
                              <div class="input-group">
                                <input type="text" class="form-control" id="edit_threshold_state_qty_proactive" name="edit_threshold_state_qty_proactive">
                                <span class="input-group-addon">Unit</span>
                              </div>
                          </div>
                          
                          <div class="form-group">
                              <label for="edit_threshold_state_persentase_proactive">Alert Proactive Trigger by Persentase</label>
                              <div class="input-group">
                                <input type="text" class="form-control" id="edit_threshold_state_persentase_proactive" name="edit_threshold_state_persentase_proactive">
                                <span class="input-group-addon">%</span>
                              </div>
                          </div>
                          
                          <div class="form-group">
                              <label for="edit_light_proactive">Alert Light Proactive Action (Blink Kuning)</label>
                              <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit_light_proactive" name="edit_light_proactive" value="1" onchange="this.value = this.checked ? 1 : 0">
                                <label class="custom-control-label" for="edit_light_proactive"></label>
                              </div>
                          </div>

                          <div class="form-group">
                              <label for="edit_sound_proactive">Alert Sound Proactive Action (Text To Speech)</label>
                              <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit_sound_proactive" name="edit_sound_proactive" value="1" onchange="this.value = this.checked ? 1 : 0">
                                <label class="custom-control-label" for="edit_sound_proactive"></label>
                                <input type="text" class="form-control" id="edit_text_to_speech_proactive" name="edit_text_to_speech_proactive">
                              </div>
                          </div>

                        <hr>
                          
                          <div class="form-group">
                              <label for="edit_is_light_strobe_active">Light Strobe</label>
                              <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit_is_light_strobe_active" name="edit_is_light_strobe_active" value="1" onchange="this.value = this.checked ? 1 : 0">
                                <label class="custom-control-label" for="edit_is_light_strobe_active"></label>
                              </div>
                          </div>

                        <hr>

                        <div class="form-group">
                            <label for="edit_interval">Interval (Every ? menit until normal)</label>
                            <div class="input-group">
                              <input type="text" class="form-control" id="edit_interval" name="edit_interval">
                              <span class="input-group-addon">Menit</span>
                            </div>
                        </div>
                           * 
                           */
                          ?>

                          <input type="hidden" class="form-control" id="edit_threshold_state_qty_proactive" name="edit_threshold_state_qty_proactive">
                          <input type="hidden" class="form-control" id="edit_threshold_state_persentase_proactive" name="edit_threshold_state_persentase_proactive">
                          <input type="hidden" class="form-control" id="edit_interval" name="edit_interval">

                          <input hidden type="checkbox" class="custom-control-input" id="edit_light_proactive" name="edit_light_proactive" value="1" onchange="this.value = this.checked ? 1 : 0">
                          <input hidden type="checkbox" class="custom-control-input" id="edit_sound_proactive" name="edit_sound_proactive" value="1" onchange="this.value = this.checked ? 1 : 0">
                          <input hidden type="checkbox" class="custom-control-input" id="edit_is_light_strobe_active" name="edit_is_light_strobe_active" value="1" onchange="this.value = this.checked ? 1 : 0">

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button onclick="update()" type="button" class="btn btn-primary" id="updateDatabase">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for hitApi Form -->
    <div class="modal fade" id="hitApiModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                
              <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Form Hit API</h5>
              </div>

                <div class="modal-body">
                    <form name="form_hitapi" id="form_hitapi" action="<?php echo site_url().'content/hitApi'?>" method="post" enctype="multipart/form-data">

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
                            <label for="hitapi_state">State / Kondisi Terakhir</label>
                            <div class="input-group">
                              <input type="text" class="form-control" id="hitapi_state" name="hitapi_state">
                              <span class="input-group-addon">Unit</span>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button onclick="updateHitApi()" type="button" class="btn btn-primary" id="updateDatabase">Update</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
<div class="container-fluid">

    <div class="row">

      <div class="col-sm-12">

        <div class="chart-hd">
          
          <strong>&nbsp;&nbsp;Filter Data&nbsp;&nbsp;</strong>

          <select name="filter_id_parameter" id="filter_id_parameter" class="selectpicker" data-live-search="true">

            <option value="0">- Pilih Kategori -</option>
            <?php foreach ($kategori as $k => $v) { ?>
              <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
            <?php } ?>

          </select>
     
          <!-- <button type="button" class="btn btn-success" onclick="get_datatables_checked()">Set State</button> -->

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

<style>
/* Styling dasar untuk tabel */
table.dataTable {
    width: 100%;
    border-collapse: collapse;
    margin: 0 auto;
    background-color: #f8f9fa;
    border: 1px solid #ddd;
}

/* Header table styling */
table.dataTable thead th {
    background-color: #343a40;
    color: #ffffff;
    font-weight: bold;
    text-align: center;
    padding: 12px;
}

/* Row styling */
table.dataTable tbody tr {
    transition: background-color 0.3s ease;
}

table.dataTable tbody tr:hover {
    background-color: #e9ecef;
}

/* Cell styling */
table.dataTable tbody td {
    padding: 10px;
    text-align: center;
    color: #495057;
}

/* Pagination styling */
.dataTables_wrapper .dataTables_paginate .paginate_button {
    color: #343a40 !important;
    border: 1px solid #ddd;
    background: #ffffff;
    padding: 5px 10px;
    margin: 2px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background-color: #6c757d;
    color: #ffffff !important;
}

/* Active page styling */
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background-color: #343a40 !important;
    color: #ffffff !important;
}

/* Search box and entries dropdown */
.dataTables_wrapper .dataTables_filter input,
.dataTables_wrapper .dataTables_length select {
    border: 1px solid #ddd;
    padding: 5px;
    border-radius: 4px;
    margin-bottom: 10px;
    color: #495057;
}

/* Information text styling */
.dataTables_wrapper .dataTables_info {
    font-size: 14px;
    color: #343a40;
    margin-top: 10px;
}

/* Table border radius */
table.dataTable {
    border-radius: 8px;
    overflow: hidden;
}
</style>

<!-- Assuming you want to display the content table data in a datatable on the same page -->
<!-- Add the following code snippet after the <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script> line in your HTML file-->

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/functions.js" type="text/javascript"></script>

<script type="text/javascript">

  function update_status(id, value) {
    window.location.href = "<?php echo base_url(); ?>content/change/" + id + "/" + value;
  }

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

  function load_dropdown_aset(){
		
		//get a reference to the select element
		var $id_aset = $('#id_aset');
    $("#id_aset").html('<option value="0">Loading...</option>');

		let hidden_id_aset = $("#hidden_id_aset").val();

		$.ajax({
		method: "POST",
		url:'<?php echo site_url() . 'content/load_dropdown_aset'; ?>',
		dataType: 'JSON', 
		success: function(data){

			if (data.is_data_ada){

				//clear the current content of the select
				$id_aset.html('');
				$id_aset.append('<option value = "0">- Silahkan Pilih -</option>');

				//iterate over the data and append a select option

				$.each(data.list_data, function (key, val){

					if (hidden_id_aset == val.id_aset){
						$id_aset.append('<option selected="selected" value = "' + val.id_aset + '">' + val.nama_aset + '</option>');
					} else {
						$id_aset.append('<option value = "' + val.id_aset + '">' + val.nama_aset + '</option>');
					}

				});

        $id_aset.val('0');

			} else {
				$id_aset.html('<option value = "0">- Tidak Ada Data -</option>');
			}

		}, 				
		error: function(){
			//if there is an error append a 'none available' option
			$id_aset.html('<option value = "0">- Tidak Ada Data -</option>');
		}

		});

	}

  function load_dropdown_ruangan(id_parameter){
		
		//get a reference to the select element
		var $ruangan_id = $('#ruangan_id');
    $("#ruangan_id").html('<option value="0">Loading...</option>');

		let hidden_ruangan_id = $("#hidden_ruangan_id").val();

		$.ajax({
		method: "POST",
		url:'<?php echo site_url() . 'content/load_dropdown_ruangan'; ?>',
		dataType: 'JSON', 
		success: function(data){

			if (data.is_data_ada){

				//clear the current content of the select
				$ruangan_id.html('');
				$ruangan_id.append('<option value = "0">- Silahkan Pilih -</option>');

				//iterate over the data and append a select option

				$.each(data.list_data, function (key, val){

					if (hidden_ruangan_id == val.id){
						$ruangan_id.append('<option selected="selected" value = "' + val.id + '">' + val.ruangan + '</option>');
					} else {
						$ruangan_id.append('<option value = "' + val.id + '">' + val.ruangan + '</option>');
					}

				});

        $ruangan_id.val('0');

			} else {
				$ruangan_id.html('<option value = "0">- Tidak Ada Data -</option>');
			}

		}, 				
		error: function(){
			//if there is an error append a 'none available' option
			$ruangan_id.html('<option value = "0">- Tidak Ada Data -</option>');
		}

		});

	}

  function load_dropdown_parameter_edit(id_parameter){
		
    //get a reference to the select element
		var $edit_ruangan_id = $('#edit_ruangan_id');
    $("#edit_ruangan_id").html('<option value="0">Loading...</option>');

		//let hidden_ruangan_id = $("#hidden_ruangan_id").val();
    let hidden_ruangan_id = id_parameter;

		$.ajax({
		method: "POST",
		url:'<?php echo site_url() . 'content/load_dropdown_parameter'; ?>',
		dataType: 'JSON', 
		success: function(data){

			if (data.is_data_ada){

				//clear the current content of the select
				$edit_ruangan_id.html('');
				$edit_ruangan_id.append('<option value = "0">- Silahkan Pilih -</option>');

				//iterate over the data and append a select option

				$.each(data.list_data, function (key, val){

					if (hidden_ruangan_id == val.id_parameter){
						$edit_ruangan_id.append('<option selected="selected" value = "' + val.id_parameter + '">' + val.nama_parameter + '</option>');
					} else {
						$edit_ruangan_id.append('<option value = "' + val.id_parameter + '">' + val.nama_parameter + '</option>');
					}

				});

			} else {
				$edit_ruangan_id.html('<option value = "0">- Tidak Ada Data -</option>');
			}

		}, 				
		error: function(){
			//if there is an error append a 'none available' option
			$edit_ruangan_id.html('<option value = "0">- Tidak Ada Data -</option>');
		}

		});

	}

  function load_dropdown_parameter_hitapi(id_parameter){
		
    //get a reference to the select element
		var $hitapi_ruangan_id = $('#hitapi_ruangan_id');
    $("#hitapi_ruangan_id").html('<option value="0">Loading...</option>');

		//let hidden_ruangan_id = $("#hidden_ruangan_id").val();
    let hidden_ruangan_id = id_parameter;

		$.ajax({
		method: "POST",
		url:'<?php echo site_url() . 'content/load_dropdown_parameter'; ?>',
		dataType: 'JSON', 
		success: function(data){

			if (data.is_data_ada){

				//clear the current content of the select
				$hitapi_ruangan_id.html('');
				$hitapi_ruangan_id.append('<option value = "0">- Silahkan Pilih -</option>');

				//iterate over the data and append a select option

				$.each(data.list_data, function (key, val){

					if (hidden_ruangan_id == val.id_parameter){
						$hitapi_ruangan_id.append('<option selected="selected" value = "' + val.id_parameter + '">' + val.nama_parameter + '</option>');
					} else {
						$hitapi_ruangan_id.append('<option value = "' + val.id_parameter + '">' + val.nama_parameter + '</option>');
					}

				});

			} else {
				$hitapi_ruangan_id.html('<option value = "0">- Tidak Ada Data -</option>');
			}

		}, 				
		error: function(){
			//if there is an error append a 'none available' option
			$hitapi_ruangan_id.html('<option value = "0">- Tidak Ada Data -</option>');
		}

		});

	}

  function load_dropdown_reader(id_ruangan){
		
		//get a reference to the select element
		var $reader_id = $('#reader_id');
    $("#reader_id").html('<option value="0">Loading...</option>');

		let hidden_reader_id = $("#hidden_reader_id").val();

		$.ajax({
		method: "POST",
		url:'<?php echo site_url() . 'content/load_dropdown_reader'; ?>',
		dataType: 'JSON', 
		data: {id_ruangan: id_ruangan},	
		success: function(data){

			if (data.is_data_ada){

				//clear the current content of the select
				$reader_id.html('');
				$reader_id.append('<option value = "0">- Silahkan Pilih -</option>');

				//iterate over the data and append a select option

				$.each(data.list_data, function (key, val){

					if (hidden_reader_id == val.id){
						$reader_id.append('<option selected="selected" value = "' + val.reader_id + '">' + val.reader_name + '</option>');
					} else {
						$reader_id.append('<option value = "' + val.reader_id + '">' + val.reader_name + '</option>');
					}

				});

        $reader_id.val('0');

			} else {
				$reader_id.html('<option value = "0">- Tidak Ada Data -</option>');
			}

		}, 				
		error: function(){
			//if there is an error append a 'none available' option
			$reader_id.html('<option value = "0">- Tidak Ada Data -</option>');
		}

		});

	}

  function load_dropdown_variable_edit(id_parameter, id_variable_old){
		
		//get a reference to the select element
		var $reader_id = $('#edit_reader_id');
    $("#edit_reader_id").html('<option value="0">Loading...</option>');

		let hidden_reader_id = id_variable_old;

		$.ajax({
		method: "POST",
		url:'<?php echo site_url() . 'content/load_dropdown_variable'; ?>',
		dataType: 'JSON', 
		data: {id_parameter: id_parameter},	
		success: function(data){

			if (data.is_data_ada){

				//clear the current content of the select
				$reader_id.html('');
				$reader_id.append('<option value = "0">- Silahkan Pilih -</option>');

				//iterate over the data and append a select option

				$.each(data.list_data, function (key, val){

					if (hidden_reader_id == val.id_variable){
						$reader_id.append('<option selected="selected" value = "' + val.id_variable + '">' + val.nama_variable + '</option>');
					} else {
						$reader_id.append('<option value = "' + val.id_variable + '">' + val.nama_variable + '</option>');
					}

				});

			} else {
				$reader_id.html('<option value = "0">- Tidak Ada Data -</option>');
			}

		}, 				
		error: function(){
			//if there is an error append a 'none available' option
			$reader_id.html('<option value = "0">- Tidak Ada Data -</option>');
		}

		});

	}

  function load_dropdown_variable_hitapi(id_parameter, id_variable_old){
		
		//get a reference to the select element
		var $reader_id = $('#hitapi_reader_id');
    $("#hitapi_reader_id").html('<option value="0">Loading...</option>');

		let hidden_reader_id = id_variable_old;

		$.ajax({
		method: "POST",
		url:'<?php echo site_url() . 'content/load_dropdown_variable'; ?>',
		dataType: 'JSON', 
		data: {id_parameter: id_parameter},	
		success: function(data){

			if (data.is_data_ada){

				//clear the current content of the select
				$reader_id.html('');
				$reader_id.append('<option value = "0">- Silahkan Pilih -</option>');

				//iterate over the data and append a select option

				$.each(data.list_data, function (key, val){

					if (hidden_reader_id == val.id_variable){
						$reader_id.append('<option selected="selected" value = "' + val.id_variable + '">' + val.nama_variable + '</option>');
					} else {
						$reader_id.append('<option value = "' + val.id_variable + '">' + val.nama_variable + '</option>');
					}

				});

			} else {
				$reader_id.html('<option value = "0">- Tidak Ada Data -</option>');
			}

		}, 				
		error: function(){
			//if there is an error append a 'none available' option
			$reader_id.html('<option value = "0">- Tidak Ada Data -</option>');
		}

		});

	}

  function load_dropdown_sound(id_sound){
		
		//get a reference to the select element
		var $ruangan_id = $('#edit_sound_id');
    $("#edit_sound_id").html('<option value="0">Loading...</option>');

		let hidden_ruangan_id = id_sound;

		$.ajax({
		method: "POST",
		url:'<?php echo site_url() . 'content/load_dropdown_sound'; ?>',
		dataType: 'JSON', 
		success: function(data){

			if (data.is_data_ada){

				//clear the current content of the select
				$ruangan_id.html('');
				$ruangan_id.append('<option value = "0">- Silahkan Pilih -</option>');

				//iterate over the data and append a select option

				$.each(data.list_data, function (key, val){

					if (hidden_ruangan_id == val.id_sound){
						$ruangan_id.append('<option selected="selected" value = "' + val.id_sound + '">' + val.nama_sound + '</option>');
					} else {
						$ruangan_id.append('<option value = "' + val.id_sound + '">' + val.nama_sound + '</option>');
					}

				});

			} else {
				$ruangan_id.html('<option value = "0">- Tidak Ada Data -</option>');
			}

		}, 				
		error: function(){
			//if there is an error append a 'none available' option
			$ruangan_id.html('<option value = "0">- Tidak Ada Data -</option>');
		}

		});

	}

  function load_dropdown_sound_add(){
		
		//get a reference to the select element
		var $ruangan_id = $('#sound_id');
    $("#sound_id").html('<option value="0">Loading...</option>');

		$.ajax({
		method: "POST",
		url:'<?php echo site_url() . 'content/load_dropdown_sound'; ?>',
		dataType: 'JSON', 
		success: function(data){

			if (data.is_data_ada){

				//clear the current content of the select
				$ruangan_id.html('');
				$ruangan_id.append('<option value = "0">- Silahkan Pilih -</option>');

				//iterate over the data and append a select option

				$.each(data.list_data, function (key, val){
					$ruangan_id.append('<option value = "' + val.id_sound + '">' + val.nama_sound + '</option>');
				});

        $('#sound_id').val('0').change();

			} else {
				$ruangan_id.html('<option value = "0">- Tidak Ada Data -</option>');
			}

		}, 				
		error: function(){
			//if there is an error append a 'none available' option
			$ruangan_id.html('<option value = "0">- Tidak Ada Data -</option>');
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

  load_dropdown_ruangan();
  load_dropdown_aset();
  load_dropdown_sound_add();

  $('#filter_id_parameter').on('change', function(){

    //var selected = $(this).find("option:selected").val();

    let selected = $(this).val();
    console.log(selected);

    //window.location.replace("<?php echo site_url(); ?>");
    reload_datatables();

  });

  $('#ruangan_id').change(function(){

    let ruangan_id = $(this).val();

    $.getJSON("<?php echo site_url(); ?>content/getRuanganById/" + ruangan_id, function(response) {
      console.log(response);
      $('#room_name').val(response.ruangan);
    });

  });

  $('#reader_id').change(function(){

    let reader_id = $(this).val();

    $.getJSON("<?php echo site_url(); ?>content/getReaderById/" + reader_id, function(response) {
      console.log(response);
      $('#reader_antena').val(response.reader_antena);
      $('#reader_angle').val(response.reader_angle);
      $('#reader_gate').val(response.reader_gate);
      // $('#tipe_moving').val(response.tipe_moving);
    });

  });

  $('#id_aset').change(function(){

    let id_aset = $(this).val();

    $.getJSON("<?php echo site_url(); ?>content/getAsetById/" + id_aset, function(response) {
      console.log(response);
      $('#rfid_tag_number').val(response.rfid_tag_number);
    });

  });

  $('#edit_total_qty_parameter, #threshold_state_qty_active, #edit_threshold_state_qty_active, #threshold_state_qty_proactive, #edit_threshold_state_qty_proactive, #edit_interval').keyup(function(){
    FormNum(this);
  });

  // add data

  $('#tipe_moving').change(function(){

    if (!this.checked) {
        // Code to execute when the checkbox is unchecked
        //alert('tidak ajib');
        $('#label_tipe_moving').html('Illegal');
    } else {
        //alert('ajib');
        $('#label_tipe_moving').html('Legal');
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

  $('#ruangan_id').on('change', function(){
		load_dropdown_reader(this.value);
	});

  let reader_id = $('#reader_id').val();

	//if (reader_id != ''){
		//load_dropdown_variable(reader_id);
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
      "order": [[1, 'desc']],
      columns: [
          { data: "No", className: "dt-center" },
          { data: "ID Content", className: "dt-center" },
          { data: "lokasi_sebelumnya", className: "dt-center" },
          { data: "Ruangan", className: "dt-center" },
          { data: "reader_gate", className: "dt-center" },
          { data: "reader_angle", className: "dt-center" },
          { data: "waktu", className: "dt-center" },
          { data: "rfid_tag_number", className: "dt-center" },
          { data: "Kode Brg", className: "dt-center" },
          { data: "NUP", className: "dt-center" },
          { data: "Nama Brg", className: "dt-left" },
          // { data: "kategori_pergerakan", className: "dt-center" },
          // { data: "is_legal_moving", className: "dt-center" },
          // { data: "keterangan_pergerakan", className: "dt-center" },
          // { data: "Action", className: "dt-center", orderable: false, searchable: false, render: function (data, type, row) {
          //     return '<i class="ui-tooltip fa fa-pencil-square-o" title="Edit" style="font-size: 22px;color:#2222aa; cursor:pointer;" data-original-title="Edit" onclick="editData(' + row.id_temp_table + ')"></i>&nbsp;<i class="ui-tooltip fa fa-trash-o" title="Hapus" style="font-size: 22px;color:#aa2222; cursor:pointer;" data-original-title="Hapus" onclick="deleteContent(' + row.id_temp_table + ')"></i>';
          // } },
      ]
    });

    var selectedItems = [];

    $('#dataTableModal').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?php echo site_url(); ?>content/serverSideDataAset",
        "type": "POST"
      },
      "columns": [
        // { "data": "no", "orderable": false, "render": function (data, type, row, meta) {
        //     return '<input type="checkbox" class="cekbok" value="'+data+'" />';
        //   } 
        // },
        { 
          data: "id_aset",
          render: function(data, type, row) {
              return `<input type="checkbox" class="row-check" value="${data}">`;
          },
          orderable: false
        },

        { "data": "nama_aset" },
        { "data": "kode_tid" }
      ],
      "order": [[ 1, "asc" ]],
      "fnDrawCallback": function( oSettings ) {
        uncheck_all();
      }
    });

    $('#checkall').change(function(){
      var cells = $('#contentTable').find('tbody > tr > td:nth-child(2)');
      $(cells).find(':checkbox').prop('checked', $(this).is(':checked'));
    });

    $('#databaseModal').on('shown.bs.modal', function () {

        if (!$.fn.DataTable.isDataTable('#dataTable2')) {

          $('#dataTableModal').DataTable({
            "retrieve": true,
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ajax": {
              "url": "<?php echo site_url(); ?>content/serverSideDataAset",
              "type": "POST"
            },
            "columns": [
              { "data": "no", "orderable": false, "render": function (data, type, row, meta) {
                return '<input type="checkbox" class="cekbok" value="'+data+'" />';
              } },
              { "data": "nama_aset" },
              { "data": "kode_tid" }
            ],
            "order": [[ 1, "asc" ]],
            "fnDrawCallback": function( oSettings ) {
              uncheck_all();
            }
          });

        }

    });

    // Select All Checkbox
    $('#select_all').on('click', function() {
        var checked = this.checked;
        $('.row-check').each(function() {
            this.checked = checked;
            updateSelectedItems(this.value, checked);
        });
    });

    // Per Row Checkbox
    $('#dataTableModal tbody').on('change', '.row-check', function() {
        updateSelectedItems(this.value, this.checked);
    });

    // Function untuk update selectedItems
    function updateSelectedItems(id, checked) {
        if (checked) {
            if (!selectedItems.includes(id)) {
                selectedItems.push(id);
            }
        } else {
            selectedItems = selectedItems.filter(item => item !== id);
        }
        console.log(selectedItems); // Debugging, cek daftar ID yang dipilih
    }

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
          
            $('#edit_ruangan_id').val(responseData.data.ruangan_id);
            $('#edit_reader_id').val(responseData.data.reader_id);
            $('#old_reader_id').val(responseData.data.reader_id);

            $('#edit_total_qty_parameter').val(responseData.data.total_qty_parameter);

            if (responseData.data.tipe_moving == 0) {
                $('#edit_tipe_moving').prop('checked', false);
                $('#label_edit_tipe_moving').html('Not Active');
            } else if (responseData.data.tipe_moving == 1) {
                $('#edit_tipe_moving').prop('checked', true);
                $('#label_edit_tipe_moving').html('Active');
            }

            $('#edit_is_reverse_threshold').val(responseData.data.is_reverse_threshold);
            $('#edit_is_data_passive').val(responseData.data.is_data_passive);

            //$('#edit_state').val(responseData.data.state);

            // Alert Proactive

            // $('#edit_threshold_state_qty_proactive').val(responseData.data.threshold_state_qty_proactive);
            // $('#edit_threshold_state_persentase_proactive').val(responseData.data.threshold_state_persentase_proactive);

            // $('#edit_light_proactive').prop('checked', responseData.data.light_proactive == 1);
            // $('#edit_sound_proactive').prop('checked', responseData.data.sound_proactive == 1);
            // $('#edit_text_to_speech_proactive').val(responseData.data.text_to_speech_proactive == '' ? 'Isi Text To Speech Proactive' : responseData.data.text_to_speech_proactive);

            // Alert Active

            // $('#edit_threshold_state_qty_active').val(parseFloat(responseData.data.threshold_state_qty_active));
            // $('#edit_threshold_state_persentase_active').val(parseFloat(responseData.data.threshold_state_persentase_active));

            // $('#edit_light_active').prop('checked', responseData.data.light_active == 1);
            // $('#edit_sound_active').prop('checked', responseData.data.sound_active == 1);
            // $('#edit_text_to_speech_active').val(responseData.data.text_to_speech_active == 1 ? 'Isi Text To Speech Active' : responseData.data.text_to_speech_active);

            // Refactor the code to uncheck or check based on the value
            /*
            if (responseData.data.is_sound_active == 0) {
                $('#edit_is_sound_active').prop('checked', false);
            } else if (responseData.data.is_sound_active == 1) {
                $('#edit_is_sound_active').prop('checked', true);
            }
            */

            // $('#edit_is_light_strobe_active').prop('checked', responseData.data.is_light_strobe_active == 1);
            // $('#edit_interval').val(responseData.data.interval);

            // $('#edit_is_threshold_confirm').prop('checked', responseData.data.is_threshold_confirm == 1);

            load_dropdown_parameter_edit(responseData.data.ruangan_id);
            load_dropdown_variable_edit(responseData.data.ruangan_id, responseData.data.reader_id);

            // load_dropdown_sound(responseData.data.id_sound);
            // $('edit_light_color_code').val(responseData.data.light_color_code);

            // $('#edit_relation_key').val(responseData.data.relation_key);
            // $('#edit_left_string_tts').val(responseData.data.left_string_tts);
            // $('#edit_right_string_tts').val(responseData.data.right_string_tts);

            $('#edit_free_text_tts').val(responseData.data.free_text_tts);

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
          
          $('#hitapi_ruangan_id').val(responseData.data.ruangan_id);
          $('#hitapi_reader_id').val(responseData.data.reader_id);

          load_dropdown_parameter_hitapi(responseData.data.ruangan_id);
          load_dropdown_variable_hitapi(responseData.data.ruangan_id, responseData.data.reader_id);

          $('#hitapi_state').val(parseFloat(responseData.data.state));

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

  /*
  let relation_key = $('#relation_key').val();

  if (relation_key == '') {
    alert('Relation Key harus diisi');
    relation_key.focus();
    return false;
  }
  */

  let ruangan_id = $('#ruangan_id').val();

  if (ruangan_id == '0') {
    alert('Ruangan harus diisi');
    ruangan_id.focus();
    return false;
  }

  let reader_id = $('#reader_id').val();

  if (reader_id == '0') {
    alert('Reader harus diisi');
    reader_id.focus();
    return false;
  }

  let reader_angle = $('#reader_angle').val();

  if (reader_angle == '0') {
    alert('Reader angle harus diisi');
    reader_angle.focus();
    return false;
  }

  let id_aset = $('#id_aset').val();

  if (id_aset == '0') {
    alert('Aset harus diisi');
    id_aset.focus();
    return false;
  }

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

  if ($('#edit_ruangan_id').val() == '0'){
    alert('Parameter harus dipilih');
    return false;
  }

  if ($('#edit_reader_id').val() == '0'){
    alert('Variable harus dipilih');
    return false;
  }

  /*
  let relation_key = $('#edit_relation_key').val();

  if (relation_key == '') {
    alert('Relation Key harus diisi');
    relation_key.focus();
    return false;
  }
    */

  let edit_is_reverse_threshold = $('#edit_is_reverse_threshold').val();

  if (edit_is_reverse_threshold == 'x') {
    alert('Mode Threshold harus diisi');
    edit_is_reverse_threshold.focus();
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

  if ($('#edit_ruangan_id').val() == '0'){
    alert('Parameter harus dipilih');
    return false;
  }

  if ($('#edit_reader_id').val() == '0'){
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
              <th style="text-align: center;">ID</th>
              <th style="text-align: center;">Lokasi Terakhir</th>
              <th style="text-align: center;">Ruangan</th>
              <th style="text-align: center;">Gate</th>
              <th style="text-align: center;">Angle</th>
              <th style="text-align: center;">Waktu</th>
              <th style="text-align: center;">Kode TID</th>
              <th style="text-align: center;">Kode Barang</th>
              <th style="text-align: center;">NUP</th>
              <th style="text-align: center;">Nama Barang</th>
              <!-- <th style="text-align: center;">Kategori Moving</th>
              <th style="text-align: center;">Tipe Moving</th>
              <th style="text-align: center;">Keterangan Moving</th> -->
              <!-- <th>Action</th> -->
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
  <div class="modal fade" id="databaseModal" tabindex="-1" role="dialog" aria-labelledby="databaseModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                
              <div class="modal-header">
                <h5 class="modal-title" id="databaseModalLabel">Form Add</h5>
              </div>

                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-6">
                      <form name="form_database" id="form_database" method="post" enctype="multipart/form-data">

                          <div class="form-group">
                              <label for="ruangan_id">Ruangan</label>
                              <select class="form-control" id="ruangan_id" name="ruangan_id">
                                  <!-- Add your select options here -->
                              </select>
                              <input type="hidden" class="form-control" id="room_name" name="room_name" value="">
                          </div>

                          <div class="form-group">
                              <label for="reader_id">Reader</label>
                              <select class="form-control" id="reader_id" name="reader_id">
                                  <!-- Add your select options here -->
                              </select>
                              <input type="hidden" class="form-control" id="reader_antena" name="reader_antena" value="">
                              <input type="hidden" class="form-control" id="reader_angle" name="reader_angle" value="">
                              <input type="hidden" class="form-control" id="reader_gate" name="reader_gate" value="">
                          </div>

                          <div class="form-group">
                              <label for="reader_angle">Reader Angle</label>
                              <select class="form-control" id="reader_angle" name="reader_angle">
                                <!-- Add your select options here -->
                                <option value="0" selected>- Silahkan Pilih -</option>
                                <option value="in">In</option>
                                <option value="out">Out</option>
                              </select>
                          </div>

                          <div class="form-group">
                              <label for="free_text_tts">Nama Aset</label>
                              <select class="form-control" id="id_aset" name="id_aset">
                                  <!-- Add your select options here -->
                              </select>
                          </div>
                          
                          <input type="hidden" class="form-control" id="rfid_tag_number" name="rfid_tag_number" value="">

                          <div class="form-group">
                              <label for="tipe_moving">Status</label>
                              <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="tipe_moving" name="tipe_moving" value="1" onchange="this.value = this.checked ? 1 : 0">
                                <label class="custom-control-label" for="tipe_moving" id="label_tipe_moving"></label>
                              </div>
                          </div>                        

                      </form>

                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                  
                        <!-- DataTables Table -->

                        <div class="table-responsive">
                            <table id="dataTableModal" class="display table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select_all"></th>
                                        <th>Nama</th>
                                        <th>RFID Tag Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    
                    </div>
                  </div>

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
                            <label for="edit_ruangan_id">Kategori</label>
                            <select class="form-control" id="edit_ruangan_id" name="edit_ruangan_id">
                                <!-- Add your select options here -->
                            </select>
                            <input type="hidden" name="hidden_id_content" id="hidden_id_content" value="">
                            <input type="hidden" name="hidden_edit_ruangan_id" id="hidden_edit_ruangan_id" value="">
                        </div>

                        <!--<div class="form-group">
                            <label for="edit_left_string_tts">Left String Text To Speech</label>
                              <input type="hidden" class="form-control" id="edit_left_string_tts" name="edit_left_string_tts">
                        </div>-->

                        <input type="hidden" class="form-control" id="edit_left_string_tts" name="edit_left_string_tts" value="">

                        <div class="form-group">
                            <label for="edit_reader_id">Variable</label>
                            <select class="form-control" id="edit_reader_id" name="edit_reader_id">
                                <!-- Add your select options here -->
                            </select>
                        </div>

                        <!--<div class="form-group">
                            <label for="edit_right_string_tts">Right String Text To Speech</label>
                              <input type="hidden" class="form-control" id="edit_right_string_tts" name="edit_right_string_tts">
                        </div>-->

                        <input type="hidden" class="form-control" id="edit_right_string_tts" name="edit_right_string_tts" value="">

                        <div class="form-group">
                            <label for="edit_free_text_tts">Free Text, Text To Speech</label>
                              <input type="text" class="form-control" id="edit_free_text_tts" name="edit_free_text_tts" value="">
                        </div>

                        <!--<div class="form-group">
                            <label for="edit_relation_key">Relation Key</label>
                              <input type="text" class="form-control" id="edit_relation_key" name="edit_relation_key">
                        </div>-->

                        <input type="hidden" class="form-control" id="edit_relation_key" name="edit_relation_key" value="">

                        <input type="hidden" class="form-control" id="old_reader_id" name="old_reader_id" value="">
                        <input type="hidden" class="form-control" id="edit_total_qty_parameter" name="edit_total_qty_parameter">

                        <div class="form-group">
                            <label for="edit_tipe_moving">Status</label>
                            <div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input" id="edit_tipe_moving" name="edit_tipe_moving" value="1" onchange="this.value = this.checked ? 1 : 0">
                              <label class="custom-control-label" for="edit_tipe_moving" id="label_edit_tipe_moving"></label>
                            </div>
                        </div>

                        <input type="hidden" class="form-control" id="edit_is_reverse_threshold" name="edit_is_reverse_threshold" value="0">
                        <input type="hidden" class="form-control" id="edit_is_data_passive" name="edit_is_data_passive" value="1">
                        <input type="hidden" class="form-control" id="edit_state" name="edit_state" value="0">

                        <!-- <h2>Parameter Set</h2>
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
                          </div> -->

                        <!-- <h2>Alert Action</h2>
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
                              </select>
                              <input type="hidden" name="edit_is_tts" id="edit_is_tts" value="0">
                              <input type="hidden" name="edit_html_id" id="edit_html_id" value="">
                              <br>
                              <input hidden type="checkbox" class="custom-control-input" id="edit_sound_active" name="edit_sound_active" value="1" onchange="this.value = this.checked ? 1 : 0">
                              <input type="hidden" class="form-control" id="edit_text_to_speech_active" name="edit_text_to_speech_active" value="">
                              <div style="text-align: right;">
                              <button type="button" class="btn btn-primary" onclick="playSound()">Play</button>
                              </div>
                          </div> -->

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
                            <label for="hitapi_ruangan_id">Kategori</label>
                            <select class="form-control" id="hitapi_ruangan_id" name="hitapi_ruangan_id">
                                <!-- Add your select options here inez -->
                            </select>
                            
                            <input type="hidden" name="hitapi_hidden_id_content" id="hitapi_hidden_id_content" value="">
                            <!--<input type="hidden" name="hidden_edit_ruangan_id" id="hidden_edit_ruangan_id" value="">-->
                        </div>

                        <div class="form-group">
                            <label for="hitapi_reader_id">Variable</label>
                            <select class="form-control" id="hitapi_reader_id" name="hitapi_reader_id">
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
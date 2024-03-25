<div class="container-fluid">

    <div class="row">

      <div class="col-sm-12">

        <div class="chart-hd">
          
          <strong>Parameter Variabel&nbsp;</strong>

          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#databaseModal">Add</button>
          <button type="button" class="btn btn-primary" onclick="window.location.reload()">Refresh</button>

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

  function load_dropdown_parameter(id_parameter = null) {
		
		//get a reference to the select element
		var $parameter_id = $('#parameter_id');
    $("#parameter_id").html('<option value="0">Loading...</option>');

    let hidden_parameter_id = id_parameter;

		$.ajax({
		method: "POST",
		url:'<?php echo site_url() . 'variable/load_dropdown_parameter'; ?>',
		dataType: 'JSON', 
		success: function(data){

			if (data.is_data_ada){

				//clear the current content of the select
				$parameter_id.html('');
				$parameter_id.append('<option value = "0">- Silahkan Pilih -</option>');

				//iterate over the data and append a select option

				$.each(data.list_data, function (key, val){
					
          //$parameter_id.append('<option value = "' + val.id_parameter + '">' + val.nama_parameter + '</option>');

          if (hidden_parameter_id == val.id_parameter){
						$parameter_id.append('<option selected="selected" value = "' + val.id_parameter + '">' + val.nama_parameter + '</option>');
          } else {
              $parameter_id.append('<option value = "' + val.id_parameter + '">' + val.nama_parameter + '</option>');
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

  function load_dropdown_parameter_edit(id_parameter){
		
    //get a reference to the select element
		var $edit_parameter_id = $('#edit_parameter_id');
    $("#edit_parameter_id").html('<option value="0">Loading...</option>');

		//let hidden_parameter_id = $("#hidden_parameter_id").val();
    let hidden_parameter_id = id_parameter;

		$.ajax({
		method: "POST",
		url:'<?php echo site_url() . 'variable/load_dropdown_parameter'; ?>',
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
</script>

<!-- Initialize DataTable on the table you want to display content data -->
<script>
$(document).ready(function() {
  
  load_dropdown_parameter('');

  $('.selectpicker').on('change', function(){

    var selected = $(this).find("option:selected").val();

    if (selected==1){
      window.location.replace("<?php echo site_url(); ?>");
    } else if (selected==2){
      //window.location.replace("<?php //echo site_url(); ?>/home/getListDalam");
    }

  });

    $('#contentTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: "<?php echo site_url(); ?>variable/serverSideDatatables",
            type: "POST"
        },
        columns: [
            { data: "no_urut", className: "dt-center" },
            { data: "nama_parameter", className: "dt-left" },
            { data: "nama_variable", className: "dt-left" },
            { data: "action", className: "dt-center" },
        ]
    });

});

// Add your edit logic here

function editData(id) {

    $.ajax({
        url: "<?php echo site_url(); ?>variable/edit/"+id,
        type: "GET",
        success: function(response){

          // handle success response here
          //console.log(response);
          var responseData = JSON.parse(response);
            
          // Populate modal with data
          $('#editModal').modal('show');
          
          //$('#edit_parameter_id').val(responseData.data.parameter_id);
          $('#edit_nama_variable').val(responseData.data.nama_variable);
          $('#hidden_edit_id_variable').val(responseData.data.id_variable);
          $('#hidden_edit_old_nama_variable').val(responseData.data.nama_variable);

          load_dropdown_parameter_edit(responseData.data.parameter_id);

        },
        error: function(xhr, status, error){
            // handle error here
        }

    });

}

function deleteVariable(id){

    // Ask for confirmation before proceeding with deletion
    if(confirm("Are you sure you want to delete this data ?")){
        $.ajax({
            url: "<?php echo site_url(); ?>variable/delete/"+id,
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

  let parameter_id = $('#parameter_id').val();

  if (parameter_id == '0'){
    alert('Kategori harus diisi !!');
    $('#parameter_id').focus();
    return false;
  }

  let nama_variable = $('#nama_variable').val();

  if (nama_variable == ''){
    alert('Variabel harus diisi !!');
    $('#nama_variable').focus();
    return false;
  }

  $.ajax({
    url: "<?php echo site_url(); ?>variable/store",
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

  // Add your button click logic here

  if ($('#edit_parameter_id').val() == '0'){
    alert('Kategori harus diisi !!');
    $('#edit_parameter_id').focus();
    return false;
  }

  if ($('#edit_nama_variable').val() == ''){
    alert('Nama Variabel harus diisi !!');
    $('#edit_nama_variable').focus();
    return false;
  }

  $.ajax({
    url: "<?php echo site_url(); ?>variable/update",
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
</script>

  <!--display: flex; -->
  <div class="container-fluid" style="justify-content: center;">

    <table width="100%" class="table table-bordered table-striped" id="contentTable">
        <thead>

            <tr>
              <th style="width: 5%;">No.</th>
              <th style="width: 60%; text-align: center;">Kategori</th>
              <th style="width: 25%; text-align: center;">Variabel</th>
              <th style="width: 10%;">Action</th>
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

  <!-- Modal for Database Structure Form -->
  <div class="modal fade" id="databaseModal" tabindex="-1" role="dialog" aria-labelledby="databaseModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              
            <div class="modal-header">
                  <h5 class="modal-title" id="databaseModalLabel">Form Add</h5>
                  <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>-->
              </div>

              <div class="modal-body">
                  <form name="form_database" id="form_database" method="post" enctype="multipart/form-data">

                      <div class="form-group">
                          <label for="parameter_id">Kategori</label>
                          <select class="form-control" id="parameter_id" name="parameter_id"></select>
                      </div>

                      <div class="form-group">
                          <label for="nama_variable">Variabel</label>
                          <input type="text" class="form-control" id="nama_variable" name="nama_variable" value="">
                      </div>

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
                    <form name="form_edit" id="form_edit" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="edit_parameter_id">Kategori</label>
                            <select class="form-control" id="edit_parameter_id" name="edit_parameter_id"></select>
                            <input type="hidden" name="hidden_edit_id_variable" id="hidden_edit_id_variable" value="">
                            <input type="hidden" name="hidden_edit_old_nama_variable" id="hidden_edit_old_nama_variable" value="">
                        </div>

                        <div class="form-group">
                            <label for="edit_nama_variable">Nama Variabel</label>
                            <input type="text" class="form-control" id="edit_nama_variable" name="edit_nama_variable">
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button onclick="update()" type="button" class="btn btn-primary" id="updateDatabase">Update</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
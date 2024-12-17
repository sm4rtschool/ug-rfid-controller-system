<div class="container-fluid">

    <div class="row">

      <div class="col-sm-12">

        <div class="chart-hd">

          <strong>Parameter Audio&nbsp;</strong>

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
</script>

<!-- Initialize DataTable on the table you want to display content data -->
<script>
$(document).ready(function() {
  
  $('#edit_total_data').keyup(function(){
    FormNum(this);
  });

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
            url: "<?php echo site_url(); ?>audio/serverSideDatatables",
            type: "POST"
        },
        columns: [
            { data: "no_urut", className: "dt-center" },
            { data: "nama_audio", className: "dt-left" },
            { data: "is_active", className: "dt-center" },
            { data: "nama_file", className: "dt-center" },
            { data: "action", className: "dt-center" },
        ]
    });

});

// Add your edit logic here

function editData(id) {

    $.ajax({
        url: "<?php echo site_url(); ?>audio/edit/"+id,
        type: "GET",
        success: function(response){

            // handle success response here
            //console.log(response);
            var responseData = JSON.parse(response);
            
            // Populate modal with data
            $('#editModal').modal('show');
          
            $('#hidden_edit_id_audio').val(responseData.data.id_audio);
            $('#edit_nama_audio').val(responseData.data.nama_audio);
            $('#hidden_edit_old_nama_audio').val(responseData.data.nama_audio);

            $('#hidden_edit_old_nama_file').val(responseData.data.nama_file);

        },
        error: function(xhr, status, error){
            // handle error here
        }

    });

}

function deleteData(id){

    // Ask for confirmation before proceeding with deletion
    if(confirm("Are you sure you want to delete this data ?")){
        $.ajax({
            url: "<?php echo site_url(); ?>audio/delete/"+id,
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

  let nama_audio = $('#nama_audio').val();

  if (nama_audio == ''){
    alert('Nama audio harus diisi !!');
    $('#nama_audio').focus();
    return false;
  }

  let formData = new FormData($('#form_database')[0]);
  
  $.ajax({
    url: "<?php echo site_url(); ?>audio/store",
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
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

  // Add your button click logic here, inez

  if ($('#edit_nama_audio').val() == ''){
    alert('Nama audio harus diisi !!');
    $('#edit_nama_audio').focus();
    return false;
  }

  var formData = new FormData($('#form_edit')[0]);
  
  $.ajax({
    url: "<?php echo site_url(); ?>audio/update",
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
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

function update_status(id) {
  window.location.href = "<?php echo base_url(); ?>audio/change/" + id;
}
</script>

  <!--display: flex; -->
  <div class="container-fluid" style="justify-content: center;">

    <table width="100%" class="table table-bordered table-striped" id="contentTable">
        <thead>

            <tr>
              <th style="width: 5%;">No.</th>
              <th style="width: 65%; text-align: center;">Nama Audio</th>
              <th style="width: 10%; text-align: center;">Aktif</th>
              <th style="width: 10%; text-align: center;">File</th>
              <th style="width: 10%;">Status</th>
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
                          <label for="nama_audio">Nama Audio</label>
                          <input type="text" class="form-control" name="nama_audio" id="nama_audio" value="">
                      </div>

                      <div class="form-group">
                          <label for="nama_audio">Nama File</label>
                          <input type="file" class="form-control-file" name="nama_file" id="nama_file" value="">
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
                            <label for="edit_nama_audio">Nama Audio</label>
                            <input type="text" class="form-control" name="edit_nama_audio" id="edit_nama_audio" value="">
                            <input type="hidden" name="hidden_edit_id_audio" id="hidden_edit_id_audio" value="">
                            <input type="hidden" name="hidden_edit_old_nama_audio" id="hidden_edit_old_nama_audio" value="">
                            <input type="hidden" name="hidden_edit_old_nama_file" id="hidden_edit_old_nama_file" value="">
                        </div>

                        <div class="form-group">
                            <label for="edit_nama_file">Nama File</label>
                            <input type="file" class="form-control-file" name="edit_nama_file" id="edit_nama_file" value="">
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
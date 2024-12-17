<div class="container-fluid">

    <div class="row">

      <div class="col-sm-12">

        <div class="chart-hd">

          <strong>Parameter Kategori&nbsp;</strong>

          <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#databaseModal">Add</button> -->
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
            url: "<?php echo site_url(); ?>kategori/serverSideDatatables",
            type: "POST"
        },
        columns: [
            { data: "no_urut", className: "dt-center" },
            { data: "nama_parameter", className: "dt-left" },
            // { data: "total_data", className: "dt-right" },
            { data: "action", className: "dt-center" },
        ]
    });

});

// Add your edit logic here

function editData(id) {

    $.ajax({
        url: "<?php echo site_url(); ?>kategori/edit/"+id,
        type: "GET",
        success: function(response){

            // handle success response here
            //console.log(response);
            var responseData = JSON.parse(response);
            
            // Populate modal with data
            $('#editModal').modal('show');
          
            $('#edit_nama_parameter').val(responseData.data.nama_parameter);
            $('#hidden_edit_id_parameter').val(responseData.data.id_parameter);
            $('#hidden_edit_old_nama_parameter').val(responseData.data.nama_parameter);

            $('#edit_total_data').val(responseData.data.total_data);

        },
        error: function(xhr, status, error){
            // handle error here
        }

    });

}

function deleteKategori(id){

    // Ask for confirmation before proceeding with deletion
    if(confirm("Are you sure you want to delete this data ?")){
        $.ajax({
            url: "<?php echo site_url(); ?>kategori/delete/"+id,
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

  let nama_parameter = $('#nama_parameter').val();

  if (nama_parameter == ''){
    alert('Kategori harus diisi !!');
    $('#nama_parameter').focus();
    return false;
  }

  $.ajax({
    url: "<?php echo site_url(); ?>kategori/store",
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

  // Add your button click logic here, inez

  if ($('#edit_nama_parameter').val() == ''){
    alert('Kategori harus diisi !!');
    $('#edit_nama_parameter').focus();
    return false;
  }

  $.ajax({
    url: "<?php echo site_url(); ?>kategori/update",
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
              <th style="width: 75%; text-align: center;">Nama Parameter</th>
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
                          <label for="parameter_id">Kategori</label>
                          <input type="text" class="form-control" name="nama_parameter" id="nama_parameter" value="">
                          <input type="hidden" class="form-control" id="total_data" name="total_data" value="0">
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
                            <input type="text" class="form-control" name="edit_nama_parameter" id="edit_nama_parameter" value="">
                            <input type="hidden" name="hidden_edit_id_parameter" id="hidden_edit_id_parameter" value="">
                            <input type="hidden" name="hidden_edit_old_nama_parameter" id="hidden_edit_old_nama_parameter" value="">
                            <input type="hidden" class="form-control" id="edit_total_data" name="edit_total_data" value="0">
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
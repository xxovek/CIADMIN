        <div class="main-wrapper">
            <div class="page-wrapper">
                <div class="content container-fluid">
					<div class="row">
						<div class="col-sm-8">
							<h4 class="page-title">Designations</h4>
						</div>
						<div class="col-sm-4 text-right m-b-30">
							<a href="#" class="btn btn-primary rounded" data-toggle="modal" data-target="#add_designation"><i class="fa fa-plus"></i> Add New Designation</a>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-striped custom-table m-b-0 datatable">
									<thead>
										<tr>
											<th>#</th>
											<th>Designation </th>
											<th>Department </th>
											<th class="text-right">Action</th>
										</tr>
									</thead>
									<tbody>

									</tbody>
								</table>
							</div>
						</div>
					</div>
                </div>

            </div>
			<div id="delete_designation" class="modal custom-modal fade" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content modal-md">
						<div class="modal-header">
							<h4 class="modal-title">Delete Designation</h4>
						</div>
						<div class="modal-body card-box">
							<p>Are you sure want to delete this?</p>
							<div class="m-t-20 text-left">
								<a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
								<button type="submit" class="btn btn-danger">Delete</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="add_designation" class="modal custom-modal fade" role="dialog">
				<div class="modal-dialog">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="modal-content modal-md">
						<div class="modal-header">
							<h4 class="modal-title">Add Designation</h4>
						</div>
						<div class="modal-body">
							<form>
								<div class="form-group">
									<label>Designation Name <span class="text-danger">*</span></label>
									<input class="form-control" required="" type="text">
								</div>
								<div class="m-t-20 text-center">
									<button class="btn btn-primary">Create Designation</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div id="edit_designation" class="modal custom-modal fade" role="dialog">
				<div class="modal-dialog">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="modal-content modal-md">
						<div class="modal-header">
							<h4 class="modal-title">Edit Designation</h4>
						</div>
						<div class="modal-body">
							<form>
								<div class="form-group">
									<label>Designation Name <span class="text-danger">*</span></label>
									<input class="form-control" value="Web Developer" type="text">
								</div>
								<div class="m-t-20 text-center">
									<button class="btn btn-primary">Edit Designation</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
        </div>
    <script type="text/javascript">
    fetchDepartmentList();

      function fetchDepartmentList(){
        $("#bodydepartmentlist").empty();
        $.ajax({
          type:'POST',
          url:'../src/fetchdepartmentlist.php',
          success:function(msg){
            var response = JSON.parse(msg);
            var count = Object.keys(response).length;
            var html ='';
            for(var i=0;i<count;i++){
              html +='<tr>';
              html +='  <td>'+(i+1)+'</td>';
              html +='  <td>'+response[i]['departmentname']+'</td>';
              html +='  <td class="text-right">';
              html +='    <div class="dropdown">';
              html +='      <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>';
              html +='      <ul class="dropdown-menu pull-right">';
              html +='        <li><a href="#" data-toggle="modal" data-target="#edit_department" title="Edit" onclick ="editDepartment('+response[i]['id']+')"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>';
              html +='        <li><a href="#" data-toggle="modal" data-target="#delete_department" title="Delete" onclick ="deleteDepartment('+response[i]['id']+')"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>';
              html +='      </ul>';
              html +='    </div>';
              html +='  </td>';
              html +='</tr>';
            }
            $("#bodydepartmentlist").html(html);
            $("#departmentListTbl").dataTable();
          }
        });
      }
      function editDepartment(param){
        $.ajax({
          type:'POST',
          url:'../src/fetchsingledepartmentname.php',
          data:({
            departmentid:param
          }),
          success:function(msg){
           var response = JSON.parse(msg);
           $("#editdepartmentname").val(response['departmentname']);
           $("#editdepartmentid").val(param);
          }
        });
      }
      function saveeditDepartment(){
        var departmentname = $("#editdepartmentname").val();
        var departmentid = $("#editdepartmentid").val();
         if(departmentname ===""){
           $("#msgeditdeptname").html("<font color='red'>Please Enter New Department Name</font>");
         }
         else {
            $("#msgeditdeptname").html("");
        $.ajax({
          type:'POST',
          url:'../src/updatedepartmentname.php',
          data:({
            departmentname:departmentname,
            departmentid:departmentid
          }),
          success:function(msg){
            alert(msg);
            window.location.reload();
             fetchDepartmentList();
          }
        });
      }
      }
      function deleteDepartment(param){
        $.ajax({
          type:'POST',
          url:'../src/deletedepartmentbyid.php',
          data:({
            departmentid:param
          }),
          success:function(msg){
            alert("Delete Successfully");

          }
        });
      }
      function addDepartment(){
        var departmentname = $("#departmentname").val();
         if(departmentname ===""){
           $("#msgdeptname").html("<font color='red'>Please Enter New Department Name</font>");
         }
         else {
            $("#msgdeptname").html("");
        $.ajax({
          type:'POST',
          url:'../src/insertdepartmentname.php',
          data:({
            departmentname:departmentname
          }),
          success:function(msg){
            alert(msg);
            window.location.reload();
          }
        });
      }
      }
      function existDepartment(){
        var departmentname = $("#departmentname").val();
        $.ajax({
          type:'POST',
          url:'../src/existdepartmentname.php',
          data:({
            departmentname:departmentname
          }),
          success:function(msg){
             var response = JSON.parse(msg);
             if(response['status']){
               $("#departmentname").val("");
               $("#msgdeptname").html("<font color='red'>Please Enter New Department Name</font>");
             }
             else {
               $("#msgdeptname").html("");
             }
          }
        });
      }
    </script>

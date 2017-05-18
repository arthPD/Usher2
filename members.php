<?php  
	include('sidenav.php');
	$_SESSION['page'] = 'Members';
	$members = R::findAll( 'members' );
?>
	<!-- body here -->
	<div ng-app="myApp" ng-controller="myCtrl" ng-init="initialize()">
		<div class="row">
			<div class="col-md-12">
			<hr>
				<div class="panel panel-info">
				    	<button data-toggle='modal' data-target='#add' style="margin-bottom: 3px" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Add</button>
				    <div class="panel-heading">
				        <h4 data-toggle="collapse" data-parent="#accordion" href="#chart1"><i class="fa fa-users"></i> Members</h4>
				    </div>
				    <div id="chart1" class="panel-collapse collapse in">
				      	<div class="panel-body">
							<div id='tablediv' class="container-fluid" style="width: 100% ;height: 450px ;overflow-y: scroll; border: thin;">
								<table id='table' class="table table-condensed table-bordered table-striped table-hover">
								    <thead>
								      <tr>
								        <th>Name</th>
								        <th>Contact Number</th>
								        <th>Address</th>
								        <th>Note</th>
								        <th>Action</th>
								      </tr>
								    </thead>
								    <tbody id='tablebody'>
								    	<tr ng-repeat="x in members track by $index">
								    		<td><span ng-bind="x.name"></span></td>
								    		<td><span ng-bind="x.contact_no"></span></td>
								    		<td><span ng-bind="x.address"></span></td>
								    		<td><span ng-bind="x.note"></span></td>
								    		<td>
								    			<button ng-click="editfunction(x)" class='btn btn-sm btn-primary'><i class='fa fa-edit'></i> Edit</button>
								    			<button ng-click="deletefunction(x)" class='btn btn-sm btn-danger'><i class='fa fa-trash'></i> Delete</button>
								    		</td>
								    	</tr>
								    </tbody>
								  </table>
							</div><!-- tablediv -->
							<h1></h1>
							<div class="pull-right col-md-3">
								<div class="input-group">
								    <span class="input-group-addon">Search: </span>
							    	<input ng-keyup="searchfunction()" id="search" type="text" class="form-control" name="search" placeholder="Enter Name here">
							  	</div>
							</div>
				     	</div>
			    	</div>
			  	</div>			
			</div>
		</div>

		<!-- Add Member Modal -->
		<div id="add" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Add Member</h4>
					</div>
					<div class="modal-body">
						<form id='newform' name="newform" class="row" enctype="multipart/form-data">
							<div class="row container-fluid">
								<div style="padding-bottom: 5px">
									<div class="col-md-6">
										<label>Full Name: </label><input type="text" class="form-control" id="name" name="name">
									</div>
									<div class="col-md-6">
										<label>Birthdate: </label><input readonly data-provide="datepicker" class="form-control" id="birthdate" name="birthdate" data-date-end-date="-10y" data-date-format="MM dd, yyyy" required>
									</div>
								</div>
								<div class="col-md-12" style="padding-bottom: 5px">
									<label >Address:</label>
									<textarea placeholder="House No./Street/Brgy./City" class="form-control" rows="5" id="address" name="address"></textarea>	
								</div>
								<div>
									<div class="col-md-6">
										<label>Contact Number:</label>
										<input type="number" id="contact_no" name="contact_no" class="form-control">
									</div>
									<div class="col-md-6">
										<label>Image:</label>
										<input type="file" accept="image/*" class="form-control" name="fileToUpload" id="fileToUpload">
									</div>
								</div>
								<div class="col-md-12" style="padding-bottom: 5px">
									<label >Note:</label>
									<textarea placeholder="Additional Note/Description" class="form-control" rows="5" id="note" name="note"></textarea>	
								</div>
							</div>
					</div>
					<div class="modal-footer">
						<button ng-click="addfunction()" data-dismiss="modal" class="btn btn-primary">Save</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<input type="hidden" name="addform" value="1">
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- <a href="tel:18475555555">Click Here To Call Support 1-847-555-5555</a>  -->
		<!-- Edit Member modal -->
		<div id="add2" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Edit Profile</h4>
					</div>
					<div class="modal-body">
					<div class="arthcontainer" style="display: flex;">
						<img src="" style="margin: 0 auto; height: 274px; border-radius: 55%; padding: 10px;" id="editimage">
					</div>
						<form id='newform2' name="newform2" class="row" enctype="multipart/form-data">
							<div class="row container-fluid">
								<div style="padding-bottom: 5px">
									<div class="col-md-6">
										<label>Full Name: </label><input type="text" class="form-control" id="name2" name="name2">
									</div>
									<div class="col-md-6">
										<label>Birthdate: </label><input readonly data-provide="datepicker" class="form-control" id="birthdate2" name="birthdate2" data-date-end-date="-10y" data-date-format="MM dd, yyyy" required>
									</div>
								</div>
								<div class="col-md-12" style="padding-bottom: 5px">
									<label >Address:</label>
									<textarea placeholder="House No./Street/Brgy./City" class="form-control" rows="5" id="address2" name="address2"></textarea>	
								</div>
								<div>
									<div class="col-md-6">
										<label>Contact Number:</label>
										<input type="number" id="contact_no2" name="contact_no2" class="form-control">
									</div>
									<div class="col-md-6">
										<label>Image:</label>
										<input type="file" accept="image/*" class="form-control" id="fileToUpload2" name="fileToUpload2">
									</div>
								</div>
								<div class="col-md-12" style="padding-bottom: 5px">
									<label >Note:</label>
									<textarea placeholder="Additional Note/Description" class="form-control" rows="5" id="note2" name="note2"></textarea>	
								</div>
							</div>
					</div>
					<div class="modal-footer">
						<input type="hidden" id="id2" name="id2">
						<button ng-click="edit()" data-dismiss="modal" class="btn btn-primary">Save</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<input type="hidden" name="editform" value="1">
						</form>
					</div>
				</div>
			</div>
		</div>

		<!-- Delete Modal -->
		<div id="deletemodal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Delete profile</h4>
					</div>
					<div class="modal-body" id='messagex'>
					</div>
					<form>
					<input type="hidden" id='id'>
					</form>
					<div class="modal-footer">
						<button ng-click="delete()" class="btn btn-danger">Yes</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	</div><!-- body -->
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="js/inputmask.js"></script>
	<script type="text/javascript" src="js/jquery.inputmask.js"></script>
	<script>/*angular*/
		var app = angular.module('myApp', []);
		app.controller('myCtrl', function($scope, $http) {
		    $scope.addimage = "images/avatar.png";
		    $scope.members;
		    $scope.initialize = function(){
		    	var array = '<?php echo json_encode($members) ?>';
		    	var array = JSON.parse(array);
		    	$scope.members = array;
		    }
		    $scope.deletefunction = function(member){
		    	$('#id').val(member.id);
		    	var msg = "Are you sure you want to delete <strong>" + member.name + "</strong>`s profile?";
		    	document.getElementById('messagex').innerHTML = msg;
		    	$('#deletemodal').modal('show');
		    }
		    $scope.delete = function(){
		    	var id = document.getElementById('id').value;
		    	$.ajax({
		    		url: "memberajax.php",
		    		type: "POST",
		    		data: {id:id, delete: 1},
		    		success: function(data){
						$scope.members = JSON.parse(data);
						$scope.$apply();
						$('#deletemodal').modal('hide');
		    		},
		    		error: function(data){
		    			alert("Error!");
		    		}
		    	})/*relfect delete*/
		    }
		    $scope.addfunction = function(){
				var formdata = new FormData($("#newform")[0]);
				$.ajax({
					url: "memberajax.php",
					type:"POST",
					data: formdata,//{name, birthdate, address, contact_no, note, fileToUpload, addform: 1},
				  	processData: false,
  					contentType: false,
					success: function(data){
						$scope.members = JSON.parse(data);
						$scope.$apply();
						$('#name').val('');
						$('#birthdate').val('');
						$('#address').val('');
						$('#contact_no').val('');
						$('#note').val('');

						/*change image*/
						let file = $("#fileToUpload")[0].files[0]; 
						$scope.addimage = "images/" + file.name;
						
					},
					error: function(data){
						alert('Error!');
					}
				});
			}
			$scope.editfunction = function(member){
				$('#id2').val(member.id);
				$('#name2').val(member.name);
				$('#birthdate2').val(member.birthdate);
				$('#address2').val(member.address);
				$('#contact_no2').val(member.contact_no);
				$('#note2').val(member.note);
				$('#fileToUpload2').src = "";
				$('#add2').modal('show');
				if(member.image == ""){
					document.getElementById("editimage").src = "images/avatar.png";
				}else{
					document.getElementById("editimage").src = "images/"+member.image;
				}
			}
			$scope.edit = function(){
				var formdata = new FormData($("#newform2")[0]);
				$.ajax({
					url: "memberajax.php",
					type:"POST",
					data:formdata,
				  	processData: false,
  					contentType: false,
					success: function(data){
						$scope.members = JSON.parse(data);
						$scope.$apply();
					},
					error: function(data){
						alert('Error!');
					}
				});
			}
			$scope.searchfunction = function(){
				var searchtext = $('#search').val();
				$.ajax({
					url: "memberajax.php",
					type: "GET",
					data: {searchtext, searchfunction: 1},
					success: function(data){
						$scope.members = JSON.parse(data);
						$scope.$apply();
					},
					error: function(data){

					}
				});
			}
		});
	</script>
	<script>
		$(document).ready(function(){
			$(":input").inputmask();
		  	or
		  	Inputmask().mask(document.querySelectorAll("input"));
		});
		window.onload = function() {
		    if(!window.location.hash) {
		        window.location = window.location + '#loaded';
		        window.location.reload();
		    }
		}
		function openNav() {
		    document.getElementById("mySidenav").style.width = "250px";
		    document.getElementById("main").style.marginLeft = "250px";
		    document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
		}

		function closeNav() {
		    document.getElementById("mySidenav").style.width = "0";
		    document.getElementById("main").style.marginLeft= "0";
		    document.body.style.backgroundColor = "white";
		}
	</script>
	</body>
</html> 
<?php  
	include('sidenav.php');
	$_SESSION['page'] = 'Services';
	$services = R::findAll('services');
	$members = R::findAll('members');
	$session = "No service started";
	if(!isset($_SESSION['started']) || empty($_SESSION['started'])){
		$_SESSION['started'] = "No service started";;
	}
	//session_destroy();
?>
	<!-- body here -->
	<div ng-app="myApp" ng-controller="myCtrl" ng-init="initialize()">

		<button id="startbtn" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addservice"><i class="fa fa-hourglass-start"></i> Start Service</button>
		<button id="savebtn" ng-click='savefunction()' class="btn btn-primary pull-right"><i class="fa fa-save"></i> Save</button>
		<button id="resetbtn" ng-click='reset()' class="btn btn-info"><i class="fa fa-refresh"></i> Reset</button>

		<!-- Start Modal -->
		<div id="addservice" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Start a service</h4>
		      </div>
		      <div class="modal-body">
		        <form>
		        	<div class="row">
		        		<div class="col-md-6">
		        			<label for="serviceid">Choose service type:</label>
				        	<select ng-model="selectservice" ng-change="custom(selectservice)" class="form-control" id="serviceid">
				        		<option value="other">Other</option>
				        		<option ng-repeat="x in services track by $index" value="{{x.id}}">{{x.name}}</option>
				        	</select>	
		        		</div>
		        		<div class="col-md-6" id="ifcustom">
		        			<label>Enter service name:</label>
		        			<input type="text" ng-model="customservice" class="form-control">
		        		</div>
		        	</div>
		        	<h1></h1>
		        </form>
		      </div>
		      <div class="modal-footer">
		      	<button ng-click="startservice()" class="btn btn-primary">Start</button>
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
		    </div>
		  </div>
		</div>

		<h2 style="text-align: center" ng-bind="servicetitle"></h2>
		<hr style="padding-bottom: 5%">

		<!-- main table -->
		<div id="presenttbl" style="width: 100% ;height: 350px ;overflow-y: scroll;">
			<table class="table table-bordered table-striped">
			    <thead>
			      <tr>
			        <th width="30%">Name</th>
			        <th width="20%">Time in</th>
			        <th>Note</th>
			        <th>Action</th>
			      </tr>
			    </thead>
			    <tbody>
			    	<tr ng-repeat="x in present track by $index">
			    		<td><span ng-bind="x.name"></span></td>
			    		<td><span ng-bind="x.timein"></span></td>
			    		<td ng-bind="x.note"></td>
			    		<td><button ng-click="removefrompresent(x)" class="btn btn-sm btn-danger"><i class="fa fa-remove"></i> Remove</button></td>	
			    	</tr>
			    </tbody>
		  	</table>
	  	</div>
	  	<button data-toggle="modal" data-target="#add" id="addmemberbtn" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add</button>

	  	<!-- Add Member Modal -->
		<div id="add" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Add to present list</h4>
					</div>
					<div class="modal-body">
						<div style="width: 100% ;height: 350px ;overflow-y: scroll; border: thin;">
							<table class="table table-bordered table-striped">
							    <thead>
							      <tr>
							        <th width="80%">Name</th>
							        <th>Action</th>
							      </tr>
							    </thead>
							    <tbody>
							    	<tr ng-repeat="x in members track by $index">
							    		<td><span ng-bind="x.name"></span></td>
							    		<td><button ng-click="addtopresent(x, $index)" class="btn btn-info"><i class="fa fa-plus"></i> Add</button></td>
							    	</tr>
							    </tbody>
						  	</table>
					  	</div>
					</div>
					<div class="modal-footer">
						<div class="col-md-6">
							<button data-toggle="modal" data-target="#first" class="pull-left btn btn-success"><i class="fa fa-user-o"></i> First timer</button>
						</div>
						<div class="pull-right col-md-6">
							<div class="input-group">
							    <span class="input-group-addon">Search: </span>
						    	<input ng-keyup="searchfunction()" id="search" type="text" class="form-control" name="search" placeholder="Enter Name here">
						  	</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- add first timer modal -->
		<div id="first" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Add First Timer</h4>
					</div>
					<div class="modal-body">
						<form id='newform' class="row">
							<div class="row container-fluid">
								<div style="padding-bottom: 5px">
									<div class="col-md-6">
										<label>Full Name: </label><input type="text" class="form-control" id="name">
									</div>
									<div class="col-md-6">
										<label>Birthdate: </label><input readonly data-provide="datepicker" class="form-control" id="birthdate" data-date-end-date="-10y" data-date-format="MM dd, yyyy" required>
									</div>
								</div>
								<div class="col-md-12" style="padding-bottom: 5px">
									<label >Address:</label>
									<textarea placeholder="House No./Street/Brgy./City" class="form-control" rows="5" id="address"></textarea>	
								</div>
								<div>
									<div class="col-md-6">
										<label>Contact Number:</label>
										<input type="number" id="contact_no" class="form-control" min="11">
									</div>
									<div class="col-md-6">
										<label>Image:</label>
										<input type="file" accept="image/*" class="form-control" id="image">
									</div>
								</div>
								<div class="col-md-12" style="padding-bottom: 5px">
									<label >Note:</label>
									<textarea placeholder="Additional Note/Description" class="form-control" rows="5" id="note"></textarea>	
								</div>
							</div>
					</div>
					<div class="modal-footer">
						<button ng-click="addfirst()" data-dismiss="modal" class="btn btn-primary">Add</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</form>
					</div>
				</div>
			</div>
		</div><!-- add first timer modal -->
	</div><!-- angular div -->
	</div>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>	
	<script>
		var app = angular.module('myApp', []);
		app.controller('myCtrl', function($scope, $http) {

			$scope.members = [];
			$scope.services = [];
			$scope.present = [];
			$scope.holder = [];
			$scope.result = [];

			$scope.initialize = function(){
				var session = "<?php echo $_SESSION['started'] ?>";
				if(session !== "No service started"){
					$scope.poststart();
				}
				else{//if no service started
					$('#ifcustom').hide();
					$('#savebtn').hide();
					$('#resetbtn').hide();
					$('#presenttbl').hide();
					$('#addmemberbtn').hide();

					var array = '<?php echo json_encode($services) ?>';
			    	var array = JSON.parse(array);
			    	Object.keys(array).forEach(function(key) {
					    $scope.services.push(array[key]);
					});

			    	var array = '<?php echo json_encode($members) ?>';
			    	var array = JSON.parse(array);
			    	Object.keys(array).forEach(function(key) {
					    $scope.members.push(array[key]);
					});
				}
			}
			$scope.startservice = function(){
				if($scope.selectservice == 'other'){
					$scope.selectservice = $scope.customservice;
				}
				$.ajax({
					url: "serviceajax.php",
					method: "POST",
					data: {servicenameorid: $scope.selectservice, start: 1},
					success: function(data){
						data = JSON.parse(data);
						$scope.servicetitle = data.name;
						$scope.$apply();
						$scope.poststart();
					},
					error: function(data){
					}
				});
			}
			$scope.poststart = function(){
				$('#addservice').modal('hide');
				$('#startbtn').hide();
				$('#savebtn').show();
				$('#resetbtn').show();
				$('#presenttbl').show();
				$('#addmemberbtn').show();
				<?php
					$stringz = "$";
					if($_SESSION['started'] !== "No service started"){
						echo "".$stringz."scope.servicetitle = '".$_SESSION['started']."';";
					}
				?>
				//$members from database
		    	var array = '<?php echo json_encode($members) ?>';
		    	var array = JSON.parse(array);
		    	Object.keys(array).forEach(function(key) {
				    $scope.members.push(array[key]);
				});
				$.ajax({
					url: "serviceajax.php",
					method: "POST",
					data: {refill: 1},
					success: function(data){
						data = JSON.parse(data);
				    	Object.keys(data).forEach(function(key) {
				    		for(var ctr = 0; ctr < $scope.members.length; ctr++){
				    			if(data[key]['member_id'] == $scope.members[ctr]['id']){
						    		var note = "";
						    		if(data[key]['first'] == 1){
						    			note = "First Timer";
						    		}
						    		data[key]['timestamp'] = data[key]['timestamp'].slice(10);
								    $scope.present.push({
								    	id:  $scope.members[ctr]['id'],
								    	name:  $scope.members[ctr]['name'],
								    	timein:  data[key]['timestamp'].slice(0, -3),
								    	note:note
								    });
								    $scope.members.splice(ctr, 1);
					    			$scope.$apply();
				    			}
				    		}
						});

					},
					error: function(data){
					}
				});
			}
			$scope.custom = function(type){
				if(type == 'other'){
					$('#ifcustom').show();
				}else{
					$('#ifcustom').hide();
					$scope.customservice = "";
				}
			}
			$scope.addtopresent = function(member, $index){
					$scope.present.push({
						id: member["id"],
						name: member["name"],
						timein: new Date().toLocaleTimeString(),
						note: ""
					});
					/*to db*//*to function*/
					$.ajax({
						url: "serviceajax.php",
						type:"POST",
						data: {toattendancemember: 1, memberid: member["id"]},
						success: function(data){
						},
						error: function(data){
							alert('error');
						}
					});
					$scope.members.splice($index, 1);
					var searchtext = $('#search').val();
					if(searchtext.length > 0){
						$('#search').val('');
						Object.keys($scope.holder).forEach(function(key) {
						    $scope.members.push($scope.holder[key]);
						});
						$scope.holder = [];
					}
			}
			$scope.searchfunction = function(){
				var searchtext = $('#search').val();

				if(searchtext.length == 0){
					Object.keys($scope.holder).forEach(function(key) {
					    $scope.members.push($scope.holder[key]);
					});
					$scope.holder = [];
				}else{
					for (var ctr = 0; ctr < $scope.members.length; ctr++){
						if(!$scope.members[ctr]['name'].toLowerCase().match(searchtext.toLowerCase())){
							$scope.holder.push($scope.members[ctr]);
							$scope.members.splice($scope.members.indexOf($scope.members[ctr]), 1);
						}
					}
				}
			}
			$scope.removefrompresent = function(member){
				for(var ctr = 0; ctr < $scope.present.length; ctr++){
					if($scope.present[ctr]['id'] == member['id']){
						$scope.present.splice($scope.present.indexOf($scope.present[ctr]), 1);
					}
				}
				/*remove from db using id and date*/
				$.ajax({
					url: "serviceajax.php",
					type: "POST",
					data: {id: member['id'], searchone: 1},
					success: function(data){
						var member = JSON.parse(data);
						$scope.members.push(member);
						$scope.$apply();
					},
					error: function(data){
						alert("Error!");
					}
				});
			}
			$scope.addfirst = function(){
				var name = document.getElementById('name').value;
				var birthdate = document.getElementById('birthdate').value;
				var address = document.getElementById('address').value;
				var contact_no = document.getElementById('contact_no').value;
				var note = document.getElementById('note').value;
				$.ajax({
					url: "serviceajax.php",
					type:"POST",
					data:{name, birthdate, address, contact_no, note, addform: 1},
					success: function(data){
						var member = JSON.parse(data);
						$scope.present.push({
							id: member.id,
							name: member.name,
							timein: new Date().toLocaleTimeString(),
							note: "First Timer"
						});
						/*add to db*/
						$.ajax({
							url: "serviceajax.php",
							type:"POST",
							data: {toattendancemember: 1, memberid: member["id"], note: 1},
							success: function(data){
							},
							error: function(data){
								alert('error');
							}
						});
						$scope.$apply();
						$('#name').val('');
						$('#birthdate').val('');
						$('#address').val('');
						$('#contact_no').val('');
						$('#note').val('');
						$('#add').modal('hide');
					},
					error: function(data){
						alert('Error!');
					}
				});
			}
			$scope.reset = function(){
				var reset = confirm("Are you sure?");
				if (reset == true){
					$.ajax({
						url: "serviceajax.php",
						type:"POST",
						data: {unset: 1},
						success:function(){
							window.location.reload();
							/*delete attendance row from table*/
							/*delete attendancemember rows*/
						},
						error:function(){
						}
					});
				}
				//< ?php session_destroy();?>
			}
			$scope.savefunction = function(){
				/*update attendance table*/
				/*remove `started` session*/
				var save = confirm("Save service record?");
				if(save == true){
					$.ajax({
						url: "serviceajax.php",
						type:"POST",
						data: {save: 1},
						success:function(data){
							window.location.reload();
						},
						error:function(){
						}
					});
				}
			}
		});
	</script>
	<script>
		window.onload = function() {
		    if(!window.location.hash) {
		        window.location = window.location + '#loaded';
		        window.location.reload();
		    }
		}
		$(document).ready(function(){
			
		});
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
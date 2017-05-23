<?php  
	include('sidenav.php');
	$date = $_GET['date'];
	$service = $_GET['service'];

	/*di kase naka foreign key :3 */
	$service_id = R::findOne('services', 'name = :servicename', [':servicename' => $service]);
	$service_id = $service_id->id;

	$attendance_id = R::findOne('attendance', 'date LIKE :date && service_id = :service_id', [':date' => '%'.$date.'%', ':service_id' => $service_id]);
	$attendance_id = $attendance_id->id;

	$attendancemember = R::findAll('attendancemember', 'attendance_id = :att', [':att' => $attendance_id]);
	//echo "<script>console.log(".json_encode($attendancemember).")</script>";

	foreach($attendancemember as $member){
		$ids[] = $member->member_id;
	}
	$members = R::batch('members', $ids);
	//echo "<script>console.log(".json_encode($members).")</script>";
?>
<!-- body here -->
<div ng-app="myApp" ng-controller="myCtrl" ng-init="initialize()">
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>Name</th>
				<th>Time In</th>
				<th>Note</th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="a in attmem">
				<td>{{present[a.member_id].name}}</td>
				<td>{{a.timestamp}}</td>
				<td ng-if="a.first == 1">First Timer</td>
				<td ng-else> </td>
			</tr>
		</tbody>
	</table>
</div><!-- angular -->
</div>
<script>
	var app = angular.module('myApp', []);
		app.controller('myCtrl', function($scope, $http) {
			$scope.initialize = function(){
 		    	var array = '<?php echo json_encode($members) ?>';
		    	var array = JSON.parse(array);
				$scope.present = array;
				console.log($scope.present);

				var array = '<?php echo json_encode($attendancemember) ?>';
		    	var array = JSON.parse(array);
				$scope.attmem = array;				
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
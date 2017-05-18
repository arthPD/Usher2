<?php
	include('sidenav.php');
	$_SESSION['page'] = 'Reports';
	if(isset($_SESSION['attendance']) && !empty($_SESSION['attendance'])){
		$attendance = $_SESSION['attendance'];
	}else{
		$attendance = R::findAll('attendance', 'date < :date', [':date' => '2017-12-31']);
	}
	$attendancemember = R::findAll('attendancemember');
	$services = R::findAll('services');
?>
<!-- body here -->
<div class="row">
	<div class="conainter">
		<div class="col-md-3" style="padding-left: 70px">
			<select onchange="updatebar()" class="form-control" id="chartyear">
				<option value="2016">2016</option>
				<option selected="" value="2017">2017</option>
				<option value="2018">2018</option>
				<option value="2019">2019</option>
				<option value="2020">2020</option>
			</select>
		</div>
		<div class="col-md-3">
			<select onchange="updatebar()" class="form-control" id="chartmonth">
				<option value="01">January</option>
				<option value="02">February</option>
				<option value="03">March</option>
				<option value="04">April</option>
				<option value="05">May</option>
				<option value="06">June</option>
				<option value="07">July</option>
				<option value="08">August</option>
				<option value="09">September</option>
				<option value="10">October</option>
				<option value="11">November</option>
				<option value="12">December</option>
			</select>
		</div>
		<canvas height="100" id="myChart"></canvas>
	</div>
</div>
</div>
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
<script type="text/javascript" src="js/Chart.js"></script>
<script>

	function updatebar(){
		var chartmonth = $('#chartmonth').val();
		var chartyear = $('#chartyear').val();
		/*send ajax request*/
		$.ajax({
			url: "reportsajax.php",
			type: "POST",
			data: {year: chartyear, month: chartmonth, updatebar: 1},
			success: function(data){
				if(data == "No Result"){
					$('#chartmonth').selected = chartmonth;
					alert(data);
				}else{
					$('#chartmonth').selected = chartmonth;
					location.reload();
				}
			},
			error: function(data){

			}
		});
	}
	var months = [
		"zerobased",
		"January",
		"February",
		"March",
		"April",
		"May",
		"June",
		"July",
		"August",
		"September",
		"October",
		"November",
		"December",

	];
	var attendance = [];
	var labels = [];
	var totals = [];
	var firsts = [];

	var services = '<?php echo json_encode($services); ?>';
	var services = JSON.parse(services);

	var array = '<?php echo json_encode($attendance); ?>';
	var array = JSON.parse(array);
	Object.keys(array).forEach(function(key) {
		/*date*/
			var date = array[key].date;
			var month = date.substr(5,2);
			var day = date.substr(8);
			var year = date.substr(0,4);
			if(month > 9){
				month = month.substr(1);
			}
			var date = months[parseInt(month)] + " " + day + ", " + year;
		/*date*/

		/*service name*/
			Object.keys(services).forEach(function(key2) {
				if(services[key2].id == array[key].service_id){
					labels.push(months[parseInt(month)] + " " + day + ", " + year + " - " + services[key2].name);
				}
			});	
		/*service name*/

	    attendance.push(array[key]);
	    totals.push(array[key].total);
	    firsts.push(array[key].first);
	});

	var ctx = $("#myChart");
	var myChart = new Chart(ctx, {
	    type: 'bar',
	    data: {
	        labels: labels,
	        datasets: [
		        {
		            label: 'Total',
		            data: totals,
		            borderWidth: 2,
		            backgroundColor: 'rgba(255, 99, 132, .7)',
		            borderColor: 'rgba(255,99,132,1)'
		        },
		        {
	                label: 'First Timers',
	                data: firsts,
	                borderWidth: 2,
	                backgroundColor: 'rgba(54, 162, 235, .7)',
		            borderColor: 'rgba(54, 162, 235, 1)'
	            }
	        ]
	    },
	    options: {
	        scales: {
	            yAxes: [{
	                ticks: {
	                    beginAtZero:true
	                }
	            }]
	        }
	    }
	});
</script>
</body>
</html> 
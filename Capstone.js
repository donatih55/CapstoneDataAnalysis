//Global Variables
var rawdata = 0;
var data = 0;
var options = 0;
var isZip = false;
//functions to check user password
function checkUserPass(){
	var x = document.getElementById("password");
	var y = document.getElementById("username");
	if (x.value != "" && y.value != ""){
		document.getElementById("login").style.visibility = "block";
	}
};
//Ajax Caller to get php info

function getOutput(code, main, Yr_From, Yr_to, hist_stage, option, order, limit) {
	var json;
	$.ajax({
		url:'functions.php?code='+ code +'&main='+ main + '&Yr_From=' + Yr_From
	+ '&Yr_to=' + Yr_to + '&hist_stage=' +hist_stage + '&option=' + option + '&order=' + order + '&limit=' + limit + "&password=" + $("#password").val() + 
		"&username="+ $("#username").val() ,
		async: false,
		dataType: 'text',
		timeout: 30000,
		complete: function (response) {
			json = response.responseText;
			
		},
		error: function () {
			alert('Bummer: there was an error!');
		}
	});
	return json;
};
function queryDatabase(code, table, main, condition, group, order, limit) {
	var json;
	$.ajax({
		url:'functions.php?code='+ code + "&table=" + table +'&main='+ main + '&condition=' + condition
		+ '&group=' + group + '&order=' + order + '&limit=' + limit,
		async: false,
		dataType: 'text',
		timeout: 30000,
		complete: function (response) {
			json = response.responseText;
			
		},
		error: function () {
			alert('Bummer: there was an error!');
		}
	});
	return json;
};

//DRAW CHARTS, tables, maps, etc on the ChartSpace Element
//pie chart
function drawChartPie() {
	var chart = new google.visualization.PieChart(document.getElementById('ChartSpace'));
	chart.draw(data, {width: '100%', height: '100%'});
}
//HEat Map
function drawChartMap (){
	var options;
	//zips have to be set as markers while states are regions
	if (isZip){
		options = {width: '100%', height: '100%', region: 'US', displayMode: 'markers', colorAxis: {colors: ['yellow', 'red']}};
	} else {
		options = {width: '100%', height: '100%', region: 'US', displayMode : 'regions', resolution : 'provinces', colorAxis: {colors: ['yellow', 'red']}};
	}

	var chart = new google.visualization.GeoChart(document.getElementById('ChartSpace'));
	chart.draw(data, options);
}
//draw table
function drawTable () {	
	var chart = new google.visualization.Table(document.getElementById('ChartSpace'));
        chart.draw(data, {showRowNumber: true, width: '100%', height: '100%'});	
}
function drawChartBar(){
	var chart = new google.visualization.ColumnChart(document.getElementById('ChartSpace'));
	chart.draw(data, {'isStacked': true, 'legend': 'bottom', width: '100%', height: '100%'});
}

function populateSelect (select, ar, val){
	select.empty();
	$(ar).each(function(index, value) {
 		select.append($("<option>").attr('value', val[index]).text(ar[index]));
	});
}

window.onload = function (e) {
	//loadApi();
	//makeTable();
 google.charts.load('current', {'packages':['corechart','geomap','table']});
	makeWizard();
}


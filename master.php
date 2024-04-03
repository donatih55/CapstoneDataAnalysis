<?php include "header.php"?>

<div id="ChartSpace"></div>
<div id="QueryWizard">
	<div id="IntroWiz">
		<h1> Welcome to the Query Wizard</h1>
		<p>Please select <strong>only</strong> the fields you want to change</p>
	</div>
	<button onclick="submit()">Query!</button><br>
	<div id="Query2" class="Query">
		<h3> Department: </h3>	
		<select id="table">
			<option></option>
			<option value='Admissions'>Admissions</option>
			<option value='Alumni'>Alumni</option>
		</select>
	</div>
	<div id="Query1" class="Query">
		<h3>What information do you want?</h3>
		<select class="main"></select>
		<form class='mainOption'>
			Sum<input type='radio' name='val' value='Sum'>
  			Count<input type='radio' name='val' value='Count'>
			None<input type='radio' name='val' value='none' checked>
		</form>
		<button onclick="addQuery(1)">+</button>
	</div>
	<div id="Query7" class="Query">
		<h3>Which output method?</h3>
		<select id="chartType">
			<option value="0">Table</option>
			<option value="1">Pie</option>
			<option value="2">Bars</option>
			<option value="3">HeatMap</option>
		</select>
	</div>
	<div id="Query3" class="Query">
		<h3>Filters:</h3>
		<select class="conditions"><option></option></select>
		<form class='conditionsOption'>
			Sum<input type='radio' name='val' value='Sum'>
  			Count<input type='radio' name='val' value='Count'>
			None<input type='radio' name='val' value='none' checked>
		</form>
		<button onclick="addQuery(3)">+</button>
	</div>
	<!-- Replaced with getting from ungrouped columns from main 
    <div id="Query4" class="Query">
		<h3>Group data?</h3>
		<select id="group"><option></option></select>
	</div>-->
	<div id="Query5" class="Query">
		<h3>Order?</h3>
		<select class="order"><option></option></select>
		<select class="order"><option value="ASC">Smallest First</option><option value="DESC">Biggest First</option></select>
		<form id='orderOption'>
			Sum<input type='radio' name='val' value='Sum'>
  			Count<input type='radio' name='val' value='Count'>
			None<input type='radio' name='val' value='none' checked>
		</form>
	</div>
	<div id="Query6" class="Query">
		<h3>Limit records returned?</h3>
		<input type='number' id='limit'>
	</div>
</div>
<script>
/*function addStageQuery(whereto){
	$(whereto).after($("<div id='lifesaver'><p> <strong>Stage</strong>, Please make up your Stage:</p><select id='stage'></select><select id='LearningExperience'></select><select id='market'></select><select id='submarket'></select></div>"));
	populateSelect($('#stage'), ['All','Prospect', 'Inquiry', 'Applicants','Pending','Decision-A','Decision-D','Confirmed','Registered','Matriculant','No longer in','Dormant'], ['%','PR','IN','AP','PE','DA','DD','CO','RE','MA','NI','DORMM']);
	populateSelect($('#LearningExperience'), ['All','Residential', 'Online', 'AE Centers','International','Independent Study'], ['%','R','O','C','I','E']);
	populateSelect($('#market'), ['All','First Year', 'Transfer', 'Graduate','Non-Degree'], ['%','F','T','G','N']);
	populateSelect($('#submarket'), [' ','All','US Senior', 'Intl Senior', 'US Adult','Intl Adult','Military','Dept. Of State', 'ESL'], [' ','%','S','I','A','T','M','D','E']);
	$('#submarket').change(function(){
		$(whereto).val("" + $("#stage").val() + $("#LearningExperience").val() + $("#market").val() + $("#submarket").val());
		if($(whereto).val() != "%%% "){
			$("#lifesaver").remove();
		}
	}).trigger( "change" );
}*/
function addQuery(queryn){
	var headers = $.parseJSON(queryDatabase(3, $("#table").val(), "","", "", "",""));
	headers.unshift("headers", "all");
	var values = headers.slice(); 
	values[0] = "";
	values[1] = "*";
	switch(queryn){
		case 1:
			$(".mainOption").last().after($("<select class='main'></select><form class='mainOption'>Sum<input type='radio' name='val' value='Sum'>"+
  			 "Count<input type='radio' name='val' value='Count'>" +
			 "None<input type='radio' name='val' value='none' checked></form>"));
			populateSelect($(".main").last(), headers, values);
		break;
		case 3:
			$(".conditionsOption").last().after($("<select class='conditions'></select><form class='conditionsOption'>Sum<input type='radio' name='val' value='Sum'>" +
  			 "Count<input type='radio' name='val' value='Count'>" +
			 "None<input type='radio' name='val' value='none' checked></form>"));
			populateSelect($(".conditions").last(), headers, values);
			changeCondition($(".conditions").last());
		break;
		default:
	}
	//makeWizard();
}
function submit(){
	isZip = false;
	var table = $('#table').val();
	var main = "";
	var condition = "";
	var group = "";
	var order = "";
	var limit = $('#limit').val();
	var temp = [];
	//get main options and build query
	$('.main').each(function(i, val){
        temp.push($(val).val()); // get all columns
	}); 
	$('.mainOption input:checked').each(function(i, val){
        //if column has grouping function, add the function to the column, then add to the select statement
        if($(val).val() != "none"){ main += $(val).val() + "(" + temp[i] + ")," ;}
        //otherwise if the value is not empty
        else if(temp[i] != ""){ 
            main += temp[i] + ","; //add to the select statement
            group += temp[i] + ","; //add to group by
        }
	});
    //remove last comma from main and group
    main = main.substring(0, main.length - 1);
    group = group.substring(0, group.length - 1);
    //clear temp to load results from conditions
	temp = [];
	$('.conditionsOption input:checked').each(function(i, val){
			temp.push($(val).val());
	});	
	var numrec = 0; //number of records
	var num = 0; //number of headers
	var secNum = false; // flag for right record count on numbers (since there is 2)
	$('.conditions').each(function(i, val){
		if ($(this).val() == ("zip") || $(this).val() == "Zip"){isZip=true;} //change isZip boolean for heat map
		if($(this).val() != ""){
			if($.isNumeric($(this).val()) || !(isNaN(Date.parse($(this).val())))){
				//number or date
				condition += $(this).val() + ",";
				// only one record for sec 
				if(secNum){
					secNum = false;	
					numrec++;
				}else{
					secNum = true;	
				}
			}else{
				if (numrec%2 == 0){
					if (temp[num] != ""){
						//sum or count go here
						condition += temp[numrec] + "(" + $(this).val() + "),";
					}else{
						//regular value goes here
						condition += $(this).val() + ",";
					}
					num++;
				}else{
					// if it's a value not a "header"
					condition += $(this).val() + ",";
				}
				numrec++;
			}
		}
	});
	//get the right order
	if ($("#orderOption input:checked").last().val() != "none"){
		//sum or count go here
		order = $("#orderOption input:checked").last().val()  + "('" + $('.order').first().val() + "') " + $('.order').last().val();
	}else{
		//regular value goes here
		order = ($('.order').first().val() !== "") ? ($('.order').first().val() + "," + $('.order').last().val()) : ("");
	}

	condition = condition.substring(0, condition.length - 1);
	//order count or other
	
	
	rawdata = queryDatabase('', table, main, condition, group, order, limit);
	data = new google.visualization.arrayToDataTable(JSON.parse(rawdata));
	$("#ChartSpace").empty();	
	
		//makeTable(2);
	switch ($('#chartType').val()){
		case "1":
			google.charts.setOnLoadCallback(drawChartPie);
		break;
		case "2":
			google.charts.setOnLoadCallback(drawChartBar);
		break;		
		case "3":
			google.charts.setOnLoadCallback(drawChartMap);
		break;
		default:
			google.charts.setOnLoadCallback(drawTable);
	}
	/* <option value="0">Table</option>
			<option value="1">Pie</option>
			<option value="2">Bars</option>
			<option value="3">HeatMap</option>*/

	//alert("?table=" + table + "&main=" + main+ "&condition=" + condition + "&group=" + group + "&order=" + order + "&limit=" + limit);
}
//function executed at the beggining
function makeWizard(){
	$("input .conditions").remove();
	$("#table").change(function() {
  		if ($(this).val() != ""){
			//add value to columns
			var headers = $.parseJSON(queryDatabase(3, $(this).val(), "","", "", "", ""));
			headers.unshift("headers", "all");
			var values = headers.slice(); 
			values[0] = "";
			values[1] = "*";
			$('.main').each(function(i, obj){
				populateSelect($(this), headers, values);
			});
			$(".conditions").each(function(){
				populateSelect($(this), headers, values);
			});
			//populateSelect($("#group"), headers, values);
			populateSelect($(".order").first(), headers, values);
		} 	
	}).trigger( "change" );
	//add extra columns when selected inside the filters
	changeCondition($(".conditions"));
	
}
//make wizard functions
function changeCondition(cond){
	//add extra columns when selected inside the filters
	$(cond).change( function() {
			$(this).next('.conditions').remove();
			$(this).next('.conditions').remove();	
			if ($(this).val() != ""){
                var json = $.parseJSON(queryDatabase(1, $("#table").val(), $(this).val(),"", "", "", ""));
                var sel = $("<select class='conditions'></select>");
                if ($.isNumeric(json[0]) || !(isNaN(Date.parse(json[0])))){
                    if ($.isNumeric(json[0])) { json = json.sort(function(a,b){ return a - b; });} //else { json = json.sort(function(a,b){ return new Date ($(a.pubDate).text()) - new Date ($(b.pubDate).text());});} 
                    populateSelect(sel,json,json);
                    $(this).after($(sel));
                    $(this).after($(sel).clone());
                }else{
                    json = json.sort();
                    populateSelect(sel,json,json);
                    $(this).after($(sel));
                }
			}
			
				
	}).trigger( "change" );
}	

</script>
<style>
.Query{
	width: 33%;
	min-height : 200px;
	position : relative;
	border: 1px solid black;
    	float: left;
}
#Query3{
	width: 99.5%;
}
#Query5, #Query6 {
    width: 49.7%;
}
</style>
<?php include "footer.php"?>

<?php include_once "header.php"?>
<main style="background-color: white;">
<h2>Intro</h2>
<p>
    This tool was created as part of my Capstone Project back in 2016. 
    It was design to connect to any view in a MS SQL Server database an allow you to run queries from it.<br> 
    It offers different visualizations options using the google visualization API, including pie charts and a heat map.<br>
    Since this webserver runs on MySQL, I had to make a few modifications, as well as, generate fake data to work with it.<Br>
    Feel free to test it out and get some sample code from it!     <br><br>
    
    The original project included repurposing old hardware (I got a couple from goodwill and put the good parts together), installing the operating system (Ubuntu), 
    setting up a web server (Apache with PHP), connecting to an existing database (MS SQL from the university) and displaying meaningful data (What you see here - jQuery, PHP and SQL). 
</p>
<h2>How to use it</h2>
<!--<h3>Admissions</h3>
<p>The admissions page was designed to show
the user what’s the best of the item selected. For example, the best source
will be the source that brought most students to UIU, or the best state will
show the state where most students come from.</p>
<ol >
 <li >The first
     item is the main query, simply choose a category to
     find out who’s the best at it.</li>
 <li >Choose a
     range of years the data is referring to.</li>
 <li >Choose 
     the stage code from the dropdown.</li>
 <li >Limit the
     data for specific major.</li>
 <li >Choose an
     output method. The program outputs tables, pie charts, bar charts and
     heatmaps. Heatmaps require State or Zip as the main Query (The first dropdown).</li>
</ol>
<p>Hit Submit and the output will be
displayed above.</p>
<h3>Alumni</h3>
<p>Much like Admissions the Alumni page
returns who’s the best of, however, the best is chosen given on the sum of
Giving Capacity. For example, state would return the state with the most
cumulative giving capacity, or first name would return the name most used by
people with big donating capacities.</p>
<ol>
 <li >Choose
     the main header you want to know that has the most giving capacity.</li>
 <li >Select a
     range in giving capacity, so only results within that range will display;</li>
 <li >Choose a range
     of the rank of the donors considered in your query.</li>
 <li >Choose an
     output method. The program outputs tables, pie charts, bar charts and
     heatmaps. Heatmaps require State or Zip as the main Query.</li>
</ol>
<p>Hit Submit and the output will be
displayed above.</p>
-->
<h3>Master Query</h3>
<p>The master query was designed for more
experienced users. It allows one to query anything from the view, and drill
down into the data acquired from the previous interfaces. One could get ahold
of the name and email of donors from a select state, for example, or filter the
queries by other fields not available in the regular queries. 
It is basically a user interface to build SQL statements.</p>
<ol >
 <li> Choose
     what department you are in.</li>
 <li> These are
     the header that will be returned to you, you can press + to increase the
     number of queries .</li>
 <li> The
     output also includes export, which outputs a version that can be copied.</li>
 <li> Filters,
     there can be as many filters as you want. Once the header is selected,
     options will appear for that header. If numeric or date, please select a
     range, else select a matching value.</li>
 <li> Group data, required to calculate the
     sum or count. Group the main header of your query if sum or count is used.</li>
 <li> Order,
     order results based on the field selected.</li>
 <li> Limit the
     number of records to be output or taken in consideration for the query.</li>
    <li> Click Query and see the results</li>
</ol>

<h2>Idea Behind It</h2>
<p>The idea was to build a simple tool to be used by stakeholders to query their own data. 
The biggest impact it had was the usage of the Heatmaps, between the other visualization optons provided. The source code and hardware was provided to
the respective stakeholders in the university, but I don't belive it was put into production. </p>
<h3>Presentation</h3>
<iframe src="https://onedrive.live.com/embed?cid=FBA1B5F7F5197DF4&amp;resid=FBA1B5F7F5197DF4%211435&amp;authkey=AM0lTBDvhYSF3oA&amp;em=2&amp;wdAr=1.7777777777777777" width="610px" height="367px" frameborder="0">This is an embedded <a target="_blank" href="https://office.com">Microsoft Office</a> presentation, powered by <a target="_blank" href="https://office.com/webapps">Office Online</a>.</iframe>
<h3>Research</h3>
<iframe src="https://onedrive.live.com/embed?cid=FBA1B5F7F5197DF4&amp;resid=FBA1B5F7F5197DF4%211434&amp;authkey=ACCrbUC0HIRD-Wg&amp;em=2&amp;wdStartOn=1" width="700px" height="500px" frameborder="0">This is an embedded <a target="_blank" href="https://office.com">Microsoft Office</a> document, powered by <a target="_blank" href="https://office.com/webapps">Office Online</a>.</iframe>


<br><br><br><br>
</main>
<?php include_once "footer.php"?>
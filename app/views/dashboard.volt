
{% extends "layouts/index.volt" %}

{% block content %}

	{{ flash.output() }}

	<div align="center">

		<h2>Dashboard!</h2>

		<script type='text/javascript' src='https://www.google.com/jsapi'></script>
		<script type='text/javascript'>
     google.load('visualization', '1', {'packages': ['geochart']});
     google.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
        	['Country', 'Visits'],
        	{% for row in summatory %}
        		['{{ row['_id'] }}', {{ row['count'] }}],
        	{% endfor %}
        ]);

        var options = {};

        var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    };
    </script>

     <div id="chart_div" style="width: 500px; height: 300px;"></div>

		<hr>

	</div>

{% endblock %}
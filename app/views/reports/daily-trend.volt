
{% extends 'layouts/index.volt' %}

{% block content %}

	<h2>Tendencia Diaria por Cliente</h2>

        <div align="right">
            <form class="well form-search" method="post" autocomplete="off">
                    <label for="initialDate">Fecha Inicial</label> {{ date_field("initialDate") }}
                    <label for="finalDate">Fecha Final</label> {{ date_field("finalDate") }}
                <input type="submit" class="btn" value="Filtrar">
            </form>
        </div>

        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">

        function drawChart() {

                var data = google.visualization.arrayToDataTable([                        
                        [{% for header in headers -%}
                                '{{ header }}' {%- if !loop.last %},{% endif -%}
                        {%- endfor %}],
                        {% for day in days -%}
                                ['{{ day }}',
                                {%- for header in headers -%}
                                        {%- if header != 'Periodo' -%}                                                
                                                {%- if table[day][header] is defined -%}
                                                        {{- table[day][header] -}}
                                                {%- else -%}
                                                        0
                                                {%- endif -%}                                                
                                                {%- if !loop.last %},{% endif -%}
                                        {%- endif -%}                                        
                                {%- endfor -%}]
                                {%- if !loop.last %},{% endif -%}
                        {%- endfor %}
                ]);

                var options = {
                        title: 'Tendencia Diaria por Cliente',                        
                        left: 0, 
                        top: 0,
                        fontSize: 12,
                        chartArea: {
                            left: 50,
                            top: 0
                        }
                };

                var chart = new google.visualization.LineChart(document.getElementById('rps_div'));
                chart.draw(data, options);
        }

        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawChart);

	</script>

	<div align="left">
		<div id="rps_div" style="height: 650px;"></div>
	</div>	

{% endblock %}

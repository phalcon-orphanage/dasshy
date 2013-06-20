
{% extends 'layouts/index.volt' %}

{% block content %}

	<h2>Tipo de Clasificación</h2>

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

                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Estado');
                data.addColumn('number', 'Número');
                data.addRows([
                        {% for row in summary %}
				['{% if row["status"] == "U" -%}
                                SIN CLASIFICAR
                                {%- elseif row["status"] == "I" -%}
                                INTERNO
                                {%- elseif row["status"] == "C" -%}
                                CLIENTES
                                {%- else -%}
                                SPAM/INFO/NOTICIAS
                                {%- endif %}', {{ row["rowcount"] }}]
				{%- if !loop.last %},{% endif %}
			{% endfor %}
                ]);

                var options = {
                        title: 'Número de Correos por Cliente',                        
                        fontSize: 12,
                        chartArea: {
                                width: '900px',                                
                                top: 0
                        }
                };

                var chart = new google.visualization.PieChart(document.getElementById('rps_div'));
                chart.draw(data, options);
        }

        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawChart);

        </script>

        <div align="center">
                <div id="rps_div" style="height: 480px;"></div>
        </div>

	<table class="table table-bordered table-striped">
                <tr>
                        <th>Tipo</th>
                        <th>Número</th>
                </tr>
        {% set total = 0 %}
	{% for row in summary %}
		<tr>
			<td>
                                {% if row["status"] == "U" -%}
                                SIN CLASIFICAR
                                {%- elseif row["status"] == "I" -%}
                                INTERNO
                                {%- elseif row["status"] == "C" -%}
                                CLIENTES
                                {%- else -%}
                                SPAM/INFO/NOTICIAS
                                {%- endif %}
                        </td>
			<td>{{ row["rowcount"] }}</td>
		</tr>
                {% set total = total + row["rowcount"] %}
	{% endfor %}
                <tr>
                        <td align="right"><b>TOTAL</b></td>
                        <td><b>{{ total }}<b></td>
                </tr>
	</table>

{% endblock %}

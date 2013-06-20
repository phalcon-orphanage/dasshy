{% extends 'layouts/index.volt' %}

{% block content %}

	<h2>Listado</h2>

	<table class="table table-bordered table-striped">
		<tr>
			<th>Id</th>
			<th>Asunto</th>
			<th>De</th>
			<th>Fecha</th>
		</tr>
	{% for email in emails %}
		<tr>
			<td>{{ email.id }}</td>
			<td>{{ email.getSubject() }}</td>
			<td>{{ email.getFrom() }}</td>
			<td>{{ email.getDate() }}</td>
		</tr>
	{% endfor %}
	</table>

{% endblock %}
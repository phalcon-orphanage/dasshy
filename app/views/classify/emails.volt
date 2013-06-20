{% extends 'layouts/index.volt' %}

{% block content %}

	<h2>E-mails/Sin Clasificar</h2>

	<table class="table table-bordered table-striped">
	{% for email in emails %}
		{{ '<tr><td><form>' }}
		{{ email.email }}
		{{ '</td><td>' ~ link_to('classify-email/' ~ email.id, 'Clasificar', 'class': 'btn btn-primary') }}
		{{ '</form></td></tr>' }}
	{% endfor %}
	</table>

{% endblock %}

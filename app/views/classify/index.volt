{% extends 'layouts/index.volt' %}

{% block content %}

	<h2>Dominios/Sin Clasificar</h2>

	<table class="table table-bordered table-striped">
	{% for domain in domains %}
		<tr><td><form>
		{{ domain.domain }}
		{{ '</td><td>' ~ link_to('classify/' ~ domain.id, 'Clasificar', 'class': 'btn btn-primary') }}
		</form></td></tr>
	{% endfor %}
	</table>

{% endblock %}



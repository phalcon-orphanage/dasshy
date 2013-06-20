{% extends 'layouts/index.volt' %}

{% block content %}

	<h2>Dominio: {{ domain.domain }}</h2>

	<form method="post" autocomplete="off">
		<p>
			<label for="tipo">Tipo</label>
			{{ select('tipo', ['C': 'Cliente', 'S': 'Spam/Información/Noticias', 'O': 'Correo Común']) }}
		</p>
		<p>
			<label for="tipo">Cliente</label>
			{{ select('cliente', customers, 'using': ['id', 'name']) }}
		</p>
		<p>
			<input type="submit" value="Guardar" class="btn btn-success">
			{{ link_to('classify', 'volver') }}
		</p>
	</form>

{% endblock %}

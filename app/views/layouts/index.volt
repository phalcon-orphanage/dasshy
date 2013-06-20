<!DOCTYPE html>
<html>
	<head>
		<title>Dasshy</title>
		<link href="//netdna.bootstrapcdn.com/bootswatch/2.3.2/flatly/bootstrap.min.css" rel="stylesheet">
		{{ stylesheet_link('css/style.css') }}
	</head>
	<body>
		<div class="navbar">
			<div class="navbar-inner">
				<div class="container">
					<a class="btn btn-navbar" data-target=".nav-collapse" data-toggle="collapse">
					{{ link_to(null, 'Dasshy', 'class': 'brand') }}
					{%- if session.get('auth') -%}
					<div class="nav-collapse collapse" id="main-menu">
						<ul class="nav" id="main-menu-left">
							<li class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#">Reportes <b class="caret"></b></a>
								<ul class="dropdown-menu" id="swatch-menu">
									<li>{{ link_to('reports', 'Número de Correos/Cliente') }}</li>
									<li>{{ link_to('reports/type', 'Tipo de Clasificación') }}</li>
									<li>{{ link_to('reports/daily-trend', 'Tendencia Diaria') }}</li>
								</ul>
							</li>
							<li>{{ link_to('customers', 'Clientes') }}</li>
							<li class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#">Sin Clasificar <b class="caret"></b></a>
								<ul class="dropdown-menu" id="swatch-menu">
									<li>{{ link_to('classify', 'Dominios') }}</li>
									<li>{{ link_to('classify-emails', 'Correos') }}</li>
									<li>{{ link_to('unclassified', 'Envíos') }}</li>
								</ul>
							</li>
						</ul>
					</div>
					{%- endif -%}
				</div>
			</div>
		</div>

		{%- block content %}{% endblock -%}

		{{- assets.outputJs() -}}
	</body>
</html>
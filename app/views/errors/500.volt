{% extends 'layouts/index.volt' %}

{% block content %}

	<div class="alert alert-error">{{ exception.getMessage() }}</div>
	{{ exception.getTraceAsString()|e|nl2br }}<br>

{% endblock %}
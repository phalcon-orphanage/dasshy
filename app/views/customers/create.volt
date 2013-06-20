{% extends 'layouts/index.volt' %}

{% block content %}

    <form method="post" autocomplete="off">

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("customers", "&larr; Volver") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Crear", "class": "btn btn-success") }}
        </li>
    </ul>

    {{ content() }}

    <div class="center scaffold">

        <h2>Crear cliente</h2>        

        <div class="clearfix">
            <label for="name">Nombre</label>
            {{ form.render("name") }}
        </div>                

        <div class="clearfix">
            <label for="name">Iniciales/Prefijo</label>
            {{ form.render("prefix") }}
        </div>                

    </div>
    
</form>

{% endblock %}
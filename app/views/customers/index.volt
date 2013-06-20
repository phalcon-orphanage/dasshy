{% extends 'layouts/index.volt' %}

{% block content %}

    <div align="right">
        {{ link_to("customers/create", "<i class='icon-plus-sign'></i> Crear Clientes", "class": "btn btn-primary") }}
    </div>

    <form method="post" autocomplete="off" action="{{ url("customers/search") }}">

        <div class="center scaffold">

            <h2>Buscar Clientes</h2>

            <div class="clearfix">
                <label for="id">Id</label>
                {{ form.render("id") }}
            </div>

            <div class="clearfix">
                <label for="name">Nombre</label>
                {{ form.render("name") }}
            </div>        

            <div class="clearfix">
                {{ submit_button("Buscar", "class": "btn btn-primary") }}
            </div>

        </div>

    </form>

{% endblock %}
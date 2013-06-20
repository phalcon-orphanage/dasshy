{% extends 'layouts/index.volt' %}

{% block content %}

    <form method="post" autocomplete="off">

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("customers", "&larr; Volver") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Guardar", "class": "btn btn-success") }}
        </li>
    </ul>

    {{ content() }}

    <div class="center scaffold">

        <h2>Editar cliente</h2>

        <ul class="nav nav-tabs">
            <li class="active"><a href="#A" data-toggle="tab">Datos Básicos</a></li>
            <li><a href="#B" data-toggle="tab">Dominios</a></li>
            <li><a href="#C" data-toggle="tab">E-Mails</a></li>
        </ul>

        <div class="tabbable">
            <div class="tab-content">
                <div class="tab-pane active" id="A">

                    {{ form.render("id") }}

                    <div class="clearfix">
                        <label for="name">Nombre</label>
                        {{ form.render("name") }}
                    </div>                

                    <div class="clearfix">
                        <label for="name">Iniciales/Prefijo</label>
                        {{ form.render("prefix") }}
                    </div>                

                </div>

                <div class="tab-pane" id="B">
                    
                </div>

                <div class="tab-pane" id="C">
                    
                </div>

            </div>
        </div>

        </form>
    </div>

{% endblock %}
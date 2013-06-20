{% extends 'layouts/index.volt' %}

{% block content %}

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("customers", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            {{ link_to("customers/create", "Crear Clientes", "class": "btn btn-primary") }}
        </li>
    </ul>

    {% for customer in page.items %}
    {% if loop.first %}
    <table class="table table-bordered table-striped" align="center">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre Corto</th>            
                <th>Nombre/Razón Social</th>            
            </tr>
        </thead>
    {% endif %}
        <tbody>
            <tr>
                <td>{{ customer.id }}</td>
                <td>{{ customer.prefix }}</td>            
                <td>{{ customer.name }}</td>            
                <td width="12%">{{ link_to("customers/edit/" ~ customer.id, '<i class="icon-pencil"></i> Editar', "class": "btn") }}</td>
                <td width="12%">{{ link_to("customers/delete/" ~ customer.id, '<i class="icon-remove"></i> Eliminar', "class": "btn") }}</td>
            </tr>
        </tbody>
    {% if loop.last %}
        <tbody>
            <tr>
                <td colspan="4" align="right">
                    <div class="btn-group">
                        {{ link_to("customers/search", '<i class="icon-fast-backward"></i> Primero', "class": "btn") }}
                        {{ link_to("users/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Anterior', "class": "btn ") }}
                        {{ link_to("customers/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Siguiente', "class": "btn") }}
                        {{ link_to("customers/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Último', "class": "btn") }}
                        <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                    </div>
                </td>
            </tr>
        <tbody>
    </table>
    {% endif %}
    {% else %}
        La búsqueda no retornó clientes
    {% endfor %}

{% endblock %}

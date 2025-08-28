let tblUsuarios, tblClientes, editor, myModal, tbl, myChart,
    tblPlanes, tblPlanCli, tblRutinas, tblPagos, tblEnt, tblAsistencias;
document.addEventListener("DOMContentLoaded", function () {
    if (document.getElementById('ProductosVendidos')) {
        actualizarGrafico();
        ventasDia();
    }
    $("#select_cliente").autocomplete({
        minLength: 2,
        source: function (request, response) {
            $.ajax({
                url: base_url + 'clientes/buscarCliente/',
                dataType: "json",
                data: {
                    cli: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            document.getElementById('id_cli').value = ui.item.id;
            document.getElementById('select_cliente').value = ui.item.nombre;
            if (document.getElementById('select_plan')) {
                buscarPlanCli(ui.item.id);
            }
        }
    });
    $("#select_entrenador").autocomplete({
        minLength: 2,
        source: function (request, response) {
            $.ajax({
                url: base_url + 'asistencias/buscarEntrenador/',
                dataType: "json",
                data: {
                    ent: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            document.getElementById('id_entrenador').value = ui.item.id;
            document.getElementById('select_entrenador').value = ui.item.nombre;
        }
    });
    $("#select_rutina").autocomplete({
        minLength: 2,
        source: function (request, response) {
            $.ajax({
                url: base_url + 'asistencias/buscarRutina',
                dataType: "json",
                data: {
                    rut: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            document.getElementById('id_rutina').value = ui.item.id;
            document.getElementById('select_rutina').value = ui.item.nombre;
        }
    });
    $("#nombre_cliente").autocomplete({
        minLength: 2,
        source: function (request, response) {
            $.ajax({
                url: base_url + 'clientes/buscarCliente',
                dataType: "json",
                data: {
                    plan: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            document.getElementById('id_planCliente').value = ui.item.id;
            document.getElementById('nombre_plan').value = ui.item.plan;
            document.getElementById('precio').value = ui.item.precio;
            document.getElementById('vencimiento').value = ui.item.vencimiento;
        }
    });
    $("#buscar_planes").autocomplete({
        minLength: 2,
        source: function (request, response) {
            $.ajax({
                url: base_url + 'clientes/buscar_planes/',
                dataType: "json",
                data: {
                    q: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            document.getElementById('id_plan').value = ui.item.id;
            document.getElementById('buscar_planes').value = ui.item.plan;
            document.getElementById('precio_plan').value = ui.item.precio_plan;
        }
    });
    const dom = "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>";
    tblUsuarios = $('#tblUsuarios').DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        ajax: {
            url: base_url + "usuarios/listar",
            dataSrc: ''
        },
        columns: [
            { 'data': 'id' },
            { 'data': 'usuario' },
            { 'data': 'nombre' },
            { 'data': 'correo' },
            { 'data': 'rol' },
            { 'data': 'estado' },
            { "data": "editar" },
            { "data": "eliminar" }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
        dom,
        resonsieve: true,
        bDestroy: true,
        iDisplayLength: 10,
        order: [
            [0, "desc"]
        ]
    });//Fin de la tabla usuarios
    tblClientes = $('#tblClientes').DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        ajax: {
            url: base_url + "clientes/listar",
            dataSrc: ''
        },
        columns: [{ 'data': 'id' },
        { 'data': 'dni' },
        { 'data': 'foto' },
        { 'data': 'nombre' },
        { 'data': 'telefono' },
        { 'data': 'direccion' },
        { 'data': 'estado' },
        { 'data': 'editar' },
        { 'data': 'eliminar' }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
        dom,

        resonsieve: true,
        bDestroy: true,
        iDisplayLength: 10,
        order: [
            [0, "desc"]
        ]
    });//Fin de la tabla clientes
    tblPlanes = $('#tblPlanes').DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        ajax: {
            url: base_url + "planes/listar",
            dataSrc: ''
        },
        columns: [{
            'data': 'id'
        },
        {
            'data': 'imagen'
        },
        {
            'data': 'plan'
        },
        {
            'data': 'descripcion'
        },
        {
            'data': 'precio_plan'
        },
        {
            'data': 'condicion'
        },
        {
            'data': 'estado'
        },
        {
            'data': 'editar'
        },
        {
            'data': 'eliminar'
        }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
        dom,

        resonsieve: true,
        bDestroy: true,
        iDisplayLength: 10,
        order: [
            [0, "desc"]
        ]
    }); //Fin de la tabla Planes
    tblPago = $('#tblPago').DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        ajax: {
            url: base_url + 'clientes/listar_pagos',
            dataSrc: ''
        },
        columns: [{
            'data': 'id'
        },
        {
            'data': 'fecha'
        },
        {
            'data': 'nombre'
        },
        {
            'data': 'plan'
        },
        {
            'data': 'precio_plan'
        },
        {
            'data': 'estado'
        },
        {
            'data': 'ver'
        }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
        dom,

        resonsieve: true,
        bDestroy: true,
        iDisplayLength: 10,
        order: [
            [0, "desc"]
        ]
    }); //Fin de la tabla Pagos
    tblPlanCli = $('#tblPlanCli').DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        ajax: {
            url: base_url + "clientes/listar_plan_clientes",
            dataSrc: ''
        },
        columns: [
            { 'data': 'id' },
            { 'data': 'fecha' },
            { 'data': 'dni' },
            { 'data': 'nombre' },
            { 'data': 'plan' },
            { 'data': 'precio_plan' },
            { 'data': 'fecha_venc' },
            { 'data': 'fecha_limite' },
            { 'data': 'estado' },
            { 'data': 'accion' }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
        dom,

        createdRow: function (row, data, index) {
            //pintar una celda
            if (data.fecha_venc < data.fecha_actual) {
                $('td', row).eq(6).html('<span class="badge bg-danger">' + data.fecha_venc + '</span>');
            }
            if (data.fecha_venc < data.fecha_actual) {
                $('td', row).css({
                    'background-color': '#ffff52'
                });
            }
        },
        resonsieve: true,
        bDestroy: true,
        iDisplayLength: 10,
        order: [
            [0, "desc"]
        ]
    }); //Fin de la tabla planes cliente
    tblRutinas = $('#tblRutinas').DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        ajax: {
            url: base_url + "rutinas/listar",
            dataSrc: ''
        },
        columns: [{
            'data': 'id'
        },
        {
            'data': 'dia'
        },
        {
            'data': 'descripcion'
        },
        {
            'data': 'estado'
        },
        {
            'data': 'editar'
        },
        {
            'data': 'eliminar'
        }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
        dom,

        resonsieve: true,
        bDestroy: true,
        iDisplayLength: 10,
        order: [
            [0, "desc"]
        ]
    }); //Rutinas
    tblEnt = $('#tblEnt').DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        ajax: {
            url: base_url + "entrenador/listar",
            dataSrc: ''
        },
        columns: [{
            'data': 'id'
        },
        {
            'data': 'nombre'
        },
        {
            'data': 'apellido'
        },
        {
            'data': 'telefono'
        },
        {
            'data': 'direccion'
        },
        {
            'data': 'estado'
        },
        {
            'data': 'editar'
        },
        {
            'data': 'eliminar'
        }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
        dom,

        resonsieve: true,
        bDestroy: true,
        iDisplayLength: 10,
        order: [
            [0, "desc"]
        ]
    }); //Entrenador
    tblAsistencias = $('#tblAsistencias').DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        ajax: {
            url: base_url + "asistencias/listar",
            dataSrc: ''
        },
        columns: [{
            'data': 'id_asistencia'
        },
        {
            'data': 'fecha'
        },
        {
            'data': 'hora_entrada'
        },
        {
            'data': 'hora_salida'
        },
        {
            'data': 'nombre'
        },
        {
            'data': 'entrenador'
        },
        {
            'data': 'descripcion'
        },
        {
            'data': 'status'
        },
        {
            'data': 'editar'
        }
        ],
        createdRow: function (row, data, index) {
            //pintar una celd
            if (data.estado == 1) {
                $('td', row).css({
                    'background-color': '#ffff52'
                });
            }
        },
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
        dom,

        resonsieve: true,
        bDestroy: true,
        iDisplayLength: 10,
        order: [
            [0, "desc"]
        ]
    }); //asistencias
    tbl = $('#tbl').DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
        dom,

        resonsieve: true,
        bDestroy: true,
        iDisplayLength: 10,
        order: [
            [0, "asc"]
        ]
    }); //Fin de la tabla usuarios

    $('#min').change(function (e) {
        if (e.target.name == 'pagos_min') {
            tblPago.draw();
        } else {
            tblPlanCli.draw();
        }
    });
    $('#max').change(function (e) {
        if (e.target.name == 'pagos_max') {
            tblPago.draw();
        } else {
            tblPlanCli.draw();
        }
    });
})
if (document.getElementById('min') && document.getElementById('max')) {
    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            let desde = $('#min').val();
            let hasta = $('#max').val();
            let fecha = data[1].trim();
            if (desde == '' || hasta == '') {
                return true;
            }
            if (fecha >= desde && fecha <= hasta) {
                return true;
            } else {
                return false;
            }
        }
    );
}
function frmCambiarPass(e) {
    e.preventDefault();
    const actual = document.getElementById('clave_actual').value;
    const nueva = document.getElementById('clave_nueva').value;
    const confirmar = document.getElementById('confirmar_clave').value;
    if (actual == '' || nueva == '' || confirmar == '') {
        alertas('Todo los campos son obligatorios', 'warning');
        return false;
    } else {
        if (nueva != confirmar) {
            alertas('Las contraseñas no coinciden', 'warning');
            return false;
        } else {
            const url = base_url + "usuarios/cambiarPass";
            const frm = document.getElementById("frmCambiarPass");
            const http = new XMLHttpRequest();
            http.open("POST", url, true);
            http.send(new FormData(frm));
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {

                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);
                    myModal.hide();
                    frm.reset();
                }
            }
        }
    }
}

function frmUsuario() {
    document.getElementById("title").textContent = "Nuevo Usuario";
    document.getElementById("btnAccion").textContent = "Registrar";
    document.getElementById("claves").classList.remove("d-none");
    document.getElementById("frmUsuario").reset();
    document.getElementById("id").value = "";
    $('#myModal').modal('show');
}
function registrarUser(e) {
    e.preventDefault();
    const usuario = document.getElementById("usuario").value;
    const nombre = document.getElementById("nombre").value;
    const correo = document.getElementById("correo").value;
    const telefono = document.getElementById("telefono").value;
    const rol = document.getElementById("rol").value;
    if (usuario == '' || nombre == '' || correo == '' || telefono == '' || rol == '') {
        alertas('Todo los campos son obligatorios', 'warning');
        return false;
    } else {
        const url = base_url + 'usuarios/registrar';
        const frm = document.getElementById("frmUsuario");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                $('#myModal').modal('hide');
                tblUsuarios.ajax.reload();
                alertas(res.msg, res.icono);
            }
        }
    }
}
function btnEditarUser(id) {
    document.getElementById("title").textContent = "Actualizar usuario";
    document.getElementById("btnAccion").textContent = "Modificar";
    const url = base_url + "usuarios/editar/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            document.getElementById("id").value = res.id;
            document.getElementById("usuario").value = res.usuario;
            document.getElementById("nombre").value = res.nombre;
            document.getElementById("correo").value = res.correo;
            document.getElementById("telefono").value = res.telefono;
            document.getElementById("rol").value = res.rol;
            document.getElementById("claves").classList.add("d-none");
            $('#myModal').modal('show');
        }
    }
}
function btnEliminarUser(id) {
    Swal.fire({
        title: 'Esta seguro de eliminar?',
        text: "El usuario no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "usuarios/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);
                    tblUsuarios.ajax.reload();
                }
            }

        }
    })
}

//Fin Usuarios
function frmCliente() {
    document.getElementById("title").textContent = "Nuevo Cliente";
    document.getElementById("btnAccion").textContent = "Registrar";
    document.getElementById("frmCliente").reset();
    document.getElementById("id").value = "";
    $('#myModal').modal('show');
}
function registrarCli(e) {
    e.preventDefault();
    const dni = document.getElementById("dni").value;
    const nombre = document.getElementById("nombre").value;
    const telefono = document.getElementById("telefono").value;
    const direccion = document.getElementById("direccion").value;
    if (dni == '' || nombre == '' || telefono == '' || direccion == '') {
        alertas('Todo los campos son obligatorios', 'warning');
    } else {
        const url = base_url + "clientes/registrar";
        const frm = document.getElementById("frmCliente");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                alertas(res.msg, res.icono);
                frm.reset();
                $('#myModal').modal('hide');
                tblClientes.ajax.reload();
            }
        }
    }
}
function btnEditarCli(id) {
    document.getElementById("title").textContent = "Actualizar cliente";
    document.getElementById("btnAccion").textContent = "Modificar";
    const url = base_url + "clientes/editar/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            document.getElementById("id").value = res.id;
            document.getElementById("dni").value = res.dni;
            document.getElementById("nombre").value = res.nombre;
            document.getElementById("telefono").value = res.telefono;
            document.getElementById("direccion").value = res.direccion;
            document.getElementById("foto_actual").value = res.foto;
            $('#myModal').modal('show');
        }
    }
}
function btnEliminarCli(id) {
    Swal.fire({
        title: 'Esta seguro de eliminar?',
        text: "El usuario no se eliminara de forma permanente, solo cambiará el estado a inactivo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "clientes/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    tblClientes.ajax.reload();
                    alertas(res.msg, res.icono);
                }
            }

        }
    })
}//Fin Clientes
function frmPlan() {
    document.getElementById("title").textContent = "Nuevo Plan";
    document.getElementById("btnAccion").textContent = "Registrar";
    document.getElementById("formulario").reset();
    document.getElementById("id").value = "";
    $('#myModal').modal('show');
}
function registrarPlan(e) {
    e.preventDefault();
    const nombre = document.getElementById("nombre").value;
    const descripcion = document.getElementById("descripcion").value;
    const precio_plan = document.getElementById("precio_plan").value;
    if (nombre == '' || descripcion == '' || precio_plan == '') {
        alertas('Todo los campos son * obligatorios', 'warning');
    } else {
        const url = base_url + 'planes/registrar';
        const frm = document.getElementById("formulario");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                alertas(res.msg, res.icono);
                frm.reset();
                $('#myModal').modal('hide');
                tblPlanes.ajax.reload();
            }
        }
    }
}
function btnEditarPlan(id) {
    document.getElementById("title").textContent = "Actualizar plan";
    document.getElementById("btnAccion").textContent = "Modificar";
    const url = base_url + "planes/editar/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            document.getElementById("id").value = res.id;
            document.getElementById("nombre").value = res.plan;
            document.getElementById("descripcion").value = res.descripcion;
            document.getElementById("precio_plan").value = res.precio_plan;
            document.getElementById("foto_actual").value = res.imagen;
            $('#myModal').modal('show');
        }
    }
}

function btnEliminarPlan(id) {
    Swal.fire({
        title: 'Esta seguro de eliminar?',
        text: "El plan no se eliminara de forma permanente, solo cambiará el estado a inactivo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "planes/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    tblPlanes.ajax.reload();
                    alertas(res.msg, res.icono);
                }
            }

        }
    })
}
function registrarPlanCliente(e) {
    e.preventDefault();
    const id_cli = document.getElementById("id_cli").value;
    const id_plan = document.getElementById("id_plan").value;
    const cliente = document.getElementById("select_cliente").value;
    const plan = document.getElementById("buscar_planes").value;
    if (id_cli == '' || id_plan == '' || cliente == '' || plan == '') {
        alertas('Todo los campos son obligatorios', 'warning');
    } else {
        const url = base_url + "planes/registrarPlanCliente";
        const frm = document.getElementById("formulario");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                const res = JSON.parse(this.responseText);
                alertas(res.msg, res.icono);
                frm.reset();
                tblPlanCli.ajax.reload();
            }
        }
    }
}
//Fin Planes
function frmPagos() {
    document.getElementById("title").textContent = "Nuevo Medida";
    document.getElementById("btnAccion").textContent = "Registrar";
    document.getElementById("formulario").reset();
    document.getElementById("id").value = "";
    $('#myModal').modal('show');
}
//rutinas
function frmRutina() {
    document.getElementById("title").textContent = "Nuevo Rutina";
    document.getElementById("btnAccion").textContent = "Registrar";
    document.getElementById("formulario").reset();
    document.getElementById("id").value = "";
    $('#myModal').modal('show');
}

function registrarRutina(e) {
    e.preventDefault();
    const dia = document.getElementById("dia").value;
    const descripcion = document.getElementById("descripcion").value;
    if (dia == '' || descripcion == '') {
        alertas('Todo los campos son obligatorios', 'warning');
    } else {
        const url = base_url + "rutinas/registrar";
        const frm = document.getElementById("formulario");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                alertas(res.msg, res.icono);
                frm.reset();
                $('#myModal').modal('hide');
                tblRutinas.ajax.reload();
            }
        }
    }
}

function btnEditarRut(id) {
    document.getElementById("title").textContent = "Actualizar Rutinas";
    document.getElementById("btnAccion").textContent = "Modificar";
    const url = base_url + "rutinas/editar/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            document.getElementById("id").value = res.id;
            document.getElementById("dia").value = res.dia;
            document.getElementById("descripcion").value = res.descripcion;
            $('#myModal').modal('show');
        }
    }
}

function btnEliminarRut(id) {
    Swal.fire({
        title: 'Esta seguro de eliminar?',
        text: "El usuario no se eliminara de forma permanente, solo cambiará el estado a inactivo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "rutinas/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    tblRutinas.ajax.reload();
                    alertas(res.msg, res.icono);
                }
            }

        }
    })
}
//Fin rutinas
//entrenador
function frmEnt() {
    document.getElementById("title").textContent = "Nuevo Entrenador";
    document.getElementById("btnAccion").textContent = "Registrar";
    document.getElementById("formulario").reset();
    document.getElementById("id").value = "";
    $('#myModal').modal('show');
}

function registrarEnt(e) {
    e.preventDefault();
    const nombre = document.getElementById("nombre").value;
    const apellido = document.getElementById("apellido").value;
    const telefono = document.getElementById("telefono").value;
    const direccion = document.getElementById("direccion").value;
    if (apellido == '' || nombre == '' || telefono == '' || direccion == '') {
        alertas('Todo los campos son obligatorios', 'warning');
    } else {
        const url = base_url + "entrenador/registrar";
        const frm = document.getElementById("formulario");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                alertas(res.msg, res.icono);
                frm.reset();
                $('#myModal').modal('hide');
                tblEnt.ajax.reload();
            }
        }
    }
}

function btnEditarEnt(id) {
    document.getElementById("title").textContent = "Actualizar Entrenador";
    document.getElementById("btnAccion").textContent = "Modificar";
    const url = base_url + "entrenador/editar/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            document.getElementById("id").value = res.id;
            document.getElementById("nombre").value = res.nombre;
            document.getElementById("apellido").value = res.apellido;
            document.getElementById("telefono").value = res.telefono;
            document.getElementById("correo").value = res.correo;
            document.getElementById("direccion").value = res.direccion;
            $('#myModal').modal('show');
        }
    }
}

function btnEliminarEnt(id) {
    Swal.fire({
        title: 'Esta seguro de eliminar?',
        text: "El usuario no se eliminara de forma permanente, solo cambiará el estado a inactivo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "entrenador/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    tblEnt.ajax.reload();
                    alertas(res.msg, res.icono);
                }
            }

        }
    })
} //Fin entrenador
function frmAsistencia() {
    document.getElementById("title").textContent = "Registro de Asistencia";
    document.getElementById("btnAccion").textContent = "Registrar";
    document.getElementById("formulario").reset();
    document.getElementById("id").value = "";
    $('#myModal').modal('show');
}
function registrarAsistencia(e) {
    e.preventDefault();
    const id_cli = document.getElementById("id_cli").value;
    const id_entrenador = document.getElementById("id_entrenador").value;
    const cliente = document.getElementById("select_cliente").value;
    const entrenador = document.getElementById("select_entrenador").value;
    if (id_cli == '' || id_entrenador == '' || cliente == '' || entrenador == '') {
        alertas('Todo los campos son obligatorios', 'warning');
    } else {
        const url = base_url + "asistencias/registrar";
        const frm = document.getElementById("formulario");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                alertas(res.msg, res.icono);
                if (res.icono == 'success') {
                    frm.reset();
                    $('#myModal').modal('hide');
                    tblAsistencias.ajax.reload();
                }
            }
        }
    }
}
function editarAsist(id) {
    Swal.fire({
        title: 'Registrar Salida?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "asistencias/actualizar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);
                    tblAsistencias.ajax.reload();
                }
            }
        }
    })
}
function modificarEmpresa(e) {
    e.preventDefault();
    const id = document.getElementById("id").value;
    const ruc = document.getElementById("ruc").value;
    const nombre = document.getElementById("nombre").value;
    const telefono = document.getElementById("telefono").value;
    const direccion = document.getElementById("direccion").value;
    const limite = document.getElementById("limite").value;

    if (id == '' || ruc == '' || nombre == '' || telefono == '' || direccion == '' || limite == '') {
        alertas('Todo los campos son requerido', 'warning');
        return false;
    } else {
        const frm = document.getElementById('frmEmpresa');
        const url = base_url + "administracion/modificar";
        const http = new XMLHttpRequest();
        let frmData = new FormData(frm);
        http.open("POST", url, true);
        http.upload.addEventListener('progress', function () {
            document.getElementById('btnAccion').textContent = 'Procesando...';
        });
        http.send(frmData);
        http.addEventListener('load', function () {
            document.getElementById('btnAccion').textContent = 'Modificar';
        });
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                alertas(res.msg, res.icono);
            }
        }
    }
}
function mostrarTodo(e) {
    document.getElementById('min').value = '';
    document.getElementById('max').value = '';
    if (e.target.name == 'pagos') {
        tblPago.draw();
    } else if (e.target.name == 'aprobadas') {
        solicitud_aprob.draw();
    } else if (e.target.name == 'solicitud_pent') {
        solicitud_pent.draw();
    } else {
        tblPlanCli.draw();
    }
}
function buscarPlanCli(id_cli) {
    const id = document.getElementById('id_cli').value;
    if (id == '') {
        alertas('Buscar el Cliente', 'warning');
        return false;
    } else {
        const url = base_url + 'clientes/buscarPlan/' + id_cli;
        const http = new XMLHttpRequest();
        http.open("GET", url, true);
        http.send();
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                let html = '';
                res.forEach(datos => {
                    html += `<option value="${datos.id_}">${datos.plan}</option>`;
                });
                document.getElementById('select_plan').innerHTML = html;
            }
        }
    }
}
function aprobarSolicitud(id) {
    Swal.fire({
        title: 'Esta seguro de aprobar la solicitud?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + 'Solicitudes/aprobarSolicitud/' + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);
                    solicitud_pent.ajax.reload();
                }
            }
        }
    })
}
function pagoPlan(id) {
    const url = base_url + 'clientes/ver/' + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            document.getElementById('id').value = res.id;
            document.getElementById('cliente').value = res.nombre;
            document.getElementById('plan').value = res.plan;
            $('#myModal').modal('show');
        }
    }
}
function generarPago() {
    Swal.fire({
        title: 'Procesar Pago?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + 'clientes/procesarPago/' + document.getElementById('id').value;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);
                    $('#myModal').modal('hide');
                    tblPlanCli.ajax.reload();
                    if (res.icono == 'success') {
                        setTimeout(() => {
                            window.open(base_url + 'clientes/pdfPago/' + res.id_pago);
                        }, 2000);
                    }
                }
            }
        }
    })
}
function desactivar(id) {
    Swal.fire({
        title: 'Esta seguro de desactivar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + 'planes/desactivar/' + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {

                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);
                    tblPlanCli.ajax.reload();
                }
            }
        }
    })
}
function actualizarGrafico() {
    const anio = document.getElementById('year').value;
    let ctx = document.getElementById('ProductosVendidos').getContext('2d');
    if (myChart) {
        myChart.destroy();
    }
    const url = base_url + 'Administracion/actualizarGrafico/' + anio;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    datasets: [{
                        label: 'Ingreso por Mes',
                        data: [res.ene, res.feb, res.mar, res.abr, res.may, res.jun, res.jul, res.ago, res.sep, res.oct, res.nov, res.dic],
                        backgroundColor: [
                            'rgb(255, 202, 240)'
                        ]
                    }]
                },
                options: {
                    indexAxis: 'x',
                    // Elements options apply to all of the options unless overridden in a dataset
                    // In this case, we are setting the border of each horizontal bar to be 2px wide
                    elements: {
                        bar: {
                            borderWidth: 2,
                        }
                    },
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: false,
                            text: 'Pagos por Mes'
                        }
                    }
                },
            });
        }
    }
}
function ventasDia() {
    let ctx = document.getElementById('ventaDia').getContext('2d');
    const url = base_url + 'Administracion/getVentas';
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            let nombre = [];
            let cantidad = [];
            for (let i = 0; i < res.length; i++) {
                nombre.push(res[i]['plan']);
                cantidad.push(res[i]['total']);
            }
            let my_Chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: nombre,
                    datasets: [{
                        label: 'Ingreso por Día',
                        data: cantidad,
                        backgroundColor: [
                            'rgb(255, 102, 102)'
                        ]
                    }]
                },
                options: {
                    indexAxis: 'x',
                    // Elements options apply to all of the options unless overridden in a dataset
                    // In this case, we are setting the border of each horizontal bar to be 2px wide
                    elements: {
                        bar: {
                            borderWidth: 2,
                        }
                    },
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Ventas por Día'
                        }
                    }
                },
            });
        }
    }
}
function registrarPago(e) {
    e.preventDefault();
    const id = document.getElementById('id_planCliente').value;
    const cliente = document.getElementById('nombre_cliente').value;
    const plan = document.getElementById('nombre_plan').value;
    const precio = document.getElementById('precio').value;
    const vencimiento = document.getElementById('vencimiento').value;
    if (id == '' || cliente == '' || plan == '' || precio == '' || vencimiento == '') {
        alertas('Todo los campos con * son requeridos', 'warning');
    } else {
        const url = base_url + 'planes/registrarPago/' + id;
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send();
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                const res = JSON.parse(this.responseText);
                alertas(res.msg, res.icono);
                document.getElementById('id_planCliente').value = '';
                document.getElementById('frmPago').reset();
                $('#modalPago').modal('hide');
                tblPlanCli.ajax.reload();
                if (res.icono == 'success') {
                    setTimeout(() => {
                        window.open(base_url + 'clientes/pdfPago/' + res.id_pago);
                    }, 2000);
                }
            }
        }
    }
}
function alertas(mensaje, icono) {
    Snackbar.show({
        text: mensaje,
        pos: 'top-right',
        backgroundColor: icono == 'success' ? '#079F00' : '#FF0303',
        actionText: 'Cerrar'
    });
}
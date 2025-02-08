let tblUsuarios,
  tblClientes,
  tblCajas,
  tblMedidas,
  tblCategorias,
  tblProductos,
  t_h_c,
  t_h_v,
  t_arqueo;
document.addEventListener("DOMContentLoaded", function () {
  $("#cliente").select2();
  // usuarios
  tblUsuarios = $("#tblUsuarios").DataTable({
    ajax: {
      url: APP_URL + "Usuarios/listar",
      dataSrc: "",
    },
    order: [3, "asc"],
    columns: [
      { data: "usuario" },
      { data: "nombre" },
      { data: "caja" },
      { data: "estado" },
      { data: "acciones" },
    ],
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    dom:
      "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        //Botón para Excel
        extend: "excelHtml5",
        footer: true,
        title: "Archivo",
        filename: "Export_File",

        //Aquí es donde generas el botón personalizado
        text: '<span class="badge badge-success"><i class="fas fa-file-excel"></i></span>',
      },
      //Botón para PDF
      {
        extend: "pdfHtml5",
        download: "open",
        footer: true,
        title: "Reporte de usuarios",
        filename: "Reporte de usuarios",
        text: '<span class="badge  badge-danger"><i class="fas fa-file-pdf"></i></span>',
        exportOptions: {
          columns: [0, ":visible"],
        },
      },
      //Botón para copiar
      {
        extend: "copyHtml5",
        footer: true,
        title: "Reporte de usuarios",
        filename: "Reporte de usuarios",
        text: '<span class="badge  badge-primary"><i class="fas fa-copy"></i></span>',
        exportOptions: {
          columns: [0, ":visible"],
        },
      },
      //Botón para print
      {
        extend: "print",
        footer: true,
        filename: "Export_File_print",
        text: '<span class="badge badge-light"><i class="fas fa-print"></i></span>',
      },
      //Botón para cvs
      {
        extend: "csvHtml5",
        footer: true,
        filename: "Export_File_csv",
        text: '<span class="badge  badge-success"><i class="fas fa-file-csv"></i></span>',
      },
      {
        extend: "colvis",
        text: '<span class="badge  badge-info"><i class="fas fa-columns"></i></span>',
        postfixButtons: ["colvisRestore"],
      },
    ],
  });
  // Fin tabla usuario

  // Clientes
  tblClientes = $("#tblClientes").DataTable({
    ajax: {
      url: APP_URL + "Clientes/listar",
      dataSrc: "",
    },
    order: [[4, "asc"]],
    columns: [
      { data: "dni" },
      { data: "nombre" },
      { data: "telefono" },
      { data: "direccion" },
      { data: "estado" },
      { data: "acciones" },
    ],
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    dom:
      "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        //Botón para Excel
        extend: "excelHtml5",
        footer: true,
        title: "Archivo",
        filename: "Export_File",

        //Aquí es donde generas el botón personalizado
        text: '<span class="badge badge-success"><i class="fas fa-file-excel"></i></span>',
      },
      //Botón para PDF
      {
        extend: "pdfHtml5",
        download: "open",
        footer: true,
        title: "Reporte de usuarios",
        filename: "Reporte de usuarios",
        text: '<span class="badge  badge-danger"><i class="fas fa-file-pdf"></i></span>',
        exportOptions: {
          columns: [0, ":visible"],
        },
      },
      //Botón para copiar
      {
        extend: "copyHtml5",
        footer: true,
        title: "Reporte de usuarios",
        filename: "Reporte de usuarios",
        text: '<span class="badge  badge-primary"><i class="fas fa-copy"></i></span>',
        exportOptions: {
          columns: [0, ":visible"],
        },
      },
      //Botón para print
      {
        extend: "print",
        footer: true,
        filename: "Export_File_print",
        text: '<span class="badge badge-light"><i class="fas fa-print"></i></span>',
      },
      //Botón para cvs
      {
        extend: "csvHtml5",
        footer: true,
        filename: "Export_File_csv",
        text: '<span class="badge  badge-success"><i class="fas fa-file-csv"></i></span>',
      },
      {
        extend: "colvis",
        text: '<span class="badge  badge-info"><i class="fas fa-columns"></i></span>',
        postfixButtons: ["colvisRestore"],
      },
    ],
  });
  // Fin tabla clientes

  // Categorias
  tblCategorias = $("#tblCategorias").DataTable({
    ajax: {
      url: APP_URL + "Categorias/listar",
      dataSrc: "",
    },
    order: [1, "asc"],
    columns: [{ data: "nombre" }, { data: "estado" }, { data: "acciones" }],
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    dom:
      "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        //Botón para Excel
        extend: "excelHtml5",
        footer: true,
        title: "Archivo",
        filename: "Export_File",

        //Aquí es donde generas el botón personalizado
        text: '<span class="badge badge-success"><i class="fas fa-file-excel"></i></span>',
      },
      //Botón para PDF
      {
        extend: "pdfHtml5",
        download: "open",
        footer: true,
        title: "Reporte de usuarios",
        filename: "Reporte de usuarios",
        text: '<span class="badge  badge-danger"><i class="fas fa-file-pdf"></i></span>',
        exportOptions: {
          columns: [0, ":visible"],
        },
      },
      //Botón para copiar
      {
        extend: "copyHtml5",
        footer: true,
        title: "Reporte de usuarios",
        filename: "Reporte de usuarios",
        text: '<span class="badge  badge-primary"><i class="fas fa-copy"></i></span>',
        exportOptions: {
          columns: [0, ":visible"],
        },
      },
      //Botón para print
      {
        extend: "print",
        footer: true,
        filename: "Export_File_print",
        text: '<span class="badge badge-light"><i class="fas fa-print"></i></span>',
      },
      //Botón para cvs
      {
        extend: "csvHtml5",
        footer: true,
        filename: "Export_File_csv",
        text: '<span class="badge  badge-success"><i class="fas fa-file-csv"></i></span>',
      },
      {
        extend: "colvis",
        text: '<span class="badge  badge-info"><i class="fas fa-columns"></i></span>',
        postfixButtons: ["colvisRestore"],
      },
    ],
  });
  // Fin tabla categorias

  // Cajas
  // Categorias
  tblCajas = $("#tblCajas").DataTable({
    ajax: {
      url: APP_URL + "Caja/listar",
      dataSrc: "",
    },
    order: [1, "asc"],
    columns: [{ data: "caja" }, { data: "estado" }, { data: "acciones" }],
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    dom:
      "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        //Botón para Excel
        extend: "excelHtml5",
        footer: true,
        title: "Archivo",
        filename: "Export_File",

        //Aquí es donde generas el botón personalizado
        text: '<span class="badge badge-success"><i class="fas fa-file-excel"></i></span>',
      },
      //Botón para PDF
      {
        extend: "pdfHtml5",
        download: "open",
        footer: true,
        title: "Reporte de usuarios",
        filename: "Reporte de usuarios",
        text: '<span class="badge  badge-danger"><i class="fas fa-file-pdf"></i></span>',
        exportOptions: {
          columns: [0, ":visible"],
        },
      },
      //Botón para copiar
      {
        extend: "copyHtml5",
        footer: true,
        title: "Reporte de usuarios",
        filename: "Reporte de usuarios",
        text: '<span class="badge  badge-primary"><i class="fas fa-copy"></i></span>',
        exportOptions: {
          columns: [0, ":visible"],
        },
      },
      //Botón para print
      {
        extend: "print",
        footer: true,
        filename: "Export_File_print",
        text: '<span class="badge badge-light"><i class="fas fa-print"></i></span>',
      },
      //Botón para cvs
      {
        extend: "csvHtml5",
        footer: true,
        filename: "Export_File_csv",
        text: '<span class="badge  badge-success"><i class="fas fa-file-csv"></i></span>',
      },
      {
        extend: "colvis",
        text: '<span class="badge  badge-info"><i class="fas fa-columns"></i></span>',
        postfixButtons: ["colvisRestore"],
      },
    ],
  });
  // Fin tabla cajas

  // Medidas
  tblMedidas = $("#tblMedidas").DataTable({
    ajax: {
      url: APP_URL + "Medidas/listar",
      dataSrc: "",
    },
    order: [1, "asc"],
    columns: [{ data: "nombre" }, { data: "estado" }, { data: "acciones" }],
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    dom:
      "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        //Botón para Excel
        extend: "excelHtml5",
        footer: true,
        title: "Archivo",
        filename: "Export_File",

        //Aquí es donde generas el botón personalizado
        text: '<span class="badge badge-success"><i class="fas fa-file-excel"></i></span>',
      },
      //Botón para PDF
      {
        extend: "pdfHtml5",
        download: "open",
        footer: true,
        title: "Reporte de usuarios",
        filename: "Reporte de usuarios",
        text: '<span class="badge  badge-danger"><i class="fas fa-file-pdf"></i></span>',
        exportOptions: {
          columns: [0, ":visible"],
        },
      },
      //Botón para copiar
      {
        extend: "copyHtml5",
        footer: true,
        title: "Reporte de usuarios",
        filename: "Reporte de usuarios",
        text: '<span class="badge  badge-primary"><i class="fas fa-copy"></i></span>',
        exportOptions: {
          columns: [0, ":visible"],
        },
      },
      //Botón para print
      {
        extend: "print",
        footer: true,
        filename: "Export_File_print",
        text: '<span class="badge badge-light"><i class="fas fa-print"></i></span>',
      },
      //Botón para cvs
      {
        extend: "csvHtml5",
        footer: true,
        filename: "Export_File_csv",
        text: '<span class="badge  badge-success"><i class="fas fa-file-csv"></i></span>',
      },
      {
        extend: "colvis",
        text: '<span class="badge  badge-info"><i class="fas fa-columns"></i></span>',
        postfixButtons: ["colvisRestore"],
      },
    ],
  });
  // Fin tabla medida

  // usuarios
  tblProductos = $("#tblProductos").DataTable({
    ajax: {
      url: APP_URL + "Productos/listar",
      dataSrc: "",
    },
    order: [6, "asc"],
    columns: [
      { data: "codigo" },
      { data: "descripcion" },
      { data: "imagen" },
      {
        data: "precio_venta",
        render: function (data, type, row) {
          if (type === "display") {
            const formattedPrice = numberFormat(data, 2, ",", ".");
            return `Bs ${formattedPrice}`;
          }
          return data;
        },
      },
      { data: "iva" },
      { data: "cantidad" },
      { data: "estado" },
      { data: "acciones" },
    ],
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    dom:
      "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        //Botón para Excel
        extend: "excelHtml5",
        footer: true,
        title: "Archivo",
        filename: "Export_File",

        //Aquí es donde generas el botón personalizado
        text: '<span class="badge badge-success"><i class="fas fa-file-excel"></i></span>',
      },
      //Botón para PDF
      {
        extend: "pdfHtml5",
        download: "open",
        footer: true,
        title: "Reporte de usuarios",
        filename: "Reporte de usuarios",
        text: '<span class="badge  badge-danger"><i class="fas fa-file-pdf"></i></span>',
        exportOptions: {
          columns: [0, ":visible"],
        },
      },
      //Botón para copiar
      {
        extend: "copyHtml5",
        footer: true,
        title: "Reporte de usuarios",
        filename: "Reporte de usuarios",
        text: '<span class="badge  badge-primary"><i class="fas fa-copy"></i></span>',
        exportOptions: {
          columns: [0, ":visible"],
        },
      },
      //Botón para print
      {
        extend: "print",
        footer: true,
        filename: "Export_File_print",
        text: '<span class="badge badge-light"><i class="fas fa-print"></i></span>',
      },
      //Botón para cvs
      {
        extend: "csvHtml5",
        footer: true,
        filename: "Export_File_csv",
        text: '<span class="badge  badge-success"><i class="fas fa-file-csv"></i></span>',
      },
      {
        extend: "colvis",
        text: '<span class="badge  badge-info"><i class="fas fa-columns"></i></span>',
        postfixButtons: ["colvisRestore"],
      },
    ],
  });
  // Fin tabla usuario

  // Historial compras
  t_h_c = $("#t_historial_c").DataTable({
    ajax: {
      url: APP_URL + "Compras/listar_historial",
      dataSrc: "",
    },
    order: [2, "asc"],
    columns: [
      {
        data: "total",
        render: function (data, type, row) {
          if (type === "display") {
            const formattedPrice = numberFormat(data, 2, ",", ".");
            return `Bs ${formattedPrice}`;
          }
          return data;
        },
      },
      { data: "fecha" },
      { data: "estado" },
      { data: "acciones" },
    ],
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    dom:
      "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        //Botón para Excel
        extend: "excelHtml5",
        footer: true,
        title: "Archivo",
        filename: "Export_File",

        //Aquí es donde generas el botón personalizado
        text: '<span class="badge badge-success"><i class="fas fa-file-excel"></i></span>',
      },
      //Botón para PDF
      {
        extend: "pdfHtml5",
        download: "open",
        footer: true,
        title: "Reporte de usuarios",
        filename: "Reporte de usuarios",
        text: '<span class="badge  badge-danger"><i class="fas fa-file-pdf"></i></span>',
        exportOptions: {
          columns: [0, ":visible"],
        },
      },
      //Botón para copiar
      {
        extend: "copyHtml5",
        footer: true,
        title: "Reporte de usuarios",
        filename: "Reporte de usuarios",
        text: '<span class="badge  badge-primary"><i class="fas fa-copy"></i></span>',
        exportOptions: {
          columns: [0, ":visible"],
        },
      },
      //Botón para print
      {
        extend: "print",
        footer: true,
        filename: "Export_File_print",
        text: '<span class="badge badge-light"><i class="fas fa-print"></i></span>',
      },
      //Botón para cvs
      {
        extend: "csvHtml5",
        footer: true,
        filename: "Export_File_csv",
        text: '<span class="badge  badge-success"><i class="fas fa-file-csv"></i></span>',
      },
      {
        extend: "colvis",
        text: '<span class="badge  badge-info"><i class="fas fa-columns"></i></span>',
        postfixButtons: ["colvisRestore"],
      },
    ],
  });
  // Fin tabla medida

  // Historial ventas
  t_h_v = $("#t_historial_v").DataTable({
    ajax: {
      url: APP_URL + "Compras/listar_historial_venta",
      dataSrc: "",
    },
    columns: [
      { data: "nombre" },
      {
        data: "total",
        render: function (data, type, row) {
          if (type === "display") {
            const formattedPrice = numberFormat(data, 2, ",", ".");
            return `Bs ${formattedPrice}`;
          }
          return data;
        },
      },
      { data: "fecha" },
      { data: "acciones" },
    ],
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    dom:
      "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        //Botón para Excel
        extend: "excelHtml5",
        footer: true,
        title: "Archivo",
        filename: "Export_File",

        //Aquí es donde generas el botón personalizado
        text: '<span class="badge badge-success"><i class="fas fa-file-excel"></i></span>',
      },
      //Botón para PDF
      {
        extend: "pdfHtml5",
        download: "open",
        footer: true,
        title: "Reporte de usuarios",
        filename: "Reporte de usuarios",
        text: '<span class="badge  badge-danger"><i class="fas fa-file-pdf"></i></span>',
        exportOptions: {
          columns: [0, ":visible"],
        },
      },
      //Botón para copiar
      {
        extend: "copyHtml5",
        footer: true,
        title: "Reporte de usuarios",
        filename: "Reporte de usuarios",
        text: '<span class="badge  badge-primary"><i class="fas fa-copy"></i></span>',
        exportOptions: {
          columns: [0, ":visible"],
        },
      },
      //Botón para print
      {
        extend: "print",
        footer: true,
        filename: "Export_File_print",
        text: '<span class="badge badge-light"><i class="fas fa-print"></i></span>',
      },
      //Botón para cvs
      {
        extend: "csvHtml5",
        footer: true,
        filename: "Export_File_csv",
        text: '<span class="badge  badge-success"><i class="fas fa-file-csv"></i></span>',
      },
      {
        extend: "colvis",
        text: '<span class="badge  badge-info"><i class="fas fa-columns"></i></span>',
        postfixButtons: ["colvisRestore"],
      },
    ],
  });
  // Fin tabla medida

  // Medidas
  t_arqueo = $("#t_arqueo").DataTable({
    ajax: {
      url: APP_URL + "Caja/listar_arqueo",
      dataSrc: "",
    },
    order: [6, "asc"],
    columns: [
      { data: "monto_inicial" },
      { data: "monto_final" },
      { data: "fecha_apertura" },
      { data: "fecha_cierre" },
      { data: "total_ventas" },
      { data: "monto_total" },
      { data: "estado" },
    ],
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    dom:
      "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        //Botón para Excel
        extend: "excelHtml5",
        footer: true,
        title: "Archivo",
        filename: "Export_File",

        //Aquí es donde generas el botón personalizado
        text: '<span class="badge badge-success"><i class="fas fa-file-excel"></i></span>',
      },
      //Botón para PDF
      {
        extend: "pdfHtml5",
        download: "open",
        footer: true,
        title: "Reporte de usuarios",
        filename: "Reporte de usuarios",
        text: '<span class="badge  badge-danger"><i class="fas fa-file-pdf"></i></span>',
        exportOptions: {
          columns: [0, ":visible"],
        },
      },
      //Botón para copiar
      {
        extend: "copyHtml5",
        footer: true,
        title: "Reporte de usuarios",
        filename: "Reporte de usuarios",
        text: '<span class="badge  badge-primary"><i class="fas fa-copy"></i></span>',
        exportOptions: {
          columns: [0, ":visible"],
        },
      },
      //Botón para print
      {
        extend: "print",
        footer: true,
        filename: "Export_File_print",
        text: '<span class="badge badge-light"><i class="fas fa-print"></i></span>',
      },
      //Botón para cvs
      {
        extend: "csvHtml5",
        footer: true,
        filename: "Export_File_csv",
        text: '<span class="badge  badge-success"><i class="fas fa-file-csv"></i></span>',
      },
      {
        extend: "colvis",
        text: '<span class="badge  badge-info"><i class="fas fa-columns"></i></span>',
        postfixButtons: ["colvisRestore"],
      },
    ],
  });
  // Fin tabla medida
});

// Formatear el precio a Bs
function numberFormat(number, decimals, decPoint, thousandsSep) {
  if (number == null || !isFinite(number)) {
    throw new TypeError("El número no es válido");
  }

  if (!decimals) {
    const len = number.toString().split(".").length;
    decimals = len > 1 ? len : 0;
  }

  if (!decPoint) {
    decPoint = ".";
  }

  if (!thousandsSep) {
    thousandsSep = ",";
  }

  number = parseFloat(number).toFixed(decimals);
  number = number.replace(".", decPoint);

  const splitNum = number.split(decPoint);
  splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousandsSep);

  return splitNum.join(decPoint);
}

// Cambiar Contraseña
function frmCambiarPass(e) {
  e.preventDefault();
  const actual = document.getElementById("clave_actual").value;
  const nueva = document.getElementById("clave_nueva").value;
  const confirmar = document.getElementById("confirmar_clave").value;
  if (actual == "" || nueva == "" || confirmar == "") {
    alertas("Todos los campos son obligatorios", "warning");
    return false;
  } else {
    if (nueva != confirmar) {
      alertas("Las Contraseña no coinciden", "warning");
      return false;
    } else {
      const url = APP_URL + "Usuarios/cambiarPass";
      const frm = document.getElementById("frmCambiarPass");
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(new FormData(frm));
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertas(res.msg, res.icono);
          $("#cambiarPass").modal("hide");
          frm.reset();
        }
      };
    }
  }
}

// Agregar Usuarios
function frmUsuario() {
  document.getElementById("title").innerHTML = "Nuevo Usuario";
  document.getElementById("btnAccion").innerHTML = "Agregar";
  document.getElementById("claves").classList.remove("d-none");
  document.getElementById("frmUsuario").reset();
  $("#nuevo_usuario").modal("show");
  document.getElementById("id").value = "";
}

// Registrar usuarios
function registrarUser(e) {
  e.preventDefault();
  const usuario = document.getElementById("usuario");
  const nombre = document.getElementById("nombre");
  const caja = document.getElementById("caja");
  if (usuario.value == "" || nombre.value == "" || caja.value == "") {
    alertas("Todos los campos son obligatorios", "warning");
  } else {
    const url = APP_URL + "Usuarios/registrar";
    const frm = document.getElementById("frmUsuario");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        $("#nuevo_usuario").modal("hide");
        alertas(res.msg, res.icono);
        tblUsuarios.ajax.reload();
      }
    };
  }
}

// Editar usuarios
function btnEditarUser(id) {
  document.getElementById("title").innerHTML = "Actualizar Usuario";
  document.getElementById("btnAccion").innerHTML = "Modificar";
  const url = APP_URL + "Usuarios/editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("id").value = res.id;
      document.getElementById("usuario").value = res.usuario;
      document.getElementById("nombre").value = res.nombre;
      document.getElementById("caja").value = res.id_caja;
      document.getElementById("claves").classList.add("d-none");
      $("#nuevo_usuario").modal("show");
    }
  };
}

// Eliminar usuarios
function btnEliminarUser(id) {
  // Swal.fire({
  //   title: "¿Está seguro de eliminar?",
  //   text: "El usuario no se liminará permanente, solo se cambiará el estado a inactivo",
  //   icon: "warning",
  //   showCancelButton: true,
  //   confirmButtonColor: "#3085d6",
  //   cancelButtonColor: "#d33",
  //   confirmButtonText: "Si",
  //   cancelButtonText: "No",
  // }).then((result) => {
  // if (result.isConfirmed) {
  const url = APP_URL + "Usuarios/eliminar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      alertas(res.msg, res.icono);
      tblUsuarios.ajax.reload();
    }
  };
}
// });
// }

// Ingresar usuarios
function btnReingresarUser(id) {
  // Swal.fire({
  //   title: "¿Está seguro de reingresar?",
  //   icon: "warning",
  //   showCancelButton: true,
  //   confirmButtonColor: "#3085d6",
  //   cancelButtonColor: "#d33",
  //   confirmButtonText: "Si",
  //   cancelButtonText: "No",
  // }).then((result) => {
  //   if (result.isConfirmed) {
  const url = APP_URL + "Usuarios/reingresar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      tblUsuarios.ajax.reload();
      alertas(res.msg, res.icono);
    }
  };
}
//   });
// }
// Fin usuarios

// Agregar clientes
function frmCliente() {
  document.getElementById("title").innerHTML = "Nuevo Cliente";
  document.getElementById("btnAccion").innerHTML = "Agregar";
  document.getElementById("frmCliente").reset();
  $("#nuevo_cliente").modal("show");
  document.getElementById("id").value = "";
}

// Registrar clientes
function registrarCli(e) {
  e.preventDefault();
  const dni = document.getElementById("dni");
  const nombre = document.getElementById("nombre");
  const telefono = document.getElementById("telefono");
  const direccion = document.getElementById("direccion");
  if (
    dni.value == "" ||
    nombre.value == "" ||
    telefono.value == "" ||
    direccion.value == ""
  ) {
    alertas(res.msg, res.icono);
  } else {
    const url = APP_URL + "Clientes/registrar";
    const frm = document.getElementById("frmCliente");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        alertas(res.msg, res.icono);
        $("#nuevo_cliente").modal("hide");
        tblClientes.ajax.reload();
      }
    };
  }
}

// Editar clientes
function btnEditarCli(id) {
  document.getElementById("title").innerHTML = "Actualizar Clientes";
  document.getElementById("btnAccion").innerHTML = "Modificar";
  const url = APP_URL + "Clientes/editar/" + id;
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
      $("#nuevo_cliente ").modal("show");
    }
  };
}

// Eliminar clientes
function btnEliminarCli(id) {
  // Swal.fire({
  //   title: "¿Está seguro de eliminar?",
  //   text: "El cliente no se liminará permanente, solo se cambiará el estado a inactivo",
  //   icon: "warning",
  //   showCancelButton: true,
  //   confirmButtonColor: "#3085d6",
  //   cancelButtonColor: "#d33",
  //   confirmButtonText: "Si",
  //   cancelButtonText: "No",
  // }).then((result) => {
  //   if (result.isConfirmed) {
  const url = APP_URL + "Clientes/eliminar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      alertas(res.msg, res.icono);
      tblClientes.ajax.reload();
    }
  };
}
//   });
// }

// Ingresar clientes
function btnReingresarCli(id) {
  // Swal.fire({
  //   title: "¿Está seguro de reingresar?",
  //   icon: "warning",
  //   showCancelButton: true,
  //   confirmButtonColor: "#3085d6",
  //   cancelButtonColor: "#d33",
  //   confirmButtonText: "Si",
  //   cancelButtonText: "No",
  // }).then((result) => {
  //   if (result.isConfirmed) {
  const url = APP_URL + "Clientes/reingresar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      alertas(res.msg, res.icono);
      tblClientes.ajax.reload();
    }
  };
}
//   });
// }
// Fin clientes

// Agregar categorias
function frmCategoria() {
  document.getElementById("title").innerHTML = "Nueva Categorias";
  document.getElementById("btnAccion").innerHTML = "Agregar";
  document.getElementById("frmCategoria").reset();
  $("#nueva_categoria").modal("show");
  document.getElementById("id").value = "";
}

// Registrar categorias
function registrarCat(e) {
  e.preventDefault();
  const nombre = document.getElementById("nombre");
  if (nombre.value == "") {
    alertas(res.msg, res.icono);
  } else {
    const url = APP_URL + "Categorias/registrar";
    const frm = document.getElementById("frmCategoria");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        alertas(res.msg, res.icono);
        $("#nueva_categoria").modal("hide");
        tblCategorias.ajax.reload();
      }
    };
  }
}

// Editar categorias
function btnEditarCat(id) {
  document.getElementById("title").innerHTML = "Actualizar Categorias";
  document.getElementById("btnAccion").innerHTML = "Modificar";
  const url = APP_URL + "Categorias/editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("id").value = res.id;
      document.getElementById("nombre").value = res.nombre;
      $("#nueva_categoria ").modal("show");
    }
  };
}

// Eliminar categorias
function btnEliminarCat(id) {
  // Swal.fire({
  //   title: "¿Está seguro de eliminar?",
  //   text: "La categoria no se liminará permanente, solo se cambiará el estado a inactivo",
  //   icon: "warning",
  //   showCancelButton: true,
  //   confirmButtonColor: "#3085d6",
  //   cancelButtonColor: "#d33",
  //   confirmButtonText: "Si",
  //   cancelButtonText: "No",
  // }).then((result) => {
  //   if (result.isConfirmed) {
  const url = APP_URL + "Categorias/eliminar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      alertas(res.msg, res.icono);
      tblCategorias.ajax.reload();
    }
  };
}
//   });
// }

// Ingresar categorias
function btnReingresarCat(id) {
  // Swal.fire({
  //   title: "¿Está seguro de reingresar?",
  //   icon: "warning",
  //   showCancelButton: true,
  //   confirmButtonColor: "#3085d6",
  //   cancelButtonColor: "#d33",
  //   confirmButtonText: "Si",
  //   cancelButtonText: "No",
  // }).then((result) => {
  //   if (result.isConfirmed) {
  const url = APP_URL + "Categorias/reingresar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      tblCategorias.ajax.reload();
      alertas(res.msg, res.icono);
    }
  };
}
//   });
// }
// Fin categorias

// Agregar caja
function frmCaja() {
  document.getElementById("title").innerHTML = "Nueva Cajas";
  document.getElementById("btnAccion").innerHTML = "Agregar";
  document.getElementById("frmCaja").reset();
  $("#nueva_caja").modal("show");
  document.getElementById("id").value = "";
}

// Registrar caja
function registrarCaj(e) {
  e.preventDefault();
  const caja = document.getElementById("caja");
  if (caja.value == "") {
    alertas(res.msg, res.icono);
  } else {
    const url = APP_URL + "Caja/registrar";
    const frm = document.getElementById("frmCaja");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        alertas(res.msg, res.icono);
        $("#nueva_caja").modal("hide");
        tblCajas.ajax.reload();
      }
    };
  }
}

// Editar caja
function btnEditarCaj(id) {
  document.getElementById("title").innerHTML = "Actualizar Caja";
  document.getElementById("btnAccion").innerHTML = "Modificar";
  const url = APP_URL + "Caja/editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("id").value = res.id;
      document.getElementById("caja").value = res.caja;
      $("#nueva_caja ").modal("show");
    }
  };
}

// Eliminar caja
function btnEliminarCaj(id) {
  // Swal.fire({
  //   title: "¿Está seguro de eliminar?",
  //   text: "La caja no se liminará permanente, solo se cambiará el estado a inactivo",
  //   icon: "warning",
  //   showCancelButton: true,
  //   confirmButtonColor: "#3085d6",
  //   cancelButtonColor: "#d33",
  //   confirmButtonText: "Si",
  //   cancelButtonText: "No",
  // }).then((result) => {
  //   if (result.isConfirmed) {
  const url = APP_URL + "Caja/eliminar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      alertas(res.msg, res.icono);
      tblCajas.ajax.reload();
    }
  };
}
//   });
// }

// Ingresar caja
function btnReingresarCaj(id) {
  // Swal.fire({
  //   title: "¿Está seguro de reingresar?",
  //   icon: "warning",
  //   showCancelButton: true,
  //   confirmButtonColor: "#3085d6",
  //   cancelButtonColor: "#d33",
  //   confirmButtonText: "Si",
  //   cancelButtonText: "No",
  // }).then((result) => {
  //   if (result.isConfirmed) {
  const url = APP_URL + "Caja/reingresar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      tblCajas.ajax.reload();
      alertas(res.msg, res.icono);
    }
  };
}
//   });
// }
// Fin tabla Caja

// Agregar medida
function frmMedida() {
  document.getElementById("title").innerHTML = "Nueva Medidas";
  document.getElementById("btnAccion").innerHTML = "Agregar";
  document.getElementById("frmMedida").reset();
  $("#nueva_medida").modal("show");
  document.getElementById("id").value = "";
}

// Registrar medida
function registrarMed(e) {
  e.preventDefault();
  const nombre = document.getElementById("nombre");
  if (nombre.value == "") {
    alertas(res.msg, res.icono);
  } else {
    const url = APP_URL + "Medidas/registrar";
    const frm = document.getElementById("frmMedida");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        alertas(res.msg, res.icono);
        $("#nueva_medida").modal("hide");
        tblMedidas.ajax.reload();
      }
    };
  }
}

// Editar medida
function btnEditarMed(id) {
  document.getElementById("title").innerHTML = "Actualizar Medida";
  document.getElementById("btnAccion").innerHTML = "Modificar";
  const url = APP_URL + "Medidas/editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("id").value = res.id;
      document.getElementById("nombre").value = res.nombre;
      $("#nueva_medida ").modal("show");
    }
  };
}

// Eliminar medida
function btnEliminarMed(id) {
  // Swal.fire({
  //   title: "¿Está seguro de eliminar?",
  //   text: "La medida no se liminará permanente, solo se cambiará el estado a inactivo",
  //   icon: "warning",
  //   showCancelButton: true,
  //   confirmButtonColor: "#3085d6",
  //   cancelButtonColor: "#d33",
  //   confirmButtonText: "Si",
  //   cancelButtonText: "No",
  // }).then((result) => {
  //   if (result.isConfirmed) {
  const url = APP_URL + "Medidas/eliminar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      alertas(res.msg, res.icono);
      tblMedidas.ajax.reload();
    }
  };
}
//   });
// }

// Ingresar medida
function btnReingresarMed(id) {
  // Swal.fire({
  //   title: "¿Está seguro de reingresar?",
  //   icon: "warning",
  //   showCancelButton: true,
  //   confirmButtonColor: "#3085d6",
  //   cancelButtonColor: "#d33",
  //   confirmButtonText: "Si",
  //   cancelButtonText: "No",
  // }).then((result) => {
  //   if (result.isConfirmed) {
  const url = APP_URL + "Medidas/reingresar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      tblMedidas.ajax.reload();
      alertas(res.msg, res.icono);
    }
  };
}
//   });
// }
// Fin tabla medida

// Agregar Productos
function frmProducto() {
  document.getElementById("title").innerHTML = "Nuevo Producto";
  document.getElementById("btnAccion").innerHTML = "Agregar";
  document.getElementById("frmProducto").reset();
  $("#nuevo_producto").modal("show");
  document.getElementById("id").value = "";
  deleteImg();
}

// Registrar Productos
function registrarPro(e) {
  e.preventDefault();
  const codigo = document.getElementById("codigo");
  const nombre = document.getElementById("nombre");
  const precio_compra = document.getElementById("precio_compra");
  const precio_venta = document.getElementById("precio_venta");
  const iva = document.getElementById("iva");
  const id_medida = document.getElementById("medida");
  const id_cat = document.getElementById("categoria");
  if (
    codigo.value == "" ||
    nombre.value == "" ||
    precio_compra.value == "" ||
    precio_venta.value == ""
  ) {
    alertas(res.msg, res.icono);
  } else {
    const url = APP_URL + "Productos/registrar";
    const frm = document.getElementById("frmProducto");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        alertas(res.msg, res.icono);
        $("#nuevo_producto").modal("hide");
        tblProductos.ajax.reload();
      }
    };
  }
}

// Editar Productos
function btnEditarPro(id) {
  document.getElementById("title").innerHTML = "Actualizar Producto";
  document.getElementById("btnAccion").innerHTML = "Modificar";
  const url = APP_URL + "Productos/editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("id").value = res.id;
      document.getElementById("codigo").value = res.codigo;
      document.getElementById("nombre").value = res.descripcion;
      document.getElementById("precio_compra").value = res.precio_compra;
      document.getElementById("precio_venta").value = res.precio_venta;
      document.getElementById("iva").value = res.iva;
      document.getElementById("medida").value = res.id_medida;
      document.getElementById("categoria").value = res.id_categoria;
      document.getElementById("img-preview").src =
        APP_URL + "Assets/img/" + res.foto;
      document.getElementById("icon-cerrar").innerHTML = `
      <button class="btn btn-danger" onclick="deleteImg()">
      <i class="fas fa-times"></i></button>`;
      document.getElementById("icon-image").classList.add("d-none");
      document.getElementById("foto_actual").value = res.foto;
      document.getElementById("foto_delete").value = res.foto;
      $("#nuevo_producto").modal("show");
    }
  };
}

// Eliminar Productos
function btnEliminarPro(id) {
  // Swal.fire({
  //   title: "¿Está seguro de eliminar?",
  //   text: "El producto no se liminará permanente, solo se cambiará el estado a inactivo",
  //   icon: "warning",
  //   showCancelButton: true,
  //   confirmButtonColor: "#3085d6",
  //   cancelButtonColor: "#d33",
  //   confirmButtonText: "Si",
  //   cancelButtonText: "No",
  // }).then((result) => {
  //   if (result.isConfirmed) {
  const url = APP_URL + "Productos/eliminar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      tblProductos.ajax.reload();
      alertas(res.msg, res.icono);
    }
  };
}
//   });
// }

// Ingresar Productos
function btnReingresarPro(id) {
  // Swal.fire({
  //   title: "¿Está seguro de reingresar?",
  //   icon: "warning",
  //   showCancelButton: true,
  //   confirmButtonColor: "#3085d6",
  //   cancelButtonColor: "#d33",
  //   confirmButtonText: "Si",
  //   cancelButtonText: "No",
  // }).then((result) => {
  //   if (result.isConfirmed) {
  const url = APP_URL + "Productos/reingresar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      tblProductos.ajax.reload();
      alertas(res.msg, res.icono);
    }
  };
}
//   });
// }

// foto productos
function preview(e) {
  const url = e.target.files[0];
  const urlTmp = URL.createObjectURL(url);
  document.getElementById("img-preview").src = urlTmp;
  document.getElementById("icon-image").classList.add("d-none");
  document.getElementById("icon-cerrar").innerHTML = `
  <button class="btn btn-danger" onclick="deleteImg()"><i class="fas fa-times"></i></button>
  ${url["name"]}`;
}

// eliminar foto producto
function deleteImg() {
  document.getElementById("icon-cerrar").innerHTML = "";
  document.getElementById("icon-image").classList.remove("d-none");
  document.getElementById("img-preview").src = "";
  document.getElementById("imagen").value = "";
  document.getElementById("foto_delete").value = "";
}

// Buscar Producto
function buscarCodigo(e) {
  e.preventDefault();
  const cod = document.getElementById("codigo").value;
  if (cod != "") {
    if (e.which == 13) {
      const url = APP_URL + "Compras/buscarCodigo/" + cod;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res) {
            document.getElementById("nombre").value = res.descripcion;
            document.getElementById("precio").value = res.precio_compra;
            document.getElementById("id").value = res.id;
            document.getElementById("cantidad").removeAttribute("disabled");
            document.getElementById("cantidad").focus();
          } else {
            alertas("El producto no existe", "warning");
            document.getElementById("codigo").value = "";
            document.getElementById("codigo").focus();
          }
        }
      };
    }
  } //else {
  //alertas("Ingrese el código", "warning");
  //}
}

// Buscar codigo venta
// Buscar Producto
function buscarCodigoVenta(e) {
  e.preventDefault();
  const cod = document.getElementById("codigo").value;
  if (cod != "") {
    if (e.which == 13) {
      const url = APP_URL + "Compras/buscarCodigo/" + cod;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res) {
            document.getElementById("nombre").value = res.descripcion;
            document.getElementById("precio").value = res.precio_venta;
            document.getElementById("id").value = res.id;
            document.getElementById("cantidad").removeAttribute("disabled");
            document.getElementById("cantidad").focus();
          } else {
            alertas("El producto no existe", "warning");
            document.getElementById("codigo").value = "";
            document.getElementById("codigo").focus();
          }
        }
      };
    }
  } //else {
  //   alertas("Ingrese el código", "warning");
  // }
}

// Calcular Precio de los Productos
function calcularPrecio(e) {
  e.preventDefault();
  const cant = document.getElementById("cantidad").value;
  const precio = document.getElementById("precio").value;
  document.getElementById("sub_total").value = precio * cant;
  if (e.which == 13) {
    if (cant > 0) {
      const url = APP_URL + "Compras/ingresar";
      const frm = document.getElementById("frmCompra");
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(new FormData(frm));
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertas(res.msg, res.icono);
          frm.reset();
          cargarDetalle();
          document
            .getElementById("cantidad")
            .setAttribute("disabled", "disabled");
          document.getElementById("codigo").focus();
        }
      };
    }
  }
}

// Calcular precio de la Venta
function calcularPrecioVenta(e) {
  e.preventDefault();
  const cant = document.getElementById("cantidad").value;
  const precio = document.getElementById("precio").value;
  document.getElementById("sub_total").value = precio * cant;
  if (e.which == 13) {
    if (cant > 0) {
      const url = APP_URL + "Compras/ingresarVenta";
      const frm = document.getElementById("frmVenta");
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(new FormData(frm));
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertas(res.msg, res.icono);
          frm.reset();
          cargarDetalleVenta();
          document
            .getElementById("cantidad")
            .setAttribute("disabled", "disabled");
          document.getElementById("codigo").focus();
        }
      };
    }
  }
}

// Listar Detalle
if (document.getElementById("tblDetalle")) {
  cargarDetalle();
}
if (document.getElementById("tblDetalleVenta")) {
  cargarDetalleVenta();
}

function cargarDetalle() {
  const url = APP_URL + "Compras/listar/detalle";
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      let html = "";
      res.detalle.forEach((row) => {
        html += `<tr>
        <td>${row["descripcion"]}</td>
        <td>${row["cantidad"]}</td>
        <td>Bs ${row["precio"]}</td>
        <td>Bs ${row["sub_total"]}</td>
        <td>
        <button class="btn btn-danger" type="button" onclick="deleteDetalle(${row["id"]}, 1)">
        <i class="fas fa-trash-alt"></i></button>
        </td>
        </tr>`;
      });
      document.getElementById("tblDetalle").innerHTML = html;
      document.getElementById("total").value = `Bs ${res.total_pagar}`;
    }
  };
}

// venta
function cargarDetalleVenta() {
  const url = APP_URL + "Compras/listar/detalle_temp";
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      let html = "";
      res.detalle.forEach((row) => {
        html += `<tr>
        <td>${row["descripcion"]}</td>
        <td>${row["cantidad"]}</td>
        <td><input class="form-control" placeholder="Desc" type="text" onkeyup="calcularDescuento(event, ${row["id"]})"></td>
        <td>${row["descuento"]}</td>
        <td>Bs ${row["precio"]}</td>
        <td>Bs ${row["sub_total"]}</td>
        <td>
        <button class="btn btn-danger" type="button" onclick="deleteDetalle(${row["id"]}, 0)">
        <i class="fas fa-trash-alt"></i></button>
        </td>
        </tr>`;
      });
      document.getElementById("tblDetalleVenta").innerHTML = html;
      document.getElementById("total").value = `Bs ${res.total_pagar}`;
    }
  };
}

// calcular descuento
function calcularDescuento(e, id) {
  e.preventDefault();
  if (e.target.value == "") {
    // alertas("Ingrese el Descuento", "warning");
  } else {
    if (e.which == 13) {
      const url =
        APP_URL + "Compras/calcularDescuento/" + id + "/" + e.target.value;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertas(res.msg, res.icono);
          cargarDetalleVenta();
        }
      };
    }
  }
}

// button eliminar compra de producto
function deleteDetalle(id, accion) {
  let url;
  if (accion == 1) {
    url = APP_URL + "Compras/delete/" + id;
  } else {
    url = APP_URL + "Compras/deleteVenta/" + id;
  }
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      alertas(res.msg, res.icono);
      if (accion == 1) {
        cargarDetalle();
      } else {
        cargarDetalleVenta();
      }
    }
  };
}

// Generar compra
function procesar(accion) {
  // Swal.fire({
  //   title: "¿Está seguro de realizar la compra?",
  //   icon: "warning",
  //   showCancelButton: true,
  //   confirmButtonColor: "#3085d6",
  //   cancelButtonColor: "#d33",
  //   confirmButtonText: "Si",
  //   cancelButtonText: "No",
  // }).then((result) => {
  // if (isConfirmed) {
  let url;
  if (accion == 1) {
    url = APP_URL + "Compras/registrarCompra";
  } else {
    const id_cliente = document.getElementById("cliente").value;
    url = APP_URL + "Compras/registrarVenta/" + id_cliente;
  }
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      if (res.msg == "ok") {
        // alertas(res.msg, res.icono);
        let ruta;
        if (accion == 1) {
          ruta = APP_URL + "Compras/generarPdf/" + res.id_compra;
        } else {
          ruta = APP_URL + "Compras/generarPdfVenta/" + res.id_venta;
        }
        window.open(ruta);
        setTimeout(() => {
          window.location.reload();
        }, 3000);
      } else {
        // alertas(res.msg, res.icono);
      }
    }
  };
}
//} );
//}

// Modificar Empresa
function modificarEmpresa() {
  const frm = document.getElementById("frmEmpresa");
  const url = APP_URL + "Administracion/modificar";
  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(new FormData(frm));
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      if (res == "ok") {
        alertas("Datos de la empresa actualizados", "success");
      }
    }
  };
}

// Alertas
function alertas(mensaje, icono) {
  let color;

  // Define el color según el tipo de icono
  switch (icono) {
    case "success":
      color = "#28a745"; // Verde para éxito
      break;
    case "error":
      color = "#dc3545"; // Rojo para error
      break;
    case "warning":
      color = "#ffc107"; // Amarillo para advertencia
      break;
    case "info":
      color = "#17a2b8"; // Azul para información
      break;
    default:
      color = "#6c757d"; // Gris para otros casos
  }

  Swal.fire({
    position: "top-end",
    icon: icono,
    title: mensaje,
    toast: true,
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    background: color, // Establece el color de fondo
    customClass: {
      title: "alert-title", // Clase personalizada para el título
    },
    showClass: {
      popup: "animate__animated animate__fadeInDown", // Animación al aparecer
    },
    hideClass: {
      popup: "animate__animated animate__fadeOutUp", // Animación al desaparecer
    },
  });

  // Aplica el estilo CSS para el texto
  const style = document.createElement("style");
  style.innerHTML = `
    .alert-title {
      color: white !important; // Asegura que el texto sea blanco
    }
  `;
  document.head.appendChild(style);
}

// resporte stock
if (document.getElementById("stockMinimo")) {
  reporteStock();
  productosVendidos();
}
function reporteStock() {
  const url = APP_URL + "Administracion/reporteStock";
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      let nombre = [];
      let cantidad = [];
      for (let i = 0; i < res.length; i++) {
        nombre.push(res[i]["descripcion"]);
        cantidad.push(res[i]["cantidad"]);
      }
      var ctx = document.getElementById("stockMinimo");
      var myPieChart = new Chart(ctx, {
        type: "pie",
        data: {
          labels: nombre,
          datasets: [
            {
              data: cantidad,
              backgroundColor: ["#007bff", "#dc3545", "#ffc107", "#28a745"],
            },
          ],
        },
      });
    }
  };
}

// Productos Más vendidos
function productosVendidos() {
  const url = APP_URL + "Administracion/productosVendidos";
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      let nombre = [];
      let cantidad = [];
      for (let i = 0; i < res.length; i++) {
        nombre.push(res[i]["descripcion"]);
        cantidad.push(res[i]["total"]);
      }
      var ctx = document.getElementById("productosVendidos");
      var myPieChart = new Chart(ctx, {
        type: "doughnut",
        data: {
          labels: nombre,
          datasets: [
            {
              data: cantidad,
              backgroundColor: ["#007bff", "#dc3545", "#ffc107", "#28a745"],
            },
          ],
        },
      });
    }
  };
}

// Anular Compra
// Generar compra
function btnAnularC(id) {
  Swal.fire({
    title: "¿Está seguro de anular la Compra?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = APP_URL + "Compras/anularCompra/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertas(res.msg, res.icono);
          t_h_c.ajax.reload();
        }
      };
    }
  });
}

// Anular Venta
// Generar Venta
function btnAnularV(id) {
  Swal.fire({
    title: "¿Está seguro de anular la Venta?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = APP_URL + "Compras/anularVenta/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertas(res.msg, res.icono);
          t_h_v.ajax.reload();
        }
      };
    }
  });
}

// Arqueo Caja
function arqueoCaja() {
  document.getElementById("ocultar_campos").classList.add("d-none");
  document.getElementById("monto_inicial").value = "";
  document.getElementById("btnAccion").textContent = "Abrir Caja";
  $("#abrir_caja").modal("show");
}

function abrirArqueo(e) {
  e.preventDefault();
  const monto_inicial = document.getElementById("monto_inicial").value;
  if (monto_inicial == "") {
    alertas("Ingrese el monto inicial", "warning");
  } else {
    const frm = document.getElementById("frmAbrirCaja");
    const url = APP_URL + "Caja/abrirArqueo";
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        alertas(res.msg, res.icono);
        t_arqueo.ajax.reload();
        $("#abrir_caja").modal("hide");
      }
    };
  }
}

function cerrarCaja() {
  const url = APP_URL + "Caja/getVentas";
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("monto_final").value = res.monto_total.total;
      document.getElementById("total_ventas").value = res.total_ventas.total;
      document.getElementById("monto_inicial").value =
        res.inicial.monto_inicial;
      document.getElementById("monto_general").value = res.monto_general;
      document.getElementById("id").value = res.inicial.id;
      document.getElementById("ocultar_campos").classList.remove("d-none");
      document.getElementById("btnAccion").textContent = "Cerrar Caja";
      $("#abrir_caja").modal("show");
    }
  };
}

function registrarPermisos(e) {
  e.preventDefault();
  const url = APP_URL + "Usuarios/registrarPermiso";
  const frm = document.getElementById("formulario");
  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(new FormData(frm));
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      if (res != "") {
        alertas(res.msg, res.icono);
      } else {
        alertas("Error no identificado", "error");
      }
    }
  };
}

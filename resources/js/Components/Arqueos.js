let t_arqueo;

/** Función para inicializar DataTable */
export async function inicializarTablaArqueo() {
  try {
    const response = await fetch(`${APP_URL}arqueo/listArqueo`, {
      method: "GET", // Método de la solicitud
      headers: {
        "Content-Type": "application/json", // Tipo de contenido
      },
    });

    if (!response.ok) {
      throw new Error("Error al conseguir los datos");
    }

    const data = await response.json(); // Parsear la respuesta JSON

    // Verifica la estructura de los datos
    // console.log(data);

    // Initialize DataTable With Fetched data
    t_arqueo = $("#t_arqueo").DataTable({
      data: data, // Use the fetched data here
      columns: [
        { data: "monto_inicial" },
        { data: "monto_final" },
        { data: "fecha_apertura" },
        { data: "fecha_cierre" },
        { data: "total_ventas" },
        { data: "monto_total" },
        { data: "estado" },
      ],
      order: [
        [1, "asc"],
        [0, "asc"],
      ],
      language: {
        decimal: "",
        emptyTable: "No hay datos disponibles en la tabla",
        info: "Mostrando _START_ a _END_ de _TOTAL_ entradas",
        infoEmpty: "Mostrando 0 a 0 de 0 entradas",
        infoFiltered: "(filtrado de _MAX_ entradas totales)",
        infoPostFix: "",
        thousands: ",",
        lengthMenu: "Mostrar _MENU_ entradas",
        loadingRecords: "Cargando...",
        processing: "Procesando...",
        search: "Buscar:",
        zeroRecords: "No se encontraron registros coincidentes",
        paginate: {
          first: "Primero",
          last: "Último",
          next: "Siguiente",
          previous: "Anterior",
        },
        aria: {
          sortAscending: ": activar para ordenar la columna ascendente",
          sortDescending: ": activar para ordenar la columna descendente",
        },
      },
    });
  } catch (error) {
    console.error("Error al conseguir los datos: ", error);
  }
}

export function arqueoCaja() {
  document.getElementById("ocultar_campos").classList.add("d-none");
  document.getElementById("monto_inicial").value = "";
  document.getElementById("btnAccion").textContent = "Abrir Caja";
  $("#abrir_caja").modal("show");
}

export async function abrirArqueo(e) {
  e.preventDefault();

  const monto_inicial = document.getElementById("monto_inicial");

  if (monto_inicial.value == "") {
    alerts("Todos los campos son obligatorios", "warning");
    return;
  }

  try {
    const response = await fetch(`${APP_URL}arqueo`, {
      method: "POST",
      body: new FormData(document.getElementById("frmAbrirCaja")),
    });

    if (!response.ok) {
      throw new Error("Error en la respuesta de la red");
    }

    const res = await response.json();
    $("#abrir_caja").modal("hide");
    alerts(res.msg, res.icon);

    // Actualiza la tabla de arqueo
    const responseList = await fetch(`${APP_URL}arqueo/listArqueo`);
    const arqueo = await responseList.json();
    t_arqueo.clear().rows.add(arqueo).draw();
  } catch (error) {
    console.error("Error:", error);
    alerts("Error en la petición", "error");
  }
}

export function cerrarCaja() {
  const url = APP_URL + "arqueo/getSales";
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

let tblCajas;

/** Función para inicializar DataTable */
export async function inicializarTablaCajas() {
  try {
    const response = await fetch(`${APP_URL}boxes/list`, {
      method: "GET", // Método de la solicitud
      headers: {
        "Content-Type": "application/json", // Tipo de contenido
      },
    });

    if (!response.ok) {
      throw new Error("Error al conseguir los datos");
    }

    const data = await response.json(); // Parsear la respuesta JSON

    // Initialize DataTable With Fetched data
    tblCajas = $("#tblCajas").DataTable({
      data: data, // Use the fetched data here
      columns: [{ data: "caja" }, { data: "estado" }, { data: "acciones" }],
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

export function frmCaja() {
  document.getElementById("title").innerHTML = "Nueva Caja";
  document.getElementById("btnAccion").innerHTML = "Agregar";
  document.getElementById("frmCaja").reset();
  $("#nueva_caja").modal("show");
  document.getElementById("id").value = "";
}

export async function registerCaj(e) {
  e.preventDefault();

  const caja = document.getElementById("caja");

  if (caja.value == "") {
    alerts("Todos los campos son obligatorios", "warning");
    return;
  }

  try {
    const response = await fetch(`${APP_URL}boxes`, {
      method: "POST",
      body: new FormData(document.getElementById("frmCaja")),
    });

    if (!response.ok) {
      throw new Error("Error en la respuesta de la red");
    }

    const res = await response.json();
    $("#nueva_caja").modal("hide");
    alerts(res.msg, res.icon);

    // Actualiza la tabla de cajas
    const responseList = await fetch(`${APP_URL}boxes/list`);
    const cajas = await responseList.json();
    tblCajas.clear().rows.add(cajas).draw();
  } catch (error) {
    console.error("Error:", error);
    alerts("Error en la petición", "error");
  }
}

export async function editCaj(id) {
  document.getElementById("title").innerHTML = "Editar Caja";
  document.getElementById("btnAccion").innerHTML = "Editar";

  try {
    const response = await fetch(`${APP_URL}boxes/${id}`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });

    if (!response.ok) {
      throw new Error("Error al obtener los datos");
    }

    const res = await response.json();

    document.getElementById("id").value = res.id;
    document.getElementById("caja").value = res.caja;
    $("#nueva_caja").modal("show");
  } catch (error) {
    console.error("Error en la solicitud:", error);
    alerts("Ocurrió un error al intentar cargar el producto.");
  }
}

export async function desactiveCaj(id) {
  Swal.fire({
    title: "¿Está seguro de desactivar?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
    cancelButtonText: "No",
  }).then(async (result) => {
    if (result.isConfirmed) {
      try {
        const response = await fetch(`${APP_URL}boxes/desactive/${id}`, {
          method: "POST",
          body: JSON.stringify({ id: id }),
          headers: {
            "Content-Type": "application/json",
          },
        });

        if (!response.ok) {
          throw new Error("Error al desactivar la caja");
        }

        const res = await response.json();
        alerts(res.msg, res.icon);

        // Actualiza la tabla de cajas
        const responseList = await fetch(`${APP_URL}boxes/list`);
        const cajas = await responseList.json();
        tblCajas.clear().rows.add(cajas).draw();
      } catch (error) {
        console.error("Error:", error);
        alerts("Error al eliminar el usuario", "danger");
      }
    }
  });
}

export async function activeCaj(id) {
  Swal.fire({
    title: "¿Está seguro de activar?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
    cancelButtonText: "No",
  }).then(async (result) => {
    if (result.isConfirmed) {
      try {
        const response = await fetch(`${APP_URL}boxes/active/${id}`, {
          method: "POST",
          body: JSON.stringify({ id: id }),
          headers: {
            "Content-Type": "application/json",
          },
        });

        if (!response.ok) {
          throw new Error("Error al activar la caja");
        }

        const res = await response.json();
        alerts(res.msg, res.icon);

        // Actualiza la tabla de cajas
        const responseList = await fetch(`${APP_URL}boxes/list`);
        const cajas = await responseList.json();
        tblCajas.clear().rows.add(cajas).draw();
      } catch (error) {
        console.error("Error:", error);
        alerts("Error al activar la categoria", "danger");
      }
    }
  });
}

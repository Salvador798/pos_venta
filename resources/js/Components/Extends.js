let tblMedidas;

/** Función para inicializar DataTable */
export async function inicializarTablaMedidas() {
  try {
    const response = await fetch(`${APP_URL}extends/list`, {
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
    tblMedidas = $("#tblMedidas").DataTable({
      data: data, // Use the fetched data here
      columns: [{ data: "nombre" }, { data: "estado" }, { data: "acciones" }],
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

export function frmMedida() {
  document.getElementById("title").innerHTML = "Nueva Medida";
  document.getElementById("btnAccion").innerHTML = "Registrar";
  document.getElementById("frmMedida").reset();
  $("#nueva_medida").modal("show");
}

// Registrar Categorias
export async function registerExtends(e) {
  e.preventDefault();

  const nombre = document.getElementById("nombre");

  if (nombre.value === "") {
    alerts("Todos los campos son obligatorios", "warning");
    return;
  }

  try {
    const response = await fetch(`${APP_URL}extends`, {
      method: "POST",
      body: new FormData(document.getElementById("frmMedida")),
    });

    if (!response.ok) {
      throw new Error("Error en la respuesta de la red");
    }

    const res = await response.json();
    $("#nueva_medida").modal("hide");
    alerts(res.msg, res.icon);

    // Actualiza la tabla de medidas
    const responseList = await fetch(`${APP_URL}extends/list`);
    const medidas = await responseList.json();
    tblMedidas.clear().rows.add(medidas).draw();
  } catch (error) {
    console.error("Error:", error);
    alerts("Error en la petición", "error");
  }
}

// Editar Medidas
export async function editExt(id) {
  document.getElementById("title").innerHTML = "Editar Medidas";
  document.getElementById("btnAccion").innerHTML = "Editar";

  try {
    const response = await fetch(`${APP_URL}extends/${id}`, {
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
    document.getElementById("nombre").value = res.nombre;
    $("#nueva_medida").modal("show");
  } catch (error) {
    console.error("Error:", error);
    alerts("Error al obtener los datos", "error");
  }
}

export async function desactiveExt(id) {
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
        const response = await fetch(`${APP_URL}extends/desactive/${id}`, {
          method: "POST",
          body: JSON.stringify({ id: id }),
          headers: {
            "Content-Type": "application/json",
          },
        });

        if (!response.ok) {
          throw new Error("Error al desactivar la medida");
        }

        const res = await response.json();
        alerts(res.msg, res.icon);

        // Actualiza la tabla de categorias
        const responseList = await fetch(`${APP_URL}extends/list`);
        const medidas = await responseList.json();
        tblMedidas.clear().rows.add(medidas).draw();
      } catch (error) {
        console.error("Error:", error);
        alerts("Error al desactivar la medida", "danger");
      }
    }
  });
}

export async function activeExt(id) {
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
        const response = await fetch(`${APP_URL}extends/active/${id}`, {
          method: "POST",
          body: JSON.stringify({ id: id }),
          headers: {
            "Content-Type": "application/json",
          },
        });

        if (!response.ok) {
          throw new Error("Error al activar la medida");
        }

        const res = await response.json();
        alerts(res.msg, res.icon);

        // Actualiza la tabla de categorias
        const responseList = await fetch(`${APP_URL}extends/list`);
        const medidas = await responseList.json();
        tblMedidas.clear().rows.add(medidas).draw();
      } catch (error) {
        console.error("Error:", error);
        alerts("Error al activar la medida", "danger");
      }
    }
  });
}

let tblClientes;

/** Función para inicializar DataTable */
export async function inicializarTablaClientes() {
  try {
    const response = await fetch(`${APP_URL}clients/list`, {
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
    tblClientes = $("#tblClientes").DataTable({
      data: data, // Use the fetched data here
      columns: [
        { data: "dni", className: "text-center" },
        { data: "nombre" },
        { data: "telefono", className: "text-center" },
        { data: "direccion" },
        { data: "estado" },
        { data: "acciones" },
      ],
      order: [
        [4, "asc"],
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

export function frmCliente() {
  document.getElementById("title").innerHTML = "Nuevo Cliente";
  document.getElementById("btnAccion").innerHTML = "Agregar";
  document.getElementById("frmCliente").reset();
  $("#nuevo_cliente").modal("show");
  document.getElementById("id").value = "";
}

export async function registerCli(e) {
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
    alerts("Por favor, completa todos los campos obligatorios.", "warning");
    return;
  }

  try {
    const response = await fetch(`${APP_URL}clients`, {
      method: "POST",
      body: new FormData(document.getElementById("frmCliente")),
    });

    if (!response.ok) {
      throw new Error("Error al obtener los datos");
    }

    const res = await response.json();
    alerts(res.msg, res.icono);
    $("#nuevo_cliente").modal("hide");

    // Actualiza la tabla de clientes
    const responseList = await fetch(`${APP_URL}clients/list`);
    const clientes = await responseList.json();
    tblClientes.clear().rows.add(clientes).draw();
  } catch (error) {
    console.error("Error en la solicitud:", error);
    alerts("Ocurrió un error inesperado.", "error");
  }
}

export async function edditCli(id) {
  document.getElementById("title").innerHTML = "Actualizar Cliente";
  document.getElementById("btnAccion").innerHTML = "Modificar";

  try {
    const response = await fetch(`${APP_URL}clients/${id}`, {
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
    document.getElementById("dni").value = res.dni;
    document.getElementById("nombre").value = res.nombre;
    document.getElementById("telefono").value = res.telefono;
    document.getElementById("direccion").value = res.direccion;
    $("#nuevo_cliente").modal("show");
  } catch (error) {
    console.error("Error en la solicitud:", error);
    alerts("Ocurrió un error al intentar cargar el producto.");
  }
}

export async function desactiveCli(id) {
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
        const response = await fetch(`${APP_URL}clients/desactive/${id}`, {
          method: "POST",
          body: JSON.stringify({ id: id }),
          headers: {
            "Content-Type": "application/json",
          },
        });

        if (!response.ok) {
          throw new Error("Error al eliminar el usuario");
        }

        const res = await response.json();
        alerts(res.msg, res.icon);

        // Actualiza la tabla de clientes
        const responseList = await fetch(`${APP_URL}clients/list`);
        const clientes = await responseList.json();
        tblClientes.clear().rows.add(clientes).draw();
      } catch (error) {
        console.error("Error:", error);
        alerts("Error al eliminar el usuario", "danger");
      }
    }
  });
}

export async function activeCli(id) {
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
        const response = await fetch(`${APP_URL}clients/active/${id}`, {
          method: "POST",
          body: JSON.stringify({ id: id }),
          headers: {
            "Content-Type": "application/json",
          },
        });

        if (!response.ok) {
          throw new Error("Error al activar la categoria");
        }

        const res = await response.json();
        alerts(res.msg, res.icon);

        // Actualiza la tabla de clientes
        const responseList = await fetch(`${APP_URL}clients/list`);
        const clientes = await responseList.json();
        tblClientes.clear().rows.add(clientes).draw();
      } catch (error) {
        console.error("Error:", error);
        alerts("Error al activar la categoria", "danger");
      }
    }
  });
}

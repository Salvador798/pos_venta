let tblCategorias;

/** Función para inicializar DataTable */
export async function inicializarTablaCategorias() {
  try {
    const response = await fetch(`${APP_URL}categories/list`, {
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
    tblCategorias = $("#tblCategorias").DataTable({
      data: data, // Use the fetched data here
      columns: [{ data: "nombre" }, { data: "estado" }, { data: "acciones" }],
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

// Agregar Usuarios
export function frmCategoria() {
  document.getElementById("title").innerHTML = "Nueva Categoria";
  document.getElementById("btnAccion").innerHTML = "Agregar";
  document.getElementById("frmCategoria").reset();
  $("#nueva_categoria").modal("show");
  document.getElementById("id").value = "";
}

// Registrar Categorias
export async function registerCat(e) {
  e.preventDefault();

  const nombre = document.getElementById("nombre");

  if (nombre.value === "") {
    alerts("Todos los campos son obligatorios", "warning");
    return;
  }

  try {
    const response = await fetch(`${APP_URL}categories`, {
      method: "POST",
      body: new FormData(document.getElementById("frmCategoria")),
    });

    if (!response.ok) {
      throw new Error("Error en la respuesta de la red");
    }

    const res = await response.json();
    $("#nueva_categoria").modal("hide");
    alerts(res.msg, res.icon);

    // Actualiza la tabla de categorias
    const responseList = await fetch(`${APP_URL}categories/list`);
    const categorias = await responseList.json();
    tblCategorias.clear().rows.add(categorias).draw();
  } catch (error) {
    console.error("Error:", error);
    alerts("Error en la petición", "error");
  }
}

// Editar Categorias
export async function editCat(id) {
  document.getElementById("title").innerHTML = "Editar Categoria";
  document.getElementById("btnAccion").innerHTML = "Editar";

  try {
    const response = await fetch(`${APP_URL}categories/${id}`, {
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
    $("#nueva_categoria").modal("show");
  } catch (error) {
    console.error("Error:", error);
    alerts("Error al obtener los datos", "error");
  }
}

export async function desactiveCat(id) {
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
        const response = await fetch(`${APP_URL}categories/desactive/${id}`, {
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

        // Actualiza la tabla de categorias
        const responseList = await fetch(`${APP_URL}categories/list`);
        const categories = await responseList.json();
        tblCategorias.clear().rows.add(categories).draw();
      } catch (error) {
        console.error("Error:", error);
        alerts("Error al eliminar el usuario", "danger");
      }
    }
  });
}

export async function activeCat(id) {
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
        const response = await fetch(`${APP_URL}categories/active/${id}`, {
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

        // Actualiza la tabla de categorias
        const responseList = await fetch(`${APP_URL}categories/list`);
        const categories = await responseList.json();
        tblCategorias.clear().rows.add(categories).draw();
      } catch (error) {
        console.error("Error:", error);
        alerts("Error al activar la categoria", "danger");
      }
    }
  });
}

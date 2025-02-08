let tblUsuarios;

/** Función para inicializar DataTable */
export async function inicializarTablaUsuarios() {
  const url = `${APP_URL}users/list`; // URL del controlador

  try {
    const response = await fetch(url, {
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
    tblUsuarios = $("#tblUsuarios").DataTable({
      data: data, // Use the fetched data here
      columns: [
        { data: "usuario" },
        { data: "nombre" },
        { data: "caja" }, // Asegúrate de que esta columna exista en los datos
        { data: "estado" },
        { data: "acciones" }, // Asegúrate de que esta columna exista en los datos
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

// Agregar Usuarios
export function frmUsuario() {
  document.getElementById("title").innerHTML = "Nuevo Usuario";
  document.getElementById("btnAccion").innerHTML = "Agregar";
  document.getElementById("claves").classList.remove("d-none");
  document.getElementById("frmUsuario").reset();
  $("#nuevo_usuario").modal("show");
  document.getElementById("id").value = "";
}

// Registrar Usuarios
export async function registerUser(e) {
  e.preventDefault();

  const usuario = document.getElementById("usuario");
  const nombre = document.getElementById("nombre");
  const caja = document.getElementById("caja");

  if (usuario.value === "" || nombre.value === "" || caja.value === "") {
    alerts("Todos los campos son obligatorios", "warning");
    return;
  }

  const url = APP_URL + "users";
  const frm = document.getElementById("frmUsuario");

  try {
    const response = await fetch(url, {
      method: "POST",
      body: new FormData(frm),
    });

    if (!response.ok) {
      throw new Error("Error en la respuesta de la red");
    }

    const res = await response.json();
    $("#nuevo_usuario").modal("hide");
    alerts(res.msg, res.icon);

    // Actualiza la tabla de usuarios
    const responseList = await fetch(`${APP_URL}users/list`);
    const usuarios = await responseList.json();
    tblUsuarios.clear().rows.add(usuarios).draw();
  } catch (error) {
    console.error("Error:", error);
    alerts("Error en la petición", "error");
  }
}

// Editar Usuarios
export async function editUser(id) {
  document.getElementById("title").innerHTML = "Actualizar Usuario";
  document.getElementById("btnAccion").innerHTML = "Modificar";
  const url = `${APP_URL}users/${id}`;

  try {
    const response = await fetch(url, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });

    if (!response.ok) {
      throw new Error("Error al obtener los datos del usuario");
    }

    const res = await response.json();
    document.getElementById("id").value = res.id;
    document.getElementById("usuario").value = res.usuario;
    document.getElementById("nombre").value = res.nombre;
    document.getElementById("caja").value = res.id_caja;
    document.getElementById("claves").classList.add("d-none");
    $("#nuevo_usuario").modal("show");
  } catch (error) {
    console.error("Error:", error);
    alerts("Error al cargar los datos del usuario", "error");
  }
}

// Función para eliminar usuarios
export function desactiveUser(id) {
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
      const url = `${APP_URL}users/desactive/${id}`;

      try {
        const response = await fetch(url, {
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

        // Actualiza la tabla de usuarios
        const responseList = await fetch(`${APP_URL}users/list`);
        const usuarios = await responseList.json();
        tblUsuarios.clear().rows.add(usuarios).draw();
      } catch (error) {
        console.error("Error:", error);
        alerts("Error al eliminar el usuario", "danger");
      }
    }
  });
}

// Función para reingresar usuarios
export function activeUser(id) {
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
      const url = `${APP_URL}users/active/${id}`;

      try {
        const response = await fetch(url, {
          method: "POST",
          body: JSON.stringify({ id: id }),
          headers: {
            "Content-Type": "application/json",
          },
        });

        if (!response.ok) {
          throw new Error("Error al reingresar el usuario");
        }

        const res = await response.json();
        alerts(res.msg, res.icon);

        // Actualiza la tabla de usuarios
        const responseList = await fetch(`${APP_URL}users/list`);
        const usuarios = await responseList.json();
        tblUsuarios.clear().rows.add(usuarios).draw();
      } catch (error) {
        console.error("Error:", error);
        alerts("Error al reingresar el usuario", "danger");
      }
    }
  });
}

// Función para registrar permisos
export async function registrarPermisos(e) {
  e.preventDefault();
  const url = `${APP_URL}users/registerPermiso`;
  const frm = document.getElementById("formulario");

  try {
    const response = await fetch(url, {
      method: "POST",
      body: new FormData(frm),
    });

    if (!response.ok) {
      throw new Error("Error al registrar los permisos");
    }

    const res = await response.json();
    if (res.msg) {
      alerts(res.msg, res.icon);
    } else {
      alerts("Error no identificado", "error");
    }
  } catch (error) {
    console.error("Error:", error);
    alerts("Error al registrar los permisos", "danger");
  }
}

// Función para cambiar la contraseña
export async function frmCambiarPass(e) {
  e.preventDefault();
  const actual = document.getElementById("clave_actual").value;
  const nueva = document.getElementById("clave_nueva").value;
  const confirmar = document.getElementById("confirmar_clave").value;

  // Validación de campos
  if (actual === "" || nueva === "" || confirmar === "") {
    alerts("Todos los campos son obligatorios", "warning");
    return false;
  }

  if (nueva !== confirmar) {
    alerts("Las contraseñas no coinciden", "warning");
    return false;
  }

  const url = `${APP_URL}users/cambiarPass`;
  const frm = document.getElementById("frmCambiarPass");

  try {
    const response = await fetch(url, {
      method: "POST",
      body: new FormData(frm),
    });

    if (!response.ok) {
      throw new Error("Error al cambiar la contraseña");
    }

    const res = await response.json();
    alerts(res.msg, res.icon);
    $("#cambiarPass").modal("hide");
    frm.reset();
  } catch (error) {
    console.error("Error:", error);
    alerts("Error al cambiar la contraseña", "danger");
  }
}

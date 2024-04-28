let tblUsuarios, tblClientes, tblCategorias;
document.addEventListener("DOMContentLoaded", function () {
  // usuarios
  tblUsuarios = $("#tblUsuarios").DataTable({
    ajax: {
      url: APP_URL + "Usuarios/listar",
      dataSrc: "",
    },
    columns: [
      {
        'data': "id"
      },
      {
        'data': "usuario"
      },
      {
        'data': "nombre"
      },
      {
        'data': "caja"
      },
      {
        'data': "estado"
      },
      {
        'data': 'acciones'
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
    columns: [
      {
        'data': "id"
      },
      {
        'data': "dni"
      },
      {
        'data': "nombre"
      },
      {
        'data': "telefono"
      },
      {
        'data': "direccion"
      },
      {
        'data': "estado"
      },
      {
        'data': 'acciones'
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
    columns: [
      {
        'data': "id"
      },
      {
        'data': "nombre"
      },
      {
        'data': "estado"
      },
      {
        'data': 'acciones'
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
    columns: [
      {
        'data': "id"
      },
      {
        'data': "caja"
      },
      {
        'data': "estado"
      },
      {
        'data': 'acciones'
      },
    ],
  });
  // Fin tabla cajas

  // Categorias
  tblMedidas = $("#tblMedidas").DataTable({
    ajax: {
      url: APP_URL + "Medidas/listar",
      dataSrc: "",
    },
    columns: [
      {
        'data': "id"
      },
      {
        'data': "nombre"
      },
      {
        'data': "estado"
      },
      {
        'data': 'acciones'
      },
    ],
  });
  // Fin tabla medida
});

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
  const clave = document.getElementById("clave");
  const confirmar = document.getElementById("confirmar");
  const caja = document.getElementById("caja");
  if (usuario.value == "" || nombre.value == "" || caja.value == "") {
    Swal.fire({
      position: "top-end",
      icon: "error",
      title: "Todos los campos son obligatorios",
      showConfirmButton: false,
      timer: 3000
    });
  } else {
    const url = APP_URL + "Usuarios/registrar";
    const frm = document.getElementById("frmUsuario");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res == "si") {
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Usuario registrado con exito",
            showConfirmButton: false,
            timer: 3000
          })
          frm.reset();
          $("#nuevo_usuario").modal("hide");
          tblUsuarios.ajax.reload();
        } else if (res == "modificado") {
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Usuario registrado con exito",
            showConfirmButton: false,
            timer: 3000
          })
          $("#nuevo_usuario").modal("hide");
          tblUsuarios.ajax.reload();
        } else {
          Swal.fire({
            position: "top-end",
            icon: "error",
            title: res,
            showConfirmButton: false,
            timer: 3000
          });
        }
      }
    }
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
  Swal.fire({
    title: "¿Está seguro de eliminar?",
    text: "El usuario no se liminará permanente, solo se cambiará el estado a inactivo",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
    cancelButtonText: "No"
  }).then((result) => {
    if (result.isConfirmed) {
      const url = APP_URL + "Usuarios/eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res == "ok") {
            Swal.fire({
              title: "Mensaje",
              text: "Usuario eliminado con éxito.",
              icon: "success"
            });
            tblUsuarios.ajax.reload();
          } else {
            Swal.fire({
              title: "Mensaje",
              text: res,
              icon: "error"
            });
          }
        }
      };

    }
  });
}

// Ingresar usuarios
function btnReingresarUser(id) {
  Swal.fire({
    title: "¿Está seguro de reingresar?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
    cancelButtonText: "No"
  }).then((result) => {
    if (result.isConfirmed) {
      const url = APP_URL + "Usuarios/reingresar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res == "ok") {
            Swal.fire({
              title: "Mensaje",
              text: "Usuario reingresado con éxito.",
              icon: "success"
            });
            tblUsuarios.ajax.reload();
          } else {
            Swal.fire({
              title: "Mensaje",
              text: res,
              icon: "error"
            });
          }
        }
      };

    }
  });
}
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
  if (dni.value == "" || nombre.value == "" || telefono.value == "" || direccion.value == "") {
    Swal.fire({
      position: "top-end",
      icon: "error",
      title: "Todos los campos son obligatorios",
      showConfirmButton: false,
      timer: 3000
    });
  } else {
    const url = APP_URL + "Clientes/registrar";
    const frm = document.getElementById("frmCliente");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res == "si") {
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Cliente registrado con exito",
            showConfirmButton: false,
            timer: 3000
          })
          frm.reset();
          $("#nuevo_cliente").modal("hide");
          tblClientes.ajax.reload();
        } else if (res == "modificado") {
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Cliente registrado con exito",
            showConfirmButton: false,
            timer: 3000
          })
          $("#nuevo_cliente").modal("hide");
          tblClientes.ajax.reload();
        } else {
          Swal.fire({
            position: "top-end",
            icon: "error",
            title: res,
            showConfirmButton: false,
            timer: 3000
          });
        }
      }
    }
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
      document.getElementById("telefono").value = res.telefno;
      document.getElementById("direccion").value = res.direccion;
      $("#nuevo_cliente ").modal("show");
    }
  };
}

// Eliminar clientes
function btnEliminarCli(id) {
  Swal.fire({
    title: "¿Está seguro de eliminar?",
    text: "El cliente no se liminará permanente, solo se cambiará el estado a inactivo",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
    cancelButtonText: "No"
  }).then((result) => {
    if (result.isConfirmed) {
      const url = APP_URL + "Clientes/eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res == "ok") {
            Swal.fire({
              title: "Mensaje",
              text: "Cliente eliminado con éxito.",
              icon: "success"
            });
            tblClientes.ajax.reload();
          } else {
            Swal.fire({
              title: "Mensaje",
              text: res,
              icon: "error"
            });
          }
        }
      };

    }
  });
}

// Ingresar clientes
function btnReingresarCli(id) {
  Swal.fire({
    title: "¿Está seguro de reingresar?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
    cancelButtonText: "No"
  }).then((result) => {
    if (result.isConfirmed) {
      const url = APP_URL + "Clientes/reingresar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res == "ok") {
            Swal.fire({
              title: "Mensaje",
              text: "Cliente reingresado con éxito.",
              icon: "success"
            });
            tblClientes.ajax.reload();
          } else {
            Swal.fire({
              title: "Mensaje",
              text: res,
              icon: "error"
            });
          }
        }
      };

    }
  });
}
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
    Swal.fire({
      position: "top-end",
      icon: "error",
      title: "El Campo Nombre es obligatorio",
      showConfirmButton: false,
      timer: 3000
    });
  } else {
    const url = APP_URL + "Categorias/registrar";
    const frm = document.getElementById("frmCategoria");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res == "si") {
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Categoria registrada con exito",
            showConfirmButton: false,
            timer: 3000
          })
          frm.reset();
          $("#nueva_categoria").modal("hide");
          tblCategorias.ajax.reload();
        } else if (res == "modificado") {
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Categoria registrada con exito",
            showConfirmButton: false,
            timer: 3000
          })
          $("#nueva_categoria").modal("hide");
          tblCategorias.ajax.reload();
        } else {
          Swal.fire({
            position: "top-end",
            icon: "error",
            title: res,
            showConfirmButton: false,
            timer: 3000
          });
        }
      }
    }
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
  Swal.fire({
    title: "¿Está seguro de eliminar?",
    text: "La categoria no se liminará permanente, solo se cambiará el estado a inactivo",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
    cancelButtonText: "No"
  }).then((result) => {
    if (result.isConfirmed) {
      const url = APP_URL + "Categorias/eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res == "ok") {
            Swal.fire({
              title: "Mensaje",
              text: "Categorias eliminado con éxito.",
              icon: "success"
            });
            tblCategorias.ajax.reload();
          } else {
            Swal.fire({
              title: "Mensaje",
              text: res,
              icon: "error"
            });
          }
        }
      };

    }
  });
}

// Ingresar categorias
function btnReingresarCat(id) {
  Swal.fire({
    title: "¿Está seguro de reingresar?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
    cancelButtonText: "No"
  }).then((result) => {
    if (result.isConfirmed) {
      const url = APP_URL + "Categorias/reingresar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res == "ok") {
            Swal.fire({
              title: "Mensaje",
              text: "Categorias reingresado con éxito.",
              icon: "success"
            });
            tblCategorias.ajax.reload();
          } else {
            Swal.fire({
              title: "Mensaje",
              text: res,
              icon: "error"
            });
          }
        }
      };
    }
  });
}
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
    Swal.fire({
      position: "top-end",
      icon: "error",
      title: "El Campo Caja es obligatorio",
      showConfirmButton: false,
      timer: 3000
    });
  } else {
    const url = APP_URL + "Caja/registrar";
    const frm = document.getElementById("frmCaja");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res == "si") {
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Caja registrada con exito",
            showConfirmButton: false,
            timer: 3000
          })
          frm.reset();
          $("#nueva_caja").modal("hide");
          tblCajas.ajax.reload();
        } else if (res == "modificado") {
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Caja registrada con exito",
            showConfirmButton: false,
            timer: 3000
          })
          $("#nueva_caja").modal("hide");
          tblCajas.ajax.reload();
        } else {
          Swal.fire({
            position: "top-end",
            icon: "error",
            title: res,
            showConfirmButton: false,
            timer: 3000
          });
        }
      }
    }
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
  Swal.fire({
    title: "¿Está seguro de eliminar?",
    text: "La caja no se liminará permanente, solo se cambiará el estado a inactivo",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
    cancelButtonText: "No"
  }).then((result) => {
    if (result.isConfirmed) {
      const url = APP_URL + "Caja/eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res == "ok") {
            Swal.fire({
              title: "Mensaje",
              text: "Caja eliminada con éxito.",
              icon: "success"
            });
            tblCajas.ajax.reload();
          } else {
            Swal.fire({
              title: "Mensaje",
              text: res,
              icon: "error"
            });
          }
        }
      };

    }
  });
}

// Ingresar caja
function btnReingresarCaj(id) {
  Swal.fire({
    title: "¿Está seguro de reingresar?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
    cancelButtonText: "No"
  }).then((result) => {
    if (result.isConfirmed) {
      const url = APP_URL + "Caja/reingresar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res == "ok") {
            Swal.fire({
              title: "Mensaje",
              text: "Caja reingresado con éxito.",
              icon: "success"
            });
            tblCajas.ajax.reload();
          } else {
            Swal.fire({
              title: "Mensaje",
              text: res,
              icon: "error"
            });
          }
        }
      };
    }
  });
}
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
    Swal.fire({
      position: "top-end",
      icon: "error",
      title: "El Campo Nombre es obligatorio",
      showConfirmButton: false,
      timer: 3000
    });
  } else {
    const url = APP_URL + "Medidas/registrar";
    const frm = document.getElementById("frmMedida");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res == "si") {
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Medida registrada con exito",
            showConfirmButton: false,
            timer: 3000
          })
          frm.reset();
          $("#nueva_medida").modal("hide");
          tblMedidas.ajax.reload();
        } else if (res == "modificado") {
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Medida registrada con exito",
            showConfirmButton: false,
            timer: 3000
          })
          $("#nueva_medida").modal("hide");
          tblMedidas.ajax.reload();
        } else {
          Swal.fire({
            position: "top-end",
            icon: "error",
            title: res,
            showConfirmButton: false,
            timer: 3000
          });
        }
      }
    }
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
  Swal.fire({
    title: "¿Está seguro de eliminar?",
    text: "La medida no se liminará permanente, solo se cambiará el estado a inactivo",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
    cancelButtonText: "No"
  }).then((result) => {
    if (result.isConfirmed) {
      const url = APP_URL + "Medidas/eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res == "ok") {
            Swal.fire({
              title: "Mensaje",
              text: "Medidas eliminado con éxito.",
              icon: "success"
            });
            tblMedidas.ajax.reload();
          } else {
            Swal.fire({
              title: "Mensaje",
              text: res,
              icon: "error"
            });
          }
        }
      };

    }
  });
}

// Ingresar medida
function btnReingresarMed(id) {
  Swal.fire({
    title: "¿Está seguro de reingresar?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
    cancelButtonText: "No"
  }).then((result) => {
    if (result.isConfirmed) {
      const url = APP_URL + "Medidas/reingresar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res == "ok") {
            Swal.fire({
              title: "Mensaje",
              text: "Medidas reingresado con éxito.",
              icon: "success"
            });
            tblMedidas.ajax.reload();
          } else {
            Swal.fire({
              title: "Mensaje",
              text: res,
              icon: "error"
            });
          }
        }
      };
    }
  });
}
// Fin tabla medida


// Agregar Usuarios
function frmProducto() {
  document.getElementById("title").innerHTML = "Nuevo Producto";
  document.getElementById("btnAccion").innerHTML = "Agregar";
  document.getElementById("frmProducto").reset();
  $("#nuevo_producto").modal("show");
  document.getElementById("id").value = "";
}

// Registrar usuarios
function registrarPro(e) {
  e.preventDefault();
  const codigo = document.getElementById("codigo");
  const nombre = document.getElementById("nombre");
  const precio_compra = document.getElementById("precio_compra");
  const precio_venta = document.getElementById("precio_venta");
  const id_medida = document.getElementById("medida");
  const id_cat = document.getElementById("categoria");
  if (codigo.value == "" || nombre.value == "" || precio_compra.value == "" || precio_venta.value == "") {
    Swal.fire({
      position: "top-end",
      icon: "error",
      title: "Todos los campos son obligatorios",
      showConfirmButton: false,
      timer: 3000
    });
  } else {
    const url = APP_URL + "Productos/registrar";
    const frm = document.getElementById("frmProducto");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res == "si") {
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Producto registrado con exito",
            showConfirmButton: false,
            timer: 3000
          })
          frm.reset();
          $("#nuevo_producto").modal("hide");
          //tblUsuarios.ajax.reload();
        } else if (res == "modificado") {
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Producto registrado con exito",
            showConfirmButton: false,
            timer: 3000
          })
          $("#nuevo_producto").modal("hide");
          //tblUsuarios.ajax.reload();
        } else {
          Swal.fire({
            position: "top-end",
            icon: "error",
            title: res,
            showConfirmButton: false,
            timer: 3000
          });
        }
      }
    }
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
  Swal.fire({
    title: "¿Está seguro de eliminar?",
    text: "El usuario no se liminará permanente, solo se cambiará el estado a inactivo",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
    cancelButtonText: "No"
  }).then((result) => {
    if (result.isConfirmed) {
      const url = APP_URL + "Usuarios/eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res == "ok") {
            Swal.fire({
              title: "Mensaje",
              text: "Usuario eliminado con éxito.",
              icon: "success"
            });
            tblUsuarios.ajax.reload();
          } else {
            Swal.fire({
              title: "Mensaje",
              text: res,
              icon: "error"
            });
          }
        }
      };

    }
  });
}

// Ingresar usuarios
function btnReingresarUser(id) {
  Swal.fire({
    title: "¿Está seguro de reingresar?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
    cancelButtonText: "No"
  }).then((result) => {
    if (result.isConfirmed) {
      const url = APP_URL + "Usuarios/reingresar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res == "ok") {
            Swal.fire({
              title: "Mensaje",
              text: "Usuario reingresado con éxito.",
              icon: "success"
            });
            tblUsuarios.ajax.reload();
          } else {
            Swal.fire({
              title: "Mensaje",
              text: res,
              icon: "error"
            });
          }
        }
      };

    }
  });
}
// Fin usuarios
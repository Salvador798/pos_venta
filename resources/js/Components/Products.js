let tblProductos;

/** Función para inicializar DataTable */
export async function inicializarTablaProductos() {
  try {
    const response = await fetch(`${APP_URL}products/list`, {
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
    tblProductos = $("#tblProductos").DataTable({
      data: data, // Use the fetched data here
      columns: [
        { data: "codigo", className: "text-center" },
        { data: "descripcion", className: "text-center" },
        { data: "imagen", className: "text-center" },
        {
          data: "precio_venta",
          className: "text-center",
          render: function (data, type, row) {
            if (type === "display") {
              const formattedPrice = numberFormat(data, 2, ",", ".");
              return `Bs ${formattedPrice}`;
            }
            return data;
          },
        },
        { data: "iva", className: "text-center" },
        { data: "cantidad", className: "text-center" },
        { data: "estado", className: "text-center" },
        { data: "acciones", className: "text-center" },
      ],
      order: [
        [6, "asc"],
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

export function frmProducto() {
  document.getElementById("title").innerHTML = "Nuevo Producto";
  document.getElementById("btnAccion").innerHTML = "Agregar";
  document.getElementById("frmProducto").reset();
  $("#nuevo_producto").modal("show");
  document.getElementById("id").value = "";
  deleteImg();
}

export async function registerPro(e) {
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
    alerts("Por favor, completa todos los campos obligatorios.", "warning");
    return;
  }

  try {
    const response = await fetch(`${APP_URL}products`, {
      method: "POST",
      body: new FormData(document.getElementById("frmProducto")),
    });

    if (!response.ok) {
      throw new Error("Error en la respuesta de la red");
    }

    // Actualiza la tabla de categorias
    const res = await response.json();
    alerts(res.msg, res.icon);
    $("#nuevo_producto").modal("hide");

    // Actualiza la tabla de productos
    const responseList = await fetch(`${APP_URL}products/list`);
    const productos = await responseList.json();
    tblProductos.clear().rows.add(productos).draw();
  } catch (error) {
    console.error("Error en la solicitud:", error);
    alerts("Ocurrió un error inesperado.", "error");
  }
}

export async function editPro(id) {
  document.getElementById("title").innerHTML = "Actualizar Producto";
  document.getElementById("btnAccion").innerHTML = "Modificar";

  try {
    const response = await fetch(`${APP_URL}products/${id}`, {
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
    document.getElementById("codigo").value = res.codigo;
    document.getElementById("nombre").value = res.descripcion;
    document.getElementById("precio_compra").value = res.precio_compra;
    document.getElementById("precio_venta").value = res.precio_venta;
    document.getElementById("iva").value = res.iva;
    document.getElementById("medida").value = res.id_medida;
    document.getElementById("categoria").value = res.id_categoria;
    document.getElementById("img-preview").src =
      APP_URL + "public/img/" + res.foto;
    document.getElementById("icon-cerrar").innerHTML = `
          <button class="btn btn-danger" onclick="deleteImg()">
          <i class="fas fa-times"></i></button>`;
    document.getElementById("icon-image").classList.add("d-none");
    document.getElementById("foto_actual").value = res.foto;
    document.getElementById("foto_delete").value = res.foto;

    $("#nuevo_producto").modal("show");
  } catch (error) {
    console.error("Error en la solicitud:", error);
    alerts("Ocurrió un error al intentar cargar el producto.");
  }
}

// foto productos
export function preview(e) {
  const url = e.target.files[0];
  const urlTmp = URL.createObjectURL(url);
  document.getElementById("img-preview").src = urlTmp;
  document.getElementById("icon-image").classList.add("d-none");
  document.getElementById("icon-cerrar").innerHTML = `
    <button class="btn btn-danger" onclick="deleteImg()"><i class="fas fa-times"></i></button>
    ${url["name"]}`;
}

// eliminar foto producto
export function deleteImg() {
  document.getElementById("icon-cerrar").innerHTML = "";
  document.getElementById("icon-image").classList.remove("d-none");
  document.getElementById("img-preview").src = "";
  document.getElementById("imagen").value = "";
  document.getElementById("foto_delete").value = "";
}

export async function desactivePro(id) {
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
        const response = await fetch(`${APP_URL}products/desactive/${id}`, {
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

        // Actualiza la tabla de productos
        const responseList = await fetch(`${APP_URL}products/list`);
        const productos = await responseList.json();
        tblProductos.clear().rows.add(productos).draw();
      } catch (error) {
        console.error("Error:", error);
        alerts("Error al eliminar el usuario", "danger");
      }
    }
  });
}

export async function activePro(id) {
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
        const response = await fetch(`${APP_URL}products/active/${id}`, {
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

        // Actualiza la tabla de productos
        const responseList = await fetch(`${APP_URL}products/list`);
        const productos = await responseList.json();
        tblProductos.clear().rows.add(productos).draw();
      } catch (error) {
        console.error("Error:", error);
        alerts("Error al activar la categoria", "danger");
      }
    }
  });
}

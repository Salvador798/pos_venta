let t_h_c, t_h_v;

export async function inicializarTablaShoppingHistory() {
  try {
    const response = await fetch(`${APP_URL}shopping/list_historial`, {
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
    t_h_c = $("#t_historial_c").DataTable({
      data: data, // Use the fetched data here
      columns: [
        {
          data: "total",
          className: "text-center",
          render: function (data, type, row) {
            if (type === "display") {
              const formattedPrice = numberFormat(data, 2, ",", ".");
              return `Bs ${formattedPrice}`;
            }
            return data;
          },
        },
        { data: "fecha", className: "text-center" },
        { data: "estado" },
        { data: "acciones" },
      ],
      order: [
        [2, "desc"],
        [1, "desc"],
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

export async function inicializarTablaSaleHistory() {
  try {
    const response = await fetch(`${APP_URL}shopping/listHistorialSale`, {
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
    t_h_v = $("#t_historial_v").DataTable({
      data: data, // Use the fetched data here
      columns: [
        {
          data: "total",
          className: "text-center",
          render: function (data, type, row) {
            if (type === "display") {
              const formattedPrice = numberFormat(data, 2, ",", ".");
              return `Bs ${formattedPrice}`;
            }
            return data;
          },
        },
        { data: "fecha", className: "text-center" },
        { data: "estado" },
        { data: "acciones" },
      ],
      order: [
        [2, "desc"],
        [1, "desc"],
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

// Historial ventas
// t_h_v = $("#t_historial_v").DataTable({
//   ajax: {
//     url: APP_URL + "Compras/listar_historial_venta",
//     dataSrc: "",
//   },
//   columns: [
//     { data: "nombre" },
//     {
//       data: "total",
//       render: function (data, type, row) {
//         if (type === "display") {
//           const formattedPrice = numberFormat(data, 2, ",", ".");
//           return `Bs ${formattedPrice}`;
//         }
//         return data;
//       },
//     },
//     { data: "fecha" },
//     { data: "acciones" },
//   ],
//   language: {
//     url: "https://cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
//   },
//   dom:
//     "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
//     "<'row'<'col-sm-12'tr>>" +
//     "<'row'<'col-sm-5'i><'col-sm-7'p>>",
//   buttons: [
//     {
//       //Botón para Excel
//       extend: "excelHtml5",
//       footer: true,
//       title: "Archivo",
//       filename: "Export_File",

//       //Aquí es donde generas el botón personalizado
//       text: '<span class="badge badge-success"><i class="fas fa-file-excel"></i></span>',
//     },
//     //Botón para PDF
//     {
//       extend: "pdfHtml5",
//       download: "open",
//       footer: true,
//       title: "Reporte de usuarios",
//       filename: "Reporte de usuarios",
//       text: '<span class="badge  badge-danger"><i class="fas fa-file-pdf"></i></span>',
//       exportOptions: {
//         columns: [0, ":visible"],
//       },
//     },
//     //Botón para copiar
//     {
//       extend: "copyHtml5",
//       footer: true,
//       title: "Reporte de usuarios",
//       filename: "Reporte de usuarios",
//       text: '<span class="badge  badge-primary"><i class="fas fa-copy"></i></span>',
//       exportOptions: {
//         columns: [0, ":visible"],
//       },
//     },
//     //Botón para print
//     {
//       extend: "print",
//       footer: true,
//       filename: "Export_File_print",
//       text: '<span class="badge badge-light"><i class="fas fa-print"></i></span>',
//     },
//     //Botón para cvs
//     {
//       extend: "csvHtml5",
//       footer: true,
//       filename: "Export_File_csv",
//       text: '<span class="badge  badge-success"><i class="fas fa-file-csv"></i></span>',
//     },
//     {
//       extend: "colvis",
//       text: '<span class="badge  badge-info"><i class="fas fa-columns"></i></span>',
//       postfixButtons: ["colvisRestore"],
//     },
//   ],
// });
// Fin tabla medida

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

// Buscar Producto
export function buscarCodigo(e) {
  e.preventDefault();
  const cod = document.getElementById("codigo").value;
  if (cod != "") {
    if (e.which == 13) {
      const url = APP_URL + "shopping/searchCode/" + cod;
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
export function buscarCodigoVenta(e) {
  e.preventDefault();
  const cod = document.getElementById("codigo").value;
  if (cod != "") {
    if (e.which == 13) {
      const url = APP_URL + "shopping/searchCode/" + cod;
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
export function calcularPrecio(e) {
  e.preventDefault();
  const cant = document.getElementById("cantidad").value;
  const precio = document.getElementById("precio").value;
  document.getElementById("sub_total").value = precio * cant;
  if (e.which == 13) {
    if (cant > 0) {
      const url = APP_URL + "shopping/getInto";
      const frm = document.getElementById("frmCompra");
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(new FormData(frm));
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alerts(res.msg, res.icon);
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
export function calcularPrecioVenta(e) {
  e.preventDefault();
  const cant = document.getElementById("cantidad").value;
  const precio = document.getElementById("precio").value;
  document.getElementById("sub_total").value = precio * cant;
  if (e.which == 13) {
    if (cant > 0) {
      const url = APP_URL + "shopping/enterSale";
      const frm = document.getElementById("frmVenta");
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(new FormData(frm));
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alerts(res.msg, res.icon);
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

export function cargarDetalle() {
  const url = APP_URL + "shopping/list/detalle";
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      let html = "";
      res.detalle.forEach((row) => {
        html += `
          <tr>
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
export function cargarDetalleVenta() {
  const url = APP_URL + "shopping/list/detalle_temp";
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      let html = "";
      res.detalle.forEach((row) => {
        html += `
          <tr>
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
export function calcularDescuento(e, id) {
  e.preventDefault();
  if (e.target.value == "") {
    alerts("Ingrese el Descuento", "warning");
  } else {
    if (e.which == 13) {
      const url =
        APP_URL + "shopping/calculateDiscount/" + id + "/" + e.target.value;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alerts(res.msg, res.icono);
          cargarDetalleVenta();
        }
      };
    }
  }
}

// button eliminar compra de producto
export function deleteDetalle(id, accion) {
  let url;
  if (accion == 1) {
    url = APP_URL + "shopping/delete/" + id;
  } else {
    url = APP_URL + "shopping/deleteSale/" + id;
  }
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      alerts(res.msg, res.icon);
      if (accion == 1) {
        cargarDetalle();
      } else {
        cargarDetalleVenta();
      }
    }
  };
}

// Generar compra
export function procesar(accion) {
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
    url = APP_URL + "shopping/registerPurchase";
  } else {
    const id_cliente = document.getElementById("cliente").value;
    url = APP_URL + "shopping/registerSale/" + id_cliente;
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
          ruta = APP_URL + "shopping/generatePDF/" + res.id_compra;
        } else {
          ruta = APP_URL + "shopping/generatePdfSale/" + res.id_venta;
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

// Generar compra
export async function btnAnularC(id) {
  const result = await Swal.fire({
    title: "¿Está seguro de anular la Compra?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
    cancelButtonText: "No",
  });

  if (result.isConfirmed) {
    try {
      const url = `${APP_URL}shopping/anularShopping/${id}`;
      const response = await fetch(url, { method: "POST" });

      if (response.ok) {
        const res = await response.json();
        alerts(res.msg, res.icon);

        // Actualiza la tabla de shopping
        const responseList = await fetch(`${APP_URL}shopping/list_historial`);
        const shopping = await responseList.json();
        t_h_c.clear().rows.add(shopping).draw();
      } else {
        console.error("Error al anular la compra:", response.statusText);
      }
    } catch (error) {
      console.error("Error en la solicitud:", error);
    }
  }
}

// Anular Venta
// Anular Venta
export async function btnAnularV(id) {
  const result = await Swal.fire({
    title: "¿Está seguro de anular la Venta?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
    cancelButtonText: "No",
  });

  if (result.isConfirmed) {
    try {
      const url = `${APP_URL}shopping/anularSale/${id}`;
      const response = await fetch(url, { method: "POST" });

      if (response.ok) {
        const res = await response.json();
        alerts(res.msg, res.icon);

        // Actualiza la tabla de sale
        const responseList = await fetch(
          `${APP_URL}shopping/listHistorialSale`
        );
        const saleData = await responseList.json(); // Cambia 'sale' a 'saleData'
        t_h_v.clear().rows.add(saleData).draw(); // Usa 'saleData' en lugar de 'sale'
      } else {
        console.error("Error al anular la compra:", response.statusText);
      }
    } catch (error) {
      console.error("Error en la solicitud:", error);
    }
  }
}

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

  if (!monto_inicial) {
    alerts("Error: No se encontró el campo de monto inicial", "error");
    return;
  }

  if (monto_inicial.value == "" || monto_inicial.value.trim() == "") {
    alerts("El monto inicial es obligatorio", "warning");
    return;
  }

  // Validar que el monto sea numérico
  const montoValue = monto_inicial.value.replace(/,/g, "");
  if (isNaN(montoValue) || parseFloat(montoValue) < 0) {
    alerts(
      "El monto inicial debe ser un número válido mayor o igual a cero",
      "warning"
    );
    return;
  }

  try {
    const formData = new FormData(document.getElementById("frmAbrirCaja"));

    const response = await fetch(`${APP_URL}arqueo`, {
      method: "POST",
      body: formData,
    });

    // Verificar que la respuesta sea JSON válido
    const contentType = response.headers.get("content-type") || "";

    if (!response.ok) {
      const errorText = await response.text();
      console.error("Error HTTP:", response.status);
      console.error("Respuesta del servidor:", errorText);
      alerts(
        `Error en la respuesta del servidor (${response.status})`,
        "error"
      );
      return;
    }

    // Intentar parsear como JSON
    let res;
    try {
      if (!contentType.includes("application/json")) {
        // Si no es JSON, leer como texto para debugging
        const text = await response.text();
        console.error("Respuesta no es JSON. Content-Type:", contentType);
        console.error("Respuesta recibida:", text);
        alerts(
          "El servidor devolvió una respuesta no válida. Revise la consola para más detalles.",
          "error"
        );
        return;
      }
      res = await response.json();
    } catch (parseError) {
      // Si falla el parseo, clonar la respuesta y leer como texto
      const responseClone = response.clone();
      const text = await responseClone.text();
      console.error("Error al parsear JSON:", parseError);
      console.error("Texto recibido:", text);
      alerts("Error al procesar la respuesta del servidor", "error");
      return;
    }

    if (res.msg && res.icon) {
      $("#abrir_caja").modal("hide");
      alerts(res.msg, res.icon);

      // Actualiza la tabla de arqueo solo si fue exitoso
      if (res.icon === "success") {
        try {
          const responseList = await fetch(`${APP_URL}arqueo/listArqueo`);
          if (responseList.ok) {
            const arqueo = await responseList.json();
            if (t_arqueo) {
              t_arqueo.clear().rows.add(arqueo).draw();
            }
          }
        } catch (error) {
          console.error("Error al actualizar la tabla:", error);
        }
      }
    } else {
      console.error("Respuesta inválida del servidor:", res);
      alerts("La respuesta del servidor no tiene el formato esperado", "error");
    }
  } catch (error) {
    console.error("Error completo:", error);
    alerts("Error al abrir la caja. Por favor, intente nuevamente.", "error");
  }
}

export async function cerrarCaja() {
  try {
    const response = await fetch(`${APP_URL}arqueo/getSales`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });

    if (!response.ok) {
      throw new Error("Error en la respuesta de la red");
    }

    // Verificar que la respuesta sea JSON válido
    const contentType = response.headers.get("content-type");
    if (!contentType || !contentType.includes("application/json")) {
      const text = await response.text();
      console.error("Respuesta no es JSON:", text);
      throw new Error("El servidor devolvió una respuesta no válida");
    }

    const res = await response.json();

    // Validar que los datos necesarios existan (pero permitir valores en 0)
    if (!res.monto_total || !res.total_ventas || !res.inicial) {
      console.error("Datos incompletos en la respuesta:", res);
      alerts(
        "No se encontraron datos de la caja. Asegúrese de tener una caja abierta.",
        "error"
      );
      return;
    }

    // Validar que exista una caja abierta (inicial debe tener id)
    if (!res.inicial.id || res.inicial.id === "") {
      alerts(
        "No hay una caja abierta. Debe abrir una caja primero.",
        "warning"
      );
      return;
    }

    document.getElementById("monto_final").value = res.monto_total.total || 0;
    document.getElementById("total_ventas").value = res.total_ventas.total || 0;
    document.getElementById("monto_inicial").value =
      res.inicial.monto_inicial || 0;
    document.getElementById("monto_general").value = res.monto_general || 0;
    document.getElementById("id").value = res.inicial.id || "";
    document.getElementById("ocultar_campos").classList.remove("d-none");
    document.getElementById("btnAccion").textContent = "Cerrar Caja";
    $("#abrir_caja").modal("show");
  } catch (error) {
    console.error("Error:", error);
    alerts("Error al obtener los datos de ventas", "error");
  }
}

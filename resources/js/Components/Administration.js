// Verificar si el elemento con ID "stockMinimo" existe y llamar a las funciones
if (document.getElementById("stockMinimo")) {
  reportStock();
  productsSold();
}

// Función para obtener el reporte de stock
export async function reportStock() {
  const url = `${APP_URL}administration/reportStock`;

  try {
    const response = await fetch(url, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });

    if (!response.ok) {
      throw new Error("Error al obtener el reporte de stock");
    }

    const res = await response.json();
    let nombre = [];
    let cantidad = [];

    for (let i = 0; i < res.length; i++) {
      nombre.push(res[i]["descripcion"]);
      cantidad.push(res[i]["cantidad"]);
    }

    const ctx = document.getElementById("stockMinimo");
    const myPieChart = new Chart(ctx, {
      type: "pie",
      data: {
        labels: nombre,
        datasets: [
          {
            data: cantidad,
            backgroundColor: ["#007bff", "#dc3545", "#ffc107", "#28a745"],
          },
        ],
      },
    });
  } catch (error) {
    console.error("Error:", error);
    alertas("Error al cargar el reporte de stock", "danger");
  }
}

// Función para obtener productos más vendidos
export async function productsSold() {
  const url = `${APP_URL}administration/productsSold`;

  try {
    const response = await fetch(url, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });

    if (!response.ok) {
      throw new Error("Error al obtener los productos vendidos");
    }

    const res = await response.json();
    let nombre = [];
    let cantidad = [];

    for (let i = 0; i < res.length; i++) {
      nombre.push(res[i]["descripcion"]);
      cantidad.push(res[i]["total"]);
    }

    const ctx = document.getElementById("productsSold");
    const myPieChart = new Chart(ctx, {
      type: "doughnut",
      data: {
        labels: nombre,
        datasets: [
          {
            data: cantidad,
            backgroundColor: ["#007bff", "#dc3545", "#ffc107", "#28a745"],
          },
        ],
      },
    });
  } catch (error) {
    console.error("Error:", error);
    alertas("Error al cargar los productos vendidos", "danger");
  }
}

// Función para modificar la empresa
export async function modificarEmpresa() {
  const frm = document.getElementById("frmEmpresa");
  const url = `${APP_URL}administration/modify`;

  try {
    const response = await fetch(url, {
      method: "POST",
      body: new FormData(frm),
    });

    if (!response.ok) {
      throw new Error("Error al modificar la empresa");
    }

    const res = await response.json();
    if (res === "ok") {
      alerts("Datos de la empresa actualizados", "success");
    }
  } catch (error) {
    console.error("Error:", error);
    alerts("Error al modificar la empresa", "danger");
  }
}

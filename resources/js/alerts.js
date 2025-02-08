// Alertas
function alerts(mensaje, icon) {
  let color;

  // Define el color según el tipo de icono
  switch (icon) {
    case "success":
      color = "#28a745"; // Verde para éxito
      break;
    case "error":
      color = "#dc3545"; // Rojo para error
      break;
    case "warning":
      color = "#ffc107"; // Amarillo para advertencia
      break;
    case "info":
      color = "#17a2b8"; // Azul para información
      break;
    default:
      color = "#6c757d"; // Gris para otros casos
  }

  Swal.fire({
    position: "top-end",
    icon: icon,
    title: mensaje,
    toast: true,
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    background: color, // Establece el color de fondo
    customClass: {
      title: "alert-title", // Clase personalizada para el título
    },
    showClass: {
      popup: "animate__animated animate__fadeInDown", // Animación al aparecer
    },
    hideClass: {
      popup: "animate__animated animate__fadeOutUp", // Animación al desaparecer
    },
  });

  // Aplica el estilo CSS para el texto
  const style = document.createElement("style");
  style.innerHTML = `
      .alert-title {
        color: white !important; // Asegura que el texto sea blanco
      }
    `;
  document.head.appendChild(style);
}

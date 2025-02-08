document.addEventListener("DOMContentLoaded", function () {
  configurarFechas("min", "hasta");
});

function configurarFechas(desdeId, hastaId) {
  const desdeInput = document.getElementById(desdeId);
  const hastaInput = document.getElementById(hastaId);

  if (!desdeInput || !hastaInput) {
    console.error("Uno o ambos elementos no se encontraron en el DOM.");
    return;
  }

  // Obtener la fecha actual
  const hoy = new Date();
  const fechaActual = hoy.toISOString().split("T")[0]; // Formato 'YYYY-MM-DD'

  // Establecer el valor máximo para "desde" como la fecha actual
  desdeInput.setAttribute("max", fechaActual);

  // Calcular el día siguiente
  const diaSiguiente = new Date(hoy);
  diaSiguiente.setDate(hoy.getDate() + 1);
  const fechaDiaSiguiente = diaSiguiente.toISOString().split("T")[0];

  // Establecer el valor máximo para "hasta" como el día siguiente
  hastaInput.setAttribute("max", fechaDiaSiguiente);

  // Escuchar cambios en el campo "desde"
  desdeInput.addEventListener("change", function () {
    const desdeFecha = new Date(desdeInput.value); // Convertir la fecha seleccionada a un objeto Date
    if (!isNaN(desdeFecha)) {
      // Verificar que la fecha sea válida
      // Si la fecha seleccionada es posterior a hoy, restablecerla a hoy
      if (desdeFecha > hoy) {
        desdeInput.value = fechaActual;
      }

      // Ajustar la fecha "hasta" al día siguiente
      desdeFecha.setDate(desdeFecha.getDate() + 1);
      const nuevaFecha = desdeFecha.toISOString().split("T")[0]; // Formatear la fecha a 'YYYY-MM-DD'
      hastaInput.value = nuevaFecha; // Establecer la nueva fecha en el campo "hasta"
    }
  });

  // Inicializar la fecha "hasta" como el día siguiente a la fecha actual
  hastaInput.value = fechaDiaSiguiente;
}

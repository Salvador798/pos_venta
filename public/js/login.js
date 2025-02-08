async function frmLogin(e) {
  e.preventDefault();
  const usuario = document.getElementById("usuario");
  const clave = document.getElementById("clave");

  if (usuario.value === "") {
    clave.classList.remove("is-invalid");
    usuario.classList.add("is-invalid");
    usuario.focus();
  } else if (clave.value === "") {
    usuario.classList.remove("is-invalid");
    clave.classList.add("is-invalid");
    clave.focus();
  } else {
    const url = APP_URL + "login"; // Corrected URL
    const frm = document.getElementById("frmLogin");

    try {
      const response = await fetch(url, {
        method: "POST",
        body: new FormData(frm),
      });

      if (response.ok) {
        const res = await response.json();
        console.log(res); // Log the response
        if (res === "ok") {
          window.location = APP_URL + "administration/home";
        } else {
          document.getElementById("alerta").classList.remove("d-none");
          document.getElementById("alerta").innerHTML = res;
        }
      } else {
        throw new Error("Network response was not ok.");
      }
    } catch (error) {
      console.error("Error:", error);
      document.getElementById("alerta").classList.remove("d-none");
      document.getElementById("alerta").innerHTML =
        "An error occurred. Please try again.";
    }
  }
}

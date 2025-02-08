import {
  productsSold,
  reportStock,
  modificarEmpresa,
} from "./Components/Administration.js";
import {
  frmUsuario,
  registerUser,
  inicializarTablaUsuarios,
  editUser,
  desactiveUser,
  activeUser,
  registrarPermisos,
  frmCambiarPass,
} from "./Components/Users.js";
import {
  frmCategoria,
  registerCat,
  inicializarTablaCategorias,
  editCat,
  desactiveCat,
  activeCat,
} from "./Components/Categories.js";
import {
  frmMedida,
  registerExtends,
  inicializarTablaMedidas,
  editExt,
  desactiveExt,
  activeExt,
} from "./Components/Extends.js";
import {
  frmProducto,
  registerPro,
  inicializarTablaProductos,
  editPro,
  preview,
  deleteImg,
  desactivePro,
  activePro,
} from "./Components/Products.js";
import {
  frmCliente,
  registerCli,
  inicializarTablaClientes,
  edditCli,
  desactiveCli,
  activeCli,
} from "./Components/Clients.js";
import {
  frmCaja,
  registerCaj,
  inicializarTablaCajas,
  editCaj,
  desactiveCaj,
  activeCaj,
} from "./Components/Boxes.js";
import {
  buscarCodigo,
  calcularPrecio,
  cargarDetalle,
  deleteDetalle,
  procesar,
  inicializarTablaShoppingHistory,
  btnAnularC,
  buscarCodigoVenta,
  calcularPrecioVenta,
  cargarDetalleVenta,
  calcularDescuento,
  inicializarTablaSaleHistory,
  btnAnularV,
} from "./Components/Shopping.js";
import {
  arqueoCaja,
  abrirArqueo,
  inicializarTablaArqueo,
  cerrarCaja,
} from "./Components/Arqueos.js";

// Llamar a la función para inicializar la tabla de usuarios al cargar el documento
document.addEventListener("DOMContentLoaded", function () {
  inicializarTablaUsuarios();
  inicializarTablaCategorias();
  inicializarTablaMedidas();
  inicializarTablaProductos();
  inicializarTablaClientes();
  inicializarTablaCajas();
  inicializarTablaShoppingHistory();
  inicializarTablaSaleHistory();
  inicializarTablaArqueo();
});

// Users
window.frmUsuario = frmUsuario;
window.registerUser = registerUser;
arqueoCaja;
arqueoCaja;
window.editUser = editUser;
window.desactiveUser = desactiveUser;
window.activeUser = activeUser;
window.registrarPermisos = registrarPermisos;
window.frmCambiarPass = frmCambiarPass;

// Administration
window.productsSold = productsSold;
window.reportStock = reportStock;
window.modificarEmpresa = modificarEmpresa;

// Categories
window.frmCategoria = frmCategoria;
window.registerCat = registerCat;
window.editCat = editCat;
window.desactiveCat = desactiveCat;
window.activeCat = activeCat;

// Measures
window.frmMedida = frmMedida;
window.registerExtends = registerExtends;
window.editExt = editExt;
window.desactiveExt = desactiveExt;
window.activeExt = activeExt;

// Products
window.frmProducto = frmProducto;
window.registerPro = registerPro;
window.editPro = editPro;
window.preview = preview;
window.deleteImg = deleteImg;
window.desactivePro = desactivePro;
window.activePro = activePro;

// Clients
window.frmCliente = frmCliente;
window.registerCli = registerCli;
window.edditCli = edditCli;
window.desactiveCli = desactiveCli;
window.activeCli = activeCli;

// Boxes
window.frmCaja = frmCaja;
window.registerCaj = registerCaj;
window.editCaj = editCaj;
window.desactiveCaj = desactiveCaj;
window.activeCaj = activeCaj;

// Shopping
window.buscarCodigo = buscarCodigo;
window.calcularPrecio = calcularPrecio;
window.cargarDetalle = cargarDetalle;
window.deleteDetalle = deleteDetalle;
window.procesar = procesar;
window.btnAnularC = btnAnularC;

// Sales
window.buscarCodigoVenta = buscarCodigoVenta;
window.calcularPrecioVenta = calcularPrecioVenta;
window.cargarDetalleVenta = cargarDetalleVenta;
window.calcularDescuento = calcularDescuento;

// Arqueo
window.arqueoCaja = arqueoCaja;
window.abrirArqueo = abrirArqueo;
window.cerrarCaja = cerrarCaja;

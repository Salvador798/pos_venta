<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard</title>
    <link href="<?php echo APP_URL; ?>Assets/css/styles.css" rel="stylesheet" />
    <link href="<?php echo APP_URL ?>Assets/css/estilos.css" rel="stylesheet" />
    <link href="<?php echo APP_URL; ?>Assets/DataTables/datatables.min.css" rel="stylesheet" />
    <link href="<?php echo APP_URL; ?>Assets/css/select2.min.css" rel="stylesheet" />
    <script src="<?php echo APP_URL; ?>Assets/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="<?php echo APP_URL; ?>Administracion/home">Pos Venta</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!" data-toggle="modal" data-target="#cambiarPass">Perfil</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="<?php echo APP_URL; ?>Usuarios/salir">Cerrar Sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-cogs fa-2x"></i></div>
                            Administración
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?php echo APP_URL; ?>Usuarios"><i class="fas fa-user mr-2 fa-2x"></i> Usuarios</a>
                                <a class="nav-link" href="<?php echo APP_URL; ?>Administracion"><i class="fas fa-tools mr-2 fa-2x"></i> Configuración</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCajas" aria-expanded="false" aria-controls="collapseCajas">
                            <div class="sb-nav-link-icon"><i class="fas fa-box fa-2x"></i></div>
                            Cajas
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseCajas" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?php echo APP_URL; ?>Caja"><i class="fas fa-box mr-2 fa-2x"></i> Cajas</a>
                                <a class="nav-link" href="<?php echo APP_URL; ?>Caja/arqueo"><i class="fas fa-tools mr-2 fa-2x"></i> Arqueo de Caja</a>
                            </nav>
                        </div>
                        <a class="nav-link" href="<?php echo APP_URL; ?>Clientes">
                            <div class="sb-nav-link-icon"><i class="fas fa-users fa-2x"></i></div>
                            Clientes
                        </a>
                        <a class="nav-link" href="<?php echo APP_URL; ?>Medidas">
                            <div class="sb-nav-link-icon"><i class="fas fa-users fa-2x"></i></div>
                            Medidas
                        </a>
                        <a class="nav-link" href="<?php echo APP_URL; ?>Categorias">
                            <div class="sb-nav-link-icon"><i class="fas fa-users fa-2x"></i></div>
                            Categorias
                        </a>
                        <a class="nav-link" href="<?php echo APP_URL; ?>Productos">
                            <div class="sb-nav-link-icon"><i class="fab fa-product-hunt fa-2x"></i></div>
                            Productos
                        </a>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCompras" aria-expanded="false" aria-controls="collapseCompras">
                            <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart fa-2x"></i></div>
                            Entradas
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseCompras" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?php echo APP_URL; ?>Compras"><i class="fas fa-shopping-cart mr-2 fa-2x"></i> Nueva Compra</a>
                                <a class="nav-link" href="<?php echo APP_URL; ?>Compras/historial"><i class="fas fa-list mr-2 fa-2x"></i> Historial Compras</a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseVenta" aria-expanded="false" aria-controls="collapseVenta">
                            <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart fa-2x"></i></div>
                            Salida
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseVenta" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?php echo APP_URL; ?>Compras/Ventas"><i class="fas fa-shopping-cart mr-2 fa-2x"></i> Nueva Venta</a>
                                <a class="nav-link" href="<?php echo APP_URL; ?>Compras/historial_ventas"><i class="fas fa-list mr-2 fa-2x"></i> Historial Ventas</a>
                            </nav>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid mt-2">
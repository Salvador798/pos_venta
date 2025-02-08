<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard</title>
    <link href="<?php echo APP_URL; ?>public/css/styles.css" rel="stylesheet" />
    <link href="<?php echo APP_URL ?>public/css/estilos.css" rel="stylesheet" />
    <link href="<?php echo APP_URL; ?>public/DataTables/datatables.min.css" rel="stylesheet" />
    <link href="<?php echo APP_URL; ?>public/css/select2.min.css" rel="stylesheet" />
    <script src="<?php echo APP_URL; ?>public/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body class="sb-nav-fixed bg-style">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-navbar">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3">Pos Venta</a>
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
                    <li><a class="dropdown-item" href="<?php echo APP_URL; ?>/logout">Cerrar Sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-light bg-nav" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="d-flex">
                        <div class="sidebar p-3">
                            <div class="d-flex align-items-center">
                                <img src="<?php echo APP_URL; ?>public/avatar/user.png" alt="Avatar" class="rounded-circle" width="50"
                                    height="50">
                                <div class="ms-3">
                                    <h5 class="mb-0"><?php echo $_SESSION['usuario']; ?></h5>
                                    <small class="text-dark"><?php echo $_SESSION['nombre']; ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nav">
                        <a class="nav-link linked" href="<?php echo APP_URL; ?>administration/home">
                            <div class="sb-nav-link-icon">
                                <span class="material-symbols-outlined text-dark">
                                    dashboard
                                </span>
                            </div>
                            Dashboard
                        </a>
                        <a class="nav-link linked" href="<?php echo APP_URL; ?>clients">
                            <div class="sb-nav-link-icon">
                                <span class="material-symbols-outlined text-dark">
                                    person
                                </span>
                            </div>
                            Clientes
                        </a>

                        <a class="nav-link linked collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseProducts" aria-expanded="false" aria-controls="collapseProducts">
                            <div class="sb-nav-link-icon">
                                <span class="material-symbols-outlined text-dark">
                                    category
                                </span>
                            </div>
                            Gestión de Productos
                            <div class="sb-sidenav-collapse-arrow">
                                <span class="material-symbols-outlined text-dark">
                                    keyboard_arrow_down
                                </span>
                            </div>
                        </a>
                        <div class="collapse" id="collapseProducts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link linked" href="<?php echo APP_URL; ?>categories">Categoria</a>
                                <a class="nav-link linked" href="<?php echo APP_URL; ?>extends">Medidas</a>
                                <a class="nav-link linked" href="<?php echo APP_URL; ?>products">Productos</a>
                            </nav>
                        </div>

                        <a class="nav-link linked collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseExits" aria-expanded="false" aria-controls="collapseExits">
                            <div class="sb-nav-link-icon">
                                <span class="material-symbols-outlined text-dark">
                                    content_paste
                                </span>
                            </div>
                            Gestión de Existencia
                            <div class="sb-sidenav-collapse-arrow">
                                <span class="material-symbols-outlined text-dark">
                                    keyboard_arrow_down
                                </span>
                            </div>
                        </a>
                        <div class="collapse" id="collapseExits" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link linked" href="<?php echo APP_URL; ?>shopping">Compra</a>
                                <a class="nav-link linked" href="<?php echo APP_URL; ?>sales">Ventas</a>
                            </nav>
                        </div>

                        <a class="nav-link linked collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon">
                                <span class="material-symbols-outlined text-dark">
                                    supervised_user_circle
                                </span>
                            </div>
                            Administración
                            <div class="sb-sidenav-collapse-arrow">
                                <span class="material-symbols-outlined text-dark">
                                    keyboard_arrow_down
                                </span>
                            </div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link linked" href="<?php echo APP_URL; ?>users">Usuarios</a>
                                <a class="nav-link linked" href="<?php echo APP_URL; ?>boxes">Cajas</a>
                                <a class="nav-link linked" href="<?php echo APP_URL; ?>arqueo">Arqueo de Caja</a>
                            </nav>
                        </div>

                        <a class="nav-link linked" href="<?php echo APP_URL; ?>administration">
                            <div class="sb-nav-link-icon">
                                <span class="material-symbols-outlined text-dark">
                                    settings
                                </span>
                            </div>
                            Configuración
                        </a>

                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid mt-2">
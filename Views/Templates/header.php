<!DOCTYPE html>
<html lang="en"> <!-- Define el tipo de documento HTML5 y el idioma de la página -->

<head>
    <!-- Configuración del juego de caracteres y del diseño adaptable a distintos dispositivos -->
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Gimnasio</title> <!-- Título que se mostrará en la pestaña del navegador -->

    <!-- Carga de estilos CSS desde plugins y librerías -->
    <link rel="stylesheet" href="<?php echo base_url; ?>Assets/vendors/iconfonts/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url; ?>Assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?php echo base_url; ?>Assets/vendors/css/vendor.bundle.addons.css">
    <link rel="stylesheet" href="<?php echo base_url; ?>Assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url; ?>Assets/css/snackbar.min.css">
    <link href="<?php echo base_url; ?>Assets/css/jquery-ui.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container-scroller"> <!-- Contenedor general que incluye el layout principal -->

        <!-- Barra de navegación superior -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row default-layout-navbar bg-primary">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <!-- Enlace al inicio con el logo de la marca -->
                <a class="navbar-brand brand-logo" href="<?php echo base_url; ?>administracion/home">Dragon's</a>
                <a class="navbar-brand brand-logo-mini" href="<?php echo base_url; ?>administracion/home">Dragon's</a>
            </div>

            <div class="navbar-menu-wrapper d-flex align-items-stretch">
                <!-- Botón para minimizar el menú lateral -->
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="fas fa-bars"></span>
                </button>

                <ul class="navbar-nav navbar-nav-right">
                    <!-- Menú desplegable para el perfil de usuario -->
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                            <img src="<?php echo base_url; ?>Assets/images/user.png" alt="profile" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="<?php echo base_url; ?>usuarios/perfil">
                                <i class="fas fa-cog text-primary"></i> Configuración
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo base_url; ?>usuarios/salir">
                                <i class="fas fa-power-off text-primary"></i> Cerrar sesión
                            </a>
                        </div>
                    </li>
                </ul>

                <!-- Botón para abrir el menú lateral en pantallas pequeñas -->
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="fas fa-bars"></span>
                </button>
            </div>
        </nav>

        <div class="container-fluid page-body-wrapper">
            <!-- Panel de configuración de temas -->
            <div class="theme-setting-wrapper">
                <div id="settings-trigger"><i class="fas fa-fill-drip"></i></div>
                <div id="theme-settings" class="settings-panel">
                    <i class="settings-close fa fa-times"></i>
                    <p class="settings-heading">SIDEBAR SKINS</p>
                    <div class="sidebar-bg-options selected" id="sidebar-light-theme">
                        <div class="img-ss rounded-circle bg-light border mr-3"></div>Light
                    </div>
                    <div class="sidebar-bg-options" id="sidebar-dark-theme">
                        <div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark
                    </div>
                    <p class="settings-heading mt-2">HEADER SKINS</p>
                    <div class="color-tiles mx-0 px-4">
                        <div class="tiles primary"></div>
                        <div class="tiles success"></div>
                        <div class="tiles warning"></div>
                        <div class="tiles danger"></div>
                        <div class="tiles info"></div>
                        <div class="tiles dark"></div>
                        <div class="tiles default"></div>
                    </div>
                </div>
            </div>

            <!-- Menú lateral con enlaces de navegación -->
            <nav class="sidebar sidebar-offcanvas shadow-lg" id="sidebar">
                <ul class="nav">
                    <!-- Perfil del usuario -->
                    <li class="nav-item nav-profile">
                        <div class="nav-link">
                            <div class="profile-image">
                                <img src="<?php echo base_url; ?>Assets/images/user.png" alt="image" />
                            </div>
                            <div class="profile-name">
                                <p class="name"><?php echo $_SESSION['nombre']; ?></p>
                                <p class="designation"><?php echo $_SESSION['usuario']; ?></p>
                            </div>
                        </div>
                    </li>

                    <!-- Opciones del menú de navegación -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url . 'administracion/home'; ?>">
                            <i class="fa fa-home menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url; ?>usuarios">
                            <i class="fa fa-user menu-icon"></i>
                            <span class="menu-title">Empleados</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url; ?>planes">
                            <i class="fa fa-list-alt menu-icon"></i>
                            <span class="menu-title">Membresias</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#page-layouts" aria-expanded="false" aria-controls="page-layouts">
                            <i class="fa fa-users menu-icon"></i>
                            <span class="menu-title">Clientes</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="page-layouts">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item d-none d-lg-block"> 
                                    <a class="nav-link" href="<?php echo base_url; ?>clientes">Listado</a>
                                </li>
                                <li class="nav-item d-none d-lg-block"> 
                                    <a class="nav-link" href="<?php echo base_url; ?>clientes/plan">Plan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo base_url; ?>clientes/pagos">Pagos</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url; ?>asistencias">
                            <i class="fa fa-calendar menu-icon"></i>
                            <span class="menu-title">Asistencias</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url; ?>rutinas">
                            <i class="fa fa-list menu-icon"></i>
                            <span class="menu-title">Rutinas</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url; ?>entrenador">
                            <i class="fa fa-user menu-icon"></i>
                            <span class="menu-title">Entrenador</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url; ?>administracion">
                            <i class="fa fa-cog menu-icon"></i>
                            <span class="menu-title">Contactos</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Contenedor principal donde se cargará el contenido dinámico -->
            <div class="main-panel">
                <div class="content-wrapper">

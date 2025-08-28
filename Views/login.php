<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <title>Admin</title>

  <!-- Estilos de fuentes y CSS -->
  <link rel="stylesheet" href="<?php echo base_url; ?>Assets/vendors/iconfonts/font-awesome/css/all.min.css">
  <link rel="stylesheet" href="<?php echo base_url; ?>Assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?php echo base_url; ?>Assets/vendors/css/vendor.bundle.addons.css">
  <link rel="stylesheet" href="<?php echo base_url; ?>Assets/css/style.css">

  <link rel="shortcut icon" href="<?php echo base_url; ?>Assets/images/favicon-32x32.png" />
  
  <style>
    /* Centrado vertical y horizontal */
    .login-container {
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #f4f4f4; /* Fondo claro */
    }

    .auth-form {
      width: 100%;
      max-width: 400px;
      padding: 40px;
      background-color: white;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
    }
    
    .login-title {
      text-align: center;
      margin-bottom: 20px;
      font-weight: bold;
      font-size: 24px;
    }

    .btn-primary {
      background-color: #4a148c;
      border-color: #4a148c;
    }
  </style>
</head>

<body>
  <div class="login-container">
    <div class="auth-form">
      <h4 class="login-title">BIENVENIDO</h4>

      <div class="alert alert-danger d-none" role="alert" id="alerta"></div>

      <form class="pt-3" id="frmLogin" onsubmit="frmLogin(event)">
        <div class="form-group">
          <label for="usuario">Nombre de usuario</label>
          <div class="input-group">
            <div class="input-group-prepend bg-transparent">
              <span class="input-group-text bg-transparent border-right-0">
                <i class="fa fa-user text-primary"></i>
              </span>
            </div>
            <input type="text" class="form-control form-control-lg border-left-0" 
                   id="usuario" name="usuario" placeholder="Nombre de usuario">
          </div>
        </div>

        <div class="form-group">
          <label for="clave">Contraseña</label>
          <div class="input-group">
            <div class="input-group-prepend bg-transparent">
              <span class="input-group-text bg-transparent border-right-0">
                <i class="fa fa-lock text-primary"></i>
              </span>
            </div>
            <input type="password" class="form-control form-control-lg border-left-0" 
                   id="clave" name="clave" placeholder="Contraseña">
          </div>
        </div>

        <div class="my-3">
          <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" 
                  type="submit" id="btnAccion">Iniciar Sesión</button>
        </div>
      </form>
    </div>
  </div>

  <script src="<?php echo base_url; ?>Assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="<?php echo base_url; ?>Assets/vendors/js/vendor.bundle.addons.js"></script>
  <script src="<?php echo base_url; ?>Assets/js/off-canvas.js"></script>
  <script src="<?php echo base_url; ?>Assets/js/hoverable-collapse.js"></script>
  <script src="<?php echo base_url; ?>Assets/js/misc.js"></script>
  <script src="<?php echo base_url; ?>Assets/js/sweetalert2.all.min.js"></script>

  <script>
    const base_url = '<?php echo base_url; ?>';
  </script>
  <script src="<?php echo base_url; ?>Assets/js/login.js"></script>
</body>

</html>

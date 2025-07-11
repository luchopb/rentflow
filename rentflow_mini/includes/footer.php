<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Agrega al head de tu documento (en header_nav.php) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">


<!-- Agrega esto antes del cierre del body (antes del </body>) -->
<nav class="fixed-bottom mobile-navbar d-lg-none">
  <div class="d-flex justify-content-around bg-primary shadow-sm pt-2 pb-3">
    <!-- Botón Propiedades -->
    <a href="propiedades.php" class="nav-link text-center px-2">
      <i class="bi bi-house-door d-block fs-5"></i>
      <span class="d-block small">Propiedades</span>
    </a>

    <!-- Botón Inquilinos -->
    <a href="inquilinos.php" class="nav-link text-center px-2">
      <i class="bi bi-people d-block fs-5"></i>
      <span class="d-block small">Inquilinos</span>
    </a>

    <!-- Botón Contratos -->
    <a href="contratos.php" class="nav-link text-center px-2">
      <i class="bi bi-file-text d-block fs-5"></i>
      <span class="d-block small">Contratos</span>
    </a>

    <!-- Botón Pagos -->
    <a href="listado_pagos.php" class="nav-link text-center px-2">
      <i class="bi bi-cash-coin d-block fs-5"></i>
      <span class="d-block small">Pagos</span>
    </a>

    <!-- Botón Gastos -->
    <a href="gastos.php" class="nav-link text-center px-2">
      <i class="bi bi-cash-stack d-block fs-5"></i>
      <span class="d-block small">Gastos</span>
    </a>
  </div>
</nav>

<script>
  // Marcar el enlace activo según la página actual
  document.addEventListener('DOMContentLoaded', function() {
    const currentPage = window.location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('.mobile-navbar .nav-link');

    navLinks.forEach(link => {
      if (link.getAttribute('href') === currentPage) {
        link.classList.add('active');
      }
    });
  });
</script>
<script>
  // Script para manejar el cambio de tema y guardar preferencia en localStorage
  function aplicarTemaOscuro(oscuro) {
    if (oscuro) {
      document.body.classList.add('tema-oscuro');
    } else {
      document.body.classList.remove('tema-oscuro');
    }
  }

  function sincronizarSwitches(oscuro) {
    document.getElementById('toggle-tema-desktop').checked = oscuro;
    document.getElementById('toggle-tema-mobile').checked = oscuro;
  }

  document.addEventListener('DOMContentLoaded', function() {
    // Leer preferencia guardada
    let temaOscuro = localStorage.getItem('temaOscuro') === 'true';
    aplicarTemaOscuro(temaOscuro);
    sincronizarSwitches(temaOscuro);

    // Listeners para ambos switches
    document.getElementById('toggle-tema-desktop').addEventListener('change', function(e) {
      aplicarTemaOscuro(e.target.checked);
      localStorage.setItem('temaOscuro', e.target.checked);
      sincronizarSwitches(e.target.checked);
    });
    document.getElementById('toggle-tema-mobile').addEventListener('change', function(e) {
      aplicarTemaOscuro(e.target.checked);
      localStorage.setItem('temaOscuro', e.target.checked);
      sincronizarSwitches(e.target.checked);
    });
  });
</script>
</body>

</html>
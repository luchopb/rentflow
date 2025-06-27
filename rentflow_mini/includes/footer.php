<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Agrega al head de tu documento (en header_nav.php) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">


<!-- Agrega esto antes del cierre del body (antes del </body>) -->
<nav class="fixed-bottom mobile-navbar d-lg-none">
  <div class="d-flex justify-content-around bg-primary shadow-sm pt-2 pb-4">
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
  </div>
</nav>

<script>
// Marcar el enlace activo según la página actual
document.addEventListener('DOMContentLoaded', function() {
  const currentPage = window.location.pathname.split('/').pop();
  const navLinks = document.querySelectorAll('.mobile-navbar .nav-link');
  
  navLinks.forEach(link => {
    if(link.getAttribute('href') === currentPage) {
      link.classList.add('active');
    }
  });
});
</script>

</body>

</html>
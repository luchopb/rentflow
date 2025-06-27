# Listado de Pagos - RentFlow

## Descripción
La página `listado_pagos.php` es una nueva funcionalidad que permite visualizar y gestionar todos los pagos recibidos en el sistema de manera centralizada.

## Características Principales

### 📊 Indicadores Dashboard
- **Total de Pagos**: Contador de todos los pagos registrados
- **Monto Total**: Suma de todos los importes de pagos
- **Promedio**: Promedio de importe por pago
- **Tipos de Pago**: Cantidad de tipos de pago diferentes

### 📈 Desglose por Tipo de Pago
- Visualización de estadísticas por tipo de pago (Efectivo, Transferencia, etc.)
- Cantidad y monto total por tipo
- Barras de progreso para visualizar la distribución

### 🔍 Filtros Avanzados
- **Propiedad**: Búsqueda por nombre de propiedad
- **Propietario**: Búsqueda por propietario
- **Fechas**: Rango de fechas desde/hasta
- **Período**: Filtro por período específico (YYYY-MM)
- **Concepto**: Filtro por concepto de pago
- **Tipo de Pago**: Filtro por tipo (Efectivo/Transferencia)

### 📋 Tabla de Pagos
- Lista completa de pagos con información detallada
- Columnas: Fecha, Período, Propiedad, Inquilino, Concepto, Tipo, Importe, Comprobante
- Acciones: Ver contrato y Eliminar pago
- Enlaces directos a comprobantes

### 💾 Exportación
- Botón para exportar datos filtrados a CSV
- Incluye todos los campos relevantes
- Formato compatible con Excel y otras herramientas

## Funcionalidades Técnicas

### Eliminación de Pagos
- Confirmación antes de eliminar
- Eliminación automática de archivos de comprobante
- Mensajes de éxito/error

### Filtros Dinámicos
- Auto-submit en cambios de selectores
- Persistencia de filtros en la URL
- Limpieza de filtros con un clic

### Responsive Design
- Diseño adaptativo para móviles y tablets
- Tabla con scroll horizontal en dispositivos pequeños
- Cards de indicadores optimizadas

## Navegación
La página está integrada en el menú principal como "Listado Pagos" y es accesible desde cualquier parte del sistema.

## Archivos Relacionados
- `listado_pagos.php`: Página principal
- `includes/header_nav.php`: Navegación actualizada
- `includes/styles.css`: Estilos específicos agregados
- `config.php`: Configuración de base de datos

## Base de Datos
Utiliza las siguientes tablas:
- `pagos`: Información de pagos
- `contratos`: Relación con contratos
- `propiedades`: Información de propiedades
- `inquilinos`: Información de inquilinos

## Seguridad
- Verificación de login requerida
- Sanitización de entradas
- Validación de permisos
- Confirmación para acciones destructivas 
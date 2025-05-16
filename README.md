# RentFlow - Sistema de Gestión Inmobiliaria

RentFlow es una aplicación web para la gestión de propiedades inmobiliarias, inquilinos, contratos y pagos. Desarrollada con PHP, MySQL, Bootstrap y jQuery.

## Características

### Gestión de Propiedades
- Registro y administración de propiedades (departamentos, casas, locales)
- Control de estado (disponible/alquilado)
- Detalles de la propiedad (dirección, precio, características)

### Gestión de Inquilinos
- Registro completo de inquilinos
- Información de contacto
- Historial de contratos y pagos
- Vista detallada de la situación del inquilino

### Gestión de Contratos
- Creación y seguimiento de contratos de alquiler
- Validación de fechas y disponibilidad
- Generación automática de pagos mensuales
- Control de estado del contrato

### Gestión de Pagos
- Registro y seguimiento de pagos
- Actualización automática de estados
- Historial de pagos por contrato
- Notificaciones de pagos vencidos

## Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache/Nginx)
- Navegador web moderno

## Instalación

1. Clonar el repositorio:
```bash
git clone https://github.com/tuusuario/rentflow.git
```

2. Importar la base de datos:
```bash
mysql -u root -p < database.sql
```

3. Configurar la conexión a la base de datos:
   - Editar el archivo `config/database.php`
   - Actualizar las credenciales de la base de datos

4. Configurar el servidor web:
   - Asegurarse de que el directorio del proyecto sea accesible
   - Configurar los permisos adecuados

## Estructura del Proyecto

```
rentflow/
├── assets/
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── main.js
├── config/
│   └── database.php
├── modules/
│   ├── propiedades/
│   │   ├── index.php
│   │   └── actions.php
│   ├── inquilinos/
│   │   ├── index.php
│   │   └── actions.php
│   ├── contratos/
│   │   ├── index.php
│   │   └── actions.php
│   └── pagos/
│       ├── index.php
│       └── actions.php
├── database.sql
├── index.php
└── README.md
```

## Uso

1. Acceder a la aplicación a través del navegador web
2. Comenzar registrando las propiedades disponibles
3. Registrar inquilinos cuando sea necesario
4. Crear contratos vinculando propiedades con inquilinos
5. Gestionar los pagos mensuales

## Seguridad

- Todas las entradas de usuario son validadas y sanitizadas
- Las consultas SQL utilizan prepared statements
- Las contraseñas y datos sensibles están protegidos
- Se implementan medidas contra CSRF y XSS

## Mantenimiento

- Los estados de los pagos se actualizan automáticamente cada hora
- Se recomienda hacer backups regulares de la base de datos
- Mantener actualizado el software del servidor

## Contribuir

1. Fork el proyecto
2. Crear una rama para la nueva característica
3. Realizar los cambios
4. Enviar un pull request

## Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## Soporte

Para reportar problemas o solicitar ayuda:
- Abrir un issue en GitHub
- Enviar un correo a soporte@rentflow.com 
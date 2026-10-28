# SaberTech — Sistema de Gestión del Conocimiento

Prototipo funcional de la **Actividad 7** del curso Gestión del Conocimiento (Ingeniería de Sistemas).
Aplicación web para **TECHSOLUTIONS CHOCÓ S.A.S.** (empresa simulada) que permite registrar, clasificar,
buscar y consultar soluciones, procedimientos y lecciones aprendidas.

**Autores:** Ferly Palacios Moya · Frank Smith Hinestroza
**Tecnologías:** Laravel 9 · PHP 8 · MySQL · Laravel Breeze (Blade + Tailwind CSS)

---

## Funcionalidades

| Requisito | Funcionalidad |
|---|---|
| RF01 | Registro, inicio y cierre de sesión (Laravel Breeze), con el área del trabajador |
| RF02 | Registrar conocimiento: título, categoría, problema, solución, enlace y etiquetas |
| RF03 | Clasificar en 5 categorías: Incidencia, Despliegue, Desarrollo, Procedimiento, Buena práctica |
| RF04 | Etiquetas libres separadas por comas (se crean solas, sin duplicados) |
| RF05 | Listado de la más reciente a la más antigua, con paginación |
| RF06 | Búsqueda por palabra clave en título, problema, solución y etiquetas |
| RF07 | Filtro por categoría y por etiqueta (clic en cualquier `#etiqueta`) |
| RF08 | Detalle con autor, área, fechas y conocimientos relacionados |
| RF09 | Editar y eliminar, **solo el autor** (Policy) |
| RF10 | Panel con totales |

---

## Instalación con XAMPP (Windows)

Requisitos: **XAMPP con PHP 8.0.2 o superior**, **Composer** y (opcional) **Node.js 16+**.

1. Copia la carpeta `sabertech` dentro de `C:\xampp\htdocs\` (o en cualquier carpeta).
2. Abre XAMPP y enciende **Apache** y **MySQL**.
3. Entra a <http://localhost/phpmyadmin> y crea una base de datos llamada **`sabertech`**
   (cotejamiento `utf8mb4_unicode_ci`).
4. Abre una terminal en la carpeta del proyecto y ejecuta:

```bash
composer install
copy .env.example .env          # en Linux/Mac: cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

5. Abre <http://127.0.0.1:8000> en el navegador.

> Los estilos ya vienen compilados en `public/build`. Si cambias las vistas o los estilos,
> ejecuta `npm install` y luego `npm run build` (o `npm run dev` mientras trabajas).

### Usuarios de prueba

Todos tienen la contraseña **`password`**:

| Correo | Nombre | Área |
|---|---|---|
| ferly@techsolutions.test | Ferly Palacios | Desarrollo |
| frank@techsolutions.test | Frank Hinestroza | Soporte |
| andres@techsolutions.test | Andrés Rentería | Infraestructura y DevOps |
| luisa@techsolutions.test | Luisa Córdoba | Proyectos |
| camila@techsolutions.test | Camila Asprilla | Comercial |

Para volver a dejar la base de datos como al principio: `php artisan migrate:fresh --seed`

---

## Estructura del código (lo que se programó)

```
app/
├── Http/Controllers/
│   ├── DashboardController.php      # Panel: totales, búsqueda, filtros y listado
│   └── ConocimientoController.php   # Registrar, ver, editar y eliminar fichas
├── Http/Requests/
│   └── ConocimientoRequest.php      # Validación del formulario
├── Models/
│   ├── Conocimiento.php             # Relaciones + scopes buscar(), deCategoria(), conEtiqueta()
│   ├── Categoria.php
│   ├── Etiqueta.php                 # idsDesdeTexto(): convierte "a, b, c" en etiquetas
│   └── User.php                     # + área y relación con sus conocimientos
└── Policies/
    └── ConocimientoPolicy.php       # Solo el autor puede editar o eliminar
config/sabertech.php                 # Áreas de la empresa
database/
├── migrations/2026_10_15_*          # area en users, categorias, conocimientos, etiquetas, pivote
└── seeders/                         # 5 categorías, 5 usuarios y 16 fichas de ejemplo
resources/views/
├── dashboard.blade.php              # Pantalla principal
├── conocimientos/                   # _form, create, edit, show
├── components/                      # marca, categoria-badge, etiqueta, avatar
└── layouts/                         # Diseño general (Breeze personalizado)
lang/es.json, lang/es/               # Interfaz y mensajes de validación en español
routes/web.php                       # Rutas protegidas con middleware auth
```

## Modelo de datos

- `users` (id, name, email, **area**, password)
- `categorias` (id, nombre, descripcion, color)
- `conocimientos` (id, titulo, problema, solucion, enlace, categoria_id → categorias, user_id → users)
- `etiquetas` (id, nombre único)
- `conocimiento_etiqueta` (conocimiento_id, etiqueta_id) — relación muchos a muchos

## Mejoras futuras (fuera del alcance de la versión 1.0)

Validación de fichas por un líder, adjuntar archivos, directorio de expertos,
comentarios y calificación, e integración automática con GitHub y Google Drive.

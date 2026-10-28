<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Conocimiento;
use App\Models\Etiqueta;
use App\Models\User;
use Illuminate\Database\Seeder;

class ConocimientoSeeder extends Seeder
{
    /**
     * Fichas de ejemplo para la fase de "Alimentación" del proyecto.
     */
    public function run()
    {
        $fichas = [
            ['andres', 'Despliegue', 2, 'Publicar una actualización del sistema de citas de la IPS sin cortar el servicio',
                'El sistema de agendamiento de citas de la IPS no puede quedar fuera de línea en horario de atención. Antes este procedimiento solo lo conocía el ingeniero DevOps.',
                "1. Avisar a la IPS y desplegar después de las 6:00 p. m.\n2. En el servidor: php artisan down --secret=\"clave-temporal\"\n3. git pull origin main\n4. composer install --no-dev --optimize-autoloader\n5. php artisan migrate --force\n6. php artisan optimize\n7. Probar entrando con la URL secreta y luego: php artisan up",
                'https://github.com/techsolutions/sistema-citas-ips', 'laravel, produccion, ips, mantenimiento'],
            ['frank', 'Incidencia', 5, 'Error 500 después de desplegar: permisos de la carpeta storage',
                'Después de subir una nueva versión al servidor, la aplicación muestra error 500 en todas las páginas. Pasó en el sistema de citas de la IPS y en el inventario de la ferretería.',
                "1. Revisar storage/logs/laravel.log para confirmar el error \"Permission denied\".\n2. Dar permisos de escritura: chmod -R 775 storage bootstrap/cache\n3. Asignar el dueño correcto: chown -R www-data:www-data storage bootstrap/cache\n4. Limpiar caché: php artisan optimize:clear",
                null, 'laravel, despliegue, permisos, error-500'],
            ['ferly', 'Buena práctica', 20, 'Lista de chequeo antes de cada despliegue',
                'Varios despliegues fallaron por olvidar pasos sencillos, como hacer copia de la base de datos o correr migraciones.',
                "Antes de desplegar:\n- Copia de seguridad de la base de datos.\n- Pruebas en el ambiente de staging.\n- Revisar que el .env de producción tenga las variables nuevas.\n- Avisar al cliente el horario.\nDespués de desplegar:\n- Revisar el log de errores durante 15 minutos.\n- Confirmar con el cliente que todo funciona.",
                null, 'despliegue, checklist, calidad'],
            ['ferly', 'Desarrollo', 30, 'Configurar la conexión a MySQL cuando falla con "Access denied"',
                'Al instalar un proyecto nuevo en XAMPP aparece SQLSTATE[HY000] [1045] Access denied for user.',
                "1. Verificar DB_USERNAME y DB_PASSWORD en el archivo .env (en XAMPP el usuario es root y la contraseña va vacía).\n2. Crear la base de datos en phpMyAdmin con cotejamiento utf8mb4_unicode_ci.\n3. Ejecutar php artisan config:clear para que Laravel lea el .env de nuevo.",
                null, 'mysql, xampp, base-de-datos, configuracion'],
            ['frank', 'Incidencia', 12, 'Los correos de recuperación de contraseña no llegan a Gmail',
                'Clientes de la ferretería reportan que el correo para restablecer la contraseña nunca llega o cae en spam.',
                "1. No usar el correo del hosting; configurar SMTP con una cuenta verificada.\n2. En .env: MAIL_MAILER=smtp, MAIL_HOST, MAIL_PORT=587, MAIL_ENCRYPTION=tls.\n3. MAIL_FROM_ADDRESS debe ser del mismo dominio de la cuenta.\n4. Probar con php artisan tinker y Mail::raw().",
                null, 'correo, smtp, laravel'],
            ['luisa', 'Procedimiento', 25, 'Cómo levantar requerimientos con un cliente nuevo',
                'Cada analista hacía el levantamiento de requerimientos a su manera y se perdían detalles importantes del cliente.',
                "1. Primera reunión: entender el proceso actual del cliente, no la solución.\n2. Pedir ejemplos reales: facturas, formatos, hojas de Excel que usan hoy.\n3. Escribir las historias de usuario y validarlas con el cliente.\n4. Registrar reglas de negocio y restricciones en el documento del proyecto en Drive.\n5. Firmar el alcance antes de empezar a desarrollar.",
                'https://drive.google.com/techsolutions/plantilla-requerimientos', 'requerimientos, clientes, analisis'],
            ['andres', 'Procedimiento', 40, 'Hacer copia de seguridad automática de las bases de datos de clientes',
                'Si un servidor falla, no había forma rápida de recuperar la información de los clientes.',
                "1. Crear un script con mysqldump por cada base de datos.\n2. Programarlo con cron todos los días a las 2:00 a. m.\n3. Comprimir el archivo y subirlo a Google Drive de la empresa.\n4. Conservar las copias de los últimos 15 días.\n5. Una vez al mes, probar que una copia se pueda restaurar.",
                null, 'mysql, backup, servidores, cron'],
            ['frank', 'Incidencia', 8, 'El sistema de inventario se pone lento al generar el reporte mensual',
                'En la ferretería, el reporte de inventario del mes tardaba más de un minuto y a veces se caía.',
                "1. Se encontró una consulta que cargaba cada producto por separado (problema N+1).\n2. Se cambió a carga anticipada con with('categoria', 'movimientos').\n3. Se agregó un índice a la columna fecha de la tabla movimientos.\nResultado: el reporte bajó de 70 a 4 segundos.",
                null, 'rendimiento, eloquent, mysql, inventario'],
            ['ferly', 'Desarrollo', 45, 'Estructura base para proyectos Laravel de la empresa',
                'Cada proyecto tenía una organización distinta y era difícil que otro desarrollador lo continuara.',
                "- Controladores delgados; la validación va en Form Requests.\n- Reglas de permisos en Policies.\n- Datos de ejemplo en Seeders para que cualquiera pueda probar.\n- Nombres de tablas y campos en español, consistentes con el cliente.\n- README con los pasos de instalación.",
                null, 'laravel, arquitectura, estandares'],
            ['camila', 'Buena práctica', 35, 'Cómo estimar el tiempo de un proyecto antes de enviar la propuesta',
                'Varias propuestas se quedaron cortas en tiempo y costo, y la empresa terminó perdiendo dinero.',
                "1. Partir de proyectos parecidos ya registrados en SaberTech.\n2. Pedir al líder de desarrollo la estimación por módulo.\n3. Sumar 20 % para pruebas y ajustes con el cliente.\n4. Incluir la capacitación y el primer mes de soporte en el valor.",
                null, 'propuestas, clientes, estimacion'],
            ['andres', 'Despliegue', 18, 'Instalar un certificado SSL gratuito con Let\'s Encrypt',
                'Los navegadores marcaban como "no seguro" los sistemas de los clientes.',
                "1. Apuntar el dominio al servidor.\n2. Instalar certbot: sudo apt install certbot python3-certbot-nginx\n3. Ejecutar: sudo certbot --nginx -d dominio.com\n4. Verificar la renovación automática: sudo certbot renew --dry-run",
                null, 'ssl, nginx, servidores, seguridad'],
            ['frank', 'Incidencia', 3, 'Usuarios no pueden iniciar sesión: error 419 Page Expired',
                'Al enviar el formulario de inicio de sesión, el sistema de citas muestra "419 Page Expired".',
                "1. Revisar que el formulario tenga @csrf.\n2. Confirmar que APP_URL en .env coincida con el dominio real (con https).\n3. Si hay HTTPS, poner SESSION_SECURE_COOKIE=true.\n4. Limpiar caché del navegador y de configuración: php artisan config:clear",
                null, 'laravel, sesiones, csrf, login'],
            ['luisa', 'Buena práctica', 50, 'Lecciones aprendidas del proyecto de la IPS',
                'Al cerrar el proyecto de agendamiento de citas se reunió al equipo para revisar qué salió bien y qué no.',
                "- Validar los horarios de atención con el cliente desde el principio.\n- Documentar cada despliegue en SaberTech, no solo en WhatsApp.\n- Capacitar a dos personas del cliente, no a una.\n- Dejar el manual de usuario listo antes de la entrega.",
                null, 'ips, lecciones-aprendidas, proyectos'],
            ['ferly', 'Desarrollo', 6, 'Exportar reportes a Excel desde Laravel',
                'Los clientes piden descargar en Excel los listados del sistema.',
                "1. Usar el paquete maatwebsite/excel.\n2. Crear una clase Export con php artisan make:export.\n3. Para muchos registros, usar FromQuery en lugar de FromCollection para no llenar la memoria.\n4. Devolver la descarga desde el controlador con Excel::download().",
                null, 'laravel, excel, reportes'],
            ['camila', 'Procedimiento', 15, 'Registrar a un cliente nuevo en el sistema de la empresa',
                'No había un paso a paso claro para dar de alta a un cliente y sus contactos.',
                "1. Crear la carpeta del cliente en Drive con la plantilla.\n2. Registrar los contactos y el NIT en la hoja de clientes.\n3. Crear el repositorio en GitHub con el nombre del proyecto.\n4. Agendar la reunión de levantamiento de requerimientos con el área de proyectos.",
                null, 'clientes, comercial, drive'],
            ['andres', 'Incidencia', 1, 'El servidor se queda sin espacio en disco',
                'El servidor de pruebas dejó de responder porque el disco llegó al 100 %.',
                "1. Ver el uso con: df -h y du -sh /var/www/*\n2. El culpable era storage/logs/laravel.log, de 6 GB.\n3. Configurar LOG_CHANNEL=daily para que el log se divida por días.\n4. Programar la limpieza de logs de más de 14 días.",
                null, 'servidores, logs, linux'],
        ];

        $categorias = Categoria::pluck('id', 'nombre');
        $usuarios = User::all()->keyBy(fn ($u) => strtok($u->email, '@'));

        foreach ($fichas as [$autor, $categoria, $diasAtras, $titulo, $problema, $solucion, $enlace, $etiquetas]) {
            $fecha = now()->subDays($diasAtras)->setTime(rand(8, 17), rand(0, 59));

            $conocimiento = new Conocimiento([
                'titulo' => $titulo,
                'problema' => $problema,
                'solucion' => $solucion,
                'enlace' => $enlace,
                'categoria_id' => $categorias[$categoria],
            ]);
            $conocimiento->user_id = $usuarios[$autor]->id;
            $conocimiento->created_at = $fecha;
            $conocimiento->updated_at = $fecha;
            $conocimiento->vistas = rand(5, 120);
            $conocimiento->save();

            $conocimiento->etiquetas()->sync(Etiqueta::idsDesdeTexto($etiquetas));
        }
    }
}

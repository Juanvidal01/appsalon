# 💇‍♀️ AppSalon — Sistema de Gestión de Citas para Salón de Belleza

AppSalon es una aplicación web desarrollada en **Laravel + MySQL** que permite la **gestión integral de servicios, citas y clientes** de un salón de belleza.  
Incluye autenticación de usuarios, panel de administración, control de horarios y reservas con validación de disponibilidad.

---


## 🚀 Instalación y Configuración

### 1️⃣ Clonar el repositorio

```bash
 git clone https://github.com/tuusuario/appsalon.git
 cd appsalon
```
### 2️⃣ Instalar dependencias de Laravel
```bash 
composer install
```
### 3️⃣ Instalar dependencias de frontend (Vite/Tailwind)
```bash 
npm install
```
### 4️⃣ Copiar el archivo de entorno y generar la clave
```bash 
cp .env.example .env
php artisan key:generate
```
### 5️⃣ Configurar la base de datos
Edita el archivo .env con tus credenciales locales de MySQL:
```bash 
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=appsalon
DB_USERNAME=root
DB_PASSWORD=
```
Luego ejecuta migraciones y seeders:
```bash 
php artisan migrate --seed
```
Esto creará usuarios, servicios y horarios de ejemplo.

### 6️⃣ Iniciar el servidor
```bash 
php artisan serve
```
Abre en tu navegador 👉 http://localhost:8000

---

## 👥 Credenciales de Usuarios de Prueba

| Rol                     | Email                                               | Contraseña |
| ----------------------- | --------------------------------------------------- | ---------- |
| 🧑‍💼 **Administrador** | [admin@appsalon.com](mailto:admin@appsalon.com)     | 12345678   |
| 💅 **Cliente**          | [cliente@appsalon.com](mailto:cliente@appsalon.com) | 12345678   |

#### También puedes registrar nuevos usuarios desde el formulario de registro.

## 💡 Funcionalidades Implementadas

### 🔐 Autenticación y Seguridad

- Registro y login de usuarios con validaciones

- Hash de contraseñas con bcrypt

- Protección CSRF y validaciones del lado del servidor

- Middleware de autenticación y roles (admin / cliente)

### 💇 Módulo de Servicios

- CRUD completo para administradores (crear, editar, eliminar)

- Visualización pública de catálogo de servicios

- Validación de datos

### 📅 Módulo de Citas

- Reserva de citas por fecha y hora

- Selección múltiple de servicios

- Validación de disponibilidad horaria (evita solapamientos)

- Cancelación y reprogramación de citas

- Historial e información de cada cita (pendiente, confirmada, cancelada)

### 🧑‍💻 Panel de Administración

- Dashboard con estadísticas (citas del día, ingresos, canceladas)

- Gestión de usuarios y servicios

- Control de horarios del salón

### 🎨 Interfaz de Usuario

- Diseño responsive con TailwindCSS

- Vistas separadas para cliente y administrador

- Formularios y tarjetas con estilo moderno
## 🧰 Tecnologías Utilizadas
| Categoría                | Tecnologías              |
| ------------------------ | ------------------------ |
| **Backend**              | Laravel 11 (PHP 8.2)     |
| **Frontend**             | Blade, TailwindCSS, Vite |
| **Base de Datos**        | MySQL                    |
| **ORM**                  | Eloquent                 |
| **Autenticación**        | Laravel Breeze           |
| **Control de versiones** | Git + GitHub             |


## ⚙️ Comandos útiles

| Tarea                        | Comando                      |
| ---------------------------- | ---------------------------- |
| Ejecutar servidor local      | `php artisan serve`          |
| Compilar assets (desarrollo) | `npm run dev`                |
| Compilar assets (producción) | `npm run build`              |
| Migrar base de datos         | `php artisan migrate`        |
| Correr seeders               | `php artisan db:seed`        |
| Limpiar caché                | `php artisan optimize:clear` |


## 🧑‍💻 Autores

- Proyecto: Sistema de Citas AppSalon

- Autores: [Juan David Vidal/Jhon Victor Lopez]

- Año: 2025

- Institución: Universidad Santiago de Cali

- Versión: 1.0



# 🏁 Licencia

Proyecto para fines académicos. Licencia MIT.


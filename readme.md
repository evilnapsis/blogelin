# Blogelin v2.0 🚀

**Blogelin** es un sistema de gestión de contenidos (CMS) moderno, ligero y potente diseñado específicamente para blogs y portales de noticias. Construido con PHP y MySQL, ofrece una interfaz administrativa elegante y una experiencia de lectura pública optimizada.

![Blogelin Preview](index.jpg)

## ✨ Características Principales

### 🛡️ Seguridad 
*   **Gestión de Sesiones:** Sistema de acceso seguro para administradores.

### 🎨 Diseño Moderno y Premium
*   **Panel Administrativo:** Rediseñado con Bootstrap 5 y CoreUI, utilizando una paleta de colores profesional (#2f3640).
*   **Dashboard Visual:** Resumen de estadísticas clave (artículos, categorías, comentarios) con un diseño intuitivo.
*   **Interfaz Pública:** Diseño responsivo con sidebar, buscador integrado y paginación fluida.

### 📝 Gestión de Contenido
*   **Editor de Artículos:** Nueva vista dedicada para redactar artículos largos con soporte para imágenes destacadas.
*   **Categorías Dinámicas:** Organización flexible de publicaciones con soporte para artículos sin categoría definida.
*   **Sistema de Comentarios:** Interacción directa con los lectores con moderación desde el panel administrativo.

## 🛠️ Tecnologías Utilizadas
*   **Backend:** PHP 8.x
*   **Base de Datos:** MySQL
*   **Frontend:** Bootstrap 5, CoreUI, jQuery
*   **Iconografía:** Bootstrap Icons
*   **Componentes:** SweetAlert2 para notificaciones interactivas y DataTables para gestión de listados.

## 🚀 Instalación Rápida

1.  **Requisitos:** Servidor web (Apache/Nginx), PHP 8.0+ y MySQL.
2.  **Clonación:** Copia los archivos en tu carpeta `htdocs` o `www`.
3.  **Base de Datos:**
    *   Crea una base de datos llamada `blogelin`.
    *   Importa el archivo `schema.sql` para crear las tablas necesarias.
4.  **Configuración:** Si necesitas cambiar las credenciales de la base de datos, edita `admin/core/controller/Database.php`.
5.  **Acceso:**
    *   **Página Pública:** `http://localhost/blogelin`
    *   **Administrador:** `http://localhost/blogelin/admin` (Usuario: `admin`, Contraseña: `admin`)

## 📂 Estructura del Proyecto
*   `/admin`: Contiene todo el sistema de administración del blog.
*   `/assets`: Recursos estáticos compartidos (CSS, JS, Imágenes).
*   `/core`: Núcleo del sistema y lógica de la vista pública.
*   `schema.sql`: Estructura de la base de datos.
*   `index.php`: Punto de entrada de la página pública.

---
Creado con ❤️ por **Evilnapsis** &copy; 2026.

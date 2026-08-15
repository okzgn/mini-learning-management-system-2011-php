# Mini Learning Management System

Prototipo de **Mini-LMS (Learning Management System) y Portal Estudiantil** desarrollado originalmente entre **2010 y 2011** en PHP procedimental para un curso universitario. 

> **Software histórico:** se ha mantenido intacto en su lógica y estética visual de la era Web 2.0, aunque adaptado con una **capa de emulación SQLite y PDO** para funcionar de forma inmediata y autocontenida en versiones modernas de **PHP 7.4 y PHP 8.x** sin necesidad de configurar un servidor MySQL externo (originalmente usado).

---

## 🎭 Roles y Funcionalidades

El sistema gestiona 3 tipos de perfiles a través del campo `details` en la base de datos:

| Rol | Usuario Demo | Contraseña | Funcionalidades |
| :--- | :--- | :--- | :--- |
| **Estudiante** (`normal`) | `estudiante` | `estudiante123` | • Perfil público con fotografía.<br>• Subida de tareas (`.doc`, `.xls`, `.ppt`).<br>• Subida de fotos (`fotoperfil` o galería).<br>• Publicar notas en el muro general. |
| **Docente** (`teacher`) | `docente` | `docente123` | • **Matriz de Calificaciones:** Vista de todas las tareas enviadas por los alumnos.<br>• **Calificación en tiempo real:** Entrada de notas con guardado asíncrono vía AJAX (`putp.php`).<br>• Publicar avisos en el muro. |
| **Administrador** (`admin`) | `admin` | `admin123` | • Funcionalidades de estudiante.<br>• **Botón de Purga:** Permite vaciar y resetear todas las notas del muro general (`?do=drnof`). |

---

## 🧩 Peculiaridades Técnicas del Código Original

Este proyecto cuenta con patrones de desarrollo muy particulares y representativos del desarrollo web prototípico de inicios de la década de 2010:

1. **Metadatos incrustados en nombres de archivo (Anti-patrón de persistencia):**
   En lugar de relacionar documentos mediante claves foráneas en tablas SQL, el sistema almacena los metadatos (tipo, dueño, fecha y calificación) directamente en el nombre del archivo en disco usando el separador `___`:
   ```text
   base/files/deber_mate___[USER_HASH]___15-5-2011___10.doc
   base/files/fotoperfil___[USER_HASH].jpg
   ```
2. **Listado de estudiantes basado en disco:**
   La cuadrícula de alumnos de la página principal **no consulta la base de datos**. Escanea la carpeta `base/files/` y renderiza únicamente a aquellos usuarios que tengan una foto física que comience por `fotoperfil___`.
3. **Muro de notas en texto plano:**
   La cartelera de anuncios usa `base/teacher/notes.txt` mediante `file_get_contents()` y `file_put_contents()` acumulativo en lugar de una tabla de comentarios.
4. **Identificadores por Hash SHA-1:**
   Los nombres de usuario se almacenan como hashes `sha1('username')` en la columna `user`, lo que vincula los nombres de archivo físicos con los registros de la base de datos.

---

## 📸 Características visuales
* **Frontend Web 2.0:** Maquetación líquida/fija clásica, degradados, bordes redondeados "artesanales" y retrocompatibilidad con navegadores antiguos.
* **Librerías integradas de la época:** jQuery 1.5.2, FancyBox 1.3.4, PHPThumb 3.0 (miniaturas al vuelo [`thumbs`]) y SWFObject 2.2 (Flash).

---

## 🛠️ Modernización y Capa Mock SQLite

Para ejecutar este sistema en servidores modernos sin modificar la lógica del código fuente legado, se integró **`libs/mysql.mock.php`**:

* **Emulador `mysql_*`:** Reemplaza las funciones eliminadas en PHP 7+ (`mysql_connect`, `mysql_query`, `mysql_fetch_object`, etc.) mapeándolas transparentemente a **PDO SQLite**.
* **Auto-Seeder dinámico:** Al iniciar, el mock escanea `base/files/`, extrae los hashes de las fotos existentes y crea automáticamente las cuentas de los estudiantes en SQLite (`uce_database.sqlite`) para evitar perfiles huérfanos.
* **Intercepción inteligente de consultas:** Detecta búsquedas de usuario en texto plano o SHA-1 y descarta comandos obsoletos de MySQL (`USE`, `CREATE DATABASE`).

---

## 🚀 Instalación y Puesta en Marcha

No se requiere Apache, Nginx ni MySQL. Solo necesitas tener PHP instalado en tu equipo.

### 1. Clonar el repositorio
```bash
git clone https://github.com/okzgn/mini-learning-management-system-2011-php.git
cd mini-learning-management-system-2011-php
```

### 2. Iniciar el servidor local
Ejecuta el servidor web embebido de PHP en la raíz del proyecto:
```bash
php -S localhost:8000
```

### 3. Abrir en el navegador
Ingresa a:
```
http://localhost:8000/index.php
```
*(La base de datos SQLite `libs/uce_database.sqlite` y las carpetas de almacenamiento se inicializarán automáticamente en la primera carga).*

---

## 📂 Estructura del Proyecto

```text
├── base/
│   ├── files/              # Almacén físico de tareas, fotos y archivos subidos
│   └── teacher/
│       ├── biganunce.jpg   # Banner principal
│       └── notes.txt       # Almacenamiento plano del muro de notas
├── libs/
│   ├── inside.php          # Helpers globales y punto de entrada
│   ├── members.php         # Manejador de conexión a BD
│   ├── mysql.mock.php      # Capa de emulación MySQL -> SQLite PDO
│   └── phpthumb/           # Librería para procesamiento de miniaturas GD
├── __data/                 # Assets (CSS, JavaScript, jQuery 1.5, plugins)
├── index.php               # Portal principal y muro de anuncios
├── students.php            # Directorio y fichas de estudiantes
├── users.php               # Panel de control (Admin / Docente / Alumno)
├── regis.php               # Formulario de registro de alumnos
├── upload_doc.php          # Procesador de subida de tareas (.doc, .xls, .ppt)
├── upload_photo.php        # Procesador de subida de fotos
├── putp.php                # Endpoint AJAX para calificar tareas
└── thumb.php               # Generador dinámico de thumbnails
```

---

## Licencia

Desarrollado por Elías Alvarado Soshina (2010–2011), actualmente [OKZGN](https://okzgn.com).

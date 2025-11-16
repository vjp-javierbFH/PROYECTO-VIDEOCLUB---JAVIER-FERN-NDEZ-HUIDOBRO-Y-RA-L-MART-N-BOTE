# PROYECTO VIDEOCLUB

**Desarrollo Web en Entorno Servidor (DWES) – Curso 2025/2026**

---

## Autores

- **Javier Baiyong Fernández Huidobro**
- **Raúl Martín Bote**

---

## Descripción

Este proyecto es una **aplicación web completa en PHP** para la gestión de un **videoclub digital**. Permite:

- Gestión de **clientes** (registro, edición, eliminación)
- Gestión de **soportes** (DVDs, cintas de video, juegos)
- Sistema de **alquiler y devolución**
- Panel de **administración** y **cliente**
- Autenticación segura con **hash de contraseñas**
- Interfaz web moderna con **HTML5, CSS3 y PHP puro**

> **Sin base de datos**: todo se almacena en `$_SESSION` (ideal para aprendizaje)

---

## Tecnologías Utilizadas

| Tecnología        | Uso |
|-------------------|-----|
| **PHP 8.1+**      | Lógica del servidor, sesiones, objetos |
| **HTML5**         | Estructura de páginas |
| **CSS3**          | Estilos modernos, responsive |
| **JavaScript**    | Confirmaciones (eliminar cliente) |
| **XAMPP**         | Servidor local (Apache + MySQL) |

---

## Estructura del Proyecto

## Clase Cliente (`Cliente.php`)

La clase `Cliente` gestiona a los socios del videoclub y sus alquileres/devoluciones de soportes.

### Atributos

| Atributo                  | Tipo    | Descripción |
|---------------------------|---------|-------------|
| `nombre`                  | string  | Nombre del cliente |
| `numero`                  | int     | ID único del cliente |
| `user`                    | string  | Nombre de usuario (login) |
| `password`                | string  | Contraseña hasheada |
| `maxAlquilerConcurrente`  | int     | Máximo de alquileres simultáneos (default: 3) |
| `numSoportesAlquilados`   | int     | Contador de soportes alquilados |
| `soportesAlquilados`      | array   | Array de soportes alquilados |

### Métodos Principales

| Método                  | Descripción |
|-------------------------|-------------|
| `getNumero()` / `setNumero()` | Obtener/establecer número de cliente |
| `getNumSoporteAlquilado()` | Cantidad de soportes alquilados |
| `getNombre()`           | Obtiene el nombre completo |
| `getUser()`             | Obtiene el usuario |
| `getPassword()`         | Obtiene la contraseña hasheada |
| `getAlquileres()`       | Devuelve el array de alquileres |
| `setNombre()`, `setUser()`, `setPassword()`, `setMaxAlquilerConcurrente()` | Modifican datos del cliente |
| `alquilar(Soporte $s)`  | Alquila un soporte (con validaciones) |
| `devolver(int $id)`     | Devuelve soporte por número |
| `listarAlquileres()`    | Lista soportes alquilados |

### Manejo de Excepciones

- `SoporteYaAlquiladoException`: Soporte ya alquilado por otro cliente
- `CupoSuperadoException`: Límite de alquileres concurrentes alcanzado
- `SoporteNoEncontradoException`: Soporte no alquilado por el cliente

### Ejemplo de Uso

```php
$cliente = new Cliente("Bruce Wayne", 101, "bruce", password_hash("batman", PASSWORD_DEFAULT));
$juego = new Juego("God of War", 1, 19.99, "PS4", 1, 1);
$cliente->alquilar($juego);
$cliente->listarAlquileres();
$cliente->devolver(1);
```

### **Clase Videoclub** (`Videoclub.php`)

La clase `Videoclub` es el **núcleo** de la aplicación, encargada de gestionar los **productos** (cintas de video, DVDs y juegos) y los **socios** del videoclub, así como las operaciones de **alquiler** y **devolución**.

### **Atributos**

| Atributo                  | Tipo    | Descripción |
|---------------------------|---------|-------------|
| `nombre`                  | String  | Nombre del videoclub |
| `productos`               | Array   | Array de soportes (cintas, DVDs, juegos) |
| `numProductos`            | int     | Contador de productos totales |
| `socios`                  | Array   | Array de clientes (socios) |
| `numSocios`               | int     | Contador de socios totales |
| `numProductosAlquilados`  | int     | Contador de productos actualmente alquilados |
| `numTotalAlquileres`      | int     | Contador del total de alquileres realizados |

### **Métodos Principales**

| Método                          | Descripción |
|---------------------------------|-------------|
| `__construct($nombre)`          | Inicializa el videoclub con un nombre y arrays vacíos |
| `incluirCintaVideo($titulo, $precio, $duracion)` | Añade una cinta de video al inventario |
| `incluirDvd($titulo, $precio, $idiomas, $pantalla)` | Añade un DVD al inventario |
| `incluirJuego($titulo, $precio, $consola, $minJ, $maxJ)` | Añade un juego al inventario |
| `incluirSocio($nombre, $maxAlquileresConcurrentes)` | Registra un nuevo cliente |
| `listarProductos()`             | Muestra un resumen de todos los productos |
| `listarSocios()`                | Muestra información de todos los socios |
| `alquilarSocioProducto($numCliente, $numerosProductos)` | Alquila múltiples productos a un cliente |
| `devolverSocioProducto($numSocio, $numeroProducto)` | Devuelve un producto por su número |
| `devolverSocioProductos($numSocio, $numerosProductos)` | Devuelve múltiples productos |
| `buscarSoporte($numeroSoporte)` | Busca un soporte por su número único |
| `getNumProductosAlquilados()`   | Obtiene el número de productos alquilados |
| `getNumTotalAlquileres()`       | Obtiene el total de alquileres realizados |

### **Manejo de Excepciones**

- `SoporteYaAlquiladoException`: Se lanza cuando un producto ya está alquilado.
- `CupoSuperadoException`: Indica que un cliente ha excedido su límite de alquileres concurrentes.
- `SoporteNoEncontradoException`: Ocurre cuando un producto no se encuentra en el inventario o en los alquileres del cliente.
- `ClienteNoEncontradoException`: Se lanza cuando no se encuentra un cliente con el número proporcionado.

## Panel de Administración (`mainAdmin.php`)

### Acceso

- **URL**: `mainAdmin.php`
- **Requisito**: Iniciar sesión como `admin / admin`

### Funcionalidades

| Acción | Descripción |
|--------|-------------|
| **Listado de Clientes** | Tabla con: **Nº Cliente**, **Nombre**, **Usuario**, **Alquileres Activos** |
| **+ Nuevo Cliente** | Botón que lleva a `formCreateCliente.php` |
| **Editar Cliente** | Icono que lleva a `formUpdateCliente.php?numero=XXX` |
| **Eliminar Cliente** | Botón rojo con `confirm()` en JavaScript → `removeCliente.php` |
| **Listado de Soportes** | Muestra todos los soportes con: **título**, **precio con IVA**, **estado (Alquilado/Disponible)** |

### Mensajes

- **Verde**: `"Cliente eliminado correctamente."`
- **Rojo**: `"No se puede eliminar al cliente porque tiene alquileres activos."`

---

## Panel de Cliente (`mainCliente.php`)

### Acceso

- **URL**: `mainCliente.php`
- **Requisito**: Iniciar sesión como cliente (ej: `bruce / batman`)

### Funcionalidades

| Acción | Descripción |
|--------|-------------|
| **Bienvenida** | `"Bienvenido, bruce"` |
| **Editar Perfil** | Botón → `formUpdateCliente.php?numero=XXX` |
| **Mis Alquileres** | Lista con: |
| | • `muestraResumen()` del soporte |
| | • Precio con IVA |
| | • Botón **Devolver** → `devolverSoporte.php` |

---

## Seguridad

- **Contraseñas** con `password_hash()` y `password_verify()`
- **Validación de roles** en cada página
- **Protección contra XSS** (`htmlspecialchars`)
- **Confirmación JS** antes de eliminar
- **Redirecciones seguras**

---


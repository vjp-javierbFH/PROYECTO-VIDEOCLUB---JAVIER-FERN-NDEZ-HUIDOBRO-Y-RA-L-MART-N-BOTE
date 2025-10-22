<h1>PROYECTO VIDEOCLUB</h1>
<h3>Autores</h3>
<ul>
  <li>Javier Baiyong Fernández Huidobro</li>
  <li>Raúl Martín Bote</li>
</ul>
<h3>Descripción</h3>
<p>Este proyecto es una aplicación web desarrollada en PHP para la gestión de un videoclub. Permite administrar cintas de video, juegos, dvd, clientes, préstamos, devoluciones y consultar el estado del inventario.</p>

<p>El objetivo es ofrecer una solución sencilla para un negocio de alquiler de vídeos, con un sistema de registro y seguimiento de las operaciones principales.</p>
<h3>Tecnologias utilizadas</h3>
<ul>
  <li>Lenguaje de programación: PHP</li>
  <li>HTML/CSS para la presentación</li>
</ul>

## 🏢 **Clase Cliente** (`Cliente.php`)

La clase `Cliente` gestiona a los socios del videoclub y sus alquileres/devoluciones de soportes.

### 📋 **Atributos**
| Atributo                  | Tipo    | Descripción |
|---------------------------|---------|-------------|
| `nombre`                  | String  | Nombre del cliente |
| `numero`                  | int     | ID único del cliente |
| `maxAlquilerConcurrente`  | int     | Máximo de alquileres simultáneos (default: 3) |
| `numSoportesAlquilados`   | int     | Contador de soportes alquilados |
| `soportesAlquilados`      | array   | Array de soportes alquilados |

### 🔧 **Métodos Principales**

| Método                  | Descripción |
|-------------------------|-------------|
| `getNumero()` / `setNumero()` | Obtener/establecer número de cliente |
| `getNumSoporteAlquilado()` | Cantidad de soportes alquilados |
| `mostrarCliente()`      | Muestra info completa del cliente |
| `tieneAlquilado(Soporte)` | Verifica si tiene un soporte alquilado |
| `alquilar(Soporte)`     | Alquila un soporte (con validaciones) |
| `devolver(int)`         | Devuelve soporte por número |
| `listarAlquileres()`    | Lista soportes alquilados |

### ⚠️ **Manejo de Excepciones**
- `SoporteYaAlquiladoException`: Soporte ya alquilado por el cliente
- `CupoSuperadoException`: Límite de alquileres concurrentes alcanzado
- `SoporteNoEncontradoException`: Soporte no alquilado por el cliente

### 💡 **Ejemplo de Uso**
```php
$cliente = new Cliente("Bruce Wayne", 23);
$pelicula = new Dvd("Los cazafantasmas", 23, 3.5, 107);
$cliente->alquilar($soporte);
$cliente->listarAlquileres();
$cliente->devolver(1);
```

### 🏢 **Clase Videoclub** (`Videoclub.php`)

La clase `Videoclub` es el **núcleo** de la aplicación, encargada de gestionar los **productos** (cintas de video, DVDs y juegos) y los **socios** del videoclub, así como las operaciones de **alquiler** y **devolución**.

### 📋 **Atributos**

| Atributo                  | Tipo    | Descripción |
|---------------------------|---------|-------------|
| `nombre`                  | String  | Nombre del videoclub |
| `productos`               | Array   | Array de soportes (cintas, DVDs, juegos) |
| `numProductos`            | int     | Contador de productos totales |
| `socios`                  | Array   | Array de clientes (socios) |
| `numSocios`               | int     | Contador de socios totales |
| `numProductosAlquilados`  | int     | Contador de productos actualmente alquilados |
| `numTotalAlquileres`      | int     | Contador del total de alquileres realizados |

### 🔧 **Métodos Principales**

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

### ⚠️ **Manejo de Excepciones**
- `SoporteYaAlquiladoException`: Se lanza cuando un producto ya está alquilado.
- `CupoSuperadoException`: Indica que un cliente ha excedido su límite de alquileres concurrentes.
- `SoporteNoEncontradoException`: Ocurre cuando un producto no se encuentra en el inventario o en los alquileres del cliente.
- `ClienteNoEncontradoException`: Se lanza cuando no se encuentra un cliente con el número proporcionado.

# SLIM API REST: ABM
Éste es un ejemplo sencillo de cómo utilizar Slim Framework 3 para realizar consultas , altas, bajas, y modificaciones. 
Através del protocolo http se realizan las diferentes peticiones.

# Configuraciones:
Para reutilizar el código basta con unas pocas modificaciones para que se adapten a cualquier proyecto. Hay que configurar tres archivos: `db.php`, `genericDAO.php` e `index.php`
# En el archivo `db.php`:
Aquí se encuentra a clase `DB` construida para obtener la única instancia de un PDO, que deberá apunta a la base de datos que se necesite. Para ello modificar las siguientes líneas:
```sh
8            $DNS = 'mysql:host=localhost;';
9            $DBName = 'dbname=ejemploabm;';
10           $username = 'root';
11           $password = '';
```
# En el archivo `genericDAO.php`:
Contiene la clase `GenericDAO`. En ésta clase se crearán los métodos necesarios para realizar las consultas a la base de datos ya configurada en el paso anterior.
# En el archivo `index.php`:
En ésta clase se hace uso de [Slim](https://www.slimframework.com/).
# Workflow: interacción entre las tres clases anteriormente mencionadas.
La interacción es simple. Desde `php.index` recibimos las request según las rutas manejadas por Slim (ver [Slim routing](https://www.slimframework.com/docs/objects/router.html)).
Si trabajamos de forma local la ruta del ejemplo será "localhost:/table/{table}" donde `{table}` es un parámetro.
Las rutas reciben las peticiones y ejecutan métodos alojados en `genericDAO.php`.
En el ejemplo, la ruta creada ejecuta el método `getAll()`.
Los métodos se alojan en la clase `GenericDAO` (genericDAO.php) y realizan las consultas a la base de datos.
Viene incluido el siguiente código de ejemplo:
```sh
 public static function getAll($table){
        try{
			$db = GenericDAO::getPDO();

			$sql = "select * from ".$table;
			$resultado = $db->sendQuery($sql);
			$resultado->execute();
            $rv = $resultado->fetchAll(PDO::FETCH_ASSOC);
			return json_encode($rv);
		}catch(Exception $ex){
			die("Error: " . $ex->getMessage());
		}
    }
```
Sintetizando un poco, en cada método que se quiera crear debemos:
- Llamar al método `getPDO()` para obtener la referencia a la base de datos.
- Utilizar el método `sendQuery()` para enviar la consulta como un parámetro string.

En éste caso convertimos la respuesta en un `JSON` el cual será el valor de retorno de la función.
Éste valor de retorno es utilizado por Slim y enviado como respuesta a la petición inicial.


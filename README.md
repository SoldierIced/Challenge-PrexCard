# Proyecto API de GIFs con Laravel

Este proyecto es una API construida con Laravel que permite a los usuarios autenticarse, buscar GIFs utilizando la API de Giphy, guardar GIFs como favoritos y ver sus GIFs favoritos.

### Consideraciones al Cambiar Puertos o URL

Recordar que si tienen instalado Wamp /Xamp puede estar usando los mismos puertos que usa este proyecto. (se recomiendo cerrarlos).
Si decides modificar los puertos o la URL base de la aplicación, asegúrate de actualizar los siguientes archivos para que reflejen los cambios:

-   **Archivo `docker-compose.yml`**:
    -   Cambia los puertos mapeados en las secciones de `app` o `webserver`.
-   **Archivo `nginx.conf`**:
    -   Ajusta las configuraciones del servidor web para el nuevo puerto o URL.
-   **Archivo `Challenge-PrexCard.postman_collection.json`**:
    -   Actualiza la variable `baseUrl` dentro de la colección si estás utilizando Postman.
-   **Archivo `.env`**:
    -   Asegúrate de ajustar las variables relacionadas con el `APP_URL` o la configuración de la base de datos según los cambios realizados.

---

### Configuración de Errores en el Archivo `.env`

En el archivo `.env`, encontrarás una variable llamada `SHOW_ERR`. Esta variable controla si los errores reales de código se muestran o no al usuario:

-   **`SHOW_ERR=true`**: Muestra los errores reales, útil en entornos de desarrollo para depuración.
-   **`SHOW_ERR=false`**: Oculta los errores reales, mostrando mensajes genéricos, recomendado para entornos de producción.

Asegúrate de configurar esta variable según las necesidades de tu entorno.

## Casos de Uso del Sistema

### Actores

1. **Usuario**: Cliente que interactúa con el sistema para buscar y guardar GIFs.
2. **Giphy API**: Servicio externo que provee los datos de los GIFs.

### Casos de Uso

1. **Autenticación**:

    - **Registro**: Los usuarios pueden registrarse en el sistema proporcionando sus datos.
    - **Inicio de Sesión**: Los usuarios pueden iniciar sesión para acceder a las funcionalidades protegidas.

2. **Gestión de GIFs**:

    - **Buscar GIFs**: Los usuarios pueden buscar GIFs por términos específicos utilizando la API de Giphy.
    - **Guardar GIFs Favoritos**: Los usuarios pueden guardar GIFs en su perfil para acceder a ellos posteriormente.
    - **Ver GIFs Favoritos**: Los usuarios pueden listar los GIFs que han guardado previamente.

3. **Manejo de Errores**:
    - El sistema registra errores relacionados con solicitudes HTTP y excepciones en la base de datos para auditoría y diagnóstico.

## Diagramas de Secuencia

### 1. Registro

1. El cliente envía una solicitud `POST` al endpoint `/api/register` con los datos de registro.
2. El **AuthController** valida los datos y crea un nuevo usuario en la base de datos.
3. Se genera un token de acceso para el usuario autenticado.
4. El sistema responde con el token y los detalles del usuario.

### 2. Inicio de Sesión

1. El cliente envía una solicitud `POST` al endpoint `/api/login` con sus credenciales.
2. El **AuthController** verifica las credenciales.
3. Se genera un token de acceso si las credenciales son válidas.
4. El sistema responde con el token y los detalles del usuario.

### 3. Buscar GIFs

1. El cliente envía una solicitud `GET` al endpoint `/api/gifs/search` con el término de búsqueda.
2. El **GifController** recibe la solicitud y llama al **GifService**.
3. El **GifService** utiliza el **HttpClient** para enviar una solicitud a la API de Giphy.
4. La respuesta de Giphy es procesada y devuelta al **GifController**.
5. El sistema responde al cliente con los resultados de la búsqueda.

### 4. Guardar GIFs Favoritos

1. El cliente envía una solicitud `POST` al endpoint `/api/gifs/favorites` con el ID del GIF.
2. El **GifController** verifica la autenticación del usuario.
3. Se guarda la relación entre el usuario y el GIF en la tabla intermedia `gif_user`.
4. El sistema responde con un mensaje de éxito.

### 5. Ver GIFs Favoritos

1. El cliente envía una solicitud `GET` al endpoint `/api/gifs/favorites`.
2. El **GifController** verifica la autenticación del usuario.
3. Se recuperan los GIFs favoritos del usuario desde la base de datos.
4. El sistema responde con la lista de GIFs favoritos.

## Diagrama de Datos (DER)

### Tablas Principales

1. **`users`**:

    - Almacena información de los usuarios registrados.
    - Campos principales: `id`, `name`, `email`, `password`, `created_at`, `updated_at`.

2. **`gifs`**:

    - Almacena información de los GIFs obtenidos de Giphy.
    - Campos principales: `id`, `url`, `slug`, `embed_url`, `username`, `source`, `title`, `source_tld`, `alt_text`, `created_at`, `updated_at`.

3. **`gif_user`**:

    - Tabla intermedia que relaciona usuarios con GIFs (muchos a muchos).
    - Campos principales: `id`, `user_id`, `gif_id`, `created_at`, `updated_at`.

4. **`error_logs`**:
    - Almacena información sobre errores ocurridos en el sistema.
    - Campos principales: `id`, `error_type`, `message`, `file`, `line`, `code`, `url`, `trace`, `created_at`.

### Relaciones

-   **Usuarios y GIFs**:
    -   Relación de muchos a muchos a través de `gif_user`.
    -   Un usuario puede tener muchos GIFs favoritos.
    -   Un GIF puede ser favorito de muchos usuarios.

## Colección POSTMAN

### Descripción

El archivo \`Challenge-PrexCard.postman_collection.json\` incluido en el proyecto contiene las solicitudes necesarias para interactuar con la API. Para utilizarlo:

La colección **`Challenge-PrexCard.postman_collection.json`** contiene las solicitudes necesarias para interactuar con la API, para usarlo:

1. Abre Postman.
2. Ve a la sección **Importar**.
3. Selecciona el archivo \`Challenge-PrexCard.postman_collection.json\`.
4. Configura un entorno con las variables necesarias, como \`baseUrl\` y \`authToken\`.

### Rutas

1. **Auth**:

    - **Registro** (`POST /api/register`)
    - **Inicio de Sesión** (`POST /api/login`)
    - Al iniciar sesión, el token se guarda automáticamente en la variable de entorno `authToken`.

2. **gifs**:

    - **Buscar GIFs** (`GET /api/gifs/search`)
    - **Guardar GIF Favorito** (`POST /api/gifs/favorites`)
    - **Listar GIFs Favoritos** (`GET /api/gifs/favorites`)

3. **User**:
    - Solicitudes relacionadas con la información del usuario.

#### Configuración de Variables de Entorno

1. Ve a **Postman > Environments**.
2. Crea un nuevo entorno con las siguientes variables:
    - \`baseUrl\`: La URL base de la API (por ejemplo, \`http://localhost:8081/api\`).
    - \`authToken\`: Inicialmente vacío; se llenará automáticamente después del inicio de sesión.

## Docker

Si deseas utilizar Docker para correr el proyecto, sigue estos pasos:

1. **Construir los Contenedores**  
   Ejecuta el siguiente comando para construir los servicios definidos en `docker-compose.yml`:

    ```bash
    docker-compose build
    ```

2. **Levantar los Contenedores**  
   Levanta los servicios en segundo plano:

    ```bash
    docker-compose up -d
    ```

3. **Acceder al Contenedor de Laravel**  
   Ingresa al contenedor `challenge-prexcard-app`:

    ```bash
    docker exec -it challenge-prexcard-app bash
    ```

4. **Instalar Dependencias de Composer**  
   Dentro del contenedor, instala las dependencias de Laravel:

    ```bash
    composer install
    ```

5. **Ejecutar Migraciones**  
   Asegúrate de que las tablas de la base de datos sean creadas correctamente:

    ```bash
    php artisan migrate
    ```

6. **Acceso a la Aplicación**  
   Una vez completados los pasos, la aplicación estará disponible en:
    ```
    http://localhost:8081
    ```

Con estos comandos, tu entorno estará configurado y listo para usar. 🚀

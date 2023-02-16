1. Inicializar proyecto

*   Instalación de Homestead

    Homestead es una máquina virtual que contiene todas las herramientas necesarias para el desarrollo de aplicaciones en Laravel. Para este paso deberá consultar la documentación oficial de Laravel, también puede consultar otras fuentes.

*   Clonar e instalar proyecto desde Gitlab

    Deberá crear un fork del proyecto ([link](https://gitlab.com/luisfergago/laravel-ejercicio)) a un repositorio personal que deberá configurar como público, seguido debe clonar el proyecto para luego instalar la aplicación en la máquina virtual. A partir de este momento se espera que utilice git para manejar el código del proyecto.

*   Instalar Git Flow

    Es un conjunto de extensiones para git que proveen comandos de alto nivel para operar repositorios basados en el modelo de ramificaciones de Vincent Driessen. Instale el paquete en su máquina virtual e inicialice la extensión dentro de la carpeta del proyecto. Durante el ejercicio trabajaremos en las ramas develop y feature, la rama master es exclusivamente para despliegue a producción.

*   Instalar dependencias de proyecto

    Utilizaremos laravel-permission para el manejo de roles y permisos. Es el único paquete solicitado en este ejercicio, queda a discreción el uso de paquetes adicionales.

2. Descripción del proyecto

    El proyecto consiste en una aplicación que permite registrarse como usuario a través de un correo electrónico y contraseña. Dentro del mismo podemos crear, ver, editar y eliminar posts que pertenecen a nuestro usuario. Tenemos una sección de feed, donde podemos ver posts de otros usuarios (ordenados por fecha y hora) y comentar en ellos, sólo si somos los autores del comentario, podemos editarlo o eliminarlo. Cada usuario tiene un perfil que puede editar, agregando su nombre completo, fecha de nacimiento y nacionalidad.

*   Utilice las vistas y componentes de la plantilla [AdminLTE](https://adminlte.io/themes/AdminLTE/index2.html) para el frontend.
*   Los comentarios son un recurso anidado de los posts y ambos pertenecer a un usuario. (ej: dominio.test/post/10/comentario/20)
*   La lista de países para la nacionalidad del usuario debe mostrarse en un tag select utilizando a discreción una librería de JS que permita la búsqueda del país. La búsqueda debe realizarse por ajax o axios (no cargar a la vista todos los países).
*   Crear un usuario Super-admin (utilizando laravel-permission), este tiene permisos para realizar cualquier acción en posts o comentarios de cualquier usuario. Crear el rol y permisos pertinentes para cada acción del CRUD.
*   Para cada modelo, crear su propio factory para llenar con datos dummies la base de datos utilizando seeders.
*   Para cada recurso que tenga el CRUD básico, crear tests unitarios en phpunit.

Al finalizar, envíe el link de su repositorio para la revisión del mismo.

<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TIENDA Kuday | ADD PRODUCTO</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Datatables CSS -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- CSS Propio -->
    <link rel="stylesheet" href="CSS/styles.css">

</head>

<body id="body_agregar_producto">

    <header>

        <nav class="navbar fixed-top navbar-expand-lg barranav border rounded">
            <div class="container-fluid">

                <a class="navbar-brand marca align-self-center text-center" href="index.php#inicio">Kuday Artesanias</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarScroll">
                    <ul class="navbar-nav ms-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 600px; margin-right:50px;">
                        <li class="nav-item">
                            <a class="nav-link active boton-nav" href="index.php#inicio">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active boton-nav" aria-current="page" href="#promociones">Promociones</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active boton-nav" href="tienda.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Productos
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="cartucheras.php">Cartucheras / Neceser</a></li>
                                <hr class="dropdown-divider">
                                <li><a class="dropdown-item" href="setsmateros.php">Sets Materos</a></li>
                                <hr class="dropdown-divider">
                                <li><a class="dropdown-item " href="billeteras.php">Billeteras</a></li>
                                <hr class="dropdown-divider">
                                <li><a class="dropdown-item" href="bolsomatero.php">Bolso Matero</a></li>
                                <hr class="dropdown-divider">
                                <li><a class="dropdown-item" href="bandoleras.php">Bandoleras</a></li>
                                <hr class="dropdown-divider">
                                <li><a class="dropdown-item" href="varios.php">Varios</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active boton-nav" href="#">Contactános</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section id="session-adm">

        <div class="container" style="max-height: auto;">


            <div class="row">
                <div class="col-10 text-center">
                    <h2>Inicio de Sesion al panel</h2>
                </div>

            </div>

            <form action="componentes/acceder.php" method="POST">

                <label for="adm" class="form-label">Usuario:</label>
                <input type="text" name="usuario-admin" id="adm" class="form-control mb-3" placeholder="Usuario" autocomplete="off">
                <label for="pass" class="form-label">Contraseña:</label>
                <input type="password" name="pass-admin" id="pass" class="form-control mb-3" placeholder="Password">
                <input type="submit" value="Acceder" class="btn btn-success m-1">
                <a href="componentes/salir.php" class="btn btn-dark m-1">Salir</a>

            </form>
            <div id="msj-session"></div>

        </div>

    </section>

    <?php if (isset($_SESSION['administrador'])) { ?>

        <section id="panel">

            <div class="container panel-adm">

                <div class="row m-2 p-1">
                    <h3 class="text-center p-3">Agregar Productos a tienda kuday</h3>
                </div>

                <div class="row m-2 p-2" style="max-height: auto;">

                    <form action="componentes/cargar_productos.php" class="form-group" method="POST" enctype="multipart/form-data">
                        <div class="col-4 mb-1 p-1">
                            <label for="seleccionProducto" class="col-form-label fs-6 fw-semibold ps-1">Elija que Producto quiere agregar al carrito:</label>
                            <select name="producto" id="seleccionProducto" class="form-select" required>
                                <option value="" disabled selected>Selecciona una opción</option>
                                <option value="Cartuchera">Cartuchera</option>
                                <option value="Neceser">Neceser</option>
                                <option value="Bolso Matero">Bolso Matero</option>
                                <option value="Set Matero">Set Matero</option>
                                <option value="Billetera">Billetera</option>
                                <option value="Bandolera">Bandolera</option>
                                <option value="Varios">Varios</option>
                            </select>
                        </div>
                        <div class="col-6 mb-1 p-1">
                            <label for="inputNombre" class="col-form-label fs-6 fw-semibold ps-1">Nombre del Producto</label>
                            <input type="text" name="nombre" id="inputNombre" class="form-control fw-light fst-italic" placeholder="Cartuchera Psicodélica" maxlength="50" required autocomplete="off">
                        </div>
                        <div class="col-6 mb-1 p-1">
                            <label for="inputId" class="col-form-label fs-6 fw-semibold ps-1">ID del Producto</label>
                            <input type="number" name="id_producto" id="inputId" class="form-control fw-light fst-italic" placeholder="Cartucheras 1-100 Set Materos 101-200 etc" min="1" max="10000" required>
                        </div>
                        <div class="col-6 mb-1 p-1">
                            <label for="inputprecio" class="col-form-label fs-6 fw-semibold ps-1">Precio del Producto:</label>
                            <input type="number" name="precio" id="inputprecio" class="form-control fw-light fst-italic" placeholder="$8500" min="5000" max="450000" autocomplete="off" required>
                        </div>
                        <div class="col-6 mb-1 p-1">
                            <label for="descripcion" class="col-form-label fs-6 fw-semibold ps-1">Descripción del Producto</label>
                            <textarea name="descripcion" id="descripcion" rows="5" placeholder="Descripción del Producto, medidas, colores, etc..." class="form-control" required></textarea>
                        </div>
                        <div class="col-8 mb-2 p-1">
                            <label for="subirfoto" class="col-form-label fs-6 fw-semibold ps-1">Subir Foto: (.jpg, .gif, .png) (Max: 200KB)</label>
                            <input type="file" name="foto_producto" id="subirfoto" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-8 mb-2 p-1">
                            <input type="submit" class="form-control btn btn-primary w-50" value="Cargar PRODUCTO">
                        </div>
                    </form>
                    <?php
                    if (isset($_GET['error_formato'])) {
                        echo "<p>El formato del archivo no coincide con el pedido. La imagen tiene que ser .png, .gif, .jpg</p>";
                    }

                    if (isset($_GET['error_peso'])) {
                        echo "<p>El peso del archivo EXCEDE lo especificado. El peso de la imagen debe ser menor a 200KB.</p>";
                    }

                    if (isset($_GET['ok'])) {
                        echo "<p>Producto cargado correctamente.</p>";
                    }

                    ?>
                </div>

            </div>


        </section>

        <section id="listar-productos">

            <div class="container fondo-panel">

                <div class="show-details row justify-content-evenly">
                    <div class="col text-center align-content-center">
                        <form action="componentes/listar_productos.php" method="POST">

                            <label for="seleccionCategoria" class="col-form-label fs-6 fw-semibold ps-1">Elija un producto de la tienda para MODIFICAR/ELIMINAR:</label>
                            <select name="categoria" id="seleccionCategoria" class="form-select" required>
                                <option value="" disabled selected>Selecciona una opción</option>
                                <option value="Cartuchera">Cartuchera</option>
                                <option value="Neceser">Neceser</option>
                                <option value="Bolso Matero">Bolso Matero</option>
                                <option value="Set Matero">Set Matero</option>
                                <option value="Billetera">Billetera</option>
                                <option value="Bandolera">Bandolera</option>
                                <option value="Varios">Varios</option>
                            </select>
                            <input type="submit" class="btn btn-danger form-control ms-auto mt-2 mb-2 w-50" value="Buscar">

                        </form>
                    </div>
                    <div class="col text-center align-content-center">
                        <button class="btn btn-dark"><a href="panel.php#listar-productos" class="anchor_boton">Borrar lista</a></button>
                    </div>

                </div>
                <div class="col-12 table-responsive">
                    <table class="table table-striped table-bordered table-sm tabla-listas display" id="tabla-resultado">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Categoria</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>IMG</th>
                                <th>FUNCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            if (isset($_SESSION['productos'])) { ?>

                                <?php
                                $productos = $_SESSION['productos'];
                                foreach ($productos as $producto) { ?>
                                    <tr>
                                        <td><?php echo $producto['id_producto']; ?></td>
                                        <td><?php echo $producto['categoria_producto']; ?></td>
                                        <td><?php echo $producto['nombre_producto']; ?></td>
                                        <td><?php echo $producto['descripcion_producto']; ?></td>
                                        <td>$<?php echo $producto['precio_producto']; ?></td>
                                        <td class="img-fetched">

                                            <?php if (!empty($producto['ci_imagen_producto'])): ?>

                                                <?php
                                                // Convertir los datos binarios de la imagen a base64 para mostrar en HTML
                                                $img_data = base64_encode($producto['ci_imagen_producto']);
                                                $img_type = $producto['formato_imagen'];
                                                echo "<img src='data:$img_type;base64,$img_data' alt='Imagen del producto' width='100' height='100'>";
                                                ?>
                                            <?php else: ?>
                                                <p>Sin imagen</p>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="celda_func">
                                                <!-- Botón para modificar -->
                                                <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modificarModal<?php echo $producto['id_producto']; ?>">
                                                    Modificar
                                                </button>

                                                <!-- Modal de modificar -->
                                                <div class="modal fade" id="modificarModal<?php echo $producto['id_producto']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modificarLabel<?php echo $producto['id_producto']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="modificarLabel<?php echo $producto['id_producto']; ?>">Modificar Producto</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" action="modificar_producto.php" enctype="multipart/form-data" id="modalmod">
                                                                    <input type="hidden" name="id" value="<?php echo $producto['id_producto']; ?>">

                                                                    <label for="nombre_producto<?php echo $producto['id_producto']; ?>" class="label_listar_modal">Nombre</label>
                                                                    <input type="text" name="nombre" id="nombre_producto<?php echo $producto['id_producto']; ?>" class="form-control mb-2" value="<?php echo $producto['nombre_producto']; ?>">

                                                                    <label for="precio_producto<?php echo $producto['id_producto']; ?>" class="label_listar_modal">Precio</label>
                                                                    <input type="number" step="0.01" name="precio" id="precio_producto<?php echo $producto['id_producto']; ?>" class="form-control mb-2" value="<?php echo $producto['precio_producto']; ?>">

                                                                    <label for="descripcion_producto<?php echo $producto['id_producto']; ?>" class="label_listar_modal">Descripción</label>
                                                                    <textarea name="descripcion" id="descripcion_producto<?php echo $producto['id_producto']; ?>" class="form-control mb-2"><?php echo $producto['descripcion_producto']; ?></textarea>

                                                                    <label for="modificarFoto<?php echo $producto['id_producto']; ?>" class="label_listar_modal">Subir Foto (.jpg, .gif, .png)</label>
                                                                    <div>
                                                                        <?php if (!empty($producto['ci_imagen_producto'])): ?>
                                                                            <?php
                                                                            $img_data = base64_encode($producto['ci_imagen_producto']);
                                                                            $img_type = $producto['formato_imagen'];
                                                                            echo "<img src='data:$img_type;base64,$img_data' alt='Imagen del producto' width='100' height='100'>";
                                                                            ?>
                                                                        <?php else: ?>
                                                                            <p>Sin imagen disponible</p>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                    <input type="file" name="foto_producto" id="modificarFoto<?php echo $producto['id_producto']; ?>" class="form-control form-control-sm mb-2" accept=".jpg, .jpeg, .png, .gif">


                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
                                                                        <button type="submit" class="btn btn-primary">Modificar</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Botón para eliminar -->
                                                <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#eliminarModal<?php echo $producto['id_producto']; ?>">
                                                    Eliminar
                                                </button>

                                                <!-- Modal de eliminar -->
                                                <div class="modal fade" id="eliminarModal<?php echo $producto['id_producto']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="eliminarLabel<?php echo $producto['id_producto']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="eliminarLabel<?php echo $producto['id_producto']; ?>">Eliminar Producto</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>¿Estás seguro que deseas eliminar el producto "<?php echo $producto['nombre_producto']; ?>"?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                <form method="POST" action="eliminar_producto.php" style="display:inline;">
                                                                    <input type="hidden" name="id" value="<?php echo $producto['id_producto']; ?>">
                                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                            <?php }
                            } else {
                                echo 'No hay productos para mostrar.';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    <?php  } ?>

    <!-- jQuery JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- DataTables JS -->
    <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- Configuracion de la datatable x script -->
    <script>
        $(document).ready(function() {
            $('#tabla-resultado').DataTable({
                // Opciones de personalización
                "paging": true, // Activar paginación
                "lengthMenu": [5, 10, 20, 50], // Opciones de elementos por página
                "searching": true, // Activar la barra de búsqueda
                "responsive": true, // Activa el modo responsive de DataTables
                "scrollX": true, // Habilita el scroll horizontal si es necesario
                "ordering": true, // Activar ordenamiento de columnas
                "order": [
                    [0, "asc"]
                ], // Ordenar por la primera columna en orden descendente
                "info": true, // Mostrar información sobre la tabla (ej. "Mostrando 1-10 de 50 entradas")
                "autoWidth": true, // Ajuste automático de ancho de columnas
                "language": { // Personalizar los textos (idioma español)
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "zeroRecords": "No se encontraron resultados",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }

            });
        });
    </script>
</body>

</html>
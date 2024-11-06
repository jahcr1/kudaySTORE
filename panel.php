<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TIENDA Kuday | PANEL ADMINISTRATIVO</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Datatables CSS -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- CSS Propio -->
    <link rel="stylesheet" href="CSS/styles.css">

</head>

<body id="body-panel">

    <header>

        <nav class="navbar fixed-top navbar-expand-lg panel-nav">
            <div class="container-fluid contenedor-barra">

                <a class="navbar-brand marca align-self-center text-center" href="index.php#inicio">Kuday Artesanias</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#panel-navbarScroll" aria-controls="panel-navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="panel-navbarScroll">
                    <ul class="navbar-nav ms-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 600px;">
                        <li class="nav-item">
                            <a class="nav-link active boton-nav" href="index.php#inicio">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active boton-nav" aria-current="page" href="#panel">Agregar Producto</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active boton-nav" href="tienda.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Tienda
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="vistas/cartucheras.php">Cartucheras / Neceser</a></li>
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

        <div class="container login">
            <div class="row">
                <div class="text-center">
                    <h2>Inicio de Sesion al panel</h2>
                </div>
            </div>

            <form action="componentes/acceder.php" method="POST">

                <label for="adm" class="form-label">Usuario:</label>
                <input type="text" name="usuario-admin" id="adm" class="form-control mb-3" placeholder="Usuario" autocomplete="off">
                <label for="pass" class="form-label">Contraseña:</label>
                <input type="password" name="pass-admin" id="pass" class="form-control mb-3" placeholder="Password">
                <input type="submit" value="Acceder" class="btn btn-success m-1">
                <a href="componentes/salir.php" class="btn btn-dark btn-salir m-1" onclick="return confirm('¿Estás seguro de que deseas cerrar la sesión?');">Cerrar Sesión</a>

            </form>
            <div id="msj-session"></div>

        </div>

    </section>

    <?php if (isset($_SESSION['administrador'])) { ?>

        <section id="panel">

            <div class="container panel-adm">

                <div class="row m-2 titulo-panel-carga">
                    <h3 class="p-3">Agregar Productos a Tienda kuday</h3>
                </div>
                <div class="row paneles">
                    <div class="col-7 panel-carga">

                        <form action="componentes/cargar_productos.php" class="form-group" method="POST" enctype="multipart/form-data" id="formulario-carga">
                            <div class="mb-1 p-1">
                                <label for="seleccionProducto" class="col-form-label fs-6 fw-semibold">Elija que Producto quiere agregar al carrito:</label>
                                <select name="producto" id="seleccionProducto" class="form-select" required>
                                    <option value="" disabled selected>Selecciona una opción</option>
                                    <option value="Cartuchera">Cartuchera</option>
                                    <option value="Neceser">Neceser</option>
                                    <option value="Bolso Matero">Bolso Matero</option>
                                    <option value="Set Matero">Set Matero</option>
                                    <option value="Billetera">Billetera</option>
                                    <option value="Bandolera">Bandolera</option>
                                    <option value="Varios">Varios</option>
                                    <option value="Promociones">Promociones</option>
                                </select>
                            </div>
                            <div class="mb-1 p-1">
                                <label for="inputNombre" class="col-form-label fs-6 fw-semibold">Nombre del Producto</label>
                                <input type="text" name="nombre" id="inputNombre" class="form-control fw-light fst-italic" placeholder="Cartuchera Psicodélica" maxlength="50" required autocomplete="off">
                            </div>
                            <div class=" mb-1 p-1">
                                <label for="inputId" class="col-form-label fs-6 fw-semibold">ID del Producto</label>
                                <input type="number" name="id_producto" id="inputId" class="form-control fw-light fst-italic" placeholder="133" min="1" max="10000" required>
                            </div>
                            <div class="mb-1 p-1">
                                <label for="inputprecio" class="col-form-label fs-6 fw-semibold">Precio del Producto:</label>
                                <input type="number" name="precio" id="inputprecio" class="form-control fw-light fst-italic" placeholder="$8500" step="0.01" min="5000.00" max="450000.00" autocomplete="off" required>
                            </div>
                            <div class=" mb-1 p-1">
                                <label for="inputstock" class="col-form-label fs-6 fw-semibold">Stock del Producto</label>
                                <input type="number" name="stock" id="inputstock" class="form-control fw-light fst-italic" placeholder="6" min="1" max="10000" required>
                            </div>
                            <div class="mb-1 p-1">
                                <label for="descripcion" class="col-form-label fs-6 fw-semibold">Descripción del Producto</label>
                                <textarea name="descripcion" id="descripcion" rows="5" placeholder="Descripción del Producto, medidas, colores, etc..." class="form-control" required></textarea>
                            </div>
                            <div class="mb-2 p-1">
                                <label for="subirfoto" class="col-form-label fs-6 fw-semibold">Subir Foto: (.jpg, .gif, .png) (Max: 1024KB = 1MB)</label>
                                <input type="file" name="foto_producto" id="subirfoto" class="form-control form-control-sm" required>
                            </div>
                            <div class="mb-2 p-1">
                                <input type="submit" class="form-control btn btn-primary" value="Cargar PRODUCTO">
                            </div>
                        </form>
                        <?php
                        
                        if (isset($_GET['mensaje'])) {
                            if ($_GET['mensaje'] === 'error-peso') {
                                echo '<div class="alerta peso">¡La imagen es demasiado grande. Debe ser menor a 1 MB!</div>';
                            } if ($_GET['mensaje'] === 'exito') {
                                echo '<div class="alerta exito">¡Producto cargado correctamente!</div>';
                            } elseif ($_GET['mensaje'] === 'error') {
                                echo '<div class="alerta error">Hubo un problema al cargar el producto. Intenta nuevamente.</div>';
                            }
                        }

                        ?>
                    </div>
                    <div class="col-5 panel-muestra">
                        <p>Cosas a tener en cuenta al momento de cargar productos : </p>       
                        <p>Estos datos se guardan directamente en la base de datos, esto significa que una vez que se suben a la BD se muestran automáticamente en todas las páginas activas de la tienda.</p>       
                        <p>Dentro de la categoria VARIOS van todos los productos sin una categoría especifica, asique acá se podrían guardar productos randoms.</p>       
                        <p>Dentro de la categoria PROMOCIONES van todos los productos que se van a mostrar en la sección PROMOS dentro de la pagina principal index.html. Asique aca pueden ir productos lindos o productos con descuentos.</p>       
                        <p>El valor del precio minimo que existe para cualquier producto es de $5000 pesos y el máximo es de $450000 (Se pueden poner hasta 2 números decimales para los centavos).</p>       
                        <p>Listas de IDs de cada producto para un mejor orden :</p>       
                        <p>ID Cartucheras : entre 1 y 100.<br>ID Neceseres : entre 101 y 200.<br>ID Bolsos materos : entre 201 y 300.<br>ID Sets Materos : entre 301 y 400.<br>ID Billeteras : entre 401 y 500.<br>ID Bandoleras : entre 501 y 600.<br>ID Varios : entre 601 y 800.<br>ID Promociones : entre 801 y 1000.<br></p>              
                    </div>
                </div>
            </div>


        </section>

        <section id="listar-productos">

            <div class="container fondo-panel">

                <div class="show-details row">
                    <div class="col-12 caja-form-add">
                        
                        <form action="componentes/listar_productos.php" method="POST" id=formulario-categoria>
                            <label for="seleccionCategoria" class="col-form-label fs-6 fw-semibold">Elija un producto de la tienda para MODIFICAR/ELIMINAR:</label>
                            <select name="categoria" id="seleccionCategoria" class="form-select" required>
                                <option value="" disabled selected>Selecciona una opción</option>
                                <option value="Cartuchera">Cartuchera</option>
                                <option value="Neceser">Neceser</option>
                                <option value="Bolso Matero">Bolso Matero</option>
                                <option value="Set Matero">Set Matero</option>
                                <option value="Billetera">Billetera</option>
                                <option value="Bandolera">Bandolera</option>
                                <option value="Varios">Varios</option>
                                <option value="Promociones">Promociones</option>
                            </select>
                            <input type="submit" class="btn btn-danger btn-buscar form-control ms-auto mt-2 mb-2 w-50" value="Buscar">
                            <button class="btn btn-dark"><a href="componentes/borrar_sesion.php" class="btn-borrar-lista">Borrar lista</a></button>
                        </form>
                    </div>

                </div>
                <div class="col-12 table-responsive">
                    <table class="table table-striped table-bordered table-sm tabla-listas" id="tabla-resultado">
                        <thead>
                            <tr>
                                <th>ID del Producto</th>
                                <th>Categoria</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Imagen del producto</th>
                                <th>Modificar / Borrar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            if (isset($_SESSION['productos']) && !empty($_SESSION['productos'])) { ?>

                                <?php

                                foreach ($_SESSION['productos'] as $producto) { ?>

                                    <tr>
                                        <td style="font-weight: 500;"><?php echo $producto['id']; ?></td>
                                        <td><?php echo $producto['categoria']; ?></td>
                                        <td><?php echo $producto['nombre']; ?></td>
                                        <td><?php echo $producto['descripcion']; ?></td>
                                        <td style="white-space: nowrap;">$ <?php echo $producto['precio']; ?></td>
                                        <td class="img-fetched">
                                            <?php if (!empty($producto['ci_imagen_producto'])): ?>
                                                <?php
                                                $img_data = base64_encode($producto['ci_imagen_producto']);
                                                $img_type = $producto['formato_imagen'];
                                                echo "<img width='100' height='100' src='data:$img_type;base64,$img_data' alt='Imagen del producto'>";
                                                ?>
                                            <?php else: ?>
                                                <p>Sin imagen disponible</p>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="celda_func">
                                                <!-- Botón para modificar -->
                                                <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modificarModal<?php echo $producto['id']; ?>">
                                                    Modificar
                                                </button>

                                                <!-- Modal de modificar -->
                                                <div class="modal fade" id="modificarModal<?php echo $producto['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modificarLabel<?php echo $producto['id']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="modificarLabel<?php echo $producto['id']; ?>">Modificar Producto</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                
                                                                <form method="POST" action="modificar_producto.php" enctype="multipart/form-data" id="modalmod">
                                                                    <!-- Campo oculto de ID del producto -->
                                                                    <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                                                                    <!-- Campo oculto de categoría -->
                                                                    <input type="hidden" name="categoria" value="<?php echo $producto['categoria']; ?>">

                                                                    <label for="nombre_producto<?php echo $producto['id']; ?>" class="label_listar_modal">Nombre</label>
                                                                    <input type="text" name="nombre" id="nombre_producto<?php echo $producto['id']; ?>" class="form-control mb-2" value="<?php echo $producto['nombre']; ?>">

                                                                    <label for="precio_producto<?php echo $producto['id']; ?>" class="label_listar_modal">Precio</label>
                                                                    <input type="number" step="0.01" name="precio" id="precio_producto<?php echo $producto['id']; ?>" class="form-control mb-2" value="<?php echo $producto['precio']; ?>">
                                                                    
                                                                    <label for="stock_producto<?php echo $producto['id']; ?>" class="label_listar_modal">Stock</label>
                                                                    <input type="number" name="stock" min="0" id="stock_producto<?php echo $producto['id']; ?>" class="form-control mb-2" value="<?php echo $producto['stock']; ?>">

                                                                    <label for="descripcion_producto<?php echo $producto['id']; ?>" class="label_listar_modal">Descripción</label>
                                                                    <textarea name="descripcion" id="descripcion_producto<?php echo $producto['id']; ?>" class="form-control mb-2"><?php echo $producto['descripcion']; ?></textarea>

                                                                    <label for="modificarFoto<?php echo $producto['id']; ?>" class="label_listar_modal">Subir Foto (.jpg, .gif, .png)</label>
                                                                    <div class="img-modal">
                                                                        <?php if (!empty($producto['ci_imagen_producto'])): ?>
                                                                            <?php
                                                                            $img_data = base64_encode($producto['ci_imagen_producto']);
                                                                            $img_type = $producto['formato_imagen'];
                                                                            echo "<img src='data:$img_type;base64,$img_data' alt='Imagen del producto' width='300' height='300'>";
                                                                            ?>
                                                                        <?php else: ?>
                                                                            <p>Sin imagen disponible</p>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                    <input type="file" name="foto_producto" id="modificarFoto<?php echo $producto['id']; ?>" class="form-control form-control-sm mb-2" accept=".jpg, .jpeg, .png, .gif">


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
                                                <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#eliminarModal<?php echo $producto['id']; ?>">
                                                    Eliminar
                                                </button>

                                                <!-- Modal de eliminar -->
                                                <div class="modal fade" id="eliminarModal<?php echo $producto['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="eliminarLabel<?php echo $producto['id']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="eliminarLabel<?php echo $producto['id']; ?>">Eliminar Producto</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>¿Estás seguro que deseas eliminar el producto "<?php echo $producto['nombre']; ?>"?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                <form method="POST" action="eliminar_producto.php" style="display:inline;">
                                                                    <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
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
                                echo 'No hay productos por mostrar';
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
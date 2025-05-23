<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon estándar -->
    <link rel="icon" type="image/png" sizes="512x512" href="images/favicon/favicon-512x512-transparent.png">

    <!-- Manifest para navegadores que lo usen -->
    <link rel="manifest" href="images/favicon/site-transparent.webmanifest">

    <title>PANEL ADM Kuday</title>

    <!-- FAMILIAS TIPOGRAFICAS DE GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Birthstone&family=Delius+Unicase:wght@400;700&family=Fuzzy+Bubbles:wght@400;700&family=Gwendolyn:wght@400;700&family=Homemade+Apple&family=Just+Me+Again+Down+Here&family=Kablammo&family=Klee+One&family=Ms+Madi&family=Mystery+Quest&family=Pacifico&family=Playwrite+IT+Moderna:wght@100..400&family=Poiret+One&family=Teko:wght@300..700&family=Unkempt:wght@400;700&family=Vibur&family=Yomogi&display=swap" rel="stylesheet">

    <!-- ICONOS DE BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- ICONOS DE FONTAWESOME -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" rel="stylesheet">

    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- DATATABLES CSS -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- CSS PROPIO -->
    <link rel="stylesheet" href="CSS/styles.css">

</head>

<body id="body-panel">

    <header>
        <nav class="navbar navbar-expand-lg fixed-top cartuchera-nav">
            <div class="container-fluid contenedor-barra" style="flex-wrap: wrap;">

                <a class="navbar-brand marca align-self-center text-center" href="index.php#inicio">Kuday Artesanias</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#panel-navbarScroll" aria-controls="panel-navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="panel-navbarScroll">

                    <div class="ms-auto w-100 w-lg-auto">
                        <form action="componentes/acceder.php" method="POST" class="d-flex flex-column flex-lg-row align-items-stretch align-items-lg-center gap-2 py-2 px-2">
                            <div class="w-100 w-lg-auto">
                                <input type="text" name="usuario-admin" class="form-control" placeholder="Usuario" autocomplete="off">
                            </div>
                            <div class="w-100 w-lg-auto">
                                <div class="input-group">
                                    <span class="input-group-text">@</span>
                                    <input type="password" name="pass-admin" class="form-control" placeholder="Password">
                                </div>
                            </div>
                            <div class="d-flex flex-column flex-lg-row gap-2 w-100 w-lg-auto">
                                <input type="submit" value="Acceder" class="btn btn-sm btn-success w-100 w-lg-auto">
                                <a href="componentes/salir.php" class="btn btn-sm btn-salir w-100 w-lg-auto" onclick="return confirm('¿Estás seguro de que deseas cerrar la sesión?');">Cerrar Sesión</a>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </nav>
    </header>


    <?php if (isset($_SESSION['administrador'])) { ?>

        <section id="panel">

            <div class="container-fluid panel-adm">

                <div class="row m-2 titulo-panel-carga">
                    <h2 class="text-center p-3 mt-4">AGREGAR PRODUCTOS [TIENDA KUDAY]</h2>
                </div>
                <div class="row paneles">
                    <div class="col-7 panel-carga">

                        <form action="componentes/cargar_productos.php" class="form-group" method="POST" enctype="multipart/form-data" id="formulario-carga">
                            <div class="mb-1 p-1">
                                <label for="seleccionProducto" class="col-form-label fs-6 fw-semibold">Elija que Producto quiere agregar al carrito:</label>
                                <select name="producto" id="seleccionProducto" class="form-select" required>
                                    <option value="" disabled selected>Selecciona una opción</option>
                                    <option value="1">Cartuchera</option>
                                    <option value="2">Neceser</option>
                                    <option value="3">Bolso Matero</option>
                                    <option value="4">Set Matero</option>
                                    <option value="5">Billetera</option>
                                    <option value="6">Bandolera</option>
                                    <option value="7">Varios</option>
                                    <option value="8">Promociones</option>
                                </select>
                            </div>
                            <div class="mb-1 p-1">
                                <label for="inputNombre" class="col-form-label fs-6 fw-semibold">Nombre del Producto</label>
                                <input type="text" name="nombre" id="inputNombre" class="form-control fw-light fst-italic" placeholder="Ej: Cartuchera Psicodélica" maxlength="50" required autocomplete="off">
                            </div>
                            <div class=" mb-1 p-1">
                                <label for="inputId" class="col-form-label fs-6 fw-semibold">ID del Producto</label>
                                <input type="number" name="id_producto" id="inputId" class="form-control fw-light fst-italic" placeholder="Escribí el N° de Id.." min="1" max="10000" required>
                            </div>
                            <div class="mb-1 p-1">
                                <label for="inputprecio" class="col-form-label fs-6 fw-semibold">Precio del Producto:</label>
                                <input type="number" name="precio" id="inputprecio" class="form-control fw-light fst-italic" placeholder="$" step="0.01" min="5000.00" max="450000.00" autocomplete="off" required>
                            </div>
                            <div class=" mb-1 p-1">
                                <label for="inputstock" class="col-form-label fs-6 fw-semibold">Stock del Producto</label>
                                <input type="number" name="stock" id="inputstock" class="form-control fw-light fst-italic" placeholder="Escribí la cantidad de stock para el producto..." min="1" max="10000" required>
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
                                <input type="submit" class="form-control btn btn-primary" id="formulario-carga1" value="Cargar PRODUCTO">
                            </div>
                        </form>
                        <?php

                        if (isset($_GET['mensaje'])) {
                            if ($_GET['mensaje'] === 'error-peso') {
                                echo '<div class="alerta peso">¡La imagen es demasiado grande. Debe ser menor a 1 MB!</div>';
                            }
                            if ($_GET['mensaje'] === 'error-duplicado') {
                                echo '<div class="alerta peso">¡El ID que ingresaste ya existe!</div>';
                            }
                            if ($_GET['mensaje'] === 'exito') {
                                echo '<div class="alerta exito">¡Producto cargado correctamente!</div>';
                            } else if ($_GET['mensaje'] === 'error') {
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

            <div class="container-fluid fondo-panel">
                <h2 class="text-center p-3 mt-4">ELIMINAR / MODIFICAR PRODUCTOS [TIENDA KUDAY]</h2>

                <div class="show-details row">
                    <div class="col-12">

                        <form action="componentes/listar_productos.php" method="POST" id=formulario-categoria class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="seleccionCategoria" class="form-label fs-6 fw-semibold ps-2">Producto a Modificar/Eliminar :</label>
                                <select name="categoria" id="seleccionCategoria" class="form-select" required>
                                    <option value="" disabled selected>Selecciona una opción</option>
                                    <option value="1">Cartuchera</option>
                                    <option value="2">Neceser</option>
                                    <option value="3">Bolso Matero</option>
                                    <option value="4">Set Matero</option>
                                    <option value="5">Billetera</option>
                                    <option value="6">Bandolera</option>
                                    <option value="7">Varios</option>
                                    <option value="8">Promociones</option>
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <input type="submit" class="btn btn-primary btn-sm btn-buscar w-100 w-lg-auto" value="Buscar">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm w-100 w-lg-auto" onclick="location.href='componentes/borrar_sesion.php'">Borrar lista</button>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="col-12 table-responsive" id="panel-listar-table-mq">
                    <table class="table table-striped table-bordered table-sm" id="tabla-resultado">
                        <thead>
                            <tr>
                                <th>ID del Producto</th>
                                <th>Categoria</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Stock</th>
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
                                        <td style="font-weight: 500;" data-label="ID del producto"><?php echo $producto['id']; ?></td>
                                        <td data-label="Categoria del producto"><?php echo $producto['categoria_nombre']; ?></td>
                                        <td data-label="Nombre del producto"><?php echo $producto['nombre']; ?></td>
                                        <td data-label="Descripción"><?php echo $producto['descripcion']; ?></td>
                                        <td style="white-space: nowrap;" data-label="Precio">$ <?php echo $producto['precio']; ?></td>
                                        <td style="font-weight: 500;" data-label="Stock"><?php echo $producto['stock']; ?></td>
                                        <td class="img-fetched" data-label="Foto del producto">
                                            <?php if (!empty($producto['ci_imagen_producto'])): ?>
                                                <?php
                                                $img_data = base64_encode($producto['ci_imagen_producto']);
                                                $img_type = $producto['formato_imagen'];
                                                echo "<img width='100' height='auto' src='data:$img_type;base64,$img_data' alt='Imagen del producto'>";
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
                                                                            echo "<img src='data:$img_type;base64,$img_data' alt='Imagen del producto' width='150' height='auto'>";
                                                                            ?>
                                                                        <?php else: ?>
                                                                            <p>Sin imagen disponible</p>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                    <input type="file" name="foto_producto" id="modificarFoto<?php echo $producto['id']; ?>" class="form-control form-control-sm mb-2" accept=".jpg, .jpeg, .png, .gif">


                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
                                                                        <button type="submit" class="btn btn-primary btn-sm">Modificar</button>
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

        <section id="ventas">
            <div class="container-fluid fondo-panel">
                <h2 class="text-center p-3 mt-4">GESTIÓN DE VENTAS</h2>

                <?php if (!isset($_SESSION['compras'])) {
                    require_once('./componentes/conexion.php');
                    $sql = "SELECT * FROM compras ORDER BY fecha_compra DESC, id DESC";
                    $resultado = mysqli_query($conexion, $sql);
                    $_SESSION['compras'] = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
                }
                ?>


                <form action="./componentes/mostrar_compras.php" method="POST" class="row g-3 mb-4" id="formulario-ventas-filtros">
                    <div class="col-md-5">
                        <label for="nombre" class="form-label fs-6 fw-semibold ps-2">Buscar por nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del cliente">
                    </div>
                    <div class="col-md-5">
                        <label for="fecha" class="form-label fs-6 fw-semibold ps-2">Buscar por fecha</label>
                        <input type="date" name="fecha" id="fecha" class="form-control">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <input type="submit" class="btn btn-primary btn-sm w-100" value="Buscar">
                    </div>
                </form>

                <div class="col-12 table-responsive" id="panel-ventas-mq">
                    <table class="table table-striped table-bordered table-sm" id="tabla-compras">

                        <thead>
                            <tr>
                                <th>Estado de la Compra</th>
                                <th>Cliente</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Productos</th>
                                <th>Total</th>
                                <th>Fecha de Compra</th>
                                <th>Dirección</th>
                                <th>Provincia/Ciudad</th>
                                <th>Código Postal</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($_SESSION['compras']) && !empty($_SESSION['compras'])): ?>

                                <?php foreach ($_SESSION['compras'] as $compra): ?>
                                    <?php
                                    $esModificada = isset($_GET['id']) && $_GET['id'] == $compra['id'];
                                    ?>
                                    <tr class="<?php echo $esModificada ? 'resaltado' : ''; ?>" id="compra-<?php echo $compra['id']; ?>">

                                        <td class="estado <?php echo strtolower($compra['estado']); ?>" data-label="Estado de la compra">
                                            <?php echo isset($compra['estado']) ? htmlspecialchars($compra['estado']) : 'N/A'; ?>
                                        </td>
                                        <td data-label="Cliente"><?php echo htmlspecialchars($compra['nombre_cliente'] . ' ' . $compra['apellido_cliente']); ?></td>
                                        <td data-label="Teléfono"><?php echo htmlspecialchars($compra['telefono_cliente']); ?></td>
                                        <td data-label="Correo"><?php echo htmlspecialchars($compra['email_cliente']); ?></td>
                                        <td data-label="Detalle de compra"><?php
                                            $productos = json_decode($compra['productos_json'], true);
                                            if (is_array($productos)) {
                                                foreach ($productos as $producto) {
                                                    echo htmlspecialchars($producto['name']) . ' x' . htmlspecialchars($producto['cantidad']) . ' - $' . htmlspecialchars($producto['price']) . '<br>';
                                                }
                                            } else {
                                                echo 'Sin productos';
                                            }
                                            ?>
                                        </td>
                                        <td data-label="Total">$<?php echo number_format($compra['total'], 2); ?></td>
                                        <td data-label="Fecha de compra"><?php echo date('d/m/Y', strtotime($compra['fecha_compra'])); ?></td>
                                        <td data-label="Dirección del Cliente"><?php echo htmlspecialchars($compra['direccion']); ?></td>
                                        <td data-label="Localidad"><?php echo htmlspecialchars($compra['provincia']) . ', ' . htmlspecialchars($compra['ciudad']); ?></td>
                                        <td data-label="Código Postal"><?php echo htmlspecialchars($compra['codigopostal']); ?></td>
                                        <td>
                                            <form method="POST" action="componentes/confirmar_compra.php" style="display:inline;">
                                                <input type="hidden" name="id_compra" value="<?php echo $compra['id']; ?>">
                                                <button type="submit" class="btn btn-success btn-sm mb-1">Confirmar</button>
                                            </form>
                                            <form method="POST" action="componentes/rechazar_compra.php" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que querés rechazar esta compra?');">
                                                <input type="hidden" name="id_compra" value="<?php echo $compra['id']; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm">Rechazar</button>
                                            </form>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>



    <?php  } ?>


    <!-- jQuery JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- BOOTSTRAP JS -->
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
                "responsive": false, // Activa el modo responsive de DataTables
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

    <script>
        $(document).ready(function() {
            $('#tabla-compras').DataTable({
                "columnDefs": [{
                    "targets": "_all",
                    "defaultContent": "—"
                }],
                "paging": true,
                "lengthMenu": [5, 10, 20, 50],
                "searching": true,
                "responsive": false,
                "scrollX": true,
                "ordering": true,
                "order": [
                    [0, "asc"]
                ],
                "info": true,
                "autoWidth": true,
                "language": {
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

            // Aplicar animación y scroll luego de que DataTable haya cargado
            setTimeout(function () {
                const urlParams = new URLSearchParams(window.location.search);
                const id = urlParams.get('id');
                if (id) {
                    const fila = document.getElementById('compra-' + id);
                    if (fila) {
                        fila.classList.add('resaltado');
                        fila.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        setTimeout(() => fila.classList.remove('resaltado'), 3000);
                    }
                }
            }, 500);

        });
    </script>

    


</body>

</html>
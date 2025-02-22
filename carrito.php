<?php
/*
session_start();
$cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;

include('./componentes/conexion.php');

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    echo "<p>No hay productos en el carrito.</p>";

    // Asegurándote de que el código JS se ejecute en el navegador
    echo "<script type='text/javascript'>";
    
    echo "if (window.opener) {";
    echo "    // Si la pestaña se abrió con target='_blank', cerramos la ventana después de 5 segundos";
    echo "    setTimeout(function() {";
    echo "        window.close();";
    echo "    }, 5000);";
    echo "} else {";
    echo "    // Si no se abrió con target='_blank', redirige atrás después de 5 segundos";
    echo "    setTimeout(function() {";
    echo "        window.history.back();";
    echo "    }, 5000);";
    echo "}";

    echo "</script>";
    
    exit();
}




$productIds = implode(',', array_keys($cart));
$query = "SELECT * FROM productos WHERE id IN ($productIds)";
$result = mysqli_query($conexion, $query);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kuday | Mi Carrito</title>

    <!-- FAMILIAS TIPOGRAFICAS DE GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Birthstone&family=Delius+Unicase:wght@400;700&family=Fuzzy+Bubbles:wght@400;700&family=Gwendolyn:wght@400;700&family=Homemade+Apple&family=Just+Me+Again+Down+Here&family=Kablammo&family=Klee+One&family=Ms+Madi&family=Mystery+Quest&family=Pacifico&family=Playwrite+IT+Moderna:wght@100..400&family=Poiret+One&family=Teko:wght@300..700&family=Unkempt:wght@400;700&family=Vibur&family=Yomogi&display=swap" rel="stylesheet">

    <!-- ICONOS DE BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS DE BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- CSS PROPIO-->
    <link rel="stylesheet" href="./CSS/styles.css">

</head>

<body id="carrito_body">
<header>
    <nav class="navbar navbar-expand-lg index-nav fixed-top">
        <div class="container-fluid" style="flex-wrap: wrap;">
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
                    <a class="nav-link active boton-nav" aria-current="page" href="index.php#titulo_tienda">Tienda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active boton-nav" href="index.php#titulo_promociones">Promociones</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active boton-nav" href="tienda.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Productos
                    </a>
                <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="vistas/cartucheras.php">Cartucheras</a></li>
                        <hr class="dropdown-divider">
                        <li><a class="dropdown-item" href="vistas/neceser.php">Neceser</a></li>
                        <hr class="dropdown-divider">
                        <li><a class="dropdown-item" href="vistas/setmatero.php">Sets Materos</a></li>
                        <hr class="dropdown-divider">
                        <li><a class="dropdown-item " href="vistas/billeteras.php">Billeteras</a></li>
                        <hr class="dropdown-divider">
                        <li><a class="dropdown-item" href="vistas/bolsomatero.php">Bolso Matero</a></li>
                        <hr class="dropdown-divider">
                        <li><a class="dropdown-item" href="vistas/bandoleras.php">Bandoleras</a></li>
                        <hr class="dropdown-divider">
                        <li><a class="dropdown-item" href="vistas/varios.php">Varios</a></li>
                        <hr class="dropdown-divider">
                        <li><a class="dropdown-item" href="vistas/promociones.php">Promociones</a></li>
                </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link active boton-nav" href="index.php#seccion_footer">Contactános</a>
                </li>
                <li class="nav-item cart-item">
                    <a href="./carrito.php" class="cart-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-cart">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a1 1 0 0 0 1 .86h9.72a1 1 0 0 0 1-.76l2.54-9.24a1 1 0 0 0-.96-1.24H5.21"></path>
                    </svg>
                    <span id="cart-count"><?php echo $cartCount; ?></span>
                    </a>
                </li>
            </ul>
            </div>
        </div>
    </nav>
</header>

    <section id="tabla-carrito">
    <h1 style="text-align: center; margin:10px;">Mi Carrito</h1>
    <table id="mi_carrito">
        <thead>
            <tr>
                <th class="mi_carrito">Producto</th>
                <th class="mi_carrito">Precio</th>
                <th class="mi_carrito">Cantidad</th>
                
                <th class="mi_carrito">Modificar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            while ($product = mysqli_fetch_assoc($result)) {
                $id = $product['id'];
                $cantidad = $cart[$id];
                $subtotal = $product['precio'] * $cantidad;
                $total += $subtotal;
            ?>
            <tr>
                <td><?php echo $product['nombre']; ?></td>
                <td>$<?php echo $product['precio']; ?></td>
                <td><?php echo $cantidad; ?></td>
                
                <td>poner ag/quitar</td>
            </tr>
            <?php } ?>
            <div>
            <tr style="height: 50px;">
                <td colspan="4" class="mi_carrito_envio">Costo de Envio</td>
                <td>agregar funcion costo envio</td>
            </tr>
            <tr style="height: 50px;">
                <td colspan="4" class="mi_carrito_total">Total</td>
                <td style="font-weight: 500;">$<?php echo $total; ?></td>
            </tr>
            </div>
        </tbody>
    </table>

    <a href="cerrar.php"> cerrar sesion</a>
    </section>

    <footer class="footer" id="seccion_footer">
        <main class="container-fluid">
        <div class="row contenedor_footer">
            
            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-10 p-2 pb-5">
            
            <h6 class="h6-footer"><i class="bi bi-tencent-qq pinguin"></i> CONTÁCTANOS</h6>
            <div class="box_1">
                <p class="p-footer"><i class="bi bi-telephone-fill tel"></i> +54 9 0297 432-1429</p>
                <p class="p-footer"><i class="bi bi-whatsapp wsp"></i> +54 9 0297 432-1429</p>
                <p class="p-footer"><i class="bi bi-geo-alt-fill ubic"></i> Gral. Araóz de Lamadrid 425</p>

                <!-- Mini mapa responsive -->
                <div class="map-container">
                <a
                    href="https://www.google.com/maps?q=-31.409736861796983,-64.16100064468557&z=17"
                    target="_blank"
                    title="Abrir ubicación en Google Maps">
                    <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3664.3467339192976!2d-64.16100064468557!3d-31.409736861796983!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0:0x0!2z-31.409736861796983_-64.16100064468557!5e0!3m2!1sen!2sar!4v1696990000000"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                </a>
                </div>
            </div>
            </div>

            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-8 p-2">
            
            <h6 class="h6-footer"><i class="bi bi-tencent-qq pinguin"></i> MEDIOS DE PAGO</h6>
            <div class="contenedor-cards p-2">
                <img src="./images/cards/visa.png" alt="mp">
                <img src="./images/cards/naranja.png" alt="visa">
                <img src="./images/cards/mercadopago2.png" alt="visa">
                <img src="./images/cards/pagofacil.png" alt="visa">
                <img src="./images/cards/efectivo.png" alt="visa">
                <img src="./images/cards/rapipago.png" alt="">
            </div>

            <h6 class="h6-footer"><i class="bi bi-tencent-qq pinguin"></i> FORMAS DE ENVIO</h6>
            <div class="contenedor-cards p-2">
                <img src="./images/cards/andreani.png" alt="">
                <img src="./images/cards/correoarg.png" alt="">
            </div>

            <h6 class="h6-footer" style="text-wrap: wrap!important;"><i class="bi bi-tencent-qq pinguin"></i> SEGUINOS EN NUESTRAS REDES!</h6>
            <div class="redes-icons-footer">
                <a href="https://www.facebook.com/dai.quiroga.7" target="_"><i class="bi bi-facebook fb"></i></a>
                <a href="https://www.facebook.com/dai.quiroga.7"><i class="bi bi-instagram ig"></i></a>
                <a href="https://www.facebook.com/dai.quiroga.7"><i class="bi bi-pinterest prest"></i></a>
            </div>
            </div>
            
        </div>
        </main>

        <p style="font-size:10px;background-color:white; color:black;width:100%;padding:0 5px;"><i class="bi bi-c-circle"></i> COPYRIGHT KUDAY ARTESANIAS & DEVCR1 2021. TODOS LOS DERECHOS RESERVADOS.</p>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</body>
</html>
*/

session_start();
$cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;

include('./componentes/conexion.php');

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    echo "<p>No hay productos en el carrito.</p>";
    echo "<script type='text/javascript'>";
    echo "if (window.opener) { setTimeout(function() { window.close(); }, 5000); } else { setTimeout(function() { window.history.back(); }, 5000); }";
    echo "</script>";
    exit();
}

$productIds = implode(',', array_keys($cart));
$query = "SELECT * FROM productos WHERE id IN ($productIds)";
$result = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kuday | Mi Carrito</title>
    <!-- FAMILIAS TIPOGRAFICAS DE GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Birthstone&family=Delius+Unicase:wght@400;700&family=Fuzzy+Bubbles:wght@400;700&family=Gwendolyn:wght@400;700&family=Homemade+Apple&family=Just+Me+Again+Down+Here&family=Kablammo&family=Klee+One&family=Ms+Madi&family=Mystery+Quest&family=Pacifico&family=Playwrite+IT+Moderna:wght@100..400&family=Poiret+One&family=Teko:wght@300..700&family=Unkempt:wght@400;700&family=Vibur&family=Yomogi&display=swap" rel="stylesheet">

    <!-- ICONOS DE BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS DE BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- CSS PROPIO-->
    <link rel="stylesheet" href="./CSS/styles.css">
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg index-nav fixed-top">
        <div class="container-fluid" style="flex-wrap: wrap;">
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
                    <a class="nav-link active boton-nav" aria-current="page" href="index.php#titulo_tienda">Tienda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active boton-nav" href="index.php#titulo_promociones">Promociones</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active boton-nav" href="tienda.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Productos
                    </a>
                <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="vistas/cartucheras.php">Cartucheras</a></li>
                        <hr class="dropdown-divider">
                        <li><a class="dropdown-item" href="vistas/neceser.php">Neceser</a></li>
                        <hr class="dropdown-divider">
                        <li><a class="dropdown-item" href="vistas/setmatero.php">Sets Materos</a></li>
                        <hr class="dropdown-divider">
                        <li><a class="dropdown-item " href="vistas/billeteras.php">Billeteras</a></li>
                        <hr class="dropdown-divider">
                        <li><a class="dropdown-item" href="vistas/bolsomatero.php">Bolso Matero</a></li>
                        <hr class="dropdown-divider">
                        <li><a class="dropdown-item" href="vistas/bandoleras.php">Bandoleras</a></li>
                        <hr class="dropdown-divider">
                        <li><a class="dropdown-item" href="vistas/varios.php">Varios</a></li>
                        <hr class="dropdown-divider">
                        <li><a class="dropdown-item" href="vistas/promociones.php">Promociones</a></li>
                </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link active boton-nav" href="index.php#seccion_footer">Contactános</a>
                </li>
                <li class="nav-item cart-item">
                    <a href="./carrito.php" class="cart-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-cart">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a1 1 0 0 0 1 .86h9.72a1 1 0 0 0 1-.76l2.54-9.24a1 1 0 0 0-.96-1.24H5.21"></path>
                    </svg>
                    <span id="cart-count"><?php echo $cartCount; ?></span>
                    </a>
                </li>
            </ul>
            </div>
        </div>
    </nav>
</header>

<section class="container" style="margin-top: 150px;">
    <h1 class="text-center">Mi Carrito</h1>
    <div class="accordion" id="cartAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingCart">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCart" aria-expanded="true" aria-controls="collapseCart">
                    Ver Carrito
                </button>
            </h2>
            <div id="collapseCart" class="accordion-collapse collapse show" aria-labelledby="headingCart" data-bs-parent="#cartAccordion">
                <div class="accordion-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Modificar</th>
                                </tr>
                            </thead>
                            <tbody id="cart-body">
                                <?php
                                $total = 0;
                                while ($product = mysqli_fetch_assoc($result)) {
                                    $id = $product['id'];
                                    $cantidad = $cart[$id];
                                    $stock = $product['stock']; // Asumiendo que tienes una columna 'stock' en la DB
                                    $subtotal = $product['precio'] * $cantidad;
                                    $total += $subtotal;
                                ?>
                                <tr data-id="<?php echo $id; ?>" data-stock="<?php echo $stock; ?>">
                                    <td><?php echo $product['nombre']; ?></td>
                                    <td class="precio">$<?php echo $product['precio']; ?></td>
                                    <td>
                                        <div class="d-flex justify-content-center align-items-center">
                                            <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(<?php echo $id; ?>, -1)">−</button>
                                            <input type="number" class="form-control mx-2 cantidad" data-id="<?php echo $id; ?>" data-stock="<?php echo $product['stock']; ?>" style="width: 60px; text-align: center;" value="<?php echo $cantidad; ?>" min="1">
                                            <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(<?php echo $id; ?>, 1)">+</button>
                                        </div>
                                    </td>
                                    <td><button class="btn btn-danger btn-sm" onclick="removeItem(<?php echo $id; ?>)"><i class="bi bi-trash"></i></button></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="3"><strong>Total</strong></td>
                                    <td><strong id="total">$<?php echo $total; ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary" onclick="continuarCompra()">Continuar con la compra</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer mt-5">
    <div class="container text-center">
        <p>&copy; 2021 Kuday Artesanias. Todos los derechos reservados.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function updateQuantity(id, change) {
        let input = document.querySelector(`.cantidad[data-id='${id}']`);
        let maxStock = parseInt(input.dataset.stock); // Obtiene el stock máximo desde el atributo data-stock
        let value = parseInt(input.value) + change;

        if (value >= 1 && value <= maxStock) {
            input.value = value;
            updateTotal();
            updateCartCount();
            updateCartSession(id, value);
        } else if (value > maxStock) {
            alert("No puedes agregar más unidades, alcanzaste el stock disponible.");
        }
    }

    function removeItem(id) {
        let row = document.querySelector(`tr[data-id='${id}']`);
        row.remove();
        updateTotal();
        updateCartCount();
        updateCartSession(id, 0);
    }

    function updateTotal() {
        let totalElem = document.getElementById('total');
        let total = Array.from(document.querySelectorAll('.cantidad')).reduce((sum, el) => {
            let id = el.dataset.id;
            let price = parseFloat(document.querySelector(`tr[data-id='${id}'] .precio`).textContent.replace('$', ''));
            return sum + (price * parseInt(el.value));
        }, 0);
        totalElem.textContent = `$${total.toFixed(2)}`;
    }

    function updateCartCount() {
        let count = Array.from(document.querySelectorAll('.cantidad')).reduce((sum, el) => sum + parseInt(el.value), 0);
        document.getElementById('cart-count').textContent = count;
    }

    // Nueva función para actualizar la sesión del carrito
    function updateCartSession(id, cantidad) {
        fetch('actualizar_carrito.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}&cantidad=${cantidad}`
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('cart-count').textContent = data.cartCount;
        })
        .catch(error => console.error('Error al actualizar el carrito:', error));
    }

    function continuarCompra() {
        let cartItems = [];
        document.querySelectorAll("#cart-body tr[data-id]").forEach(row => {
            let id = row.dataset.id;
            let name = row.cells[0].textContent;
            let price = parseFloat(row.cells[1].textContent.replace('$', ''));
            let cantidad = parseInt(row.querySelector('.cantidad').value);
            let subtotal = price * cantidad;
            cartItems.push({ id, name, cantidad, subtotal });
        });

        console.log("Productos en el carrito:", cartItems);
        alert("Carrito actualizado. Puedes proceder con la compra.");
    }
</script>
</body>
</html>



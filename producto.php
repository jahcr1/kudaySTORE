<?php
include('./componentes/conexion.php');
session_start();

$cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;

// Obtiene el ID del producto de la URL
$id_producto = $_GET['id'] ?? null;

if (!$id_producto) {
    echo "Producto no encontrado.";
    exit;
}

// Consulta el producto en la base de datos
$query = "SELECT p.*, c.nombre AS categoria_nombre 
        FROM productos p 
        JOIN categorias c 
        ON p.categoria_id = c.id 
        WHERE p.id = $id_producto";
$result = mysqli_query($conexion, $query);
$producto = mysqli_fetch_assoc($result);

if (!$producto) {
    echo "Producto no encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalles del Producto | Kuday Store</title>
    
    <!-- FAMILIAS TIPOGRAFICAS DE GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Birthstone&family=Delius+Unicase:wght@400;700&family=Fuzzy+Bubbles:wght@400;700&family=Gwendolyn:wght@400;700&family=Homemade+Apple&family=Just+Me+Again+Down+Here&family=Kablammo&family=Klee+One&family=Ms+Madi&family=Mystery+Quest&family=Pacifico&family=Playwrite+IT+Moderna:wght@100..400&family=Poiret+One&family=Teko:wght@300..700&family=Unkempt:wght@400;700&family=Vibur&family=Yomogi&display=swap" rel="stylesheet">
    
    <!-- ICONOS DE BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- ICONOS DE FONTAWESOME -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" rel="stylesheet">

    <!-- CSS DE BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- CSS PROPIO -->
    <link rel="stylesheet" href="./CSS/styles.css">

</head>

<body>
    
    <header>
        <nav class="navbar navbar-expand-lg fixed-top cartuchera-nav">
            <div class="container-fluid" style="flex-wrap: wrap;">
                    <a class="navbar-brand marca align-self-center text-center" href="./index.php#inicio">Kuday Artesanias</a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarScroll">
                        <ul class="navbar-nav ms-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 620px; margin-right:50px;">
                            <li class="nav-item">
                                <a class="nav-link active boton-nav" href="#ver_producto">Inicio</a>
                            </li>
                            <li class="nav-item dropdown" style="align-items: flex-start;">
                                <a class="nav-link dropdown-toggle active boton-nav" href="tienda.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Productos
                                </a>
                                <ul class="dropdown-menu mx-2">
                                    <li><a class="dropdown-item" href="./vistas/cartucheras.php">Cartucheras</a></li>
                                    <hr class="dropdown-divider">
                                    <li><a class="dropdown-item" href="./vistas/neceser.php">Neceser</a></li>
                                    <hr class="dropdown-divider">
                                    <li><a class="dropdown-item" href="./vistas/setmatero.php">Sets Materos</a></li>
                                    <hr class="dropdown-divider">
                                    <li><a class="dropdown-item " href="./vistas/billeteras.php">Billeteras</a></li>
                                    <hr class="dropdown-divider">
                                    <li><a class="dropdown-item" href="./vistas/bolsomatero.php">Bolso Matero</a></li>
                                    <hr class="dropdown-divider">
                                    <li><a class="dropdown-item" href="./vistas/bandoleras.php">Bandoleras</a></li>
                                    <hr class="dropdown-divider">
                                    <li><a class="dropdown-item" href="./vistas/varios.php">Varios</a></li>
                                    <hr class="dropdown-divider">
                                    <li><a class="dropdown-item" href="./vistas/promociones.php">Promociones</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active boton-nav" aria-current="page" href="#seccion_footer">Quiénes Somos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active boton-nav" href="./contacto.php">Contactános</a>
                            </li>
                            <li class="nav-item cart-item">
                                <a href="./carrito.php" target="_blank" class="cart-icon">
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


    <section id="ver_producto" class="py-5">
        <div class="container-fluid">
            <div class="detalleproducto row align-items-start justify-content-center g-5 shadow rounded-4 p-4">
                
                <!-- Imagen del producto -->
                <div class="col-lg-5 text-center">
                    <img src="data:<?php echo $producto['formato_imagen']; ?>;base64,<?php echo base64_encode($producto['ci_imagen_producto']); ?>" 
                        alt="Imagen del Producto" 
                        class="img-fluid rounded-3 shadow-sm producto-img-prod"
                        style="max-height: 400px; object-fit: contain;">
                </div>

                <!-- Detalles del producto -->
                <div class="cuadro-detalle col-lg-6 text-center">
                    <div class="mb-4">
                        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-center gap-3 mb-3">
                            <h1 class="titulo-producto fw-normal display-6 m-0 text-capitalize"><?php echo $producto['nombre']; ?></h1>
                            
                            <!-- Botones de compartir -->
                            <div class="social-share d-flex align-items-center gap-2 ms-3">
                                <a href="https://wa.me/?text=<?php echo urlencode('Mirá este producto de Kuday Artesanías: https://tusitio.com/producto.php?id=' . $producto['id']); ?>" 
                                target="_blank" 
                                class="btn btn-sm btn-success shadow-sm rounded-circle"
                                title="Compartir en WhatsApp">
                                    <i class="bi bi-whatsapp"></i>
                                </a>

                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('https://tusitio.com/producto.php?id=' . $producto['id']); ?>" 
                                target="_blank" 
                                class="btn btn-sm btn-primary shadow-sm rounded-circle"
                                title="Compartir en Facebook">
                                    <i class="bi bi-facebook"></i>
                                </a>
                            </div>
                        </div>

                        <p class="mb-1 detalle-producto"><strong>Categoría:</strong> <?php echo $producto['categoria_nombre']; ?></p>
                        <p class="mb-1 detalle-producto"><strong>Precio:</strong> <span class="text-success fw-semibold fs-6">$<?php echo $producto['precio']; ?></span></p>
                        <p class="mb-1 detalle-producto"><strong>Stock disponible:</strong> <?php echo $producto['stock']; ?></p>
                        <p class="mt-3 detalle-producto"><strong>Descripción:</strong> <br><?php echo $producto['descripcion']; ?></p>
                    </div>

                    <!-- Control de cantidad y botón -->
                    <div class="botonera-producto row text-center text-md-start">
                        <div class="col-12 col-md-auto mb-3 mb-md-0">
                            <div class="quantity-controller d-flex justify-content-center justify-content-md-start">
                                <button class="btn btn-outline-secondary px-3" onclick="updateQuantity(-1)">−</button>
                                <input type="number" id="product-quantity" class="form-control text-center " value="1" min="1" max="<?php echo $producto['stock']; ?>">
                                <button class="btn btn-outline-secondary px-3" onclick="updateQuantity(1)">+</button>
                            </div>
                        </div>

                        <div class="col-12 col-md-auto">
                            <button id="add-to-cart" class="btn btn-danger add-carrito-prod px-4 py-2 shadow" data-id="<?php echo $producto['id']; ?>">
                            <i class="fa-solid fa-cart-plus me-2"></i>Agregar al carrito
                            </button>
                        </div>
                    </div>


                    <!-- Acordeón -->
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne">
                                    <i class="fa-solid fa-house-chimney me-3"></i> Nuestro Local
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <p class="text-secondary">    
                                        <strong>Kuday Artesanias</strong> General Araóz de Lamadrid 425 - Barrio General Paz, Córdoba, Argentina.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo">
                                    <i class="fa-solid fa-sack-dollar me-3"></i>Formas de Pago
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <p class="text-secondary">
                                        En <strong>Kuday</strong> aceptamos varios métodos de pago, depósitos, transferencias bancarias, transferencias de plataformas digitales como <strong>MercadoPago</strong>, <strong>Ualá</strong>, <strong>Modo</strong>, <strong>Lemon</strong>, y <strong>efectivo.</strong>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree">
                                    <i class="fa-solid fa-truck-fast me-3"></i>Medios de Envío
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <p class="mb-0 text-secondary">Hacemos envíos a todo el país, trabajamos mediante <strong>Andreani Envíos</strong> y <strong>Correo Argentino</strong><br>Si sos de <strong>Córdoba Capital</strong> y querés recibir el pedido en tu casa, al continuar la compra en tu carrito, seleccionar en el formulario de envio, en el campo <strong>provincia</strong> la opcion: <strong>Córdoba</strong> y en el campo <strong>ciudad</strong> la opcion: <strong>Capital</strong>. Si querés pagarlo en <strong>efectivo</strong> podés comunicarte con nosotros y acercarte a nuestro local.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- Fin col -->
            </div> <!-- Fin row -->
        </div> <!-- Fin container -->
    </section>


    <footer class="footer" id="seccion_footer">
        <main class="container-fluid">
            <div class="row contenedor_footer align-items-center">
                
                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-10 p-2 pb-5">
                
                <h6 class="h6-footer"><i class="bi bi-tencent-qq pinguin"></i> CONTÁCTANOS</h6>
                <div class="box_1">
                    <p class="p-footer"><i class="bi bi-envelope-at correo"></i>kudayartesanias@gmail.com</p>
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

                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-8 p-2" >
                
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
                    </div>
                </div>
                
            </div>
        </main>

        <p  style="font-size:10px;background-color:white; color:black;width:100%;padding:0 5px;"><i class="bi bi-c-circle"></i> 2021 Kuday Artesanias & jahcr1. Todos los derechos reservados.</p>

    </footer>

    <!-- Incluyendo BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Script JS para sumar productos al carrito dinamicamente -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const addToCartButton = document.getElementById('add-to-cart');
        const quantityInput = document.getElementById('product-quantity');

        // Actualiza la cantidad desde los botones
        window.updateQuantity = function (change) {
            const maxStock = parseInt(quantityInput.getAttribute('max'));
            let currentValue = parseInt(quantityInput.value);

            if (isNaN(currentValue)) currentValue = 1;

            const newValue = currentValue + change;

            if (newValue >= 1 && newValue <= maxStock) {
                quantityInput.value = newValue;
            }
        };

        // Manejo del clic en "Agregar al carrito"
        addToCartButton.addEventListener('click', function (event) {
            event.preventDefault();

            const productId = addToCartButton.getAttribute('data-id');
            const quantity = parseInt(quantityInput.value);

            // Validar cantidad
            if (isNaN(quantity) || quantity < 1) {
                alert('Por favor, ingresa una cantidad válida.');
                return;
            }

            // Enviar solicitud para agregar al carrito
            fetch('./componentes/add_to_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ productId: productId, quantity: quantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Actualizar el contador del carrito
                    document.getElementById('cart-count').textContent = data.cartCount;

                   /* // Opcional: Mostrar mensaje de confirmación
                    alert('Producto agregado al carrito correctamente.');*/

                    // Resetear la cantidad al valor inicial (1)
                    quantityInput.value = 1;
                } else {
                    console.error('Error al agregar al carrito:', data.error);
                    alert('Error al agregar al carrito. Posiblemente no hay mas stock ó agregaste el último artículo. Intenta nuevamente.');
                }
            })
            .catch(error => {
                console.error('Error al procesar la solicitud:', error);
                alert('Error al agregar al carrito. Intenta nuevamente.');
            });
        });
    });
</script>


</body>

</html>
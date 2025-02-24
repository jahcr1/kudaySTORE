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
    <title>Detalles del Producto </title>
    
    <!-- FAMILIAS TIPOGRAFICAS DE GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aclonica&family=Bangers&family=Barrio&family=Chango&family=Chewy&family=Chicle&family=Delius+Unicase:wght@400;700&family=Flavors&family=Gwendolyn:wght@400;700&family=Ingrid+Darling&family=Just+Me+Again+Down+Here&family=Kablammo&family=Lumanosimo&family=Martian+Mono:wght@100..800&family=Mystery+Quest&family=Pacifico&family=Rubik+Puddles&family=Shrikhand&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&family=Unkempt:wght@400;700&family=Vibur&family=Yomogi&display=swap" rel="stylesheet">
    
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
            <div class="container-fluid">
                    <a class="navbar-brand marca align-self-center text-center" href="../index.php#inicio">Kuday Artesanias</a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarScroll">
                        <ul class="navbar-nav ms-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 600px; margin-right:50px;">
                            <li class="nav-item">
                                <a class="nav-link active boton-nav" href="../index.php#inicio">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active boton-nav" aria-current="page" href="promociones.php">Promociones</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle active boton-nav" href="tienda.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Productos
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="neceser.php">Neceser</a></li>
                                    <hr class="dropdown-divider">
                                    <li><a class="dropdown-item" href="setmatero.php">Sets Materos</a></li>
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
                            <li class="nav-item align-self-center">
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

    <section id="ver_producto">
        <div id="details">
            <div class="detalle-img col-xl-5 col-lg-5 col-md-5 col-sm-10">
                <img src="data:<?php echo $producto['formato_imagen']; ?>;base64,<?php echo base64_encode($producto['ci_imagen_producto']); ?>" alt="Imagen del Producto" class="img-fluid">
            </div>
            <div class="detalle-producto col-xl-5 col-lg-5 col-md-5 col-sm-10 text-center">
                <div class="detalle-main">
                    <h1><?php echo $producto['nombre']; ?></h1>
                    <p><strong>Categoría:</strong> <?php echo $producto['categoria_nombre']; ?></p>
                    <p><strong>Precio:</strong> $<?php echo $producto['precio']; ?></p>
                    <p><strong>Stock disponible:</strong> <?php echo $producto['stock']; ?></p>
                    <p><strong>Descripción:</strong> <?php echo $producto['descripcion']; ?></p>
                </div>

                <div class="detalle-botones">
                    <div class="quantity-controller">
                        <button class="btn-decrease" onclick="updateQuantity(-1)">−</button>
                        <input type="number" id="product-quantity" value="1" min="1" max="<?php echo $producto['stock']; ?>">
                        <button class="btn-increase" onclick="updateQuantity(1)">+</button>
                    </div>
                    <button id="add-to-cart" class="btn btn-danger add-carrito" data-id="<?php echo $producto['id']; ?>">
                        Agregar al carrito
                    </button>
                </div>

                <div class="accordion mt-3" id="accordionPanelsStayOpenExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                        <i class="fa-solid fa-house-chimney"></i>&nbsp;&nbsp;&nbsp;Nuestro Local
                        </button>
                        </h2>
                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <strong>Kuday Artesanias</strong> General Araóz de Lamadrid 425 - Barrio General Paz, Cordoba Argentina
                        </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                        <i class="fa-solid fa-truck-fast"></i></i>&nbsp;&nbsp;&nbsp;Medios de Envio
                        </button>
                        </h2>
                        <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <div class="input-group">
                                <input type="text" class="form-control" aria-label="Text input with segmented dropdown button" placeholder="Tu código postal">
                                <button type="button" class="btn btn-outline-secondary">CALCULAR</button>
                                <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="visually-hidden">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="https://www.correoargentino.com.ar/formularios/cpa" target="_blank">No sé mi Código Postal</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#">RESETEAR C.P</a></li>
                                </ul>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                            Accordion Item #3
                        </button>
                        </h2>
                        <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <footer class="cartuchera-footer">
        <main class="container-fluid">
            <div class="row contenedor_footer-cartuchera">  
                <div class="col-xl-3 col-md-3 col-sm-10 p-2">
                    <h6 class="h6-footer-cartuchera"><i class="bi bi-tencent-qq"></i>  CONTÁCTANOS</h6>
                    <p class="p-footer-cartuchera"><i class="bi bi-telephone-fill"></i>   +54 9 0297 432-1429</p>
                    <p class="p-footer-cartuchera"><i class="bi bi-whatsapp"></i>   +54 9 0297 432-1429</p>
                    <p class="p-footer-cartuchera"><i class="bi bi-geo-alt-fill"></i>   Gral. Araóz de Lamadrid 425</p>
                </div>
                <div class="col-xl-3 col-md-3 col-sm-6 p-2">
                    <h6 class="h6-footer-cartuchera"><i class="bi bi-tencent-qq"></i>  MEDIOS DE PAGO</h6>
                    <div class="contenedor-cards p-2">
                        <img src="./images/cards/visa.png"  alt="mp">
                        <img src="./images/cards/naranja.png" alt="visa">
                        <img src="./images/cards/mercadopago2.png" alt="visa">
                        <img src="./images/cards/pagofacil.png" alt="visa">
                        <img src="./images/cards/efectivo.png" alt="visa">
                        <img src="./images/cards/rapipago.png" alt="">
                    </div>
                </div>
                <div class="col-xl-3 col-md-3 col-sm-6 p-2">
                    <h6 class="h6-footer-cartuchera"><i class="bi bi-tencent-qq"></i>  FORMAS DE ENVIO</h6>
                    <div class="contenedor-cards p-2">
                        <img src="./images/cards/andreani.png" alt="">
                        <img src="./images/cards/correoarg.png" alt="">
                    </div>
                </div>
                <div class="row d-flex">
                    <h4>Seguinos en nuestras redes!</h4>
                    <div class="redes-icons-footer-cartuchera ">
                        <a href="https://www.facebook.com/dai.quiroga.7" target="_"><i class="bi bi-facebook"></i></a>
                        <a href="https://www.facebook.com/dai.quiroga.7"><i class="bi bi-instagram"></i></a>
                        <a href="https://www.facebook.com/dai.quiroga.7"><i class="bi bi-pinterest"></i></a>
                    </div>
                </div>
            </div>
        </main>

        <p style="font-size:10px;background-color:white; color:black;width:100%;padding:0 5px;"><i class="bi bi-c-circle"></i> COPYRIGHT KUDAY ARTESANIAS & DEVCR1 2021. TODOS LOS DERECHOS RESERVADOS.</p>
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
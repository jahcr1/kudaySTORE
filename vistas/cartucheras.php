<?php
session_start();
$cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cartucheras Kuday | Sitio Oficial</title>
    
    <!-- FAMILIAS TIPOGRAFICAS DE GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aclonica&family=Bangers&family=Barrio&family=Chango&family=Chewy&family=Chicle&family=Delius+Unicase:wght@400;700&family=Flavors&family=Gwendolyn:wght@400;700&family=Ingrid+Darling&family=Just+Me+Again+Down+Here&family=Kablammo&family=Lumanosimo&family=Martian+Mono:wght@100..800&family=Mystery+Quest&family=Pacifico&family=Rubik+Puddles&family=Shrikhand&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&family=Unkempt:wght@400;700&family=Vibur&family=Yomogi&display=swap" rel="stylesheet">
    
    <!-- ICONOS DE BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS DE BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- CSS PROPIO -->
    <link rel="stylesheet" href="../CSS/styles.css">

</head>

<body class="cartuchera-body">

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
                                <a href="../carrito.php" class="cart-icon">
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

    <section id="slide-cartuchera">

        <div class="container contenedor-slide-cartuchera">
            <div class="box1">
                <a id="cartuchera-bounce" class="propaganda2" href="../vistas/promociones.php" target="_blank">Ver Promociones</a>
            </div>
            <div class="box2">
                <div class="imagen-logo">
                    <img src="../images/logo/logo.png" class="img-logo-slide">
                </div>
            </div>
            
        </div>

    </section>


    <section id="cartucheras" style="margin-top:20px; padding:20px 0 20px 0;">

        <div class="container">
            <h3 class="text-center titulo-categoria" style="margin-top: 80px;">Cartucheras</h3>
        </div>

        <div style="margin-top: 50px;">
            <div class="grid-container">
                <!-- ACA LISTAMOS SOLO LAS CARTUCHERAS DESDE LA BD -->
                <?php
                include('../componentes/conexion.php');
                $consultar_productos = mysqli_query($conexion, "SELECT p.*, c.nombre AS categoria_nombre FROM productos p JOIN categorias c ON p.categoria_id = c.id WHERE p.categoria_id = '1'");
                while ($listar_productos = mysqli_fetch_assoc($consultar_productos)) {
                ?>
                    <div class="producto">
                        <div class="contenedor-foto">
                            <?php if (!empty($listar_productos['ci_imagen_producto'])): ?>
                                <?php
                                $img_data = base64_encode($listar_productos['ci_imagen_producto']);
                                $img_type = $listar_productos['formato_imagen'];
                                echo "<img src='data:$img_type;base64,$img_data' class='imagen-producto' alt='Imagen del producto'>";
                                ?>
                            <?php else: ?>
                                <p>Sin imagen disponible</p>
                            <?php endif; ?>
                        </div>
                        <div class="card contenedor-detalle">
                            <div class="card-body">
                                <h5 class="card-title p-2 item-card"><?php echo $listar_productos['nombre']; ?></h5>
                                <p class="text-start p-3"><strong>Articulo : </strong><span class="dato"><?php echo $listar_productos['categoria_nombre']; ?></span></p>
                                <p class="text-start p-3" style="border-top: 1px solid black;"><strong>Precio : </strong><span class="dato">$<?php echo $listar_productos['precio']; ?></span></p>
                                <p class="text-start p-3" style="border-top: 1px solid black;"><strong>Cantidad : </strong><span class="dato"><?php echo $listar_productos['stock']; ?></span></p>
                                <p class="text-start p-3" style="border-top: 1px solid black;"><strong>Descripción : </strong><span class="dato"><?php echo $listar_productos['descripcion']; ?></span></p>
                                <div class="botonera-producto">
                                    <!-- Botón para Ver Producto -->
                                    <a href="../producto.php?id=<?php echo $listar_productos['id']; ?>" class="btn btn-danger ver-producto">Ver producto</a>
                                    <a href="../carrito.php" class="btn btn-danger add-carrito" data-id="<?php echo $listar_productos['id']; ?>">Agregar al carrito</a>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
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
                        <img src="../images/cards/visa.png"  alt="mp">
                        <img src="../images/cards/naranja.png" alt="visa">
                        <img src="../images/cards/mercadopago2.png" alt="visa">
                        <img src="../images/cards/pagofacil.png" alt="visa">
                        <img src="../images/cards/efectivo.png" alt="visa">
                        <img src="../images/cards/rapipago.png" alt="">
                    </div>
                </div>
                <div class="col-xl-3 col-md-3 col-sm-6 p-2">
                    <h6 class="h6-footer-cartuchera"><i class="bi bi-tencent-qq"></i>  FORMAS DE ENVIO</h6>
                    <div class="contenedor-cards p-2">
                        <img src="../images/cards/andreani.png" alt="">
                        <img src="../images/cards/correoarg.png" alt="">
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
    
    <!-- Incluyendo GSAP desde un CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.2/gsap.min.js"></script>
    
    <!-- Incluyendo GSAP BOUNCE -->
    <script>
        gsap.to("#cartuchera-bounce", {
            duration: 1.5,
            y: 50,
            ease: "bounce.out", // Efecto de rebote realista
            repeat: -1, // Animación infinita
            yoyo: true // Vuelve a su posición original para continuar rebotando
        });
    </script>

    <script>
        let words = gsap.utils.toArray("svg text"),
        tl = gsap.timeline({delay: 0.5}),
        timePerCharacter = 0.2;

        words.forEach(el => {
            tl.from(el, {text: "", duration: el.innerHTML.length * timePerCharacter, ease: "none"});
        });
    </script>

    <!-- Script JS para sumar productos al carrito dinamicamente -->
    <script>
        // Obtén todos los botones de agregar al carrito
        const addToCartButtons = document.querySelectorAll('.add-carrito');

        addToCartButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Evita que la página se recargue al hacer clic

                const productId = button.getAttribute('data-id'); // Obtén el ID del producto

                // Envío de los datos al servidor
                fetch('../componentes/add_to_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        productId: productId,
                        quantity: 1
                    })
                })
                .then(response => response.text()) // Usamos text() en lugar de json() para ver la respuesta completa
                .then(responseText => {
                    console.log('Respuesta del servidor:', responseText);
                    try {
                        const data = JSON.parse(responseText);
                        if (data.success) {
                            document.getElementById('cart-count').textContent = data.cartCount;
                            console.log('Producto agregado correctamente');
                        } else {
                            console.error('Error al agregar al carrito:', data.error);
                        }
                    } catch (error) {
                        console.error('Error al parsear JSON:', error);
                    }
                })
                .catch(error => {
                    console.error('Error al hacer la solicitud:', error);
                });

        });
    });

    </script>





</body>

</html>
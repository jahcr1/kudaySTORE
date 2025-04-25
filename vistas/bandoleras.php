<?php
session_start();
$cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bandoleras Kuday | Sitio Oficial</title>
    
    <!-- FAMILIAS TIPOGRAFICAS DE GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Birthstone&family=Delius+Unicase:wght@400;700&family=Fuzzy+Bubbles:wght@400;700&family=Gwendolyn:wght@400;700&family=Homemade+Apple&family=Just+Me+Again+Down+Here&family=Kablammo&family=Klee+One&family=Ms+Madi&family=Mystery+Quest&family=Pacifico&family=Playwrite+IT+Moderna:wght@100..400&family=Poiret+One&family=Teko:wght@300..700&family=Unkempt:wght@400;700&family=Vibur&family=Yomogi&display=swap" rel="stylesheet">
    
    <!-- ICONOS DE BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- ICONOS DE FONTAWESOME -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" rel="stylesheet">

    <!-- Agrega Swiper.js desde CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <!-- CSS DE BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- CSS PROPIO -->
    <link rel="stylesheet" href="../CSS/styles.css">

</head>

<body class="cartuchera-body">

    <header>
        <nav class="navbar navbar-expand-lg fixed-top cartuchera-nav">
            <div class="container-fluid" style="flex-wrap: wrap;">
                    <a class="navbar-brand marca align-self-center text-center" href="../index.php#inicio">Kuday Artesanias</a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarScroll">
                        <ul class="navbar-nav ms-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 620px; margin-right:50px;">
                            <li class="nav-item">
                                <a class="nav-link active boton-nav" href="../index.php#inicio">Inicio</a>
                            </li>
                            <li class="nav-item dropdown" style="align-items: flex-start;">
                                <a class="nav-link dropdown-toggle active boton-nav" href="tienda.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Productos
                                </a>
                                <ul class="dropdown-menu mx-2">
                                    <li><a class="dropdown-item" href="cartucheras.php">Cartucheras</a></li>
                                    <hr class="dropdown-divider">
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
                                    <hr class="dropdown-divider">
                                    <li><a class="dropdown-item" href="promociones.php">Promociones</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active boton-nav" aria-current="page" href="#seccion_footer">Quiénes Somos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active boton-nav" href="../contacto.php" target="_blank">Contactános</a>
                            </li>
                            <li class="nav-item cart-item">
                                <a href="../carrito.php" target="_blank" class="cart-icon">
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

    <section id="cartucheras" style="margin-top:20px; padding:20px 0 20px 0;">

        <div class="container contenedor-h3">
            <h3 class="text-center titulo-categoria" style="margin-top: 80px;">Bandoleras</h3>
        </div>

        <div style="margin-top: 50px;">
            <div class="grid-container">
                <!-- ACA LISTAMOS SOLO LAS BANDOLERAS DESDE LA BD -->
                <?php
                include('../componentes/conexion.php');
                $consultar_productos = mysqli_query($conexion, "SELECT p.*, c.nombre AS categoria_nombre FROM productos p JOIN categorias c ON p.categoria_id = c.id WHERE p.categoria_id = '6'");
                while ($listar_productos = mysqli_fetch_assoc($consultar_productos)) {
                ?>
                    <div class="producto">
                        <div class="contenedor-foto">
                            <?php if (!empty($listar_productos['ci_imagen_producto'])): ?>
                                <?php
                                $img_data = base64_encode($listar_productos['ci_imagen_producto']);
                                $img_type = $listar_productos['formato_imagen'];
                                echo "<img src='data:$img_type;base64,$img_data' class='imagen-producto' loading='lazy' alt='Imagen del producto'>";
                                ?>
                            <?php else: ?>
                                <p>Sin imagen disponible</p>
                            <?php endif; ?>
                        </div>
                        <div class="card contenedor-detalle">
                            <div class="card-body">
                                <h5 class="item-card"><?php echo $listar_productos['nombre']; ?></h5>

                                <ul class="detalle-lista">
                                    <li><strong>Artículo:</strong> <?php echo $listar_productos['categoria_nombre']; ?></li>
                                    <li><strong>Precio:</strong> $<?php echo $listar_productos['precio']; ?></li>
                                    <li><strong>Cantidad:</strong> <?php echo $listar_productos['stock']; ?></li>
                                    <li><strong>Descripción:</strong> <?php echo $listar_productos['descripcion']; ?></li>
                                </ul>

                                <div class="botonera-producto">
                                    <a href="../producto.php?id=<?php echo $listar_productos['id']; ?>" class="boton-producto">Ver producto</a>
                                    <a href="../carrito.php" class="boton-producto add-carrito" data-id="<?php echo $listar_productos['id']; ?>">Agregar al carrito</a>
                                </div>
                            </div> 
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

    </section>

    <section id="productos-relevantes" class="slider-container">
        <h3 class="titulo-slider-views" id="titulo_productos">Productos que también llevaron.. </h3>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <?php
                include('../componentes/conexion.php');
                $query = "SELECT p.*, c.nombre AS categoria_nombre FROM productos p JOIN categorias c ON p.categoria_id = c.id WHERE p.categoria_id = '8' LIMIT 10";
                $result = mysqli_query($conexion, $query);
                while ($producto = mysqli_fetch_assoc($result)) {
                ?>
                    <div class="swiper-slide slider-item">
                        <?php if (!empty($producto['ci_imagen_producto'])): ?>
                            <?php
                            $img_data = base64_encode($producto['ci_imagen_producto']);
                            $img_type = $producto['formato_imagen'];
                            echo "<img src='data:$img_type;base64,$img_data' alt='Imagen de {$producto['nombre']}' class='producto-img'>";
                            ?>
                        <?php else: ?>
                            <p class="no-imagen">Sin imagen disponible</p>
                        <?php endif; ?>
                        <h5 class="producto-nombre"><?php echo $producto['nombre']; ?></h5>
                        <button class="btn btn-primary" onclick="window.location.href='../producto.php?id=<?php echo $producto['id']; ?>'">
                            Ver más
                        </button>
                    </div>
                <?php } ?>
            </div>
            <!-- Agrega navegación y paginación -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
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

                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-8 p-2">
                
                <h6 class="h6-footer"><i class="bi bi-tencent-qq pinguin"></i> MEDIOS DE PAGO</h6>
                <div class="contenedor-cards p-2">
                    <img src="../images/cards/visa.png" alt="mp">
                    <img src="../images/cards/naranja.png" alt="visa">
                    <img src="../images/cards/mercadopago2.png" alt="visa">
                    <img src="../images/cards/pagofacil.png" alt="visa">
                    <img src="../images/cards/efectivo.png" alt="visa">
                    <img src="../images/cards/rapipago.png" alt="">
                </div>

                <h6 class="h6-footer"><i class="bi bi-tencent-qq pinguin"></i> FORMAS DE ENVIO</h6>
                <div class="contenedor-cards p-2">
                    <img src="../images/cards/andreani.png" alt="">
                    <img src="../images/cards/correoarg.png" alt="">
                </div>

                <h6 class="h6-footer" style="text-wrap: wrap!important;"><i class="bi bi-tencent-qq pinguin"></i> SEGUINOS EN NUESTRAS REDES!</h6>
                <div class="redes-icons-footer">
                    <a href="https://www.facebook.com/dai.quiroga.7" target="_blank"><i class="bi bi-facebook fb"></i></a>
                    <a href="https://www.facebook.com/dai.quiroga.7" target="_blank"><i class="bi bi-instagram ig"></i></a>
                </div>
                </div>
                
            </div>
        </main>

        <p style="font-size:10px;background-color:white; color:black;width:100%;padding:0 5px;"><i class="bi bi-c-circle"></i> 2021 Kuday Artesanias & jahcr1. Todos los derechos reservados.</p>

    </footer>


    <!-- Incluyendo BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <!-- Incluyendo GSAP desde un CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.2/gsap.min.js"></script>

    <!-- Agrega Swiper.js desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    

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

    <script>
        document.addEventListener("DOMContentLoaded", function () {
        new Swiper(".mySwiper", {
            loop: true, // Hace que el slider sea infinito
            slidesPerView: 3,
            spaceBetween: 10,
            autoplay: {
                delay: 3000, // Cambia cada 3 segundos
                disableOnInteraction: false, // Sigue moviéndose aunque el usuario interactúe
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                250: {  
                    slidesPerView: 1,  // Muestra 1 slide (ya está igual en 480px)
                    spaceBetween: 5,   // Espacio muy pequeño entre los slides
                },
                480: {  
                    slidesPerView: 1, // Muestra solo un slide
                    spaceBetween: 10, // Menor espacio entre los slides
                },
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
            },
        });
    });
    </script>



</body>

</html>
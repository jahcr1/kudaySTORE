<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TIENDA Kuday</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/styles.css">

</head>

<body class="cartuchera-body">

    <header>
        <nav class="navbar navbar-expand-lg fixed-top cartuchera-nav">
            <div class="container-fluid">
                    <a class="navbar-brand marca align-self-center text-center" href="index.php#inicio">Kuday Artesanias</a>

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
                       </ul>
                 </div>
            </div>
        </nav>
    </header>

    <section id="slide-cartuchera">

        <div class="container contenedor-slide-cartuchera">
            <div class="box1">
                <div class="box1-index">
                    <p class="propaganda1">En Kuday vas a encontrar promos, articulos unicos y más...</p>
                </div>
                <a id="cartuchera-bounce" class="propaganda2" href="../vistas/promociones.php" target="_blank">Ver Promociones..</a>
            </div>
            <div class="box2">
                <div class="imagen-logo">
                    <img src="../images/logo/logo.png" alt="">
                </div>
                <div style="display: none;">
                    <svg viewBox="0 0 250 80" xmlns="http://www.w3.org/2000/svg">
                        <style>
                        .small {
                            font: italic 13px sans-serif;
                         }
                        .heavy {
                            font: bold 25px sans-serif;
                          }

                        .Rrrrr {
                            font: italic 32px serif;
                            fill: red;
                         }
                        </style>

                        <text x="20" y="35" class="small">En</text>
                        <text x="40" y="35" class="heavy">Kuday</text>
                        <text x="25" y="55" class="small">festejamos</text>
                        <text x="85" y="65" class="Rrrrr">El Verano!</text>
                    </svg>
                </div>
            </div>
            
        </div>

    </section>


    <section id="cartucheras" style="margin-top: 20px; padding: 20px 0 20px 0;">

        <div class="container">
            <h3 class="text-center titulo-categoria" style="margin-top: 80px;">Cartucheras</h3>
        </div>

        <div class="container text-center" style="margin-top: 50px;">
            <div class=" row m-1">
                
                <!-- ACA LISTAMOS SOLO LAS CARTUCHERAS DESDE LA BD -->
                <?php
                include('../componentes/conexion.php');
                $consultar_productos = mysqli_query($conexion, "SELECT p.*, c.nombre AS categoria_nombre FROM productos p JOIN categorias c ON p.categoria_id = c.id WHERE p.categoria_id = '1'");
                while ($listar_productos = mysqli_fetch_assoc($consultar_productos)) {
                ?>
                    <div class="listas">
                        <div class="col-md-3 m-2 contenedor-foto align-self-center">
                            <?php if (!empty($listar_productos['ci_imagen_producto'])): ?>
                                <?php
                                $img_data = base64_encode($listar_productos['ci_imagen_producto']);
                                $img_type = $listar_productos['formato_imagen'];
                                echo "<img src='data:$img_type;base64,$img_data' class='imagen-render-vistas' alt='Imagen del producto'>";
                                ?>
                            <?php else: ?>
                                <p>Sin imagen disponible</p>
                            <?php endif; ?>
                        </div>
                        <div class="card contenedor-detalle m-2">
                            <div class="card-body card-body-tienda ">
                                <h5 class="card-title text-center p-2 item-card "><?php echo $listar_productos['nombre']; ?></h5>
                                <p class="text-start p-2"><span style="font-weight: bold;">Articulo: </span><span class="dato"><?php echo $listar_productos['categoria_nombre']; ?></span></p>
                                <p class="text-start p-2" style="border-top: 1px solid black;"><span style="font-weight: bold;">Precio: </span><span class="dato">$<?php echo $listar_productos['precio']; ?></span></p>
                                <p class="text-start p-2" style="border-top: 1px solid black;"><span style="font-weight: bold;">Descripción: </span><span class="dato"><?php echo $listar_productos['descripcion']; ?></span></p>
                                <a href="./index.php" class="btn btn-danger add-carrito">Agregar al carrito</a>
                            </div>
                        </div>
                    </div>
                <?php  } ?>

            </div>
        </div>

    </section>



    <footer>
        <?php include('../foot.php'); ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Incluyendo GSAP desde un CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.2/gsap.min.js"></script>
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

</body>

</html>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TIENDA Kuday</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/styles.css">

</head>

<body style="background-color: #fcd6ef;">

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

    <section id="slide-cartuchera">
        
        <div class="container">

        <div class="container-fluid slide-tienda">
            
            <div id="carouselExampleAutoplaying" style="margin-top: 100px;" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner contenedor-carusel1 border rounded">
                        <div class="carousel-item active">
                            <div class="container mx-auto">
                                <div class="text-center">
                                    <img src="./images/cartu/cartu1.png" class="pic-slide-tienda object-fit-contain text-center" alt="cartu1">
                                </div>
                                <div class="heading text-center">
                                    <h3>Cartuchera purple1</h3>
                                    <a href="detallesflores.php" class="btn btn-danger">VER</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item active">
                            <div class="container mx-auto">
                                <div class="text-center">
                                    <img src="./images/cartu/cartu2.png" class="pic-slide-tienda object-fit-cover text-center" alt="cartu2">
                                </div>
                                <div class="heading text-center">
                                    <h3>Cartuchera purple2</h3>
                                    <a href="detallesflores.php" class="btn btn-danger">VER</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item active">
                            <div class="container mx-auto">
                                <div class="text-center">
                                    <img src="./images/cartu/cartu3.png" class="pic-slide-tienda object-fit-contain text-center" alt="cartu3">
                                </div>
                                <div class="heading text-center">
                                    <h3>Cartuchera purple3</h3>
                                    <a href="detallesflores.php" class="btn btn-danger">VER</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
    
                </div>
            
        </div>

    </section>


    <section id="cartucheras" style="margin-top: 20px; padding: 20px 0 20px 0;" class="img-fluid">

        <div class="container">
            <h3 class="text-center titulo" style="margin-top: 80px;">Cartucheras</h3>
        </div>

        <div class="container text-center" style="margin-top: 50px;">
            <div class=" row m-1">
                <?php 
                include('componentes/conexion.php');
                $consultar_productos = mysqli_query($conexion, "SELECT * FROM productos WHERE categoria_producto = 'Cartuchera'");
                while ($listar_productos = mysqli_fetch_assoc($consultar_productos)) {
                ?>
                             
                <div class="col-md-3 m-2 fondo-card-tienda align-content-center">
                    <img src="componentes/imagen_producto.php?id=<?php echo $listar_productos['id_producto']; ?>" style="padding: 10px" class="img-promo-tienda img-fluid img3">
                </div>
                <div class="card col-md-7 m-2">
                    <div class="card-body card-body-tienda ">
                        <h5 class="card-title text-center p-2 item-card "><?php echo $listar_productos['nombre_producto']; ?></h5>
                        <p class="text-start p-2"><span style="font-weight: bold;">Articulo: </span><?php echo $listar_productos['categoria_producto']; ?></p>
                        <p class="text-start p-2" style="border-top: 1px solid black;"><span style="font-weight: bold;">Precio: </span><?php echo $listar_productos['precio_producto']; ?></p>
                        <p class="text-start p-2" style="border-top: 1px solid black;"><span style="font-weight: bold;">Descripción: </span><?php echo $listar_productos['descripcion_producto']; ?></p>
                        <a href="./index.php" class="btn btn-danger w-100 mt-auto">Agregar al carrito</a>
                    </div>
                </div>
                <?php  } ?>
            
            </div>
        </div>

    </section>

    

    <footer>
        <?php include('foot.php');?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
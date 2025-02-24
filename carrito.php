<?php
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
                        Mis Productos
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
                                        <th>Eliminar</th>
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
                                    <tr id="costoEnvioRow" style="display: none;">
                                        <td colspan="3"><strong>Costo de Envío</strong></td>
                                        <td><strong id="costoEnvio">$0.00</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><strong>Total</strong></td>
                                        <td><strong id="total">$<?php echo $total; ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-3">
                            <button class="btn btn-primary" onclick="continuarCompra()">Continuar con la Compra</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="envioAccordion" style="display: none;">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Datos de Envio
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <form class="p-4 border rounded shadow-sm bg-light">
                            <div class="row g-3">
                                <!-- Nombre -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control form-control-sm" id="nombre" placeholder="Nombre" required autocomplete="on">
                                        <label for="nombre">Nombre</label>
                                    </div>
                                </div>
                                <!-- Apellido -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control form-control-sm" id="apellido" placeholder="Apellido" required autocomplete="on">
                                        <label for="apellido">Apellido</label>
                                    </div>
                                </div>
                                <!-- Teléfono -->
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control form-control-sm" id="telefono" placeholder="Teléfono" required autocomplete="off">
                                        <label for="telefono">Teléfono</label>
                                    </div>
                                </div>
                                <!-- Correo -->
                                <div class="col-md-8">
                                    <div class="form-floating">
                                        <input type="email" class="form-control form-control-sm" id="correo" placeholder="Correo Electrónico" required autocomplete="off">
                                        <label for="correo">Correo Electrónico</label>
                                    </div>
                                </div>
                                <!-- Provincia -->
                                <div class="col-md-5">
                                    <div class="form-floating">
                                        <select class="form-select form-select-sm" id="provincia" required autocomplete="off">
                                            <option selected>Seleccione...</option>
                                            <option value="1">Buenos Aires</option>
                                            <option value="2">Córdoba</option>
                                            <option value="3">Santa Cruz</option>
                                            <option value="4">Catamarca</option>
                                            <option value="5">Chaco</option>
                                            <option value="6">Chubut</option>
                                            <option value="7">Corrientes</option>
                                            <option value="8">Entre Rios</option>
                                            <option value="9">Formosa</option>
                                            <option value="10">Jujuy</option>
                                            <option value="11">La Pampa</option>
                                            <option value="12">La Rioja</option>
                                            <option value="13">Mendoza</option>
                                            <option value="14">Misiones</option>
                                            <option value="15">Neuquén</option>
                                            <option value="16">Rio Negro</option>
                                            <option value="17">Salta</option>
                                            <option value="18">San Juan</option>
                                            <option value="19">San Luis</option>
                                            <option value="20">Santa Fe</option>
                                            <option value="21">Santiago Del Estero</option>
                                            <option value="22">Tierra Del Fuego</option>
                                            <option value="23">Tucumán</option>
                                        </select>
                                        <label for="provincia">Provincia</label>
                                    </div>
                                </div>
                                <!-- Ciudad -->
                                <div class="col-md-7">
                                    <div class="form-floating">
                                        <input type="text" class="form-control form-control-sm" id="ciudad" placeholder="Ciudad" required autocomplete="off">
                                        <label for="ciudad">Ciudad</label>
                                    </div>
                                </div>
                                <!-- Dirección -->
                                <div class="col-md-9">
                                    <div class="form-floating">
                                        <input type="text" class="form-control form-control-sm" id="direccion" placeholder="Dirección" required autocomplete="off">
                                        <label for="direccion">Dirección</label>
                                    </div>
                                </div>
                                <!-- Código Postal -->
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control form-control-sm" id="codigoPostal" placeholder="Código Postal" required autocomplete="off">
                                        <label for="codigoPostal">Código Postal</label>
                                    </div>
                                </div>
                                <!-- Botón de envío -->
                                <div class="col-12 text-center mt-3">
                                    <button type="button" class="btn btn-primary px-4" onclick="confirmarDatosEnvio()">Confirmar Datos de Envío</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="text-center mt-3 w-100">
                <button id="finalizarCompraBtn" class="btn btn-success" style="display: none;" onclick="finalizarCompra()">Finalizar Compra</button>
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
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${id}&cantidad=${cantidad}`
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('cart-count').textContent = data.cartCount;
                })
                .catch(error => console.error('Error al actualizar el carrito:', error));
        }

        function continuarCompra() {
            // Habilita el segundo accordion
            document.getElementById("envioAccordion").style.display = "block";

            let cartItems = [];
            document.querySelectorAll("#cart-body tr[data-id]").forEach(row => {
                let id = row.dataset.id;
                let name = row.cells[0].textContent;
                let price = parseFloat(row.cells[1].textContent.replace('$', ''));
                let cantidad = parseInt(row.querySelector('.cantidad').value);
                let subtotal = price * cantidad;
                cartItems.push({
                    id,
                    name,
                    cantidad,
                    subtotal
                });
            });

            console.log("Productos en el carrito:", cartItems);
            alert("Carrito actualizado. Puedes proceder con la compra.");

            //  Reiniciar el costo de envío a 0
            let costoEnvioActual = parseFloat(localStorage.getItem("costoEnvio") || "0");
            let totalActual = parseFloat(document.getElementById("total").textContent.replace("$", "").trim());

            // Restar el costo de envío anterior del total
            let nuevoTotal = totalActual - costoEnvioActual;

            // Asegurar que no haya valores negativos
            nuevoTotal = Math.max(nuevoTotal, 0);

            // Actualizar la interfaz y limpiar el localStorage
            document.getElementById("costoEnvio").textContent = "$0";
            document.getElementById("costoEnvioRow").style.display = "none";
            document.getElementById("total").textContent = `$${nuevoTotal.toFixed(2)}`;

            localStorage.setItem("costoEnvio", "0");
            localStorage.setItem("totalCompra", nuevoTotal);
        }


        function confirmarDatosEnvio() {
            let provincia = document.getElementById("provincia").value;

            if (provincia === "Seleccione...") {
                alert("Por favor, selecciona una provincia.");
                return;
            }

            fetch('./componentes/calcular_envio.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `provincia=${provincia}`
                })
                .then(response => response.json())
                .then(data => {
                    let costoEnvio = parseFloat(data.costoEnvio);

                    // Mostrar el costo de envío en el segundo accordion
                    document.getElementById("costoEnvio").textContent = `$${costoEnvio}`;
                    document.getElementById("costoEnvioRow").style.display = "table-row";

                    // Obtener el total actual del primer accordion
                    let totalActual = parseFloat(document.getElementById("total").textContent.replace("$", "").trim());
                    let nuevoTotal = totalActual + costoEnvio;

                    // Actualizar el total en el primer accordion
                    document.getElementById("total").textContent = `$${nuevoTotal.toFixed(2)}`;

                    // Guardar en localStorage para mantener valores después de actualizar
                    localStorage.setItem("costoEnvio", costoEnvio);
                    localStorage.setItem("totalCompra", nuevoTotal);

                    // Mostrar el botón "Finalizar Compra"
                    document.getElementById("finalizarCompraBtn").style.display = "block";
                })
                .catch(error => console.error('Error al calcular el costo de envío:', error));
        }

            // Este script hace que Al cargar la página, recuperar los valores guardados en localStorage
            document.addEventListener("DOMContentLoaded", function() {
                let costoGuardado = localStorage.getItem("costoEnvio");
                let totalGuardado = localStorage.getItem("totalCompra");

                if (costoGuardado && totalGuardado) {
                    document.getElementById("costoEnvio").textContent = `$${costoGuardado}`;
                    document.getElementById("costoEnvioRow").style.display = "table-row";
                    document.getElementById("total").textContent = `$${parseFloat(totalGuardado).toFixed(2)}`;
                }
            });

        function finalizarCompra() {
            let nombre = document.getElementById("nombre").value.trim();
            let apellido = document.getElementById("apellido").value.trim();  // Nuevo campo
            let telefono = document.getElementById("telefono").value.trim();  // Nuevo campo
            let email = document.getElementById("correo").value.trim();
            let direccion = document.getElementById("direccion").value.trim();
            let ciudad = document.getElementById("ciudad").value.trim();  // Nuevo campo
            let provincia = document.getElementById("provincia").value.trim();
            let codigopostal = document.getElementById("codigoPostal").value.trim();
            let total = parseFloat(localStorage.getItem("totalCompra") || "0");

            // Recoger los productos del carrito
            let productos = [];
            document.querySelectorAll("#cart-body tr[data-id]").forEach(row => {
                let id = row.dataset.id;
                let name = row.cells[0].textContent;
                let price = parseFloat(row.cells[1].textContent.replace('$', ''));
                let cantidad = parseInt(row.querySelector('.cantidad').value);
                productos.push({ id, name, cantidad, price });
            });

            // Validación básica (ahora incluye los nuevos campos)
            if (!nombre || !apellido || !telefono || !email || !direccion || !ciudad || !codigopostal || provincia === "Seleccione..." || productos.length === 0 || total <= 0) {
                alert("Por favor, completa todos los datos correctamente.");
                return;
            }

            // Enviar los datos al servidor
            fetch('./componentes/procesar_compra.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    nombre: nombre,
                    apellido: apellido,  //  Nuevo campo agregado 
                    telefono: telefono,  //  Nuevo campo agregado 
                    email: email,
                    direccion: direccion,
                    provincia: provincia,
                    ciudad: ciudad,  //  Nuevo campo agregado 
                    codigopostal: codigopostal,  //  Nuevo campo agregado 
                    productos: JSON.stringify(productos),
                    total: total
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Compra finalizada con éxito. Recibirás un correo de confirmación.");
                    
                    // Limpiar carrito y almacenamiento local
                    localStorage.removeItem("costoEnvio");
                    localStorage.removeItem("totalCompra");

                    // Redirigir a página de confirmación
                    window.location.href = "confirmacion.php";
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(error => console.error('Error al finalizar la compra:', error));
        }
     
    </script>
</body>

</html>
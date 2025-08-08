<?php
session_start();
$cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;

include('./componentes/conexion.php');

$cart = $_SESSION['cart'] ?? [];

// Eliminar productos con cantidad 0
$cart = array_filter($cart, function ($cantidad) {
    return $cantidad > 0;
});

// Actualizar la sesión con el carrito limpio
$_SESSION['cart'] = $cart;

$productosVacios = empty($cart); // Bandera para saber si mostrar el mensaje de carrito vacío



if (!$productosVacios) {
    $productIds = implode(',', array_keys($cart));
    $query = "SELECT * FROM productos WHERE id IN ($productIds)";
    $result = mysqli_query($conexion, $query);
}


?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon estándar -->
    <link rel="icon" type="image/png" sizes="512x512" href="images/favicon/favicon-512x512-transparent.png">

    <!-- Manifest para navegadores que lo usen -->
    <link rel="manifest" href="images/favicon/site-transparent.webmanifest">

    <title>Mi Carrito Kuday</title>
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

    <!-- CSS PROPIO-->
    <link rel="stylesheet" href="./CSS/styles.css">
</head>

<body id="carrito_body" class="d-flex flex-column min-vh-100">
    <header>
        <nav class="navbar navbar-expand-lg fixed-top cartuchera-nav">
            <div class="container-fluid" style="flex-wrap: wrap;">
                <a class="navbar-brand marca align-self-center text-center" href="index.php#inicio">Kuday Artesanias</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarScroll">
                    <ul class="navbar-nav ms-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 700px; margin-right:50px;">
                        <li class="nav-item">
                            <a class="nav-link active boton-nav" href="carrito.php#carrito_body">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active boton-nav" aria-current="page" href="index.php#titulo_tienda">Tienda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active boton-nav" href="index.php#productos-relevantes">Promociones</a>
                        </li>
                        <li class="nav-item dropdown" style="align-items: flex-start;">
                            <a class="nav-link dropdown-toggle active boton-nav" href="tienda.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Productos
                            </a>
                            <ul class="dropdown-menu mx-2">
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
                            <a class="nav-link active boton-nav" href="contacto.php">Contactános</a>
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

    <main class="flex-grow-1">
        <section class="container-fluid carrito-acc" style="margin-top: 150px;">
            <h3 class="text-center titulo-carrito">Mi Carrito</h3>
            <div class="accordion" id="cartAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingCart">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCart" aria-expanded="true" aria-controls="collapseCart">
                            <i class="fa-solid fa-basket-shopping"></i>&nbsp;&nbsp;&nbsp;Mis Productos
                        </button>
                    </h2>
                    <div id="collapseCart" class="accordion-collapse collapse show" aria-labelledby="headingCart" data-bs-parent="#cartAccordion">
                        <div class="accordion-body">
                            <div class="table-responsive" id="carrito-table-mq">
                                <table class="table table-striped table-bordered text-center align-middle">
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
                                        if (!empty($cart)) { ?>
                                            <?php
                                            while ($product = mysqli_fetch_assoc($result)) {
                                                $id = $product['id'];
                                                $cantidad = $cart[$id];
                                                $stock = $product['stock']; // Asumiendo que tienes una columna 'stock' en la DB
                                                $subtotal = $product['precio'] * $cantidad;
                                                $total += $subtotal;
                                            ?>
                                                <tr data-id="<?php echo $id; ?>" data-stock="<?php echo $stock; ?>">
                                                    <td class="fw-normal" data-label="Producto"><?php echo $product['nombre']; ?></td>
                                                    <td class="precio" data-label="Precio">$<?php echo $product['precio']; ?></td>
                                                    <td class="botonera-update" data-label="Cantidad">
                                                        <div class="d-flex justify-content-center align-items-center celda-cantidad">
                                                            <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(<?php echo $id; ?>, -1)">−</button>
                                                            <input type="number" class="form-control mx-2 cantidad" data-id="<?php echo $id; ?>" data-stock="<?php echo $product['stock']; ?>" style="width: 60px; text-align: center;" value="<?php echo $cantidad; ?>" min="1">
                                                            <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(<?php echo $id; ?>, 1)">+</button>
                                                        </div>
                                                    </td>
                                                    <td class="botonera-eliminar" data-label="Eliminar">
                                                        <button class="btn btn-danger btn-sm" onclick="removeItem(<?php echo $id; ?>)"><i class="bi bi-trash"></i></button>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <tr>
                                                <td colspan="4">
                                                    <div class="alert alert-info mb-0">
                                                        No hay productos en el carrito. Podés volver a la <a href="index.php#titulo_tienda" class="alert-link">tienda</a> para agregar alguno.
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <tr id="costoEnvioRow" style="display: none;" class="costo-envio-row">
                                            <td colspan="3" data-label="Costo de Envío" class="costo-envio-label"><strong>Costo de Envío</strong></td>
                                            <td data-label="Costo de Envío" class="costo-envio-valor"><strong id="costoEnvio">$0.00</strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><strong>Total</strong></td>
                                            <td><strong id="total">$<?php echo $total; ?></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <?php if (!$productosVacios) : ?>
                                <div class="d-flex justify-content-center gap-2 mt-3 flex-wrap" id="botonesCompra">
                                    <button id="continuarCompraBtn" class="btn btn-primary" onclick="continuarCompra()">Continuar con la Compra</button>
                                    <button id="finalizarCompraBtn" class="btn btn-success" style="display: none;" onclick="finalizarCompra()">Pagar</button>
                                    <button id="reiniciarBtn" class="btn btn-danger" style="display: none;" onclick="reiniciarCarrito()">Reiniciar Carrito</button>
                                </div>
                            <?php endif; ?>



                        </div>
                    </div>
                </div>

                <div class="accordion-item" id="envioAccordion" style="display: none;">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><i class="fa-solid fa-truck-fast"></i>&nbsp;&nbsp;&nbsp;Datos de Envio
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <form class="p-4 border rounded shadow-sm bg-light" id="formEnvio">
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
                                            <input type="tel" class="form-control form-control-sm" id="telefono" placeholder="2976-423488" required autocomplete="off" pattern="^[\d\s\+\-\(\)]{10,18}$" title="Debe ser un número de teléfono válido (con o sin espacios, guiones, paréntesis). Ej: 3516884521">
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
                                                <option value="" selected>Seleccione...</option>
                                                <option value="Buenos Aires">Buenos Aires</option>
                                                <option value="Cordoba">Córdoba</option>
                                                <option value="Santa Cruz">Santa Cruz</option>
                                                <option value="Catamarca">Catamarca</option>
                                                <option value="Chaco">Chaco</option>
                                                <option value="Chubut">Chubut</option>
                                                <option value="Corrientes">Corrientes</option>
                                                <option value="Entre Rios">Entre Rios</option>
                                                <option value="Formosa">Formosa</option>
                                                <option value="Jujuy">Jujuy</option>
                                                <option value="La Pampa">La Pampa</option>
                                                <option value="La Rioja">La Rioja</option>
                                                <option value="Mendoza">Mendoza</option>
                                                <option value="Misiones">Misiones</option>
                                                <option value="Neuquen">Neuquén</option>
                                                <option value="Rio Negro">Rio Negro</option>
                                                <option value="Salta">Salta</option>
                                                <option value="San Juan">San Juan</option>
                                                <option value="San Luis">San Luis</option>
                                                <option value="Santa Fe">Santa Fe</option>
                                                <option value="Santiago Del Estero">Santiago Del Estero</option>
                                                <option value="Tierra Del Fuego">Tierra Del Fuego</option>
                                                <option value="Tucuman">Tucumán</option>
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
                                        <button type="submit" class="btn btn-primary px-4">Confirmar Datos de Envío</button>
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
    </main>

    <footer class="footer mt-5">
        <div class="container text-center">
            <p>&copy; 2021 Kuday Artesanias. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Overlay de carga oculto inicialmente -->
    <div id="overlay-carga" style="display:none;">
        <div class="spinner"></div>
        <p>Procesando tu compra, por favor espera...</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Función para actualizar la cantidad de productos en el carrito
        function updateQuantity(id, change) {
            let input = document.querySelector(`.cantidad[data-id='${id}']`);
            let maxStock = parseInt(input.dataset.stock);
            let value = parseInt(input.value) + change;

            // Se evita que el valor sea negativo o mayor al stock disponible
            value = Math.max(0, Math.min(value, maxStock));

            if (value <= maxStock) {
                input.value = value;
                updateTotal();
                updateCartCount();
                updateCartSession(id, value);

                if (value === maxStock) {
                    alert("Has alcanzado el stock máximo disponible para este producto.");
                }
            }
        }

        // Función para eliminar un producto del carrito
        function removeItem(id) {
            let row = document.querySelector(`tr[data-id='${id}']`);
            if (row) row.remove(); // Remover visualmente la fila

            // Obtener carrito actualizado y eliminar el producto
            let cart = JSON.parse(localStorage.getItem("carrito")) || [];
            cart = cart.filter(item => item.id != id);
            localStorage.setItem("carrito", JSON.stringify(cart)); // Guardar en localStorage

            // Enviar la actualización al servidor para que elimine el producto de la sesión
            fetch('actualizar_carrito.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${encodeURIComponent(id)}&cantidad=0`
                }).then(response => response.json())
                .then(data => {
                    document.getElementById('cart-count').textContent = data.cartCount;
                })
                .catch(error => console.error('Error al actualizar el carrito en el servidor:', error));

            updateTotal();
            updateCartCount();

            // Busca que cantidad queda en el carrito y si es 0 lo reinicia
            const totalItems = Array.from(document.querySelectorAll('.cantidad'))
                .reduce((s, el) => s + parseInt(el.value), 0);

            if (totalItems === 0) {
                // vacía storage + sesión y recarga
                reiniciarCarrito(); // ← ya existe, la reutilizamos
                return; // detiene cualquier resto de lógica
            }
        }

        // Función para actualizar el total del carrito
        function updateTotal() {
            const totalElem = document.getElementById('total');
            const total = Array.from(document.querySelectorAll('.cantidad'))
                .reduce((sum, el) => {
                    const id = el.dataset.id;
                    const price = parseFloat(
                        document.querySelector(`tr[data-id='${id}'] .precio`)
                        .textContent.replace('$', '')
                    );
                    return sum + price * parseInt(el.value);
                }, 0);

            totalElem.textContent = `$${total.toFixed(2)}`;

            // Actualizar el valor total en el localStorage
            localStorage.setItem("totalCompra", total);

            /* ---- NUEVO: si el usuario está en paso 2/3, volvemos a paso 1 ---- */
            const continuarBtn = document.getElementById("continuarCompraBtn");
            const finalizarBtn = document.getElementById("finalizarCompraBtn");
            const reiniciarBtn = document.getElementById("reiniciarBtn");

            if (continuarBtn) continuarBtn.style.display = (total > 0) ? "block" : "none";
            if (finalizarBtn) finalizarBtn.style.display = "none";
            if (reiniciarBtn) reiniciarBtn.style.display = "none";

            // reset de envío
            localStorage.setItem("costoEnvio", "0");
            document.getElementById("costoEnvio").textContent = "$0";
            document.getElementById("costoEnvioRow").style.display = "none";

            // re‑activar el botón del formulario por si estaba todavía visible
            document.querySelector("#formEnvio button[type='submit']").disabled = false;
        }

        // Función para actualizar el contador de productos en el carrito
        function updateCartCount() {
            const count = Array.from(document.querySelectorAll('.cantidad'))
                .reduce((sum, el) => sum + parseInt(el.value), 0);

            // actualiza burbuja del carrito
            document.getElementById('cart-count').textContent = count;
            localStorage.setItem("cartCount", count);

            // botones
            const continuarBtn = document.getElementById("continuarCompraBtn");
            const finalizarBtn = document.getElementById("finalizarCompraBtn");
            const reiniciarBtn = document.getElementById("reiniciarBtn");

            if (continuarBtn) continuarBtn.style.display = (count > 0) ? "block" : "none";

            /*  “Finalizar” y “Reiniciar” solo se muestran después de que el usuario
                confirma los datos de envío; si en algún momento el carrito queda vacío
                los ocultamos para evitar que el flujo continúe inconsistentes. */
            if (finalizarBtn) finalizarBtn.style.display = "none";
            if (reiniciarBtn) reiniciarBtn.style.display = "none";
        }

        // Función para actualizar la sesión del carrito
        function updateCartSession(id, cantidad) {
            // Se sanitiza el ID y la cantidad para evitar inyección de código
            let safeId = encodeURIComponent(id);
            let safeCantidad = encodeURIComponent(cantidad);

            fetch('actualizar_carrito.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${safeId}&cantidad=${safeCantidad}`
                })
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    document.getElementById('cart-count').textContent = data.cartCount;
                })
                .catch(error => console.error('Error al actualizar el carrito:', error));
        }

        // Función para continuar con la compra
        function continuarCompra() {

            let totalItems = Array.from(document.querySelectorAll('.cantidad')).reduce((sum, el) => sum + parseInt(el.value), 0);

            if (totalItems === 0) {
                alert("Tu carrito está vacío. Agrega al menos un producto antes de continuar.");
                return;
            }
            // Si hay mas de 0 Items, entonces Habilita el segundo accordion
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

            alert("Carrito actualizado. Puedes proceder con la compra.");

            //  Reiniciar el costo de envío a 0
            let costoEnvioActual = parseFloat(localStorage.getItem("costoEnvio") || "0");
            let totalActual = parseFloat(document.getElementById("total").textContent.replace("$", "").trim());

            // Restar el costo de envío anterior del total y ponerlo en cero en caso de actualizar 
            let nuevoTotal = Math.max(totalActual - costoEnvioActual, 0);

            // Actualizar la interfaz y limpiar el localStorage
            document.getElementById("costoEnvio").textContent = "$0";
            document.getElementById("costoEnvioRow").style.display = "none";
            document.getElementById("total").textContent = `$${nuevoTotal.toFixed(2)}`;

            // Limpiar costo de envío y total en localStorage
            localStorage.setItem("costoEnvio", "0");
            localStorage.setItem("totalCompra", nuevoTotal);

            // Mostrar y abrir el accordion de envío
            document.getElementById("envioAccordion").style.display = "block";

            // Habilitamos el boton Confirmar Datos de Envio
            document.querySelector("#formEnvio button[type='submit']").disabled = false;

            let envioCollapse = new bootstrap.Collapse(document.getElementById('collapseTwo'), {
                toggle: true
            });

            setTimeout(() => {
                const element = document.getElementById('collapseTwo');
                const offsetTop = element.getBoundingClientRect().top + window.pageYOffset;
                window.scrollTo({
                    top: offsetTop - 150, // aquí le restas 50px para que suba un poco más
                    behavior: 'smooth'
                });
            }, 200);

        }

        // Validación del formulario de envío 
        document.getElementById("formEnvio").addEventListener("submit", function(event) {
            const provincia = document.getElementById("provincia");


            // Verifica si la provincia ha sido seleccionada correctamente
            if (!provincia.value) {
                provincia.setCustomValidity("Por favor, selecciona una provincia.");
                provincia.reportValidity();
                event.preventDefault(); // Detiene el envío
                return;
            } else {
                provincia.setCustomValidity(""); // Se limpia el mensaje de error dinámicamente
            }

            // Validación general del formulario
            if (!this.checkValidity()) {
                event.preventDefault();
                this.reportValidity(); // Muestra los errores en pantalla
                return;
            }

            // Si todo es válido, ejecutamos confirmarDatosEnvio después de un pequeño retraso
            event.preventDefault();
            setTimeout(confirmarDatosEnvio, 100);
        });

        // Evento para limpiar errores de provincia
        document.getElementById("provincia").addEventListener("change", function() {
            this.setCustomValidity("");
        });


        // Función para confirmar los datos de envío
        function confirmarDatosEnvio() {
            let provincia = document.getElementById("provincia").value;

            fetch('./componentes/calcular_envio.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `provincia=${encodeURIComponent(provincia)}`
                })
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    let costoEnvio = parseFloat(data.costoEnvio);

                    // Calcular subtotal real sin costo de envío
                    let subtotal = Array.from(document.querySelectorAll('.cantidad')).reduce((sum, el) => {
                        let id = el.dataset.id;
                        let price = parseFloat(document.querySelector(`tr[data-id='${id}'] .precio`).textContent.replace('$', ''));
                        return sum + (price * parseInt(el.value));
                    }, 0);

                    // Evitar aplicar el costo de envío varias veces
                    let totalActual = parseFloat(document.getElementById("total").textContent.replace("$", ""));
                    let costoAnterior = parseFloat(localStorage.getItem("costoEnvio") || "0");

                    // Si ya se había aplicado un costo de envío antes, lo eliminamos
                    let subtotalReal = totalActual - costoAnterior;
                    let nuevoTotal = subtotalReal + costoEnvio;


                    // Actualizar UI
                    document.getElementById("costoEnvio").textContent = `$${costoEnvio.toFixed(2)}`;
                    const rowEnvio = document.getElementById("costoEnvioRow");
                    rowEnvio.style.display = "table-row";
                    document.getElementById("total").textContent = `$${nuevoTotal.toFixed(2)}`;

                    // Guardar en localStorage
                    localStorage.setItem("costoEnvio", costoEnvio.toFixed(2));
                    localStorage.setItem("totalCompra", nuevoTotal.toFixed(2));
                    localStorage.setItem("subtotalCompra", subtotalReal.toFixed(2));


                    // Ocultar botón Continuar, mostrar Finalizar y Reiniciar
                    document.getElementById("continuarCompraBtn").style.display = "none";
                    document.getElementById("finalizarCompraBtn").style.display = "inline-block";
                    document.getElementById("reiniciarBtn").style.display = "inline-block";

                    // deshabilitamos el botón para evitar un segundo envío con datos obsoletos
                    document.querySelector("#formEnvio button[type='submit']").disabled = true;

                    // Cerrar accordion de envío
                    let envioCollapse = new bootstrap.Collapse(document.getElementById('collapseTwo'), {
                        toggle: false
                    });
                    envioCollapse.hide();

                    // Enfocar en el primer accordion (productos)
                    setTimeout(() => {
                        document.getElementById('collapseCart').scrollIntoView({
                            behavior: 'smooth'
                        });
                    }, 400);

                })
                .catch(error => console.error('Error al calcular el costo de envío:', error));
        }

        // Restaurar valores guardados en localStorage 
        // al cargar la página f5 y al abrir carrito por primera vez
        document.addEventListener("DOMContentLoaded", function() {
            let cart = JSON.parse(localStorage.getItem("carrito")) || [];

            if (cart.length > 0) {
                cart.forEach(item => {
                    let row = document.createElement("tr");
                    row.setAttribute("data-id", item.id);
                    row.innerHTML = `
                        <td>${item.name}</td>
                        <td class="precio">$${item.precio.toFixed(2)}</td>
                        <td>
                            <button onclick="updateQuantity(${item.id}, -1)">-</button>
                            <input type="number" class="cantidad" data-id="${item.id}" data-stock="${item.stock}" value="${item.cantidad}" readonly>
                            <button onclick="updateQuantity(${item.id}, 1)">+</button>
                        </td>
                        <td>$${(item.precio * item.cantidad).toFixed(2)}</td>
                        <td><button onclick="removeItem(${item.id})">🗑</button></td>
                    `;
                    document.getElementById("cart-body").appendChild(row);
                });
            }

            // Actualizamos el subtotal
            updateTotal();

            // Recuperamos costo de envío
            let costoGuardado = parseFloat(localStorage.getItem("costoEnvio") || "0");
            let subtotal = Array.from(document.querySelectorAll('.cantidad')).reduce((sum, el) => {
                let id = el.dataset.id;
                let price = parseFloat(document.querySelector(`tr[data-id='${id}'] .precio`).textContent.replace('$', ''));
                return sum + (price * parseInt(el.value));
            }, 0);


            if (costoGuardado > 0) {
                document.getElementById("costoEnvio").textContent = `$${costoGuardado.toFixed(2)}`;
                document.getElementById("costoEnvioRow").style.display = "table-row";
            } else {
                document.getElementById("costoEnvio").textContent = "$0";
                document.getElementById("costoEnvioRow").style.display = "none";
            }

            // Mostrar total real: subtotal + envío
            let nuevoTotal = subtotal + costoGuardado;
            document.getElementById("total").textContent = `$${nuevoTotal.toFixed(2)}`;

            const continuarBtn = document.getElementById("continuarCompraBtn");
            let totalItems = Array.from(document.querySelectorAll('.cantidad')).reduce((sum, el) => sum + parseInt(el.value), 0);
            if (continuarBtn) {
                continuarBtn.style.display = (totalItems > 0) ? "block" : "none";
            }

        });



        function finalizarCompra() {
            // Mostrar overlay de "procesando" (asegurate tener un elemento overlay con id="overlay")
            const overlay = document.getElementById('overlay');
            if (overlay) overlay.classList.add('visible');

            try {
                let nombre = document.getElementById("nombre").value.trim();
                let apellido = document.getElementById("apellido").value.trim();
                let telefono = document.getElementById("telefono").value.trim();
                let email = document.getElementById("correo").value.trim();
                let direccion = document.getElementById("direccion").value.trim();
                let ciudad = document.getElementById("ciudad").value.trim();
                let provincia = document.getElementById("provincia").value.trim();
                let codigopostal = document.getElementById("codigoPostal").value.trim();

                // recalcular subtotal
                let subtotal = Array.from(document.querySelectorAll('.cantidad')).reduce((sum, el) => {
                    let id = el.dataset.id;
                    let priceEl = document.querySelector(`tr[data-id='${id}'] .precio`);
                    let price = 0;
                    if (priceEl) price = parseFloat(priceEl.textContent.replace('$', '').replace(',', '.')) || 0;
                    return sum + (price * parseInt(el.value || 0));
                }, 0);

                let costoEnvioStr = localStorage.getItem("costoEnvio");
                let costoEnvio = (costoEnvioStr && !isNaN(costoEnvioStr)) ? parseFloat(costoEnvioStr) : 0;

                let total = subtotal + costoEnvio;
                const totalEl = document.getElementById("total");
                if (totalEl) totalEl.textContent = `$${total.toFixed(2)}`;

                localStorage.setItem("totalCompra", total.toFixed(2));
                localStorage.setItem("subtotalCompra", subtotal.toFixed(2));

                // productos
                let productos = [];
                document.querySelectorAll("#cart-body tr[data-id]").forEach(row => {
                    let id = row.dataset.id;
                    let name = row.cells[0] ? row.cells[0].textContent.trim() : '';
                    let price = row.querySelector('.precio') ? parseFloat(row.querySelector('.precio').textContent.replace('$', '').replace(',', '.')) : 0;
                    let cantidad = row.querySelector('.cantidad') ? parseInt(row.querySelector('.cantidad').value || 0) : 0;
                    if (cantidad > 0) {
                        productos.push({ id, name, cantidad, price });
                    }
                });

                if (productos.length === 0) {
                    if (overlay) overlay.classList.remove('visible');
                    alert('El carrito está vacío.');
                    return;
                }

                const payload = {
                    nombre, apellido, telefono, email, direccion, provincia, ciudad, codigopostal,
                    productos, total, costoEnvio
                };

                fetch('./componentes/procesar_compra.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                })
                .then(res => {
                    if (!res.ok) throw new Error(`HTTP error ${res.status}`);
                    return res.json();
                })
                .then(data => {
                    if (data.success && data.init_point) {
                        // redirigir al checkout (Mercado Pago)
                        window.location.href = data.init_point;
                    } else {
                        throw new Error(data.message || 'No se generó init_point.');
                    }
                })
                .catch(err => {
                    console.error('Error en compra:', err);
                    alert('Hubo un problema al procesar la compra. ' + (err.message || 'Intentá nuevamente.'));
                    if (overlay) overlay.classList.remove('visible');
                });

            } catch (err) {
                console.error('Error al preparar la compra:', err);
                alert('Error interno al procesar la compra.');
                if (overlay) overlay.classList.remove('visible');
            }
        }



        // Funcion para reiniciar el carrito en el ultimo paso
        function reiniciarCarrito() {
            localStorage.removeItem("carrito");
            localStorage.removeItem("costoEnvio");
            localStorage.removeItem("totalCompra");
            localStorage.removeItem("subtotalCompra");
            localStorage.removeItem("cartCount");

            fetch('./componentes/vaciar_carrito.php', {
                method: 'POST'
            }).then(() => {
                window.location.href = "carrito.php";
            }).catch(error => {
                console.error("Error al reiniciar el carrito:", error);
                alert("No se pudo reiniciar el carrito. Intenta nuevamente.");
            });
        }

        // Script para overlay de carga al finalizar la compra
        document.addEventListener('DOMContentLoaded', function() {
            const finalizarBtn = document.getElementById('finalizarCompraBtn'); // ID de tu botón de finalizar compra
            finalizarBtn.addEventListener('click', function() {
                // Mostrar overlay
                document.getElementById('overlay-carga').style.display = 'flex';

                // Deshabilitar todo
                document.body.style.pointerEvents = 'none';

                // Permitir eventos solo en overlay (opcional)
                document.getElementById('overlay-carga').style.pointerEvents = 'auto';

                // Importante: dejar que el submit/trámite del formulario siga
            });
        });
    </script>
</body>

</html>
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
$cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;

include('./componentes/conexion.php');

$cart = $_SESSION['cart'] ?? [];

// Eliminar productos con cantidad 0
$cart = array_filter($cart, function($cantidad) {
    return $cantidad > 0;
});

// Actualizar la sesión con el carrito limpio
$_SESSION['cart'] = $cart;

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

    <!-- ICONOS DE FONTAWESOME -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" rel="stylesheet">

    <!-- CSS DE BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- CSS PROPIO-->
    <link rel="stylesheet" href="./CSS/styles.css">
</head>

<body>
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
                            <a class="nav-link active boton-nav" href="index.php#inicio">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active boton-nav" aria-current="page" href="index.php#titulo_tienda">Tienda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active boton-nav" href="index.php#titulo_promociones">Promociones</a>
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
                        <i class="fa-solid fa-basket-shopping"></i>&nbsp;&nbsp;&nbsp;Mis Productos
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

    <footer class="footer mt-5">
        <div class="container text-center">
            <p>&copy; 2021 Kuday Artesanias. Todos los derechos reservados.</p>
        </div>
    </footer>

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
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${encodeURIComponent(id)}&cantidad=0`
            }).then(response => response.json())
            .then(data => {
                document.getElementById('cart-count').textContent = data.cartCount;
            })
            .catch(error => console.error('Error al actualizar el carrito en el servidor:', error));

            updateTotal();
            updateCartCount();
        }

        // Función para actualizar el total del carrito
        function updateTotal() {
            let totalElem = document.getElementById('total');
            let total = Array.from(document.querySelectorAll('.cantidad')).reduce((sum, el) => {
                let id = el.dataset.id;
                let price = parseFloat(document.querySelector(`tr[data-id='${id}'] .precio`).textContent.replace('$', ''));
                return sum + (price * parseInt(el.value));
            }, 0);
            
            totalElem.textContent = `$${total.toFixed(2)}`;
        
            // Actualizar el valor total en el localStorage
            localStorage.setItem("totalCompra", total);
        }

        // Función para actualizar el contador de productos en el carrito
        function updateCartCount() {
            let count = Array.from(document.querySelectorAll('.cantidad')).reduce((sum, el) => sum + parseInt(el.value), 0);
            document.getElementById('cart-count').textContent = count;

            // Actualizar el contador en localStorage
            localStorage.setItem("cartCount", count);
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
                    
                    // Obtener el total actual del primer accordion
                    let totalActual = parseFloat(document.getElementById("total").textContent.replace("$", "").trim());
                    let nuevoTotal = totalActual + costoEnvio;

                    // Mostrar el costo de envío en el segundo accordion
                    document.getElementById("costoEnvio").textContent = `$${costoEnvio}`;
                    document.getElementById("costoEnvioRow").style.display = "table-row";

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

        // Restaurar valores guardados en localStorage 
        // al cargar la página f5 y al abrir carrito por primera vez
        document.addEventListener("DOMContentLoaded", function() {
            // Recuperar productos y datos desde localStorage o sesión
            let cart = JSON.parse(localStorage.getItem("carrito")) || [];
            
            // Si hay productos, actualiza el carrito visualmente
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

            // Luego, actualizamos el total
            updateTotal();
            
            // Verificar si hay un costo de envío guardado y mostrarlo si es necesario
            let costoGuardado = localStorage.getItem("costoEnvio");
            let totalGuardado = localStorage.getItem("totalCompra");

            if (costoGuardado && totalGuardado) {
                document.getElementById("costoEnvio").textContent = `$${costoGuardado}`;
                document.getElementById("costoEnvioRow").style.display = "table-row";
                document.getElementById("total").textContent = `$${parseFloat(totalGuardado).toFixed(2)}`;
            } else {
                // Si no hay costo de envío guardado, reiniciamos a cero
                document.getElementById("costoEnvio").textContent = "$0";
                document.getElementById("costoEnvioRow").style.display = "none";
            }
        });


        function finalizarCompra() {
            let nombre = document.getElementById("nombre").value.trim();
            let apellido = document.getElementById("apellido").value.trim(); // Nuevo campo
            let telefono = document.getElementById("telefono").value.trim(); // Nuevo campo
            let email = document.getElementById("correo").value.trim();
            let direccion = document.getElementById("direccion").value.trim();
            let ciudad = document.getElementById("ciudad").value.trim(); // Nuevo campo
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
                productos.push({
                    id,
                    name,
                    cantidad,
                    price
                });
            });

            // Se sanitizan los datos antes de enviarlos al servidor
            let params = new URLSearchParams({
                nombre: nombre, // No se codifica
                apellido: apellido, // No se codifica
                telefono: telefono, // No se codifica
                email: email, // No se codifica
                direccion: direccion, // No se codifica
                provincia: provincia, // No se codifica
                ciudad: ciudad, // No se codifica
                codigopostal: codigopostal, // No se codifica
                productos: JSON.stringify(productos),
                total: total
            });

            fetch('./componentes/procesar_compra.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: params
                })
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert("Compra finalizada con éxito. Recibirás un correo con el comprobante en PDF.");

                        // Verificación de URL antes de descargar el PDF (seguridad)
                        if (data.pdfUrl) {
                            const downloadLink = document.createElement("a");
                            downloadLink.href = data.pdfUrl;
                            downloadLink.download = "factura.pdf";
                            document.body.appendChild(downloadLink);
                            downloadLink.click();
                            document.body.removeChild(downloadLink);
                        } else {
                            alert("Error: URL del comprobante no válida.");
                        }

                        // Limpiar localStorage y redirigir
                        localStorage.removeItem("costoEnvio");
                        localStorage.removeItem("totalCompra");
                        window.location.href = "confirmacion.php";
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(error => {
                    console.error("Error en la respuesta del servidor:", error);
                    alert("Hubo un problema al procesar la compra.");
                });
        }

    </script>
</body>

</html>
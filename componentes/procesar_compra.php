    <?php

    require_once 'conexion.php';
    require_once __DIR__ . '/../vendor/autoload.php';

    use MercadoPago\SDK;
    use MercadoPago\Preference;
    use MercadoPago\Item;



    SDK::setAccessToken($_ENV['MP_ACCESS_TOKEN']); // Usa tus credenciales reales

    $preference = new Preference();

    // Armar los productos para Mercado Pago
    $items = [];
    foreach ($productos_array as $producto) {
        $item = new Item();
        $item->id = $producto['id'];
        $item->title = $producto['name'];
        $item->quantity = $producto['cantidad'];
        $item->unit_price = $producto['price'];
        $items[] = $item;
    }
    $preference->items = $items;

    // Agregar información del comprador
    $preference->payer = array(
        "name" => $nombre,
        "surname" => $apellido,
        "email" => $email,
    );

    // Redirecciones
    $preference->back_urls = array(
        "success" => "https://kudayartesanias.com.ar/compra_exitosa.php",
        "failure" => "https://kudayartesanias.com.ar/compra_fallida.php",
        "pending" => "https://kudayartesanias.com.ar/compra_pendiente.php"
    );
    $preference->auto_return = "approved";

    // URL a la que Mercado Pago notificará el pago
    $preference->notification_url = "https://kudayartesanias.com.ar/webhook.php";

    // Guardar ID de preferencia (si querés vincular con la compra)
    $preference->external_reference = $email; // o el ID de la compra

    $preference->save();

    // Responder al frontend con la URL de pago
    $response = [
        'success' => true,
        'init_point' => $preference->init_point
    ];
    echo json_encode($response);
    exit;
    ?>
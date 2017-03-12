# ESTADOS DE PEDIDOS Y PROCESO DE COMPRA


Cuando un usuario registrado completa el trámite del pedido y pincha en el botón COMPRAR AHORA, el sistema guarda un registro del pedido que inmediatamente queda reflejado en el panel de gestión, independientemente del método de pago escogido.

* Método de pago Reembolso:
    * El estado de ese nuevo pedido es NUEVO PEDIDO - REEMBOLSO -> fondo de color amarillo en panel gestión - Pedidos
    * El sistema crea automáticamente un PDF con la factura y envía un correo al usuario y gestión con la plantilla de email de Pedido Recibido con el pdf de la factura adjunta.
    * Cuando se entrega el pedido a la empresa de transporte, desde el panel de gestión hay que cambiar el estado del pedido a Pedido Enviado y automáticamente se envía un email al usuario con la plantilla del email de Pedido Enviado.
    * La empresa de transporte entrega el pedido, se tiene que cambiar el estado del pedido a Pedido Entregado y así enviamos un email al usuario con la plantilla de Pedido Entregado.
* Método de pago PayPal:
    * El estado de ese nuevo pedido es NUEVO PEDIDO - PAYPAL - fondo de color amarillo en panel gestión - Pedidos
    * El sistema redirige al entorno de PayPal para que el usuario realice la compra.
    * Cuando el usuario finaliza o cancela la compra, Paypal redirige a la tienda devolviendo el resultado de la transacción o cancelación.
    * La plataforma actualiza el registro del pedido del cliente con el resultado devuelto por PayPal.
    * En caso de compra finalizada con éxito en PayPal, el estado del pedido será Pedido Recibido y automáticamente se crea el PDF de la factura y se le envía un correo a usuario y gestión con los datos de la compra con la plantilla de correo Pedido Recibido.
    * Cuando se entrega el pedido a la empresa de transporte, desde el panel de gestión hay que cambiar el estado del pedido a Pedido Enviado y automáticamente se envía un email al usuario con la plantilla del email de Pedido Enviado.
    * La empresa de transporte entrega el pedido, se tiene que cambiar el estado del pedido a Pedido Entregado y así enviamos un email al usuario con la plantilla de Pedido Entregado.
    * En caso de compra cancelada por el usuario, (En la ventana de Paypal hay un enlace que pone algo parecido a "Volver a la tienda Dxbwatch"), PayPal redirige al usuario a la tienda y el sistema guarda el nuevo estado que sería Pedido Cancelado. En este caso la plataforma no informa ni al usuario ni a gestión a través de correo electrónico.
    * Puede ocurrir, y ESTE ES EL CASO, que el usuario no cancele, ni finalice, ni vuelva a la tienda, por lo que la plataforma no obtiene ninguna respuesta por parte de PayPal y el estado del pedido queda en Nuevo Pedido - PayPal. Estos son procesos de compras fallidas.
    * Para certificar todos los pasos del proceso de compra a través de PayPal, la plataforma cuenta con un sistema de registro de eventos de PayPal en los que guarda en un archivo todas las comunicaciones que la tienda hace con PayPal.
* Estados de los pedidos:
    * Nuevo Pedido - Reembolso: Compra realizada con el método de pago Contra reembolso
    * Nuevo Pedido - PayPal: Inicio de compra a través de PayPal. El sistema queda a la espera de una respuesta por parte de PayPal
    * Pedido Recibido. Recibimos respuesta de PayPal o TPV notificándonos el resultado de la compra.
    * Pedido Cancelado. El usuario ha cancelado el proceso de la compra antes de finalizarlo.
    * Pedido Enviado. El pedido se ha empaquetado y entreagdo a la empresa de mensajería / transporte
    * Pedido Entregado. La empresa de transporte entrega el pedido al cliente final. 
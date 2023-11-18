// mercadoPago.js
const mp = new MercadoPago('TEST-37621760-87a1-41e5-86c6-0956594e0489', {
    locale: 'es-AR'
});

mp.checkout({
    preference: {
        id: '<?php echo $preference->id; ?> '
    },
    render: {
        container: '.checkout-btn',
        label: 'Pagar con MP'
    }
});
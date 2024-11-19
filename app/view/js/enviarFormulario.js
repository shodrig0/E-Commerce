async function manejarFormSubmit(selectorForm, urlAction, redireccionUrl, operacion) {
    $(document).ready(function() {
        $(selectorForm).on('submit', async function(e) {
            e.preventDefault();

            const formData = $(this).serializeArray();
            formData.push({ name: 'operacion', value: operacion });

            $.ajax({
                url: urlAction,
                type: 'POST',
                data: formData,
                success: function(response) {
                    const res = JSON.parse(response);
                    $('#contModal').html(`<p>${res.message}</p>`);
                    $('#modalResponse').modal('show');

                    if (res.success && redireccionUrl) {
                        setTimeout(function() {
                            window.location.href = redireccionUrl;
                        }, 4000);
                    }
                },
                error: function() {
                    $('#contModal').html('<p>Ha ocurrido un error. Por favor, intenta nuevamente.</p>');
                    $('#modalResponse').modal('show');
                }
            });
        });
    });
}

async function hashPassword(password, salteo) {
    const encoder = new TextEncoder();
    const salt = encoder.encode(salteo);
    const passSalted = new Uint8Array([...salt, ...encoder.encode(password)]);

    const hashear = await crypto.subtle.digest("SHA-256", passSalted);
    const hashedArray = Array.from(new Uint8Array(hashear));
    
    return hashedArray.map(b => b.toString(16).padStart(2, "0")).join("");
}

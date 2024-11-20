async function manejarFormSubmit(selectorForm, urlAction, redireccionUrl) {
    $(document).ready(function () {
        $(selectorForm).on('submit', async function (e) {
            e.preventDefault();

            const usnombre = $("input[name='usnombre']").val();

            const passwordInput = $("input[name='uspass']");
            let password = '';

            // Si existe el campo de contraseña, obtener su valor
            if (passwordInput.length > 0) {
                password = passwordInput.val();

                if (!password) {
                    alert("La contraseña no puede estar vacía");
                    return;
                }

                const hashedPassword = await hashPassword(password, usnombre);
                passwordInput.val(hashedPassword);
            }

            $.ajax({
                url: urlAction,
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    $('#contModal').html(response);
                    $('#modalResponse').modal('show');

                    // Redirigir después de 4 segundos si se proporciona una URL
                    if (redireccionUrl) {
                        setTimeout(function () {
                            window.location.href = redireccionUrl;
                        }, 4000);
                    }
                },
                error: function () {
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
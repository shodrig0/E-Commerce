async function formSubmit() {
    const passwordInput = document.getElementById("uspass")
    const usnombre = document.getElementById("usnombre").value
    const password = passwordInput.value;

    if (!password) {
        alert("La contraseña no puede estar vacía")
    }

    const hashedPassword = await hashPassword(password, usnombre)
    passwordInput.value = hashedPassword
    document.getElementById("formulario").submit()
}

async function hashPassword(password, salteo) {
    const encoder = new TextEncoder()
    const salt = encoder.encode(salteo) // usar username para aplicar mas seguridad
    const passSalted = new Uint8Array([...salt, ...encoder.encode(password)])

    const hashear = await crypto.subtle.digest("SHA-256", passSalted)
    const hashedArray = Array.from(new Uint8Array(hashear))
    return hashedArray.map(b => b.toString(16).padStart(2, "0")).join("")
}

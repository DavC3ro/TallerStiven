document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("a[href*='eliminar']").forEach(button => {
        button.addEventListener("click", (event) => {
            if (!confirm("¿Estás seguro de que deseas eliminar este contacto?")) {
                event.preventDefault();
            }
        });
    });
});

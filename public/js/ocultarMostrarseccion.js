let profileContainers = document.querySelectorAll('.profile-section');

profileContainers.forEach(function (profileContainer) {
    const detalles = profileContainer.querySelector('.ocultar-mostrar');
    const icono = profileContainer.querySelector('.icono'); // Reemplaza '.icono' con el selector adecuado para tu icono

    profileContainer.addEventListener('click', function (event) {
        if (event.target === icono) {
            detalles.classList.toggle('visually-hidden');
            if (detalles.classList.contains('visually-hidden')) {
                icono.textContent = '↓'; // Texto cuando está oculto
            } else {
                icono.textContent = '↑'; // Texto cuando está visible
            }
        }
    });
});

// Obtén todos los elementos de nav-item que contienen un submenú
const navItems = document.querySelectorAll('.nav-item');

// Itera sobre cada uno de ellos
navItems.forEach(item => {
    item.addEventListener('click', function(event) {
        // Evitar que se propague el evento del clic
        event.stopPropagation();

        const dropdown = this.querySelector('.dropdown');
        
        // Si el submenú está visible, lo ocultamos, y viceversa
        if (dropdown.style.display === 'block') {
            dropdown.style.display = 'none';
        } else {
            // Primero cerramos todos los submenús
            document.querySelectorAll('.dropdown').forEach(drop => drop.style.display = 'none');
            dropdown.style.display = 'block';
        }
    });
});

// Cerrar el menú desplegable si se hace clic fuera de él
document.addEventListener('click', function(event) {
    if (!event.target.closest('.navbar')) {
        document.querySelectorAll('.dropdown').forEach(drop => drop.style.display = 'none');
    }
});


document.addEventListener("DOMContentLoaded", function() {
    const readMoreLinks = document.querySelectorAll('.read-more');

    readMoreLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const card = this.closest('.card');
            const description = card.querySelector('.card-description');
            description.style.display = 'block';
            this.style.display = 'none';
        });
    });
});
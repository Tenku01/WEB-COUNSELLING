const images = document.querySelectorAll('.clickable');

    // Menambahkan event listener untuk setiap gambar
    images.forEach((image) => {
        image.addEventListener('click', function () {
            // Menyembunyikan semua keterangan lainnya
            document.querySelectorAll('.description').forEach((desc) => {
                desc.style.display = 'none';
            });
        });
    });
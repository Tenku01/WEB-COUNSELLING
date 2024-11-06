function startCountdown() {
    const launchDate = new Date("2024-12-31T00:00:00");
    const timerElement = document.getElementById("timer");

    function updateTimer() {
        const now = new Date();
        const timeRemaining = launchDate - now;

        const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
        const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

        timerElement.innerHTML = `${days} Hari ${hours} Jam ${minutes} Menit ${seconds} Detik`;

        if (timeRemaining < 0) {
            clearInterval(interval);
            timerElement.innerHTML = "Acara sudah dimulai!";
            document.getElementById("specialOffers").style.display = 'block';
        }
    }

    const interval = setInterval(updateTimer, 1000);
    updateTimer();
}

function createCalendar() {
    const calendarElement = document.getElementById("eventCalendar");
    const events = [
        { date: "2024-06-15", title: "Webinar: Cara Mengelola Stres" },
        { date: "2024-07-10", title: "Konseling: Komunikasi Efektif" },
    ];

    calendarElement.innerHTML = events.map(event => `
        <div class="event">
            <h5>${event.title}</h5>
            <p>Tanggal: ${new Date(event.date).toLocaleDateString()}</p>
        </div>
    `).join("");
}

document.addEventListener("DOMContentLoaded", function() {
    startCountdown();
    createCalendar();
});

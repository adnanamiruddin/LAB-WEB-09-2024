document.addEventListener('DOMContentLoaded', () => {
    const progressBar = document.getElementById('progress');
    let width = 0;
    const duration = 6000;
    const interval = 100; // 0.1 detik
    const increment = 100 / (duration / interval);

    const progressInterval = setInterval(() => {
        width += increment;
        if (width >= 100) {
            width = 100;
            clearInterval(progressInterval);
            window.location.href = 'game.html';
        }
        progressBar.style.width = width + '%';
    }, interval);
});
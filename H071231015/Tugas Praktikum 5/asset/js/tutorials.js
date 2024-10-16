document.addEventListener('DOMContentLoaded', () => {
    const backBtn = document.getElementById('back-btn');
    const buttonSound = document.getElementById('button-sound');

    backBtn.addEventListener('click', () => {
        buttonSound.play();
        setTimeout(() => {
            window.location.href = "index.html"; // Ganti dengan nama halaman utama Anda
        }, 300);
    });

    const backMainBtn = document.querySelector('main button');
    backMainBtn.addEventListener('click', () => {
        buttonSound.play();
        setTimeout(() => {
            window.location.href = "index.html"; 
        }, 300);
    });

    
});
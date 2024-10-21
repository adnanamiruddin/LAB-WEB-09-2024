document.addEventListener('DOMContentLoaded', () => {
    const backBtn = document.getElementById('back-btn');
    const buttonSound = document.getElementById('button-sound');

    backBtn.addEventListener('click', () => {
        buttonSound.play();
        setTimeout(() => {
            window.location.href = "index.html"; 
        }, 300);
    });
});
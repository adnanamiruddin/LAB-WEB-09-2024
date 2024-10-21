document.addEventListener('DOMContentLoaded', () => {
    const startGameBtn = document.getElementById('start-game-btn');
    const playerNameInput = document.getElementById('player-name');

    startGameBtn.addEventListener('click', () => {
        const playerName = playerNameInput.value.trim();
        if (!playerName) {
            alert("Silakan masukkan nama Anda.");
            return;
        }

        localStorage.setItem('playerName', playerName);
        localStorage.setItem('playerRole', 'player');
        localStorage.setItem('gameMode', 'pvc'); 

        window.location.href = 'loading.html';
    });
});
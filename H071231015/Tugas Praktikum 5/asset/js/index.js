document.addEventListener('DOMContentLoaded', () => {
    const playBtn = document.querySelector("button:has(ion-icon[name='play-outline'])");
    const optionsBtn = document.querySelector("button:has(ion-icon[name='settings-outline'])");
    const tutorialsBtn = document.querySelector("button:has(ion-icon[name='help-circle-outline'])");
    const creditsBtn = document.querySelector("button:has(ion-icon[name='book-outline'])");

    const buttonSound = document.getElementById('button-sound');  // Single sound for all buttons

    // Play button click handler
    playBtn.addEventListener('click', () => {
        buttonSound.play();  // Play sound
        setTimeout(() => {
            window.location.href = "play.html";  // Redirect to game page
        }, 300);  // Delay for sound
    });

    // Options button click handler (open modal)
    optionsBtn.addEventListener('click', () => {
        buttonSound.play();  // Play sound
        document.getElementById('options-modal').classList.remove('hidden');
    });

    // Tutorials button click handler
    tutorialsBtn.addEventListener('click', () => {
        buttonSound.play();  // Play sound
        setTimeout(() => {
            window.location.href = "tutorials.html";  // Redirect to tutorials page
        }, 300);  // Delay for sound
    });

    // Credits button click handler
    creditsBtn.addEventListener('click', () => {
        buttonSound.play();  // Play sound
        setTimeout(() => {
            window.location.href = "credits.html";  // Redirect to credits page
        }, 300);  // Delay for sound
    });

    // Close modal button handler
    document.getElementById('close-modal').addEventListener('click', () => {
        buttonSound.play();  // Play sound
        document.getElementById('options-modal').classList.add('hidden');
    });
});
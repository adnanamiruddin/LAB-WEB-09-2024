let playerBet = 0;
let playerChips = 5000;
let totalDealer = 0;


document.addEventListener('DOMContentLoaded', () => {
    const chipContainer = document.getElementById('chip-container');
    const betArea = document.getElementById('bet-area');
    const clearBetBtn = document.createElement('button');
    clearBetBtn.textContent = 'Hapus Bet';
    clearBetBtn.className = 'bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition duration-300 mt-2';
    clearBetBtn.addEventListener('click', clearBet);
    document.getElementById('action-buttons').prepend(clearBetBtn);

    // Hapus event listener yang ada pada chip
    chipContainer.querySelectorAll('.chip').forEach(chip => {
        chip.removeEventListener('click', chipClickHandler);
    });

    // Tambahkan event listener baru
    chipContainer.querySelectorAll('.chip').forEach(chip => {
        chip.addEventListener('click', () => {
            const value = parseInt(chip.getAttribute('data-value'));
            placeBet(value);
        });
    });
});


// perhatikan amounttt
function placeBet(amount) {
    const betArea = document.getElementById('bet-area');

    if (playerChips >= amount) {
        const chip = document.createElement('img');
        chip.src = `asset/images/Chips/chip${getChipColor(amount)}White_border.png`;
        chip.className = 'chip absolute';
        chip.style.left = `${Math.random() * 150}px`;
        chip.style.top = `${Math.random() * 50}px`;
        chip.setAttribute('data-value', amount);

        betArea.appendChild(chip);

        playerBet += amount;
        playerChips -= amount;
        updateChipDisplay();

        chip.addEventListener('click', () => returnChip(chip));
    } else {
        alert('Chip Anda tidak cukup untuk taruhan ini.');
    }
}

// Fungsi lainnya tetap sama seperti sebelumnya
function getChipColor(value) {
    switch (value) {
        case 10: return 'Blue';
        case 25: return 'Green';
        case 50: return 'Red';
        case 100: return 'Black';
        default: return 'Blue';
    }
}


function returnChip(chipElement) {
    const chipValue = parseInt(chipElement.getAttribute('data-value'));
    playerBet -= chipValue;
    playerChips += chipValue;
    updateChipDisplay();
    chipElement.remove();
}

function clearBet() {
    const betArea = document.getElementById('bet-area');
    betArea.innerHTML = '';

    playerChips += playerBet;  // Mengembalikan chip yang ditaruhkan ke saldo pemain
    playerBet = 0;
    updateChipDisplay();
}

function updateChipDisplay() {
    const playerChipsElement = document.getElementById('player-chips');
    playerChipsElement.textContent = `Money: $${playerChips}`;
    const currentBetElement = document.getElementById('current-bet');
    currentBetElement.textContent = `Current Bet: $${playerBet}`;
}

document.addEventListener('DOMContentLoaded', () => {
    const dealerNameElement = document.getElementById('dealer-name');
    const dealerCards = document.getElementById('dealer-cards');
    const dealerTotal = document.getElementById('dealer-total');
    const playerNameElement = document.getElementById('player-name');
    const playerCards = document.getElementById('player-cards');
    const playerTotal = document.getElementById('player-total');
    const hitBtn = document.getElementById('hit-btn');
    const standBtn = document.getElementById('stand-btn');
    const blackScreen = document.getElementById('black-screen');
    const blackScreenMessage = document.getElementById('black-screen-message');
    const continueBtn = document.getElementById('continue-btn');
    const playerChipsElement = document.getElementById('player-chips');
    const betAmountInput = document.getElementById('bet-amount');
    const placeBetBtn = document.getElementById('place-bet-btn');

    let deck = [];
    let players = [];
    let currentPlayerIndex = 0;
    let gameMode = '';
    let playerChips = 5000;
    let currentBet = 0;

    const suits = ['Clubs', 'Hearts', 'Diamonds', 'Spades'];
    const values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
    const cardImagesPath = "asset/images/Cards/";

    function validateAndInitializeGameData() {
        gameMode = localStorage.getItem('gameMode');

        if (!gameMode) {
            alert('Anda belum memilih mode permainan. Silakan pilih mode permainan terlebih dahulu.');
            window.location.href = 'play.html';
            return;
        }

        if (gameMode === 'pvc') {
            if (!localStorage.getItem('playerName') || !localStorage.getItem('playerRole')) {
                alert('Data pemain tidak lengkap. Silakan pilih mode permainan kembali.');
                window.location.href = 'play.html';
                return;
            }
            initializePvC();
        } else {
            alert('Mode permainan tidak valid. Kembali ke setup.');
            window.location.href = 'play.html';
        }
    }

    function initializePvC() {
        const playerName = localStorage.getItem('playerName') || 'Player';
        const playerRole = localStorage.getItem('playerRole') || 'player';
        const comName = 'Computer';

        if (playerRole === 'dealer') {
            players = [
                { name: comName, isComputer: true, role: 'player' },
                { name: playerName, isComputer: false, role: 'dealer' }
            ];
        } else {
            players = [
                { name: playerName, isComputer: false, role: 'player' },
                { name: comName, isComputer: true, role: 'dealer' }
            ];
        }

        setupUI();
    }

    function setupUI() {
        const playerOne = players.find(p => p.role === 'player');
        const dealer = players.find(p => p.role === 'dealer');

        playerNameElement.textContent = playerOne.name;
        dealerNameElement.textContent = dealer.name;

        updateChipDisplay();
        toggleActionButtons(false);
    }

    // function createDeck() {
    //     deck = [];
    //     suits.forEach(suit => {
    //         values.forEach(value => {
    //             deck.push({ suit, value });
    //         });
    //     });
    //     shuffleDeck();
    // }
    function createDeck() {
        deck = [];
        const cardSet = new Set();
        suits.forEach(suit => {
            values.forEach(value => {
                const card = `${value} of ${suit}`;
                if (!cardSet.has(card)) {
                    deck.push({ suit, value });
                    cardSet.add(card);
                }
            });
        });
        shuffleDeck();
    }

    function shuffleDeck() {
        for (let i = deck.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [deck[i], deck[j]] = [deck[j], deck[i]];
            // deck = ["A of Spades", "2 of Hearts", ...]
            // deck[0] = { suit: 'Spades', value: 'A' }
        }
    }

    function dealCard() {
        if (deck.length === 0) {
            createDeck();
        }
        return deck.pop();
    }

    function calculateHandValue(hand) {
        let value = 0;
        let aceCount = 0;
        hand.forEach(card => {
            if (card.value === 'A') {
                aceCount++;
                value += 11;
            } else if (['K', 'Q', 'J'].includes(card.value)) {
                value += 10;
            } else {
                value += parseInt(card.value);
            }
        });
        while (value > 21 && aceCount > 0) {
            value -= 10;
            aceCount--;
        }
        return value;
    }

    function displayHand(hand, container, showAll = true) {
        container.innerHTML = '';
        hand.forEach((card, index) => {
            const cardElement = document.createElement('img');
            cardElement.className = 'card';
            if (!showAll && index === 0) {
                cardElement.src = `${cardImagesPath}cardBack_blue1.png`;
                cardElement.alt = 'Hidden card';
            } else {
                cardElement.src = `${cardImagesPath}card${card.suit}${card.value}.png`;
                cardElement.alt = `${card.value} of ${card.suit}`;
            }
            container.appendChild(cardElement);
        });
    }


    function updateTotal(hand, totalElement, showAll = true) {
        const total = calculateHandValue(hand);
        if (showAll) {
            totalElement.textContent = `Total: ${total}`;
        } else {
            totalElement.textContent = 'Total: ?';
        }
        if (totalElement.id === 'dealer-total') {
            totalDealer = total;
        }
    }

    function startGame() {
        createDeck();
        players.forEach(player => player.hand = []);

        players.forEach(player => {
            player.hand.push(dealCard());
            player.hand.push(dealCard());
        });

        const playerOne = players.find(p => p.role === 'player');
        const dealer = players.find(p => p.role === 'dealer');

        displayHand(playerOne.hand, playerCards);
        updateTotal(playerOne.hand, playerTotal);

        displayHand(dealer.hand, dealerCards, false);
        updateTotal(dealer.hand, dealerTotal, false);

        currentPlayerIndex = players.findIndex(p => p.role === 'player');
        updateActionButtons();

        if (playerOne.isComputer) {
            playComputerTurn();
        }
    }



    function hit() {
        const currentPlayer = players[currentPlayerIndex];
        currentPlayer.hand.push(dealCard());

        if (currentPlayer.role === 'player') {
            displayHand(currentPlayer.hand, playerCards);
            updateTotal(currentPlayer.hand, playerTotal);
        } else {
            displayHand(currentPlayer.hand, dealerCards, currentPlayer.role === 'player');
            updateTotal(currentPlayer.hand, dealerTotal, currentPlayer.role === 'player');
            totalDealer = calculateHandValue(currentPlayer.hand);
        }

        const total = calculateHandValue(currentPlayer.hand);
        if (total > 21) {
            endTurn();
        }

        if (total >= 21) {
            hitBtn.disabled = true;
            hitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }

    function stand() {
        endTurn();
    }

    async function endTurn() {
        currentPlayerIndex = (currentPlayerIndex + 1) % 2;
        const nextPlayer = players[currentPlayerIndex];

        if (nextPlayer.role === 'dealer') {
            await showBlackScreen(`Ganti ke Dealer (${nextPlayer.name})`);
            displayHand(nextPlayer.hand, dealerCards, true);
            updateTotal(nextPlayer.hand, dealerTotal, true);
            if (nextPlayer.isComputer) {
                playDealerTurn();
            } else {
                updateActionButtons();
            }
        } else {
            determineWinners();
        }
    }

    async function playDealerTurn() {
        const dealer = players.find(p => p.role === 'dealer');
        let dealerTotal = calculateHandValue(dealer.hand);

        while (dealerTotal < 17) {
            await new Promise(resolve => setTimeout(resolve, 1000));
            dealer.hand.push(dealCard());
            displayHand(dealer.hand, dealerCards, true);
            updateTotal(dealer.hand, dealerTotal, true);
            dealerTotal = calculateHandValue(dealer.hand);
        }

        determineWinners();
    }

    async function playComputerTurn() {
        const currentPlayer = players[currentPlayerIndex];
        let total = calculateHandValue(currentPlayer.hand);

        while (total < 17) {
            await new Promise(resolve => setTimeout(resolve, 1000));
            hit();
            total = calculateHandValue(currentPlayer.hand);
        }

        stand();
    }

    function determineWinners() {
        const playerOne = players.find(p => p.role === 'player');
        const dealer = players.find(p => p.role === 'dealer');

        const playerTotal = calculateHandValue(playerOne.hand);

        console.log("Player Total:", playerTotal);
        console.log("Dealer Total:", totalDealer);

        let result = '';

        if (playerTotal > 21) {
            result = `${dealer.name} Menang! ${playerOne.name} Bust.`;
            updateChips(-currentBet);
        } else if (totalDealer > 21 || playerTotal > totalDealer) {
            result = `${playerOne.name} Menang!`;
            updateChips(currentBet * 2);
        } else if (playerTotal < totalDealer) {
            result = `${dealer.name} Menang!`;
            updateChips(-currentBet);
        } else {
            result = 'Seri!';
        }

        showResult(result);
    }


    function showResult(message) {
        blackScreenMessage.textContent = message;
        blackScreen.style.display = 'flex';
        continueBtn.style.display = 'block';
        continueBtn.textContent = 'Lanjutkan';

        //reset otomatis
        setTimeout(() => {
            resetGame();
        }, 3000); // Delay 3 detik
    }


    function showBlackScreen(message) {
        return new Promise((resolve) => {
            blackScreenMessage.textContent = message;
            blackScreen.style.display = 'flex';
            setTimeout(() => {
                blackScreen.style.display = 'none';
                resolve();
            }, 2000);
        });
    }

    function updateActionButtons() {
        const currentPlayer = players[currentPlayerIndex];
        const isPlayerTurn = currentPlayer.role === 'player' && !currentPlayer.isComputer;

        toggleActionButtons(isPlayerTurn);

        if (!isPlayerTurn && currentPlayer.isComputer) {
            playComputerTurn();
        }
    }

    function toggleActionButtons(enabled) {
        hitBtn.disabled = !enabled;
        standBtn.disabled = !enabled;
        hitBtn.classList.toggle('opacity-50', !enabled);
        hitBtn.classList.toggle('cursor-not-allowed', !enabled);
        standBtn.classList.toggle('opacity-50', !enabled);
        standBtn.classList.toggle('cursor-not-allowed', !enabled);
    }

    function updateChipDisplay() {
        playerChipsElement.textContent = `Money: $${playerChips}`;
    }

    function updateChips(amount) {
        playerChips += amount;
        updateChipDisplay();

        // Clear 
        currentBet = 0;
        playerBet = 0;
        const currentBetElement = document.getElementById('current-bet');
        currentBetElement.textContent = `Current Bet: $${currentBet}`;

        // Check chip player 0 atau lebih rendah
        if (playerChips <= 0) {
            showGameOver();
        }
    }



    function showGameOver() {
        window.location.href = 'gameover.html';
    }



    function resetGame() {
        blackScreen.style.display = 'none';
        continueBtn.style.display = 'none';

        // Clear 
        const betArea = document.getElementById('bet-area');
        betArea.innerHTML = '';

        document.getElementById('player-cards').innerHTML = '';
        document.getElementById('dealer-cards').innerHTML = '';

        // Kalau tidak end
        if (playerChips > 0) {
            playerBet = 0;
            currentBet = 0;
            updateChipDisplay();
            placeBetBtn.disabled = false;
        }
    }



    function resetButtons() {
        hitBtn.disabled = false;
        standBtn.disabled = false;
        hitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        standBtn.classList.remove('opacity-50', 'cursor-not-allowed');
    }

    placeBetBtn.addEventListener('click', () => {
        if (playerBet < 100) {
            alert('Taruhan minimal $100.');
            return;
        }
        currentBet = playerBet;
        placeBetBtn.disabled = true;
        toggleActionButtons(true);
        startGame();
    });

    hitBtn.addEventListener('click', hit);
    standBtn.addEventListener('click', stand);

    validateAndInitializeGameData();
});
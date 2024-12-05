// Inisialisasi variabel
let deck = [];
let playerHand = [];
let dealerHand = [];
let playerScore = 0;
let dealerScore = 0;
let saldo = 5000;
let currentBet = 0;
// let gameOver = false;

// Fungsi untuk membuat deck
function createDeck() {
  const suits = ["S", "H", "D", "C"];
  const values = ["A","2","3","4","5","6","7","8","9","10","J","Q","K",];
  deck = [];
  for (let suit of suits) {
    for (let value of values) {
      deck.push({ suit, value });
    }
  }
  shuffleDeck();
}

// Fungsi untuk mengacak deck
function shuffleDeck() {
  for (let i = deck.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [deck[i], deck[j]] = [deck[j], deck[i]];
  }
}

// Fungsi untuk mengambil kartu dari deck
function drawCard() {
  return deck.pop();
}

// Fungsi untuk menghitung nilai kartu
function calculateHandValue(hand) {
  let value = 0;
  let aces = 0;
  for (let card of hand) {
    if (card.value === "A") {
      aces++;
      value += 11;
    } else if (["J", "Q", "K"].includes(card.value)) {
      value += 10;
    } else {
      value += parseInt(card.value);
    }
  }
  while (value > 21 && aces > 0) {
    value -= 10;
    aces--;
  }
  return value;
}

// Fungsi untuk memulai permainan baru
function startNewGame() {
  if (saldo < 100) {
    showModal("Saldo Anda tidak cukup untuk bermain. Game Over!");
    return;
  }
  gameOver = false;
  createDeck();
  playerHand = [drawCard(), drawCard()];
  dealerHand = [drawCard(), drawCard()];
  playerScore = calculateHandValue(playerHand);
  dealerScore = calculateHandValue(dealerHand);
  currentBet = 0;
  updateUI();
  enableControls();
}

function placeBet(amount) {
  if (saldo >= amount) {
    currentBet += amount;
    saldo -= amount;
    updateUI();
    document.getElementById("current-bet").textContent = currentBet; // Update tampilan taruhan
  } else {
    showModal("Saldo tidak cukup!");
  }
}


// Fungsi untuk memperbarui UI
function updateUI() {
  document.getElementById("saldo").textContent = `Saldo: Rp ${saldo}`;
  document.getElementById("current-bet").textContent = currentBet; // Menampilkan nilai taruhan yang sedang dipasang
  updateHandUI("player-area", playerHand, playerScore);
  updateHandUI("dealer-area", dealerHand, dealerScore, !gameOver);
}



// Fungsi untuk memperbarui UI tangan
// function updateHandUI(areaId, hand, score, hideSecondCard = false) {
//   const area = document.getElementById(areaId);
//   const cardsDiv = area.querySelector(".cards");
//   cardsDiv.innerHTML = "";
//   hand.forEach((card, index) => {
//     const cardElement = document.createElement("div");
//     cardElement.classList.add("card");
//     if (hideSecondCard && index === 1) {
//       cardElement.textContent = "?";
//     } else {
//       cardElement.textContent = `${card.value}${card.suit}`;
//     }
//     cardsDiv.appendChild(cardElement);
//   });
//   const scoreElement = area.querySelector("p");
//   scoreElement.textContent = `Total: ${hideSecondCard ? "?" : score}`;
// }

// ... (start)

// Fungsi untuk memperbarui UI tangan
function updateHandUI(areaId, hand, score, hideSecondCard = false) {
  const area = document.getElementById(areaId);
  const cardsDiv = area.querySelector(".cards");
  cardsDiv.innerHTML = "";
  hand.forEach((card, index) => {
    const cardElement = document.createElement("div");
    cardElement.classList.add("card");
    if (hideSecondCard && index === 1) {
      // Gambar kartu tertutup
      cardElement.style.backgroundImage = "url('Cards/back.png')";
    } else {
      // Gambar kartu terbuka berdasarkan suit dan value
      const imageName = `${getSuitName(card.suit)}-${getCardName(card.value)}.png`;
      cardElement.style.backgroundImage = `url('Cards/${imageName}')`;
    }
    cardElement.style.backgroundSize = 'cover'; // Pastikan gambar sesuai dengan ukuran elemen
    cardsDiv.appendChild(cardElement);
  });
  const scoreElement = area.querySelector("p");
  scoreElement.textContent = `Total: ${hideSecondCard ? "?" : score}`;
}

// Fungsi pembantu untuk mengubah simbol suit menjadi nama file yang sesuai
function getSuitName(suit) {
  const suitNames = {
    "S": "spades",    // Sekop (♠)
    "H": "hearts",    // Hati (♥)
    "D": "diamonds",  // Wajik (♦)
    "C": "clubs"      // Keriting (♣)
  };
  return suitNames[suit];
}

// Fungsi pembantu untuk mengubah value kartu menjadi nama file yang sesuai
function getCardName(value) {
  const cardNames = {
    "A": "ace",    // As
    "K": "king",   // King
    "Q": "queen",  // Queen
    "J": "jack"    // Jack
  };
  return cardNames[value] || value.toLowerCase(); 
}
// ... (end)


// Fungsi untuk menangani aksi "Hit"
function hit() {
  if (currentBet === 0) {
    showModal("Silakan pasang taruhan terlebih dahulu!");
    return;
  }
  playerHand.push(drawCard());
  playerScore = calculateHandValue(playerHand);
  updateUI();
  if (playerScore > 21) {
    endGame("Dealer");
  }
}

// Fungsi untuk menangani aksi "Stay"
function stay() {
  if (currentBet === 0) {
    showModal("Silakan pasang taruhan terlebih dahulu!");
    return;
  }
  gameOver = true;
  while (dealerScore < 17) {
    dealerHand.push(drawCard());
    dealerScore = calculateHandValue(dealerHand);
  }
  updateUI();
  if (dealerScore > 21 || playerScore > dealerScore) {
    endGame("Player");
  } else if (dealerScore > playerScore) {
    endGame("Dealer");
  } else {
    endGame("Draw");
  }
}

// Fungsi untuk mengakhiri permainan
function endGame(winner) {
  gameOver = true;
  if (winner === "Player") {
    saldo += currentBet * 2;
    showModal("Anda menang!");
  } else if (winner === "Dealer") {
    showModal("Dealer menang!");
  } else {
    saldo += currentBet;
    showModal("Seri!");
  }
  currentBet = 0;
  updateUI();
  disableControls();

  if (saldo <= 0) {
    showModal("Game Over! Saldo Anda habis.", true);
  }
}

// Fungsi untuk menampilkan modal
function showModal(message) {
  const modal = document.createElement("div");
  modal.classList.add("modal");
  modal.innerHTML = `
    <div class="modal-content">
      <p>${message}</p>
      <button onclick="closeModal()">Tutup</button>
    </div>
  `;
  document.body.appendChild(modal);
}

// Fungsi untuk menutup modal
function closeModal() {
  document.querySelector(".modal").remove();
}

// Fungsi untuk memasang taruhan
function placeBet(amount) {
  if (saldo >= amount) {
    currentBet += amount;
    saldo -= amount;
    updateUI();
  } else {
    showModal("Saldo tidak cukup!");
  }
}

// Fungsi untuk mengaktifkan kontrol
function enableControls() {
  document.getElementById("hit-button").disabled = false;
  document.getElementById("stay-button").disabled = false;
}

// Fungsi untuk menonaktifkan kontrol
function disableControls() {
  document.getElementById("hit-button").disabled = true;
  document.getElementById("stay-button").disabled = true;
}

// Event listeners
document.getElementById("hit-button").addEventListener("click", hit);
document.getElementById("stay-button").addEventListener("click", stay);
document
  .getElementById("new-game-button")
  .addEventListener("click", startNewGame);

document.querySelectorAll(".chip").forEach((chip) => {
  chip.addEventListener("click", () => {
    const betAmount = parseInt(chip.textContent.replace("K", "000"));
    placeBet(betAmount);
  });
});


function showModal(message, isGameOver = false) {
  const modal = document.createElement("div");
  modal.classList.add("modal");
  let content = `
    <div class="modal-content">
      <p>${message}</p>
  `;

  if (isGameOver) {
    content += `<img src="https://i.pinimg.com/474x/e7/fe/e0/e7fee070be49126a45256a37e8a17bfa.jpg" alt="Game Over" style="width: 100%; max-width: 300px;">`;
  }

  content += `<br/>
      <button onclick="closeModal()">Tutup</button>
    </div>
  `;

  modal.innerHTML = content;
  document.body.appendChild(modal);

}

// Memulai permainan
startNewGame();

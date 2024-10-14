//blackjack backend
let start = document.getElementById("startBtn");
let hit = document.getElementById("hitBtn");
let hold = document.getElementById("holdBtn");

let deallerCard = document.getElementById("deallerCard");
let deallerSums = document.getElementById("deallerSums");

let myMoney = document.getElementById("myMoney");
let myBetInput = document.getElementById("myBet");

let playerCardsDiv = document.getElementById("playerCards");
let dealerCardsDiv = document.getElementById("dealerCards");

let modal = document.getElementById('popup-modal');
const closeModalButton = document.getElementById('close-modal');
const modalContainer = document.getElementById("modalContainer");
let mClose= false;

let resultGameImg = document.getElementById("resultImg");
let resultGameText = document.getElementById("resultModalH3");

let myBet = 0;
let money = 5000;
const cards = ['A', 2, 3, 4, 5, 6, 7, 8, 9, 10, 'J', 'Q', 'K'];
const symbols = ['spade', 'heart', 'diamond', 'club'];
let deallerResult = [];
let playerResult = [];
let usedCards = [];
let deallerFirstCard;

function drawCards(cards, draws) {
    let total = 0;
    const drawnCards = [];
    const drawnCardPaths = [];  

    for (let i = 0; i < draws; i++) {
        let card, symbol;
        do {
            const randomIndex = Math.floor(Math.random() * cards.length);
            card = cards[randomIndex];
            const randomSymbolIndex = Math.floor(Math.random() * symbols.length);
            symbol = symbols[randomSymbolIndex];
        } while (usedCards.includes(`${card}_${symbol}`)); 

        usedCards.push(`${card}_${symbol}`); 

        let value;
        if (typeof card == "number") {
            value = card;
        } else if (card === 'J' || card === 'Q' || card === 'K') {
            value = 10;
        } else if (card === 'A') {
            value = 11;
        }
        total += value;

        drawnCards.push(card);

        const cardPath = getCardPath(card, symbol);
        drawnCardPaths.push(cardPath);
    }

    return [drawnCards, total, drawnCardPaths];  
}


function dealerDraw() {
    while (deallerResult[1] < 17) { 
        let newDealerCard = drawCards(cards, 1, deallerResult[1]);
        deallerResult[0].push(newDealerCard[0][0]);       
        deallerResult[1] += newDealerCard[1];             
        deallerResult[2].push(newDealerCard[2][0]);       

        deallerResult[1] = adjustForAces(deallerResult[1], deallerResult[0]);  
    }

    updateDealerCards();
    deallerSums.textContent = deallerResult[1];
}


myBetInput.addEventListener("input", function() {
    myBet = Number(myBetInput.value);
})


function adjustForAces(total, cards) {
    let aceCount = 0;

    for (let i = 0; i < cards.length; i++) {
        if (cards[i] === 'A') {
            aceCount += 1;  
        }
    }

    while (total > 21 && aceCount > 0) {
        total -= 10;  
        
        for (let i = 0; i < cards.length; i++) {
            if (cards[i] === 'A') {
                cards[i] = 'A1';  
                aceCount -= 1;  
                break;  
            }
        }
    }

    return total;
}


function getCardPath(card, symbol) {
    let cardValue;
    if (card === 'A') {
        cardValue = '01';  
    } else if (card === 'J') {
        cardValue = '11';  
    } else if (card === 'Q') {
        cardValue = '12';  
    } else if (card === 'K') {
        cardValue = '13';  
    } else if (card >= 2 && card < 10){
        cardValue = '0' + card;  
    } else {
        cardValue = card;
    }

    return `card_${symbol}_${cardValue}`;  
}


function updatePlayerCards() {
    const playerCardPaths = playerResult[2];  
    playerCardsDiv.innerHTML = '';  

    playerCardPaths.forEach(path => {
        const img = document.createElement('img');
        img.src = `assets/images/card_img/${path}.png`;  
        img.alt = path;
        img.className = 'w-14 h-max slide-card';  
        img.style.animationDelay = '0s';  
        playerCardsDiv.appendChild(img);  
    });
}


function updateDealerCards() {
    const dealerCardPaths = deallerResult[2];  
    dealerCardsDiv.innerHTML = '';  

    dealerCardPaths.forEach((path, index) => {
        setTimeout(() => {
            const img = document.createElement('img');
            img.src = `assets/images/card_img/${path}.png`;  
            img.alt = path;
            img.className = 'w-14 h-max slide-card';  
            img.style.animationDelay = '0s';  
            dealerCardsDiv.appendChild(img);  
        }, index * 500); // Jeda waktu 500ms antara tiap kartu
    });
}



start.addEventListener("click", function() {
    if (myBet >= 100 && myBet <= money) {
        usedCards.length = 0;
        start.textContent = "Try Again";
        toggleDisableButtons(hit, false);
        toggleDisableButtons(hold, false);    

        deallerResult = [];
        playerResult = [];
        dealerCardsDiv.innerHTML = '';
        playerCardsDiv.innerHTML = '';

        const img = document.createElement('img');
        img.src = `assets/images/card_img/card_back.png`;  
        img.className = 'w-16 h-auto slide-card';  
        img.style.animationDelay = '0s';
        dealerCardsDiv.appendChild(img);

        deallerSums.textContent = "0";
        playerSums.textContent = "0";

        money -= myBet;
        myMoney.textContent = `$${money}`;

        deallerResult = drawCards(cards, 2);
        playerResult = drawCards(cards, 2);

        updatePlayerCards();
        playerSums.textContent = playerResult[1];

        toggleDisableButtons(start, true);

        } else if (myBet < 100) {
            window.alert("Minimal uang taruhkan adalah $100");
        } else if (myBet > money) {
            window.alert("Uang kamu tidak cukup :(");
        } else {
            window.alert("Silahkan menginput jumlah uang yang ingin dipertaruhkan");
        }
});


hit.addEventListener("click", function() {
    let newCards = drawCards(cards, 1, playerResult[1]);

    playerResult[0].push(newCards[0][0]);  
    playerResult[1] += newCards[1];        

    playerResult[2].push(newCards[2][0]); 

    playerResult[1] = adjustForAces(playerResult[1], playerResult[0]);

    updatePlayerCards();
    playerSums.textContent = playerResult[1];

    if (playerResult[1] > 21 || playerResult[1] == 21) {
        resultGame();

        toggleDisableButtons(hit, true);
        toggleDisableButtons(hold, true);
        toggleDisableButtons(start, false);
    }
});


hold.addEventListener("click", function () {
    dealerDraw();  
    resultGame();

    toggleDisableButtons(hit, true);
    toggleDisableButtons(hold, true);
    toggleDisableButtons(start, false);
});


function resultGame() {
    if (playerResult[1] <= 21 && (deallerResult[1] > 21 || playerResult[1] > deallerResult[1])) {
        console.log("player wins");
        money += (myBet * 2) 
        resultGameImg.src = `assets/images/win.png`; 
        resultGameText.textContent = "YOU WIN!!!";
        modalContainer.classList.remove("from-white");  
        modalContainer.classList.add("from-orange-400"); 
    } else if (deallerResult[1] <= 21 && (playerResult[1] > 21 || deallerResult[1] > playerResult[1])) {
        console.log("dealer wins");
        resultGameImg.src = `assets/images/lose.png`; 
        resultGameText.textContent = "YOU LOSE!!!";
        modalContainer.classList.remove("from-white");  
        modalContainer.classList.add("from-black");
        
    } else {
        console.log("It's a tie");
        resultGameImg.src = `assets/images/tie.png`; 
        resultGameText.textContent = "It's a tie";
        modalContainer.classList.remove("from-white");  
        modalContainer.classList.add("from-blue-950");
    }
    myMoney.textContent = `$${money}`;

    setTimeout(() => {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }, 2000); 
}


closeModalButton.addEventListener('click', function() {
    modalContainer.classList.add("from-white");  
    
    modalContainer.classList.remove("from-green-300", "from-blue-950", "from-black", "from-orange-400");

    modal.classList.add('hidden');  
    modal.classList.remove('flex');
    
    if (money == 0) {
        setTimeout(() => {
            resultGameImg.src = `assets/images/no money.png`;
            resultGameText.textContent = "GAME OVER! You have no money left :(";
            
            modalContainer.classList.remove("from-white");
            modalContainer.classList.add("from-black");
    
            modal.classList.remove('hidden');  
            modal.classList.add('flex');
    
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 3000);  
        }, 1000);  
    }
});


function toggleDisableButtons(btn, disable) {
    if (disable) {
        if (btn === start) {
            start.classList.add('bg-blue-950', 'text-white');
            start.disabled = true;
        } else if (btn === hit) {
            hit.classList.add('bg-green-950', 'text-white');
            hit.disabled = true;
        } else if (btn === hold) {
            hold.classList.add('bg-red-950', 'text-white');
            hold.disabled = true;
        }
    } else {
        if (btn === start) {
            start.classList.remove('bg-blue-950', 'text-white');
            start.disabled = false;
        } else if (btn === hit) {
            hit.classList.remove('bg-green-950', 'text-white');
            hit.disabled = false;
        } else if (btn === hold) {
            hold.classList.remove('bg-red-950', 'text-white');
            hold.disabled = false;
        }
    }
}
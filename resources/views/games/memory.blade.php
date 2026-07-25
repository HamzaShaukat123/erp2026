<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Match</title>

    <style>
        body {
            background: #0f172a;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        .card-container {
            background: #111827;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
            text-align: center;
            width: 360px;
            color: white;
        }

        h2 {
            margin-top: 0;
            margin-bottom: 15px;
            color: #60a5fa;
        }

        /* Stats Bar */
        .stats-bar {
            display: flex;
            justify-content: space-between;
            background: #020617;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .stat-item span {
            font-size: 16px;
            color: #60a5fa;
            margin-top: 2px;
        }

        /* Card Grid */
        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            perspective: 1000px;
            margin-bottom: 20px;
        }

        .memory-card {
            width: 100%;
            height: 75px;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.4s ease;
            cursor: pointer;
        }

        .memory-card.flipped,
        .memory-card.matched {
            transform: rotateY(180deg);
        }

        .card-front, .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
            backface-visibility: hidden;
            font-size: 32px;
            user-select: none;
        }

        /* Card Back (Hidden state) */
        .card-back {
            background: #1e293b;
            border: 1px solid #334155;
            color: #60a5fa;
            font-size: 22px;
        }

        .memory-card:hover .card-back {
            background: #334155;
        }

        /* Card Front (Revealed state) */
        .card-front {
            background: #020617;
            border: 1px solid #60a5fa;
            transform: rotateY(180deg);
        }

        .memory-card.matched .card-front {
            background: #064e3b;
            border-color: #22c55e;
        }

        .status {
            font-size: 16px;
            min-height: 24px;
            margin-bottom: 15px;
        }

        .restart-btn {
            background: #ef4444;
            color: white;
            border: none;
            width: 100%;
            padding: 10px;
            font-size: 15px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.2s;
        }

        .restart-btn:hover {
            background: #dc2626;
        }
    </style>
</head>
<body>

<div class="card-container">
    <h2>🧠 Memory Match</h2>

    <div class="stats-bar">
        <div class="stat-item">
            Moves
            <span id="movesCount">0</span>
        </div>
        <div class="stat-item">
            Matches
            <span id="matchesCount">0 / 8</span>
        </div>
        <div class="stat-item">
            Time
            <span id="timer">0s</span>
        </div>
    </div>

    <div class="grid" id="grid"></div>

    <div class="status" id="status">Flip any card to start!</div>

    <button class="restart-btn" onclick="initGame()">Restart Game</button>
</div>

<script>
    const icons = ['🎮', '🎲', '🎯', '🚀', '💎', '👾', '🏆', '⚡'];
    let cards = [];
    let flippedCards = [];
    let matchedPairs = 0;
    let moves = 0;
    let timer = null;
    let seconds = 0;
    let isTimerRunning = false;
    let isLockBoard = false;

    const grid = document.getElementById('grid');
    const movesText = document.getElementById('movesCount');
    const matchesText = document.getElementById('matchesCount');
    const timerText = document.getElementById('timer');
    const statusText = document.getElementById('status');

    function initGame() {
        // Reset Variables
        cards = [...icons, ...icons]; // 8 pairs = 16 cards
        shuffle(cards);
        flippedCards = [];
        matchedPairs = 0;
        moves = 0;
        seconds = 0;
        isLockBoard = false;

        stopTimer();
        isTimerRunning = false;
        
        movesText.innerText = "0";
        matchesText.innerText = "0 / 8";
        timerText.innerText = "0s";
        statusText.innerText = "Flip any card to start!";

        renderBoard();
    }

    function shuffle(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    }

    function renderBoard() {
        grid.innerHTML = "";
        cards.forEach((symbol, index) => {
            const card = document.createElement('div');
            card.classList.add('memory-card');
            card.dataset.index = index;
            card.dataset.symbol = symbol;

            card.innerHTML = `
                <div class="card-back">❓</div>
                <div class="card-front">${symbol}</div>
            `;

            card.addEventListener('click', () => flipCard(card));
            grid.appendChild(card);
        });
    }

    function flipCard(card) {
        if (isLockBoard) return;
        if (card.classList.contains('flipped') || card.classList.contains('matched')) return;

        // Start timer on first card click
        if (!isTimerRunning) {
            startTimer();
            isTimerRunning = true;
        }

        card.classList.add('flipped');
        flippedCards.push(card);

        if (flippedCards.length === 2) {
            checkMatch();
        }
    }

    function checkMatch() {
        isLockBoard = true;
        moves++;
        movesText.innerText = moves;

        const [card1, card2] = flippedCards;
        const isMatch = card1.dataset.symbol === card2.dataset.symbol;

        if (isMatch) {
            card1.classList.add('matched');
            card2.classList.add('matched');
            matchedPairs++;
            matchesText.innerText = `${matchedPairs} / 8`;
            flippedCards = [];
            isLockBoard = false;

            if (matchedPairs === 8) {
                stopTimer();
                statusText.innerText = `🎉 You Won in ${moves} moves & ${seconds}s!`;
            } else {
                statusText.innerText = "It's a match! 🌟";
            }
        } else {
            statusText.innerText = "Try again!";
            setTimeout(() => {
                card1.classList.remove('flipped');
                card2.classList.remove('flipped');
                flippedCards = [];
                isLockBoard = false;
                statusText.innerText = "Find the pairs!";
            }, 900);
        }
    }

    function startTimer() {
        seconds = 0;
        timer = setInterval(() => {
            seconds++;
            timerText.innerText = `${seconds}s`;
        }, 1000);
    }

    function stopTimer() {
        clearInterval(timer);
    }

    // Initialize Game on Load
    initGame();
</script>

</body>
</html>
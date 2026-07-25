<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tic Tac Toe</title>

    <style>
        body {
            background: #0f172a;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background: #111827;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
            text-align: center;
            width: 340px;
            color: white;
        }

        h2 {
            margin-top: 0;
            margin-bottom: 15px;
            color: #60a5fa;
        }

        /* Scoreboard */
        .scoreboard {
            display: flex;
            justify-content: space-between;
            background: #020617;
            padding: 8px 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 13px;
            font-weight: 600;
        }

        .scoreboard .score-item {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .scoreboard .score-item span {
            font-size: 16px;
            margin-top: 2px;
        }

        .score-x { color: #60a5fa; }
        .score-draw { color: #9ca3af; }
        .score-o { color: #f87171; }

        .controls {
            margin-bottom: 10px;
        }

        .hidden {
            display: none !important;
        }

        button {
            padding: 7px 12px;
            margin: 3px;
            border: 1px solid transparent;
            border-radius: 6px;
            cursor: pointer;
            background: #1f2937;
            color: white;
            transition: 0.2s;
        }

        button:hover {
            background: #17365D;
        }

        button.active {
            background: #17365D;
            border-color: #60a5fa;
        }

        .board {
            display: grid;
            grid-template-columns: repeat(3, 90px);
            gap: 8px;
            justify-content: center;
            margin-top: 15px;
        }

        .cell {
            width: 90px;
            height: 90px;
            background: #020617;
            border-radius: 10px;
            font-size: 40px;
            font-weight: bold;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: 0.2s;
            user-select: none;
        }

        .cell:hover {
            background: #1e293b;
        }

        /* Distinct Player Colors */
        .cell.x-mark {
            color: #60a5fa;
        }

        .cell.o-mark {
            color: #f87171;
        }

        .cell.win {
            background: #22c55e !important;
            color: #000 !important;
        }

        .status {
            margin-top: 15px;
            font-size: 16px;
            min-height: 24px;
        }

        .restart {
            margin-top: 15px;
            background: #ef4444;
            width: 100%;
            padding: 10px;
            font-weight: bold;
        }

        .restart:hover {
            background: #dc2626;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>🎮 Tic Tac Toe</h2>

    <div class="scoreboard">
        <div class="score-item score-x">
            <label id="labelX">Player (X)</label>
            <span id="scoreX">0</span>
        </div>
        <div class="score-item score-draw">
            <label>Draws</label>
            <span id="scoreDraw">0</span>
        </div>
        <div class="score-item score-o">
            <label id="labelO">PC (O)</label>
            <span id="scoreO">0</span>
        </div>
    </div>

    <div class="controls">
        <button id="pvpBtn" onclick="setMode('pvp')">2 Player</button>
        <button id="pcBtn" onclick="setMode('pc')">vs PC</button>
    </div>

    <div class="controls" id="difficultyContainer">
        <button id="easyBtn" onclick="setDifficulty('easy')">Easy</button>
        <button id="mediumBtn" onclick="setDifficulty('medium')">Medium</button>
        <button id="hardBtn" onclick="setDifficulty('hard')">Hard</button>
    </div>

    <div class="board" id="board"></div>

    <div class="status" id="status">Select Mode</div>

    <button class="restart" onclick="resetGame()">Restart Game</button>
</div>

<script>
    let cells = ["","","","","","","","",""];
    let currentPlayer = "X";
    let gameActive = true;
    let isWaitingForPC = false;

    // Default configuration
    let mode = "pc";
    let difficulty = "medium";

    // Scores
    let scores = { X: 0, O: 0, Draw: 0 };

    const board = document.getElementById("board");
    const statusText = document.getElementById("status");

    const winConditions = [
        [0,1,2],[3,4,5],[6,7,8],
        [0,3,6],[1,4,7],[2,5,8],
        [0,4,8],[2,4,6]
    ];

    function setMode(m) {
        if (mode !== m) {
            mode = m;
            resetScores();
            updateControlsUI();
            resetGame();
        }
    }

    function setDifficulty(level) {
        if (difficulty !== level) {
            difficulty = level;
            updateControlsUI();
            resetGame();
        }
    }

    function updateControlsUI() {
        // Toggle Active Classes for Mode
        document.getElementById("pvpBtn").classList.toggle("active", mode === "pvp");
        document.getElementById("pcBtn").classList.toggle("active", mode === "pc");

        // Hide Difficulty menu in 2-Player Mode
        const diffContainer = document.getElementById("difficultyContainer");
        if (mode === "pvp") {
            diffContainer.classList.add("hidden");
            document.getElementById("labelO").innerText = "Player (O)";
        } else {
            diffContainer.classList.remove("hidden");
            document.getElementById("labelO").innerText = "PC (O)";
        }

        // Toggle Active Classes for Difficulty
        document.getElementById("easyBtn").classList.toggle("active", difficulty === "easy");
        document.getElementById("mediumBtn").classList.toggle("active", difficulty === "medium");
        document.getElementById("hardBtn").classList.toggle("active", difficulty === "hard");
    }

    function renderBoard(winCombo = []) {
        board.innerHTML = "";
        cells.forEach((cell, index) => {
            const div = document.createElement("div");
            div.classList.add("cell");

            if (cell === "X") div.classList.add("x-mark");
            if (cell === "O") div.classList.add("o-mark");

            if (winCombo.includes(index)) {
                div.classList.add("win");
            }

            div.innerText = cell;
            div.onclick = () => handleClick(index);
            board.appendChild(div);
        });
    }

    function handleClick(index) {
        if (cells[index] !== "" || !gameActive || isWaitingForPC) return;

        cells[index] = currentPlayer;
        renderBoard();

        if (checkWinner()) return;

        if (mode === "pc") {
            isWaitingForPC = true;
            statusText.innerText = "PC is thinking...";
            setTimeout(pcMove, 400);
        } else {
            currentPlayer = currentPlayer === "X" ? "O" : "X";
            statusText.innerText = `Player ${currentPlayer} Turn`;
        }
    }

    function pcMove() {
        let move;

        if (difficulty === "easy") {
            move = randomMove();
        } else if (difficulty === "medium") {
            move = Math.random() < 0.5 ? randomMove() : bestMove();
        } else {
            move = bestMove();
        }

        cells[move] = "O";
        isWaitingForPC = false;
        renderBoard();

        if (checkWinner()) return;

        currentPlayer = "X";
        statusText.innerText = "Player X Turn";
    }

    function randomMove() {
        let empty = cells.map((v, i) => v === "" ? i : null).filter(v => v !== null);
        return empty[Math.floor(Math.random() * empty.length)];
    }

    function bestMove() {
        let bestScore = -Infinity;
        let move;

        for (let i = 0; i < 9; i++) {
            if (cells[i] === "") {
                cells[i] = "O";
                let score = minimax(cells, 0, false);
                cells[i] = "";
                if (score > bestScore) {
                    bestScore = score;
                    move = i;
                }
            }
        }
        return move;
    }

    function minimax(boardState, depth, isMax) {
        let result = checkWinnerMini(boardState);
        if (result !== null) return result;

        if (isMax) {
            let best = -Infinity;
            for (let i = 0; i < 9; i++) {
                if (boardState[i] === "") {
                    boardState[i] = "O";
                    best = Math.max(best, minimax(boardState, depth + 1, false));
                    boardState[i] = "";
                }
            }
            return best;
        } else {
            let best = Infinity;
            for (let i = 0; i < 9; i++) {
                if (boardState[i] === "") {
                    boardState[i] = "X";
                    best = Math.min(best, minimax(boardState, depth + 1, true));
                    boardState[i] = "";
                }
            }
            return best;
        }
    }

    function checkWinnerMini(b) {
        for (let c of winConditions) {
            const [a, b1, c1] = c;
            if (b[a] && b[a] === b[b1] && b[a] === b[c1]) {
                return b[a] === "O" ? 1 : -1;
            }
        }
        if (!b.includes("")) return 0;
        return null;
    }

    function checkWinner() {
        for (let cond of winConditions) {
            const [a, b, c] = cond;
            if (cells[a] && cells[a] === cells[b] && cells[a] === cells[c]) {
                renderBoard(cond);
                const winner = cells[a];
                statusText.innerText = `🎉 Player ${winner} Wins!`;
                gameActive = false;
                
                scores[winner]++;
                updateScoreboard();
                return true;
            }
        }

        if (!cells.includes("")) {
            statusText.innerText = "🤝 Draw!";
            gameActive = false;
            
            scores.Draw++;
            updateScoreboard();
            return true;
        }

        return false;
    }

    function updateScoreboard() {
        document.getElementById("scoreX").innerText = scores.X;
        document.getElementById("scoreO").innerText = scores.O;
        document.getElementById("scoreDraw").innerText = scores.Draw;
    }

    function resetScores() {
        scores = { X: 0, O: 0, Draw: 0 };
        updateScoreboard();
    }

    function resetGame() {
        cells = ["","","","","","","","",""];
        currentPlayer = "X";
        gameActive = true;
        isWaitingForPC = false;

        statusText.innerText = mode === "pc" 
            ? `Player X vs PC (${difficulty.charAt(0).toUpperCase() + difficulty.slice(1)})` 
            : "Player X Turn";

        renderBoard();
    }

    // Initialize UI and Board on load
    updateControlsUI();
    resetGame();
</script>

</body>
</html>
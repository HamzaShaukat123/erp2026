<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brick Breaker</title>

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

        .game-wrapper {
            background: #111827;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            text-align: center;
            color: white;
            position: relative;
        }

        h2 {
            margin-top: 0;
            margin-bottom: 12px;
            color: #60a5fa;
        }

        /* Stats Header */
        .stats-bar {
            display: flex;
            justify-content: space-between;
            background: #020617;
            padding: 8px 15px;
            border-radius: 8px;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
        }

        .stat-item span {
            color: #60a5fa;
            font-size: 16px;
        }

        /* Powerup Bar */
        .powerup-bar {
            height: 22px;
            margin-bottom: 8px;
            font-size: 12px;
            font-weight: bold;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .powerup-badge {
            padding: 2px 8px;
            border-radius: 4px;
            background: #1e293b;
        }

        .canvas-container {
            position: relative;
            width: 420px;
            height: 500px;
        }

        canvas {
            background: #020617;
            border: 2px solid #1e293b;
            border-radius: 8px;
            display: block;
        }

        /* Overlay UI */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(2, 6, 23, 0.85);
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(2px);
        }

        .hidden {
            display: none !important;
        }

        .overlay h3 {
            font-size: 28px;
            margin: 0 0 10px 0;
            color: #f87171;
        }

        .overlay p {
            font-size: 14px;
            color: #9ca3af;
            margin-bottom: 20px;
        }

        .btn {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 15px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn:hover {
            background: #2563eb;
        }

        .controls-hint {
            margin-top: 12px;
            font-size: 12px;
            color: #64748b;
        }
    </style>
</head>
<body>

<div class="game-wrapper">
    <h2>🧱 Brick Breaker</h2>

    <div class="stats-bar">
        <div class="stat-item">Score: <span id="scoreText">0</span></div>
        <div class="stat-item">Level: <span id="levelText">1</span></div>
        <div class="stat-item">Lives: <span id="livesText">❤️❤️❤️</span></div>
    </div>

    <div class="powerup-bar" id="powerupBar"></div>

    <div class="canvas-container">
        <canvas id="gameCanvas" width="420" height="500"></canvas>

        <div class="overlay" id="gameOverlay">
            <h3 id="overlayTitle">Brick Breaker</h3>
            <p id="overlaySub">Smash all bricks and collect power-ups!</p>
            <button class="btn" id="startBtn" onclick="startGame()">Start Game</button>
        </div>
    </div>

    <div class="controls-hint">
        Use <b>Left/Right Arrows</b>, <b>A/D</b>, or move your <b>Mouse</b> to control paddle.
    </div>
</div>

<script>
    const canvas = document.getElementById("gameCanvas");
    const ctx = canvas.getContext("2d");

    // UI Elements
    const scoreText = document.getElementById("scoreText");
    const levelText = document.getElementById("levelText");
    const livesText = document.getElementById("livesText");
    const powerupBar = document.getElementById("powerupBar");
    const overlay = document.getElementById("gameOverlay");
    const overlayTitle = document.getElementById("overlayTitle");
    const overlaySub = document.getElementById("overlaySub");
    const startBtn = document.getElementById("startBtn");

    const keys = { Left: false, Right: false };

    // Game Variables
    let gameLoopId;
    let isRunning = false;
    let score = 0;
    let level = 1;
    let lives = 3;

    // Power-up state timers
    let widePaddleTimer = 0;
    let fastBallTimer = 0;

    // Game Objects
    let paddle;
    let ball;
    let bricks = [];
    let particles = [];
    let powerups = [];

    // Row color configuration
    const rowColors = ["#f87171", "#fb923c", "#facc15", "#4ade80", "#60a5fa"];

    // Input Handlers
    window.addEventListener("keydown", (e) => {
        if (e.code === "ArrowLeft" || e.code === "KeyA") keys.Left = true;
        if (e.code === "ArrowRight" || e.code === "KeyD") keys.Right = true;
    });

    window.addEventListener("keyup", (e) => {
        if (e.code === "ArrowLeft" || e.code === "KeyA") keys.Left = false;
        if (e.code === "ArrowRight" || e.code === "KeyD") keys.Right = false;
    });

    canvas.addEventListener("mousemove", (e) => {
        if (!isRunning) return;
        const rect = canvas.getBoundingClientRect();
        const mouseX = e.clientX - rect.left;
        paddle.x = mouseX - paddle.width / 2;

        // Keep inside boundary
        if (paddle.x < 0) paddle.x = 0;
        if (paddle.x + paddle.width > canvas.width) paddle.x = canvas.width - paddle.width;
    });

    // Paddle Class
    class Paddle {
        constructor() {
            this.baseWidth = 75;
            this.width = this.baseWidth;
            this.height = 12;
            this.x = canvas.width / 2 - this.width / 2;
            this.y = canvas.height - 30;
            this.speed = 7;
        }

        draw() {
            ctx.fillStyle = widePaddleTimer > 0 ? "#facc15" : "#60a5fa";
            ctx.beginPath();
            ctx.roundRect(this.x, this.y, this.width, this.height, 6);
            ctx.fill();
        }

        update() {
            if (widePaddleTimer > 0) {
                this.width = 115;
            } else {
                this.width = this.baseWidth;
            }

            if (keys.Left && this.x > 0) this.x -= this.speed;
            if (keys.Right && this.x + this.width < canvas.width) this.x += this.speed;
        }
    }

    // Ball Class
    class Ball {
        constructor() {
            this.reset();
        }

        reset() {
            this.x = canvas.width / 2;
            this.y = canvas.height - 45;
            this.radius = 7;
            this.baseSpeed = 4 + (level - 1) * 0.5;
            this.dx = (Math.random() > 0.5 ? 1 : -1) * this.baseSpeed;
            this.dy = -this.baseSpeed;
        }

        draw() {
            ctx.fillStyle = "#38bdf8";
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
            ctx.fill();
        }

        update() {
            let speedMultiplier = fastBallTimer > 0 ? 1.3 : 1.0;

            this.x += this.dx * speedMultiplier;
            this.y += this.dy * speedMultiplier;

            // Wall collisions
            if (this.x - this.radius <= 0 || this.x + this.radius >= canvas.width) {
                this.dx *= -1;
            }
            if (this.y - this.radius <= 0) {
                this.dy *= -1;
            }

            // Paddle collision
            if (
                this.y + this.radius >= paddle.y &&
                this.y - this.radius <= paddle.y + paddle.height &&
                this.x >= paddle.x &&
                this.x <= paddle.x + paddle.width
            ) {
                // Calculate bounce angle depending on hit location
                let hitPoint = (this.x - (paddle.x + paddle.width / 2)) / (paddle.width / 2);
                this.dx = hitPoint * (this.baseSpeed + 1);
                this.dy = -Math.abs(this.dy);
            }

            // Bottom out (Life lost)
            if (this.y - this.radius > canvas.height) {
                takeDamage();
            }
        }
    }

    // Power-up Gift Class
    class PowerUp {
        constructor(x, y, type) {
            this.x = x;
            this.y = y;
            this.type = type; // 'wide', 'life'
            this.radius = 10;
            this.speed = 2;
        }

        draw() {
            ctx.save();
            ctx.font = "14px Segoe UI";
            ctx.textAlign = "center";
            ctx.textBaseline = "middle";

            let icon = "↔️";
            if (this.type === 'life') icon = "❤️";

            ctx.fillText(icon, this.x, this.y);
            ctx.restore();
        }

        update() {
            this.y += this.speed;
        }
    }

    // Particle Class
    class Particle {
        constructor(x, y, color) {
            this.x = x;
            this.y = y;
            this.color = color;
            this.radius = Math.random() * 3 + 1;
            this.vx = (Math.random() - 0.5) * 4;
            this.vy = (Math.random() - 0.5) * 4;
            this.alpha = 1;
        }

        draw() {
            ctx.save();
            ctx.globalAlpha = this.alpha;
            ctx.fillStyle = this.color;
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
            ctx.fill();
            ctx.restore();
        }

        update() {
            this.x += this.vx;
            this.y += this.vy;
            this.alpha -= 0.03;
        }
    }

    function createBricks() {
        bricks = [];
        const rows = 5;
        const cols = 7;
        const padding = 8;
        const offsetTop = 40;
        const offsetLeft = 15;
        const brickWidth = 48;
        const brickHeight = 16;

        for (let r = 0; r < rows; r++) {
            for (let c = 0; c < cols; c++) {
                bricks.push({
                    x: offsetLeft + c * (brickWidth + padding),
                    y: offsetTop + r * (brickHeight + padding),
                    width: brickWidth,
                    height: brickHeight,
                    color: rowColors[r],
                    points: (rows - r) * 10,
                    status: 1
                });
            }
        }
    }

    function createExplosion(x, y, color) {
        for (let i = 0; i < 10; i++) {
            particles.push(new Particle(x, y, color));
        }
    }

    function gameLoop() {
        if (!isRunning) return;

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        updatePowerupStatus();

        // 1. Update Paddle & Ball
        paddle.update();
        paddle.draw();

        ball.update();
        ball.draw();

        // 2. Power-ups Handling
        powerups.forEach((pu, index) => {
            pu.update();
            pu.draw();

            if (
                pu.y + pu.radius >= paddle.y &&
                pu.x >= paddle.x &&
                pu.x <= paddle.x + paddle.width
            ) {
                applyPowerup(pu.type);
                createExplosion(pu.x, pu.y, "#facc15");
                powerups.splice(index, 1);
            } else if (pu.y > canvas.height) {
                powerups.splice(index, 1);
            }
        });

        // 3. Bricks Collision
        let activeBricks = 0;
        bricks.forEach(b => {
            if (b.status === 1) {
                activeBricks++;

                // Draw Brick
                ctx.fillStyle = b.color;
                ctx.beginPath();
                ctx.roundRect(b.x, b.y, b.width, b.height, 4);
                ctx.fill();

                // Ball-Brick Collision Check
                if (
                    ball.x + ball.radius > b.x &&
                    ball.x - ball.radius < b.x + b.width &&
                    ball.y + ball.radius > b.y &&
                    ball.y - ball.radius < b.y + b.height
                ) {
                    ball.dy *= -1;
                    b.status = 0;
                    score += b.points;
                    scoreText.innerText = score;
                    createExplosion(b.x + b.width / 2, b.y + b.height / 2, b.color);

                    // 15% Chance to drop powerup
                    if (Math.random() < 0.15) {
                        const types = ['wide', 'life'];
                        const selectedType = types[Math.floor(Math.random() * types.length)];
                        powerups.push(new PowerUp(b.x + b.width / 2, b.y, selectedType));
                    }
                }
            }
        });

        // Next Level Check
        if (activeBricks === 0) {
            level++;
            levelText.innerText = level;
            ball.reset();
            createBricks();
        }

        // 4. Update Explosions
        particles.forEach((p, index) => {
            p.update();
            p.draw();
            if (p.alpha <= 0) particles.splice(index, 1);
        });

        gameLoopId = requestAnimationFrame(gameLoop);
    }

    function applyPowerup(type) {
        if (type === 'wide') {
            widePaddleTimer = 360; // 6 seconds
        } else if (type === 'life') {
            if (lives < 5) {
                lives++;
                livesText.innerText = "❤️".repeat(lives);
            }
        }
    }

    function updatePowerupStatus() {
        let statusHTML = "";

        if (widePaddleTimer > 0) {
            widePaddleTimer--;
            let secLeft = Math.ceil(widePaddleTimer / 60);
            statusHTML += `<span class="powerup-badge" style="color:#facc15;">↔️ Wide Paddle: ${secLeft}s</span>`;
        }

        powerupBar.innerHTML = statusHTML;
    }

    function takeDamage() {
        lives--;
        livesText.innerText = "❤️".repeat(Math.max(0, lives));

        if (lives <= 0) {
            endGame();
        } else {
            ball.reset();
        }
    }

    function startGame() {
        score = 0;
        level = 1;
        lives = 3;
        widePaddleTimer = 0;

        scoreText.innerText = score;
        levelText.innerText = level;
        livesText.innerText = "❤️❤️❤️";

        paddle = new Paddle();
        ball = new Ball();
        particles = [];
        powerups = [];
        createBricks();

        overlay.classList.add("hidden");
        isRunning = true;
        gameLoopId = requestAnimationFrame(gameLoop);
    }

    function endGame() {
        isRunning = false;
        cancelAnimationFrame(gameLoopId);

        overlayTitle.innerText = "Game Over";
        overlaySub.innerText = `Final Score: ${score} points!`;
        startBtn.innerText = "Play Again";
        overlay.classList.remove("hidden");
    }
</script>

</body>
</html>
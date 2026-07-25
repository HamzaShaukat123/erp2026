<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Shooter - Power-Up Edition</title>

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

        /* Powerup Active Display */
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
            width: 400px;
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
    <h2>🚀 Space Shooter</h2>

    <div class="stats-bar">
        <div class="stat-item">Score: <span id="scoreText">0</span></div>
        <div class="stat-item">Wave: <span id="waveText">1</span></div>
        <div class="stat-item">Lives: <span id="livesText">❤️❤️❤️</span></div>
    </div>

    <div class="powerup-bar" id="powerupBar"></div>

    <div class="canvas-container">
        <canvas id="gameCanvas" width="400" height="500"></canvas>

        <div class="overlay" id="gameOverlay">
            <h3 id="overlayTitle">Space Shooter</h3>
            <p id="overlaySub">Collect Power-ups & Defend the Galaxy!</p>
            <button class="btn" id="startBtn" onclick="startGame()">Start Game</button>
        </div>
    </div>

    <div class="controls-hint">
        Use <b>Left/Right Arrows</b> or <b>A/D</b> to move. Press <b>Spacebar</b> to shoot.
    </div>
</div>

<script>
    const canvas = document.getElementById("gameCanvas");
    const ctx = canvas.getContext("2d");

    // UI Elements
    const scoreText = document.getElementById("scoreText");
    const waveText = document.getElementById("waveText");
    const livesText = document.getElementById("livesText");
    const powerupBar = document.getElementById("powerupBar");
    const overlay = document.getElementById("gameOverlay");
    const overlayTitle = document.getElementById("overlayTitle");
    const overlaySub = document.getElementById("overlaySub");
    const startBtn = document.getElementById("startBtn");

    const keys = { Left: false, Right: false, Space: false };

    // Game Variables
    let gameLoopId;
    let isRunning = false;
    let score = 0;
    let wave = 1;
    let lives = 3;
    let lastShootTime = 0;

    // Power-up state timers
    let rapidFireTimer = 0;
    let hasShield = false;

    // Game Objects
    let player;
    let bullets = [];
    let enemies = [];
    let particles = [];
    let powerups = [];

    window.addEventListener("keydown", (e) => {
        if (e.code === "ArrowLeft" || e.code === "KeyA") keys.Left = true;
        if (e.code === "ArrowRight" || e.code === "KeyD") keys.Right = true;
        if (e.code === "Space") {
            keys.Space = true;
            e.preventDefault();
        }
    });

    window.addEventListener("keyup", (e) => {
        if (e.code === "ArrowLeft" || e.code === "KeyA") keys.Left = false;
        if (e.code === "ArrowRight" || e.code === "KeyD") keys.Right = false;
        if (e.code === "Space") keys.Space = false;
    });

    // Player Class
    class Player {
        constructor() {
            this.width = 30;
            this.height = 20;
            this.x = canvas.width / 2 - this.width / 2;
            this.y = canvas.height - 40;
            this.speed = 5;
        }

        draw() {
            // Draw Shield Bubble if Active
            if (hasShield) {
                ctx.save();
                ctx.strokeStyle = "#38bdf8";
                ctx.lineWidth = 2;
                ctx.shadowColor = "#38bdf8";
                ctx.shadowBlur = 8;
                ctx.beginPath();
                ctx.arc(this.x + this.width / 2, this.y + this.height / 2, 22, 0, Math.PI * 2);
                ctx.stroke();
                ctx.restore();
            }

            // Draw Ship Body
            ctx.fillStyle = "#60a5fa";
            ctx.beginPath();
            ctx.moveTo(this.x + this.width / 2, this.y);
            ctx.lineTo(this.x, this.y + this.height);
            ctx.lineTo(this.x + this.width, this.y + this.height);
            ctx.closePath();
            ctx.fill();
        }

        update() {
            if (keys.Left && this.x > 0) this.x -= this.speed;
            if (keys.Right && this.x + this.width < canvas.width) this.x += this.speed;
        }
    }

    // Bullet Class
    class Bullet {
        constructor(x, y) {
            this.x = x;
            this.y = y;
            this.radius = rapidFireTimer > 0 ? 4 : 3;
            this.speed = 8;
        }

        draw() {
            ctx.fillStyle = rapidFireTimer > 0 ? "#facc15" : "#38bdf8";
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
            ctx.fill();
        }

        update() {
            this.y -= this.speed;
        }
    }

    // Enemy Class
    class Enemy {
        constructor(x, y) {
            this.x = x;
            this.y = y;
            this.width = 24;
            this.height = 20;
            this.speed = 1 + wave * 0.2;
        }

        draw() {
            ctx.fillStyle = "#f87171";
            ctx.fillRect(this.x, this.y, this.width, this.height);

            ctx.fillStyle = "#020617";
            ctx.fillRect(this.x + 4, this.y + 4, 4, 4);
            ctx.fillRect(this.x + 16, this.y + 4, 4, 4);
        }

        update(direction) {
            this.x += direction * this.speed;
        }
    }

    // Power-up Gift Class
    class PowerUp {
        constructor(x, y, type) {
            this.x = x;
            this.y = y;
            this.type = type; // 'rapid', 'shield', 'life'
            this.radius = 10;
            this.speed = 2;
        }

        draw() {
            ctx.save();
            ctx.font = "14px Segoe UI";
            ctx.textAlign = "center";
            ctx.textBaseline = "middle";

            let icon = "⚡";
            if (this.type === 'shield') icon = "🛡️";
            if (this.type === 'life') icon = "❤️";

            ctx.fillText(icon, this.x, this.y);
            ctx.restore();
        }

        update() {
            this.y += this.speed;
        }
    }

    // Particle Explosion Class
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

    function spawnEnemies() {
        enemies = [];
        const rows = 3 + Math.min(wave, 3);
        const cols = 7;
        const padding = 12;
        const offsetTop = 40;
        const offsetLeft = 30;

        for (let r = 0; r < rows; r++) {
            for (let c = 0; c < cols; c++) {
                let x = offsetLeft + c * (24 + padding);
                let y = offsetTop + r * (20 + padding);
                enemies.push(new Enemy(x, y));
            }
        }
    }

    function createExplosion(x, y, color) {
        for (let i = 0; i < 12; i++) {
            particles.push(new Particle(x, y, color));
        }
    }

    let enemyDirection = 1;

    function gameLoop(timestamp) {
        if (!isRunning) return;

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Update Timers & UI Bar
        updatePowerupStatus();

        // 1. Update Player
        player.update();
        player.draw();

        // 2. Firing Logic (Faster cooldown when Rapid Fire is active)
        const fireInterval = rapidFireTimer > 0 ? 100 : 260; // 100ms vs 260ms
        if (keys.Space && timestamp - lastShootTime > fireInterval) {
            bullets.push(new Bullet(player.x + player.width / 2, player.y));
            lastShootTime = timestamp;
        }

        // 3. Bullets Loop
        bullets.forEach((bullet, index) => {
            bullet.update();
            bullet.draw();
            if (bullet.y < 0) bullets.splice(index, 1);
        });

        // 4. Power-ups Falling & Collision
        powerups.forEach((pu, index) => {
            pu.update();
            pu.draw();

            // Collision with Player
            let dist = Math.hypot(pu.x - (player.x + player.width / 2), pu.y - (player.y + player.height / 2));
            if (dist < pu.radius + 15) {
                applyPowerup(pu.type);
                createExplosion(pu.x, pu.y, "#facc15");
                powerups.splice(index, 1);
            } else if (pu.y > canvas.height) {
                powerups.splice(index, 1);
            }
        });

        // 5. Enemies Movement
        let touchEdge = false;
        enemies.forEach(enemy => {
            if ((enemy.x + enemy.width >= canvas.width && enemyDirection > 0) || (enemy.x <= 0 && enemyDirection < 0)) {
                touchEdge = true;
            }
        });

        if (touchEdge) {
            enemyDirection *= -1;
            enemies.forEach(enemy => { enemy.y += 12; });
        }

        // 6. Enemies Loop & Collision
        enemies.forEach((enemy, eIndex) => {
            enemy.update(enemyDirection);
            enemy.draw();

            if (enemy.y + enemy.height >= player.y) {
                takeDamage();
            }

            bullets.forEach((bullet, bIndex) => {
                if (
                    bullet.x > enemy.x &&
                    bullet.x < enemy.x + enemy.width &&
                    bullet.y > enemy.y &&
                    bullet.y < enemy.y + enemy.height
                ) {
                    createExplosion(enemy.x + enemy.width / 2, enemy.y + enemy.height / 2, "#f87171");

                    // 20% Chance to Drop a Power-up
                    if (Math.random() < 0.20) {
                        const types = ['rapid', 'shield', 'life'];
                        const selectedType = types[Math.floor(Math.random() * types.length)];
                        powerups.push(new PowerUp(enemy.x + enemy.width / 2, enemy.y, selectedType));
                    }

                    enemies.splice(eIndex, 1);
                    bullets.splice(bIndex, 1);
                    score += 10;
                    scoreText.innerText = score;
                }
            });
        });

        // Next Wave Check
        if (enemies.length === 0) {
            wave++;
            waveText.innerText = wave;
            spawnEnemies();
        }

        // 7. Explosions Loop
        particles.forEach((particle, index) => {
            particle.update();
            particle.draw();
            if (particle.alpha <= 0) particles.splice(index, 1);
        });

        gameLoopId = requestAnimationFrame(gameLoop);
    }

    function applyPowerup(type) {
        if (type === 'rapid') {
            rapidFireTimer = 360; // ~6 seconds (60 FPS * 6)
        } else if (type === 'shield') {
            hasShield = true;
        } else if (type === 'life') {
            if (lives < 5) {
                lives++;
                livesText.innerText = "❤️".repeat(lives);
            }
        }
    }

    function updatePowerupStatus() {
        let statusHTML = "";

        if (rapidFireTimer > 0) {
            rapidFireTimer--;
            let secLeft = Math.ceil(rapidFireTimer / 60);
            statusHTML += `<span class="powerup-badge" style="color:#facc15;">⚡ Rapid Fire: ${secLeft}s</span>`;
        }

        if (hasShield) {
            statusHTML += `<span class="powerup-badge" style="color:#38bdf8;">🛡️ Shield Active</span>`;
        }

        powerupBar.innerHTML = statusHTML;
    }

    function takeDamage() {
        if (hasShield) {
            hasShield = false; // Shield absorbs hit
            createExplosion(player.x + player.width / 2, player.y, "#38bdf8");
            return;
        }

        lives--;
        livesText.innerText = "❤️".repeat(Math.max(0, lives));
        createExplosion(player.x + player.width / 2, player.y, "#60a5fa");

        if (lives <= 0) {
            endGame();
        } else {
            spawnEnemies();
        }
    }

    function startGame() {
        score = 0;
        wave = 1;
        lives = 3;
        rapidFireTimer = 0;
        hasShield = false;

        scoreText.innerText = score;
        waveText.innerText = wave;
        livesText.innerText = "❤️❤️❤️";

        player = new Player();
        bullets = [];
        particles = [];
        powerups = [];
        spawnEnemies();

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
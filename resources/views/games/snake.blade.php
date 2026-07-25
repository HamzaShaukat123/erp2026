<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Snake Game</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            background: #111;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial;
            color: white;
        }

        .game-container {
            text-align: center;
        }

        canvas {
            background: #000;
            border: 3px solid #17365D;
        }

        .score {
            margin-bottom: 10px;
            font-size: 20px;
        }
    </style>
</head>
<body>

<div class="game-container">
    <div class="score">Score: <span id="score">0</span></div>
    <canvas id="game" width="400" height="400"></canvas>
</div>

<script>
    const canvas = document.getElementById("game");
    const ctx = canvas.getContext("2d");

    const grid = 20;
    let count = 0;

    let snake = {
        x: 160,
        y: 160,
        dx: grid,
        dy: 0,
        cells: [],
        maxCells: 4
    };

    let apple = {
        x: 320,
        y: 320
    };

    let score = 0;

    function getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min)) + min;
    }

    function gameLoop() {
        requestAnimationFrame(gameLoop);

        if (++count < 12) return;
        count = 0;

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        snake.x += snake.dx;
        snake.y += snake.dy;

        // wall collision
        if (snake.x < 0) snake.x = canvas.width - grid;
        else if (snake.x >= canvas.width) snake.x = 0;

        if (snake.y < 0) snake.y = canvas.height - grid;
        else if (snake.y >= canvas.height) snake.y = 0;

        snake.cells.unshift({x: snake.x, y: snake.y});

        if (snake.cells.length > snake.maxCells) {
            snake.cells.pop();
        }

        // draw apple
        ctx.fillStyle = "red";
        ctx.fillRect(apple.x, apple.y, grid-1, grid-1);

        // draw snake
        ctx.fillStyle = "#00ff88";
        snake.cells.forEach(function(cell, index) {
            ctx.fillRect(cell.x, cell.y, grid-1, grid-1);

            // eat apple
            if (cell.x === apple.x && cell.y === apple.y) {
                snake.maxCells++;
                score++;
                document.getElementById("score").innerText = score;

                apple.x = getRandomInt(0, 20) * grid;
                apple.y = getRandomInt(0, 20) * grid;
            }

            // self collision
            for (let i = index + 1; i < snake.cells.length; i++) {
                if (cell.x === snake.cells[i].x && cell.y === snake.cells[i].y) {
                    snake.x = 160;
                    snake.y = 160;
                    snake.cells = [];
                    snake.maxCells = 4;
                    snake.dx = grid;
                    snake.dy = 0;
                    score = 0;
                    document.getElementById("score").innerText = score;
                }
            }
        });
    }

    document.addEventListener("keydown", function(e) {
        if (e.which === 37 && snake.dx === 0) {
            snake.dx = -grid;
            snake.dy = 0;
        } else if (e.which === 38 && snake.dy === 0) {
            snake.dy = -grid;
            snake.dx = 0;
        } else if (e.which === 39 && snake.dx === 0) {
            snake.dx = grid;
            snake.dy = 0;
        } else if (e.which === 40 && snake.dy === 0) {
            snake.dy = grid;
            snake.dx = 0;
        }
    });

    requestAnimationFrame(gameLoop);
</script>

</body>
</html>
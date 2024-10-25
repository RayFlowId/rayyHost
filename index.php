<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Spike Game</title>
    <style>
        body {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #87CEEB;
        }
        #gameCanvas {
            background-color: #ffffff;
            border: 1px solid #000;
        }
    </style>
</head>
<body>
    <canvas id="gameCanvas" width="400" height="400"></canvas>
    <script>
        const canvas = document.getElementById('gameCanvas');
        const ctx = canvas.getContext('2d');

        let player = { x: 50, y: 350, width: 30, height: 30, dy: 0, gravity: 0.5, jumpPower: -10, isJumping: false };
        let spikes = [];
        let score = 0;
        let gameOver = false;

        function createSpike() {
            const spike = { x: canvas.width, y: 370, width: 30, height: 30 };
            spikes.push(spike);
        }

        function drawPlayer() {
            ctx.fillStyle = 'blue';
            ctx.fillRect(player.x, player.y, player.width, player.height);
        }

        function drawSpikes() {
            ctx.fillStyle = 'red';
            for (let spike of spikes) {
                ctx.fillRect(spike.x, spike.y, spike.width, spike.height);
            }
        }

        function update() {
            if (!gameOver) {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                player.dy += player.gravity;
                player.y += player.dy;

                if (player.y + player.height >= canvas.height) {
                    player.y = canvas.height - player.height;
                    player.isJumping = false;
                }

                if (player.isJumping) {
                    player.dy = player.jumpPower;
                }

                for (let spike of spikes) {
                    spike.x -= 5;
                    if (spike.x < -spike.width) {
                        spikes.shift();
                        score++;
                    }

                    // Collision detection
                    if (player.x < spike.x + spike.width &&
                        player.x + player.width > spike.x &&
                        player.y < spike.y + spike.height &&
                        player.y + player.height > spike.y) {
                        gameOver = true;
                    }
                }

                drawPlayer();
                drawSpikes();
                requestAnimationFrame(update);
            } else {
                ctx.fillStyle = 'black';
                ctx.font = '30px Arial';
                ctx.fillText('Game Over!', 120, 200);
                ctx.fillText('Score: ' + score, 150, 250);
            }
        }

        document.addEventListener('keydown', (e) => {
            if (e.code === 'Space' && !player.isJumping) {
                player.isJumping = true;
                player.dy = player.jumpPower;
            }
        });

        setInterval(createSpike, 2000);
        update();
    </script>
</body>
  </html>

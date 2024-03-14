const canvas = document.getElementById("myCanvas1");
const ctx = canvas.getContext("2d");
let isDrawing = false;

// キャンバスのサイズを画面のサイズに合わせる
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

// マウスイベントが発生した場所をキャンバス内の座標に変換する関数
function getCanvasCoordinates(event, canvas) {
    const rect = canvas.getBoundingClientRect();
    const scaleX = canvas.width / rect.width;
    const scaleY = canvas.height / rect.height;

    return {
        x: (event.clientX - rect.left) * scaleX,
        y: (event.clientY - rect.top) * scaleY
    };
}

canvas.addEventListener("mousemove", (event) => {
    const { x, y } = getCanvasCoordinates(event, canvas);
    draw(x, y);
});

canvas.addEventListener("mousedown", () => (isDrawing = true));
canvas.addEventListener("mouseup", () => (isDrawing = false));

canvas.addEventListener("mousemove", (event) => {
    if (isDrawing) {
        const { x, y } = getCanvasCoordinates(event, canvas);
        draw(x, y);
    }
});

function draw(x, y) {
    if (isDrawing) {
        ctx.beginPath();
        ctx.arc(x, y, 10, 0, Math.PI * 2);
        ctx.closePath();
        ctx.fill();
    }
}

window.addEventListener("resize", () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
});
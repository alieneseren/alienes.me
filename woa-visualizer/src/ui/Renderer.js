export class Renderer {
    constructor(canvas) {
        this.canvas = canvas;
        this.ctx = canvas.getContext('2d', { alpha: false }); // Optimize for no transparency on bg
        this.width = canvas.width;
        this.height = canvas.height;
        this.offscreenCanvas = document.createElement('canvas'); // Cache background
        this.offscreenCtx = this.offscreenCanvas.getContext('2d');
    }

    resize(width, height) {
        this.width = width;
        this.height = height;
        this.canvas.width = width;
        this.canvas.height = height;
        this.offscreenCanvas.width = width;
        this.offscreenCanvas.height = height;
    }

    // Draw the heatmap of the function once
    drawFunctionMap(funcObj) {
        const { func, bounds } = funcObj;
        const [min, max] = bounds;
        const width = this.width;
        const height = this.height;
        const ctx = this.offscreenCtx;

        // Optimization: Draw in low res blocks for performance, or pixel by pixel?
        // Let's do a decent resolution (e.g. 2px blocks) for speed
        const blockSize = 4;
        const cols = Math.ceil(width / blockSize);
        const rows = Math.ceil(height / blockSize);

        // Find min/max values for normalization (approximate by sampling)
        let minZ = Infinity;
        let maxZ = -Infinity;

        // First pass: find range
        // Note: For visualization, we often know the range or can cap it.
        // But let's verify.
        for (let i = 0; i < cols; i += 2) { // sparse sampling
            for (let j = 0; j < rows; j += 2) {
                const x = min + (i * blockSize / width) * (max - min);
                const y = min + (j * blockSize / height) * (max - min);
                const z = func(x, y);
                if (z < minZ) minZ = z;
                if (z > maxZ) maxZ = z;
            }
        }

        // Logarithmic scale for better visualization of minima usually
        // But for general purpose, linear coloring from specific palette

        for (let i = 0; i < cols; i++) {
            for (let j = 0; j < rows; j++) {
                const x = min + (i * blockSize / width) * (max - min);
                const y = min + (j * blockSize / height) * (max - min);
                const z = func(x, y);

                // Create color
                // Map z to 0-1
                let t = (z - minZ) / (maxZ - minZ + 0.0001);
                // Clamp t
                t = Math.max(0, Math.min(1, t));

                // Color map: Dark Blue (low) -> Cyan -> Green -> Yellow -> Red (high)
                // Actually usually optimization seeks minimum. 
                // So let's make Minimum (low z) bright/distinct, and High z dark or inverse.
                // Standard: Blue (low) to Red (high).

                // Using HSL: 240 (Blue) -> 0 (Red)
                const hue = 240 - (t * 240);
                const lightness = 50 - (t * 20); // Darker at high peaks

                ctx.fillStyle = `hsl(${hue}, 70%, ${lightness}%)`;
                ctx.fillRect(i * blockSize, j * blockSize, blockSize, blockSize);
            }
        }
    }

    draw(whales, bounds) {
        // Draw background from offscreen canvas
        this.ctx.drawImage(this.offscreenCanvas, 0, 0);

        // Draw whales
        const [min, max] = bounds;

        this.ctx.fillStyle = 'rgba(255, 255, 255, 0.9)';
        this.ctx.shadowBlur = 10;
        this.ctx.shadowColor = 'white';

        for (let whale of whales) {
            const [wx, wy] = whale.position;

            // Map coordinates to canvas
            const cx = ((wx - min) / (max - min)) * this.width;
            const cy = ((wy - min) / (max - min)) * this.height;

            // Simple circle for agent
            this.ctx.beginPath();
            this.ctx.arc(cx, cy, 3, 0, Math.PI * 2);
            this.ctx.fill();
        }

        this.ctx.shadowBlur = 0;
    }
}

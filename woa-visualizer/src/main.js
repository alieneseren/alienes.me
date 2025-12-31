import { WOA } from './core/WOA.js';
import { Functions } from './core/Functions.js';
import { Renderer } from './ui/Renderer.js';

// State
let woa;
let renderer;
let isRunning = false;
let animationId;
let currentFunc = Functions.sphere;
let speed = 60; // FPS target

// Chart State
let fitnessHistory = [];
const maxHistory = 100;

// DOM Elements
const canvas = document.getElementById('visualizer');
const chartCanvas = document.getElementById('fitness-chart');
const chartCtx = chartCanvas.getContext('2d');

const startBtn = document.getElementById('start-btn');
const resetBtn = document.getElementById('reset-btn');
const funcSelect = document.getElementById('function-select');
const popInput = document.getElementById('pop-size');
const popVal = document.getElementById('pop-val');
const speedInput = document.getElementById('speed-control');
const speedVal = document.getElementById('speed-val');

const iterEl = document.getElementById('iter-count');
const fitEl = document.getElementById('best-fit');
const posEl = document.getElementById('best-pos');

// Initialize
function init() {
  renderer = new Renderer(canvas);
  handleResize();

  // Set initial speed
  speed = parseInt(speedInput.value);

  // Initial Setup
  createSimulation();

  // Event Listeners
  window.addEventListener('resize', handleResize);

  funcSelect.addEventListener('change', (e) => {
    currentFunc = Functions[e.target.value];
    stopSimulation();
    createSimulation();
  });

  popInput.addEventListener('input', (e) => {
    popVal.textContent = e.target.value;
  });

  popInput.addEventListener('change', () => {
    stopSimulation();
    createSimulation();
  });

  speedInput.addEventListener('input', (e) => {
    speed = parseInt(e.target.value);
    speedVal.textContent = speed;
  });

  startBtn.addEventListener('click', toggleSimulation);
  resetBtn.addEventListener('click', resetSimulation);
}

function handleResize() {
  const parent = canvas.parentElement;
  renderer.resize(parent.clientWidth, parent.clientHeight);
  if (renderer && currentFunc) {
    renderer.drawFunctionMap(currentFunc);
    if (woa) renderer.draw(woa.whales, currentFunc.bounds);
  }
}

function createSimulation() {
  const popSize = parseInt(popInput.value);
  woa = new WOA(currentFunc, popSize);
  woa.init();

  fitnessHistory = [];
  chartCtx.clearRect(0, 0, chartCanvas.width, chartCanvas.height);

  // Redraw background map since it might depend on resolution or if function changed
  renderer.drawFunctionMap(currentFunc);
  updateUI();
  renderer.draw(woa.whales, currentFunc.bounds);
}

function toggleSimulation() {
  if (isRunning) {
    stopSimulation();
  } else {
    startSimulation();
  }
}

function startSimulation() {
  if (isRunning) return;
  isRunning = true;
  startBtn.textContent = 'Durdur';
  startBtn.style.backgroundColor = '#f43f5e'; // Reddish for stop/pause
  startBtn.style.backgroundImage = 'none';

  loop();
}

function stopSimulation() {
  isRunning = false;
  cancelAnimationFrame(animationId);
  startBtn.textContent = 'Simülasyonu Başlat';
  startBtn.style.backgroundColor = ''; // Revert to default
  startBtn.style.backgroundImage = '';
}

function resetSimulation() {
  stopSimulation();
  createSimulation();
}

let lastFrameTime = 0;

function loop(timestamp) {
  if (!isRunning) return;

  // Throttle FPS
  const interval = 1000 / speed;
  if (timestamp - lastFrameTime < interval) {
    animationId = requestAnimationFrame(loop);
    return;
  }
  lastFrameTime = timestamp;

  // Run one step
  const result = woa.step(500);

  updateUI();
  updateChart();
  renderer.draw(woa.whales, currentFunc.bounds);

  if (result && result.iteration < 500) {
    animationId = requestAnimationFrame(loop);
  } else {
    stopSimulation();
    startBtn.textContent = 'Tamamlandı';
    startBtn.style.backgroundColor = '#10b981';
  }
}

function updateChart() {
  if (!woa.bestWhale) return;

  fitnessHistory.push(woa.bestWhale.fitness);
  if (fitnessHistory.length > maxHistory) {
    fitnessHistory.shift();
  }

  const w = chartCanvas.width;
  const h = chartCanvas.height;
  chartCtx.clearRect(0, 0, w, h);

  // Draw background grid
  chartCtx.strokeStyle = 'rgba(255, 255, 255, 0.1)';
  chartCtx.lineWidth = 1;
  chartCtx.beginPath();
  chartCtx.moveTo(0, h / 2);
  chartCtx.lineTo(w, h / 2);
  chartCtx.stroke();

  if (fitnessHistory.length < 2) return;

  // Normalize values
  const min = Math.min(...fitnessHistory);
  const max = Math.max(...fitnessHistory);
  const range = max - min || 1;

  chartCtx.beginPath();
  chartCtx.strokeStyle = '#22d3ee';
  chartCtx.lineWidth = 2;

  for (let i = 0; i < fitnessHistory.length; i++) {
    const x = (i / (maxHistory - 1)) * w;
    // Invert Y because canvas 0 is top
    const normalized = (fitnessHistory[i] - min) / range;
    const y = h - (normalized * (h - 10) + 5); // Padding 5px

    if (i === 0) chartCtx.moveTo(x, y);
    else chartCtx.lineTo(x, y);
  }
  chartCtx.stroke();
}

function updateUI() {
  iterEl.textContent = woa.iteration;
  fitEl.textContent = woa.bestWhale.fitness.toFixed(9);
  posEl.textContent = `(${woa.bestWhale.position[0].toFixed(2)}, ${woa.bestWhale.position[1].toFixed(2)})`;
}

// Start
init();

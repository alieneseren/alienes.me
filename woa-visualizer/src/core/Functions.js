/**
 * Benchmark Functions for Optimization
 */

export const Functions = {
    sphere: {
        name: 'Sphere',
        func: (x, y) => x * x + y * y,
        bounds: [-10, 10],
        globalMin: 0,
        at: [0, 0]
    },
    rastrigin: {
        name: 'Rastrigin',
        func: (x, y) => {
            const A = 10;
            return A * 2 + (x * x - A * Math.cos(2 * Math.PI * x)) + (y * y - A * Math.cos(2 * Math.PI * y));
        },
        bounds: [-5.12, 5.12],
        globalMin: 0,
        at: [0, 0]
    },
    ackley: {
        name: 'Ackley',
        func: (x, y) => {
            return -20 * Math.exp(-0.2 * Math.sqrt(0.5 * (x * x + y * y))) -
                Math.exp(0.5 * (Math.cos(2 * Math.PI * x) + Math.cos(2 * Math.PI * y))) +
                Math.E + 20;
        },
        bounds: [-5, 5],
        globalMin: 0,
        at: [0, 0]
    },
    booth: {
        name: 'Booth',
        func: (x, y) => {
            return Math.pow(x + 2 * y - 7, 2) + Math.pow(2 * x + y - 5, 2);
        },
        bounds: [-10, 10],
        globalMin: 0,
        at: [1, 3]
    },
    rosenbrock: {
        name: 'Rosenbrock',
        func: (x, y) => {
            return 100 * Math.pow(y - x * x, 2) + Math.pow(1 - x, 2);
        },
        bounds: [-5, 10],
        globalMin: 0,
        at: [1, 1]
    },
    griewank: {
        name: 'Griewank',
        func: (x, y) => {
            return 1 + (x * x + y * y) / 4000 - Math.cos(x) * Math.cos(y / Math.sqrt(2));
        },
        bounds: [-10, 10],
        globalMin: 0,
        at: [0, 0]
    }
};

/**
 * Whale Optimization Algorithm (WOA) Implementation
 * Based on Mirjalili and Lewis (2016)
 */

export class WOA {
    constructor(funcObj, popSize = 50) {
        this.func = funcObj.func;
        this.bounds = funcObj.bounds;
        this.popSize = popSize;
        this.dimension = 2; // Fixed for visualization

        this.whales = [];
        this.bestWhale = { position: [0, 0], fitness: Infinity };
        this.iteration = 0;

        // History for visualization trails (optional, can affect performance)
        this.history = [];
    }

    init() {
        this.iteration = 0;
        this.whales = [];
        this.bestWhale = { position: [0, 0], fitness: Infinity };

        for (let i = 0; i < this.popSize; i++) {
            const x = Math.random() * (this.bounds[1] - this.bounds[0]) + this.bounds[0];
            const y = Math.random() * (this.bounds[1] - this.bounds[0]) + this.bounds[0];
            const fitness = this.func(x, y);

            const whale = {
                position: [x, y],
                fitness: fitness
            };

            this.whales.push(whale);

            if (fitness < this.bestWhale.fitness) {
                this.bestWhale = {
                    position: [...whale.position],
                    fitness: fitness
                };
            }
        }
    }

    // Main loop step
    step(maxIter) {
        if (this.iteration >= maxIter) return;

        const a = 2 - this.iteration * (2 / maxIter); // Linearly decreased from 2 to 0

        for (let i = 0; i < this.popSize; i++) {
            const r1 = Math.random();
            const r2 = Math.random();

            const A = 2 * a * r1 - a;
            const C = 2 * r2;

            const b = 1;
            const l = (Math.random() * 2) - 1; // Random number in [-1, 1]
            const p = Math.random();

            let newPos = [...this.whales[i].position];
            const leaderPos = this.bestWhale.position;

            if (p < 0.5) {
                if (Math.abs(A) < 1) {
                    // Update position of the current search agent by the Equation (2.1)
                    for (let j = 0; j < this.dimension; j++) {
                        const D = Math.abs(C * leaderPos[j] - newPos[j]);
                        newPos[j] = leaderPos[j] - A * D;
                    }
                } else {
                    // Select a random search agent
                    const randIdx = Math.floor(Math.random() * this.popSize);
                    const randWhalePos = this.whales[randIdx].position;

                    for (let j = 0; j < this.dimension; j++) {
                        const D = Math.abs(C * randWhalePos[j] - newPos[j]);
                        newPos[j] = randWhalePos[j] - A * D;
                    }
                }
            } else {
                // Spiral updating position
                for (let j = 0; j < this.dimension; j++) {
                    const D_prime = Math.abs(leaderPos[j] - newPos[j]);
                    newPos[j] = D_prime * Math.exp(b * l) * Math.cos(2 * Math.PI * l) + leaderPos[j];
                }
            }

            // Check boundaries
            for (let j = 0; j < this.dimension; j++) {
                if (newPos[j] < this.bounds[0]) newPos[j] = this.bounds[0];
                if (newPos[j] > this.bounds[1]) newPos[j] = this.bounds[1];
            }

            this.whales[i].position = newPos;
        }

        // Calculate fitness and update best
        for (let i = 0; i < this.popSize; i++) {
            const [x, y] = this.whales[i].position;
            const fitness = this.func(x, y);
            this.whales[i].fitness = fitness;

            if (fitness < this.bestWhale.fitness) {
                this.bestWhale = {
                    position: [x, y],
                    fitness: fitness
                };
            }
        }

        this.iteration++;
        return {
            iteration: this.iteration,
            bestFitness: this.bestWhale.fitness,
            whales: this.whales
        };
    }
}

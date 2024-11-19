export default class ScenariosBuilder {
  constructor() {
    this.scenarios = {};
  }

  addSmokeScenario(smokeConfig) {
    this.scenarios.smoke = {
      executor: 'constant-arrival-rate',
      rate: smokeConfig.rps,
      timeUnit: '1s',
      duration: `${smokeConfig.duration}s`,
      preAllocatedVUs: smokeConfig.vus,
      tags: { test_type: 'smoke' },
    };

    return this;
  }

  addAverageScenario(averageConfig, startTime) {
    return this.addDefaultScenario('average', averageConfig, startTime);
  }

  addStressScenario(stressConfig, startTime) {
    return this.addDefaultScenario('stress', stressConfig, startTime);
  }

  addSpikeScenario(spikeConfig, startTime) {
    this.scenarios.spike = {
      executor: 'ramping-arrival-rate',
      startRate: 0,
      timeUnit: '1s',
      preAllocatedVUs: spikeConfig.vus,
      stages: [
        {
          target: spikeConfig.rps,
          duration: `${spikeConfig.duration.rise}s`,
        },
        {
          target: 0,
          duration: `${spikeConfig.duration.fall}s`,
        },
      ],
      startTime: `${startTime}s`,
      tags: { test_type: 'spike' },
    };

    return this;
  }

  addDefaultScenario(scenarioName, config, startTime) {
    this.scenarios[scenarioName] = {
      executor: 'ramping-arrival-rate',
      startRate: 0,
      timeUnit: '1s',
      preAllocatedVUs: config.vus,
      stages: [
        {
          target: config.rps,
          duration: `${config.duration.rise}s`,
        },
        {
          target: config.rps,
          duration: `${config.duration.plateau}s`,
        },
        {
          target: 0,
          duration: `${config.duration.fall}s`,
        },
      ],
      startTime: `${startTime}s`,
      tags: { test_type: scenarioName },
    };

    return this;
  }

  build() {
    return this.scenarios;
  }
}

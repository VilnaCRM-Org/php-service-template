import ScenariosBuilder from './scenariosBuilder.js';
import ThresholdsBuilder from './thresholdsBuilder.js';

export default class ScenarioUtils {
  constructor(utils, scenarioName) {
    this.utils = utils;
    this.config = utils.getConfig();
    this.smokeConfig = this.config.endpoints[scenarioName].smoke;
    this.averageConfig = this.config.endpoints[scenarioName].average;
    this.stressConfig = this.config.endpoints[scenarioName].stress;
    this.spikeConfig = this.config.endpoints[scenarioName].spike;
    this.setupTimeout = `${this.config.endpoints[scenarioName].setupTimeoutInMinutes}m`;
    this.teardownTimeout = `${this.config.endpoints[scenarioName].teardownTimeoutInMinutes}m`;
    this.delay = this.config.delayBetweenScenarios;
    this.averageTestStartTime = 0;
    this.stressTestStartTime = 0;
    this.spikeTestStartTime = 0;
  }

  getOptions() {
    return {
      setupTimeout: this.setupTimeout,
      teardownTimeout: this.teardownTimeout,
      insecureSkipTLSVerify: true,
      scenarios: this.getScenarios(),
      thresholds: this.getThresholds(),
      batchPerHost: this.config.batchSize,
    };
  }

  getScenarios() {
    const scenariosBuilder = new ScenariosBuilder();
    const scenarioFunctions = {
      run_smoke: this.addSmokeScenario.bind(this, scenariosBuilder),
      run_average: this.addAverageScenario.bind(this, scenariosBuilder),
      run_stress: this.addStressScenario.bind(this, scenariosBuilder),
      run_spike: this.addSpikeScenario.bind(this, scenariosBuilder),
    };

    Object.keys(scenarioFunctions).forEach(key => {
      if (this.utils.getCLIVariable(key) !== 'false') {
        scenarioFunctions[key]();
      }
    });

    return scenariosBuilder.build();
  }

  addSmokeScenario(scenariosBuilder) {
    scenariosBuilder.addSmokeScenario(this.smokeConfig);
    this.averageTestStartTime = this.smokeConfig.duration + this.delay;
  }

  addAverageScenario(scenariosBuilder) {
    scenariosBuilder.addAverageScenario(this.averageConfig, this.averageTestStartTime);
    this.stressTestStartTime =
      this.averageTestStartTime +
      this.averageConfig.duration.rise +
      this.averageConfig.duration.plateau +
      this.averageConfig.duration.fall +
      this.delay;
  }

  addStressScenario(scenariosBuilder) {
    scenariosBuilder.addStressScenario(this.stressConfig, this.stressTestStartTime);
    this.spikeTestStartTime =
      this.stressTestStartTime +
      this.stressConfig.duration.rise +
      this.stressConfig.duration.plateau +
      this.stressConfig.duration.fall +
      this.delay;
  }

  addSpikeScenario(scenariosBuilder) {
    scenariosBuilder.addSpikeScenario(this.spikeConfig, this.spikeTestStartTime);
  }

  getThresholds() {
    const thresholdsBuilder = new ThresholdsBuilder();
    const thresholdConfigs = {
      run_smoke: { name: 'smoke', config: this.smokeConfig },
      run_average: { name: 'average', config: this.averageConfig },
      run_stress: { name: 'stress', config: this.stressConfig },
      run_spike: { name: 'spike', config: this.spikeConfig },
    };

    Object.keys(thresholdConfigs).forEach(key => {
      if (this.utils.getCLIVariable(key) !== 'false') {
        const { name, config } = thresholdConfigs[key];
        thresholdsBuilder.addThreshold(name, config);
      }
    });

    return thresholdsBuilder.build();
  }
}

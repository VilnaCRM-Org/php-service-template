import http from 'k6/http';
import exec from 'k6/x/exec';

export default class InsertUsersUtils {
    constructor(utils, scenarioName) {
        this.utils = utils;
        this.config = utils.getConfig();
        this.scenarioName = scenarioName;
        this.smokeConfig = this.config.endpoints[scenarioName].smoke;
        this.averageConfig = this.config.endpoints[scenarioName].average;
        this.stressConfig = this.config.endpoints[scenarioName].stress;
        this.spikeConfig = this.config.endpoints[scenarioName].spike;
    }
    countTotalRequest() {
        const requestsMap = {
            'run_smoke': this.countSmokeRequest.bind(this),
            'run_average': this.countAverageRequest.bind(this),
            'run_stress': this.countStressRequest.bind(this),
            'run_spike': this.countSpikeRequest.bind(this)
        };

        let totalRequests = 0;

        for (const key in requestsMap) {
            if (this.utils.getCLIVariable(key) !== 'false') {
                totalRequests += requestsMap[key]();
            }
        }

        return Math.round(totalRequests * this.additionalUsersRatio);
    }

    countSmokeRequest() {
        return this.smokeConfig.rps * this.smokeConfig.duration;
    }

    countAverageRequest() {
        return this.countDefaultRequests(this.averageConfig);
    }

    countStressRequest() {
        return this.countDefaultRequests(this.stressConfig);
    }

    countDefaultRequests(config) {
        const riseRequests = this.countRequestForRampingRate(
                0,
                config.rps,
                config.duration.rise
            );

        const plateauRequests = config.rps * config.duration.plateau;

        const fallRequests = this.countRequestForRampingRate(
                config.rps,
                0, config.duration.fall
            );

        return riseRequests + plateauRequests + fallRequests;
    }

    countSpikeRequest() {
        const spikeRiseRequests = this.countRequestForRampingRate(
                0,
                this.spikeConfig.rps,
                this.spikeConfig.duration.rise
            );

        const spikeFallRequests = this.countRequestForRampingRate(
                this.spikeConfig.rps,
                0, this.spikeConfig.duration.fall
            );

        return spikeRiseRequests + spikeFallRequests;
    }
}
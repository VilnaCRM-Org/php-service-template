export default class ThresholdsBuilder {
    constructor() {
        this.thresholds = {};
    }

    addThreshold(scenarioName, config){
        this.thresholds[`http_req_duration{test_type:${scenarioName}}`] = ['p(99)<' + config.threshold];
        this.thresholds[`checks{scenario:${scenarioName}}`] = ['rate>0.99'];
        return this;
    }

    build() {
        return this.thresholds;
    }
}

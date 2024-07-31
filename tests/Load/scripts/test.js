import http from 'k6/http';
import counter from 'k6/x/counter';
import ScenarioUtils from '../utils/scenarioUtils.js';
import Utils from '../utils/utils.js';

const scenarioName = 'healthCheck';

const utils = new Utils();
const scenarioUtils = new ScenarioUtils(utils, scenarioName);

export const options = scenarioUtils.getOptions();

export default async function healthCheck() {
    const num = counter.up();

    const response = await http.get(`${utils.getBaseHttpUrl()}/health`);

    utils.checkResponse(
        response,
        'is status 200',
        (res) => res.status === 200
    );
}

export function teardown(data) {

}

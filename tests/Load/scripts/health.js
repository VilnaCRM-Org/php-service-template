import http from 'k6/http';
import ScenarioUtils from '../utils/scenarioUtils.js';
import Utils from '../utils/utils.js';
import { sleep } from 'k6';

const scenarioName = 'health';

const utils = new Utils();
const scenarioUtils = new ScenarioUtils(utils, scenarioName);

export const options = scenarioUtils.getOptions();

sleep(5)

export default function health() {
    const response = http.get(`${utils.getBaseHttpUrl()}/health`);
    utils.checkResponse(
        response,
        'is status 204',
        (res) => res.status === 204
    );
}

import http from 'k6/http';
import ScenarioUtils from '../utils/scenarioUtils.js';
import Utils from '../utils/utils.js';

const scenarioName = 'health';

const utils = new Utils();
const scenarioUtils = new ScenarioUtils(utils, scenarioName);

export const options = scenarioUtils.getOptions();

export default function health() {
  const response = http.get(`${utils.getBaseHttpUrl()}/health`);
  utils.checkResponse(response, 'is status 204', res => res.status === 204);
}

import Utils from './utils.js';
import http from 'k6/http';

const utils = new Utils();
const scenarioName = utils.getCLIVariable('scenarioName');


export const options = {
    setupTimeout: utils.getConfig().endpoints[scenarioName].setupTimeoutInMinutes + 'm',
    stages: [
        { duration: '1s', target: 1},
    ],
    insecureSkipTLSVerify: true,
    batchPerHost: utils.getConfig().batchSize,
}
export default function func()
{
    const url = 'https://httpbin.test.k6.io/get';
    http.get(url);
}

import { check } from 'k6';
import http from 'k6/http';
import faker from 'k6/x/faker';

export default class Utils {
    constructor() {
        const host = this.getConfig().apiHost;
        const port = this.getConfig().apiPort;

        this.baseUrl = `http://${host}:${port}/api`;
        this.baseHttpUrl = this.baseUrl;
    }

    getConfig() {
        try {
            return JSON.parse(open('../config.json'));
        } catch (error) {
            try {
                return JSON.parse(open('../config.json.dist'));
            } catch (error) {
                console.log('Error occurred while trying to open config')
            }
        }
    }

    getBaseHttpUrl() {
        return this.baseHttpUrl;
    }

    getCLIVariable(variable) {
        return `${__ENV[variable]}`;
    }


   checkResponse(response, checkName, checkFunction) {
        check(response, {[checkName]: (res) => checkFunction(res)});
    }

}
import { check } from 'k6';

export default class Utils {
  constructor() {
    const config = this.getConfig();
    const host = config.apiHost;
    const port = config.apiPort;

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
        console.error('Failed to load configuration from config.json and config.json.dist:', error);
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
    check(response, { [checkName]: res => checkFunction(res) });
  }
}

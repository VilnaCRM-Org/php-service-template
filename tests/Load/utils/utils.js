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
    } catch (configError) {
      try {
        return JSON.parse(open('../config.json.dist'));
      } catch (fallbackError) {
        throw new Error(
          `Failed to load configuration from config.json and config.json.dist: ${configError.message}; ${fallbackError.message}`,
        );
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

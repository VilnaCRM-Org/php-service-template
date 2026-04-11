import { check } from 'k6';

export default class Utils {
  constructor() {
    const config = this.getConfig();
    const host = this.getEnv('API_HOST') ?? config.apiHost;
    const port = this.getEnv('API_PORT') ?? config.apiPort;

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

  getEnv(variable) {
    const value = typeof __ENV === 'undefined' ? undefined : __ENV[variable];

    if (value === undefined || value === null || value === '' || value === 'undefined') {
      return undefined;
    }

    return value;
  }

  getCLIVariable(variable) {
    return `${__ENV[variable]}`;
  }

  checkResponse(response, checkName, checkFunction) {
    check(response, { [checkName]: res => checkFunction(res) });
  }
}

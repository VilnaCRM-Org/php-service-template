import { check } from 'k6';

/**
 * Shared helpers for the k6 load-test scenarios.
 */
export default class Utils {
  /**
   * Builds the base API URLs from environment overrides or load-test config.
   */
  constructor() {
    const config = this.getConfig();
    const host = this.getEnv('API_HOST') ?? config.apiHost;
    const port = this.getEnv('API_PORT') ?? config.apiPort;

    this.baseUrl = `http://${host}:${port}/api`;
    this.baseHttpUrl = this.baseUrl;
  }

  /**
   * Loads the primary load-test config and falls back to the distributed template.
   *
   * @returns {{apiHost: string, apiPort: string|number}}
   */
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

  /**
   * Returns the computed base HTTP URL used by the k6 scenarios.
   *
   * @returns {string}
   */
  getBaseHttpUrl() {
    return this.baseHttpUrl;
  }

  /**
   * Reads an optional k6 environment variable and normalizes empty values.
   *
   * @param {string} variable
   * @returns {string|undefined}
   */
  getEnv(variable) {
    const value = typeof __ENV === 'undefined' ? undefined : __ENV[variable];

    if (value === undefined || value === null || value === '' || value === 'undefined') {
      return undefined;
    }

    return value;
  }

  /**
   * Returns the raw CLI variable value that k6 injected into the environment.
   *
   * @param {string} variable
   * @returns {string}
   */
  getCLIVariable(variable) {
    return `${__ENV[variable]}`;
  }

  /**
   * Runs a named k6 response assertion against the provided response.
   *
   * @param {import('k6/http').RefinedResponse<'text'>} response
   * @param {string} checkName
   * @param {(response: import('k6/http').RefinedResponse<'text'>) => boolean} checkFunction
   * @returns {void}
   */
  checkResponse(response, checkName, checkFunction) {
    check(response, { [checkName]: res => checkFunction(res) });
  }
}

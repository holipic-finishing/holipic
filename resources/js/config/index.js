/**
 * Config api domain
 * add .env
 * APP_DOMAIN=yourdomain.com
 * APP_PROTOCOL=http
 * MIX_APP_PROTOCOL="${APP_PROTOCOL}"
 * MIX_APP_DOMAIN="${APP_DOMAIN}"
 */
var APP_PROTOCOL = process.env.MIX_APP_PROTOCOL;

var APP_DOMAIN = APP_PROTOCOL + '://' + process.env.MIX_APP_DOMAIN;

export default {
  API_URL: APP_DOMAIN + '/api/',
  // API_URL: 'http://159.65.140.235/api/auth/',
  BASE_URL: APP_DOMAIN,
  // BASE_URL: 'http://159.65.140.235/',
}
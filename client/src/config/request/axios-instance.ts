import axios from 'axios'
import envConfig from '../env-config'

// constants
const CSRF_METHODS = ['POST', 'PUT', 'PATCH', 'DELETE']
const CSRF_REQUEST_URL = envConfig.SERVER_URL + '/sanctum/csrf-cookie'

// Set config defaults when creating the instance
const axiosInstance = axios.create({
  baseURL: envConfig.API_URL,
  withCredentials: true,
  headers: {
    'Content-Type': 'application/json',
    Accept: 'application/json',
  },
})

axiosInstance.interceptors.request.use(
  async (config) => {
    const needsCsrf = CSRF_METHODS.includes(config.method?.toUpperCase() || 'GET')
    console.log('needsCsrf', needsCsrf)
    if (needsCsrf) {
      // Extract CSRF token from cookies
      const csrfToken = document.cookie
        .split('; ')
        .find((row) => row.startsWith('XSRF-TOKEN='))
        ?.split('=')[1]

      // if (!csrfToken) {
      // Get CSRF cookie first
      await axios.get(CSRF_REQUEST_URL, {
        withCredentials: true,
      })
      // }

      if (csrfToken) {
        // Decode the token (Laravel encodes it)
        const decodedToken = decodeURIComponent(csrfToken)
        config.headers['X-XSRF-TOKEN'] = decodedToken
      }
    }

    return config
  },
  (error) => Promise.reject(error),
)

axiosInstance.interceptors.response.use(
  (response) => {
    return response.data
  },
  async (error) => {
    if (error.response?.status === 419) {
      await axios.get(CSRF_REQUEST_URL, { withCredentials: true })
      return axiosInstance.request(error.config) // retry original request
    }
    return Promise.reject(error)
  },
)

export default axiosInstance

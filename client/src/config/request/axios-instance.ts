import axios from 'axios'
import envConfig from '../env-config'

// constants
const CSRF_METHODS = ['POST', 'PUT', 'PATCH', 'DELETE']
const CSRF_REQUEST_URL = envConfig.SERVER_URL + '/sanctum/csrf-cookie'

// Set config defaults when creating the instance
const axiosInstance = axios.create({
  baseURL: envConfig.API_URL,
})

axiosInstance.interceptors.request.use(
  async (config) => {
    // add config here before the request is sent

    const needsCsrf = CSRF_METHODS.includes(config.method || 'GET')

    if (needsCsrf) {
      await axios.get(CSRF_REQUEST_URL, {
        withCredentials: true,
      })
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

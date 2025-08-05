import axios from 'axios'

// Set config defaults when creating the instance
const axiosInstance = axios.create({
  baseURL: 'https://api.example.com',
})

export default axiosInstance

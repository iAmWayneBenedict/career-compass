import axios from "axios";

const axiosInstance = axios.create({
  baseURL: "http://127.0.0.1:8000",
  timeout: 1000,
});

axiosInstance.defaults.withCredentials = true;
axiosInstance.defaults.withXSRFToken = true;

export default axiosInstance;

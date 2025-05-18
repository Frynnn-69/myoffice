import axios from "axios";

const API_KEY = import.meta.env.VITE_REACT_API_KEY;
const BASE_URL = import.meta.env.VITE_REACT_API_URL;
const GMAPS_API_KEY = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;

const apiClient = axios.create({
    baseURL: BASE_URL,
    headers: {
        "X-API-KEY": API_KEY,
        "X-GMAPS-API-KEY": GMAPS_API_KEY,
    },
    });

export const isAxiosError = axios.isAxiosError;

export {GMAPS_API_KEY};
export default apiClient;



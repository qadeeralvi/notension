import axios from "axios";

const defaultOptions = {
    headers: {
        // "Access-Control-Allow-Origin": "*",
        // "Content-Type": "application/json",
    },
};

const MAX_REQUESTS_COUNT = 1;
const INTERVAL_MS = 10;
let PENDING_REQUESTS = 0;

const instance = axios.create(defaultOptions);

// Request interceptor
instance.interceptors.request.use(
    function(config) 
    {
        return new Promise((resolve, reject) => {
            
            let interval = setInterval(() => 
            {
                if(PENDING_REQUESTS < MAX_REQUESTS_COUNT ) 
                {
                    PENDING_REQUESTS++
                    clearInterval(interval);

                    // Before request sent
                    // Inject in body

                    // Update accessToken in localStorage
                    // if (localStorage.getItem("accessToken")) {
                    //     config.headers.accessToken = localStorage.getItem("accessToken");
                    // }

                    resolve(config)
                }
            }, INTERVAL_MS)
        });
        
    },
    function(error) {
        // Do something with request error

        return Promise.reject(error);
    }
);

// Response interceptor
instance.interceptors.response.use(
    function(response) 
    {
        // Update accessToken in localStorage
        if (response.data.accessToken) {
            localStorage.setItem("accessToken", response.data.accessToken);
        }
        PENDING_REQUESTS = Math.max(0, PENDING_REQUESTS - 1);
        return response;
    },
    function(error) 
    {
        PENDING_REQUESTS = Math.max(0, PENDING_REQUESTS - 1);
        return Promise.reject(error);
    }
);



export default instance;


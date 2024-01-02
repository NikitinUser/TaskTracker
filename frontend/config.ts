interface AppConfig {
    apiUrl: string;
}

const config: AppConfig = {
    apiUrl: import.meta.env.VITE_APP_API_URL
};

export default config;

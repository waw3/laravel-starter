import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig(({ mode}) => {
    // Load current .env-file
    const env = loadEnv(mode, process.cwd(), '')
    // Set the host based on APP_URL
    // noinspection JSUnresolvedVariable
    let host = new URL(env.APP_URL).host


    return {
        plugins: [
            laravel({
                input: [
                    'resources/css/app.scss',
                    'resources/js/app.js'
                ],
                refresh: true,
                valetTls: host
            }),
        ]
    }
})

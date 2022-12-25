import { defineConfig, loadEnv } from 'vite';
import tailwindcss from 'tailwindcss'
import autoprefixer from 'autoprefixer'
import laravel from 'vite-plugin-laravel'
import vue from '@vitejs/plugin-vue'
import inertia from './resources/scripts/vite/inertia-layout'

export default defineConfig(({ command, mode }) => {
  const env = loadEnv(mode, process.cwd(), '')

  return {
    plugins: [
      inertia(),
      vue(),
      laravel({
        postcss: [
          tailwindcss(),
          autoprefixer(),
        ],
      }),
    ],
    server: {
      host: '0.0.0.0',
      port: env.VITE_PORT,
    },
  }
})

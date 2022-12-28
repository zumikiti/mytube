import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { resolvePageComponent } from 'vite-plugin-laravel/inertia'
import VueVideoPlayer from '@videojs-player/vue'
import 'video.js/dist/video-js.css'

createInertiaApp({
	resolve: (name) => resolvePageComponent(name, import.meta.glob('../views/pages/**/*.vue')),
	setup({ el, app, props, plugin }) {
		createApp({ render: () => h(app, props) })
		.use(plugin)
		.use(VueVideoPlayer)
		.mount(el)
	},
})

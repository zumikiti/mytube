<script setup lang="ts">
import { VideoPlayer } from '@videojs-player/vue'
import 'video.js/dist/video-js.css'
import { computed } from 'vue';

const props = defineProps<{
  filename: string
}>()

const filePath = computed(() => `storage/video/${props.filename}.m3u8`)
</script>

<template>
  <div class="p-6">
    <div class="flex items-center">
      <VideoPlayer
        :src="filePath"
        poster="/your-path/poster.jpg"
        type="application/x-mpegURL"
        controls
        :loop="true"
        :volume="0.6"
        :waiting="true"
        :width="300"
        :height="300"
        />
    </div>
  </div>
</template>

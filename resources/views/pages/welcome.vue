<script setup lang="ts">
import { FilmIcon } from '@heroicons/vue/24/solid'
import FileUpload from '@/views/components/file-upload.vue'
import ResourceBlock from '@/views/components/resource-block.vue'

defineProps<{
  videos: {
    name: string
  },
}>()
</script>

<template layout>
  <div class="relative items-top justify-center min-h-screen bg-zinc-100 dark:bg-zinc-900 sm:items-center py-4 sm:pt-0">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
      <div class="flex justify-center items-center pt-8 space-x-12 sm:pt-0">
        <FilmIcon
          class="text-orange-500 w-10 h-10"
          />
        <h1
          class="font-mono text-6xl text-orange-600"
          >
          MY TUBE
        </h1>
      </div>

      <FileUpload />
    </div>

    <div class="sm:px-6 lg:px-8">
      <div class="mt-8 bg-white dark:bg-zinc-800 overflow-hidden shadow sm:rounded-lg">
        <div class="flex flex-wrap">
          <ResourceBlock
            v-for="(video, i) in videos"
            :key="i"
            :filename="video.name"
            />
        </div>
      </div>
    </div>
  </div>
</template>

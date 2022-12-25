<script setup lang="ts">
import LaravelLogo from '@/views/components/laravel-logo.vue'
import InertiaLogo from '@/views/components/inertia-logo.vue'
import FileUpload from '@/views/components/file-upload.vue'
import ResourceBlock from '@/views/components/resource-block.vue'

defineProps<{
  videos: {
    name: string
  },
  token: string,
}>()
</script>

<template layout>
  <div class="relative flex items-top justify-center min-h-screen bg-zinc-100 dark:bg-zinc-900 sm:items-center py-4 sm:pt-0">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
      <div class="flex justify-center items-center pt-8 space-x-12 sm:pt-0">
        <LaravelLogo class="h-20 w-auto text-[#EF3B2D]" />
        <InertiaLogo class="h-11 w-auto text-[#826ded]" />
      </div>

      <div class="flex justify-center items-center pt-8 space-x-12 sm:pt-0">
        <FileUpload
          :token="token"
        />
      </div>

      <div class="mt-8 bg-white dark:bg-zinc-800 overflow-hidden shadow sm:rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-2">
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

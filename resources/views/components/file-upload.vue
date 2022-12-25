<script setup lang="ts">
import { Inertia } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/inertia-vue3'

const props = defineProps<{
  token: string,
}>()

const form = useForm({
  name: null,
  file: null,
  _token: props.token,
})

const submit = () => {
  Inertia.post('/videos', form)
}
</script>

<template>
  <form @submit.prevent="submit">
    <input type="file" @input="form.file = $event.target.files[0]" />

    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
      {{ form.progress.percentage }}%
    </progress>

    <button type="submit">Submit</button>
  </form>
</template>

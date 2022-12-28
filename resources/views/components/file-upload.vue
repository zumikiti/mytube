<script setup lang="ts">
import axios from 'axios';
import { reactive, ref } from 'vue';

const props = defineProps<{
  token: string,
}>()

const video = reactive({
  file: null,
  src: '',
  inputSize: null,
  uploadSize: null,
  progress: null,
  splitData: null,
})

const count = ref(0)
const fileName = ref('')
const i = ref(0)
const intervalId = ref(0)

const uploadFile = async () => {
  if (i.value > count.value) {
    clearInterval(intervalId.value)
    intervalId.value = 0
    return
  }

  const file = video.file
  // 該当箇所をスライス
  const splitData = file.slice(i.value * sliceSize, (i.value + 1) * sliceSize)

  const form = new FormData()
  form.append('name', fileName.value)
  form.append('file', splitData)

  try {
    const res = await axios.post('/api/videos', form)
    video.uploadSize = res.data.size
  } catch (error) {
    throw error.response.status
  }

  ++i.value
}

const sliceSize = 0.5 * 1024 * 1024 // 切り取るサイズ 2M
const submit = async () => {
  // 連打防止
  if (intervalId.value) return

  const file = video.file
  const size = file.size
  video.inputSize = size.toString()

  count.value = Math.ceil(size / sliceSize) // 分割数を計算
  fileName.value = `${(new Date()).getTime()}-${file.name}`

  // 分割アップロード実施
  intervalId.value = setInterval(() => {
    uploadFile()
      .catch((statusCd) => {
        console.error("死んでいる", statusCd)
        clearInterval(intervalId.value)
        intervalId.value = 0
      })
  }, 1000)
}

const selectedFile = (event) => {
  // ファイルのチェック
  const file = event.target.files[0]
  if (!file || !file.type.match('video/*')) return

  video.file = file

  // ファイルの読み込み
  const reader = new FileReader()
  reader.onload = (evt) => {
    console.log('start loading.')

    console.log(evt?.target?.result)
    video.src = evt.target.result

    console.log('end loading.')
    // this.createThumbnails(this.src)
  }
  reader.readAsDataURL(file)
}
</script>

<template>
  <form @submit.prevent="submit">
    <input
      type="file"
      accept="video/mp4,video/x-m4v"
      @change="selectedFile" />

    <progress v-if="count" :value="i / count * 100" max="100">
      {{ i / count * 100 }}%
    </progress>

    <video
      v-if="video.src"
      controls>
      <source
        :src="video.src"
        type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
    </video>

    <button type="submit">Submit</button>
  </form>
</template>

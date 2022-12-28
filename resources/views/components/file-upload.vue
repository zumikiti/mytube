<script setup lang="ts">
import axios from 'axios';
import { reactive, ref } from 'vue';

const video = reactive({
  file: null,
  src: '',
  inputSize: null,
  uploadSize: null,
  progress: 0,
  splitData: null,
})

const count = ref(0)
const fileName = ref('')
const i = ref(0)
const intervalId = ref(0)

const uploadFile = async () => {
  // 進捗更新
  video.progress = Math.floor(i.value / count.value * 100)

  if (i.value > count.value) {
    clearInterval(intervalId.value)
    intervalId.value = 0
    return
  }

  const file = video.file
  // 該当箇所をスライス
  const splitData = file.slice(
    i.value * sliceSize,
    (i.value + 1) * sliceSize
  )

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

const sliceMB = import.meta.env.VITE_FILE_SLICE_SIZE_MB
const sliceSize = sliceMB * 1024 * 1024 // 切り取るサイズ
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
  }
  reader.readAsDataURL(file)
}
</script>

<template>
  <div
    class="flex justify-center items-center
    pt-8 space-x-12 sm:pt-0">
    <form
      class="flex item-center space-x-6"
      @submit.prevent="submit">
      <input
        type="file"
        accept="video/mp4,video/x-m4v"
        class="block w-full text-sm text-slate-500
        file:mr-4 file:py-2 file:px-4
        file:rounded-full file:border-0
        file:text-sm file:font-semibold
        file:bg-violet-50 file:text-violet-700
        hover:file:bg-violet-100"
        @change="selectedFile" />

      <button
        type="submit"
        class="rounded-full bg-indigo-500 text-sm
        block mr-4 py-2 px-4">
        Submit
      </button>
    </form>
  </div>

  <div
    v-if="video.progress"
    class="flex my-10">
    <progress
      :value="video.progress"
      max="100"
      class="w-3/4 mr-5"
      />
    <output class="text-slate-400 w-1/4">
      {{ video.progress }}%
    </output>
  </div>

  <div
    class="flex justify-center items-center
    pt-8 space-x-12 sm:pt-0">
    <video
      v-if="video.src"
      controls>
      <source
        :src="video.src"
        type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
    </video>
  </div>
</template>

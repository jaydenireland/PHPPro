<script setup lang="ts">
import { ref, watch } from 'vue'
import Editor from './Editor.vue'
import OutputRender from './OutputRender.vue'

const code = ref<string>('')
const output = ref<string>('')

watch(code, async (newVal) => {
  try {
    const val = await window.electron.ipcRenderer.invoke('code', newVal)
    if (val instanceof Error) {
      output.value = val.message
      return
    }
    output.value = val
  } catch (e) {
    output.value = (e as Error).message
  }
})
</script>

<template>
  <div class="w-screen h-screen grid grid-cols-2">
    <Editor @input="(val) => (code = val)" />
    <OutputRender :src="output" />
  </div>
</template>

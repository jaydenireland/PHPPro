<script lang="ts" setup>
import { ref, onMounted } from 'vue'
import * as monaco from 'monaco-editor'
import registerPHPSnippetLanguage from '../utils/registerPHPSnippetLanguage'

const editor = ref<HTMLDivElement | null>(null)
const emits = defineEmits(['input'])
registerPHPSnippetLanguage(monaco.languages)

onMounted(() => {
  if (editor.value) {
    const editorInstance = monaco.editor.create(editor.value, {
      value: '',
      language: 'php-snippet',
      theme: 'vs-dark',
      automaticLayout: true
    })

    editorInstance.onDidChangeModelContent(() => {
      emits('input', editorInstance.getValue())
    })

    // Resize the editor to fit the window
    window.addEventListener('resize', () => editorInstance.render())
  }
})
</script>

<template>
  <div ref="editor"></div>
</template>

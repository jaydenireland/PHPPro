<script lang="ts" setup>
import { ref, onMounted } from 'vue';
import * as monaco from 'monaco-editor';

const editor = ref<HTMLDivElement | null>(null);
const emits = defineEmits(['input']);
const props = defineProps({
  init: String,
  light: {
    type: Boolean,
    default: true
  }
});

onMounted(() => {
  if (editor.value) {
    const editorInstance = monaco.editor.create(editor.value, {
      value: '',
      language: 'php',
      theme: props.light ? 'vs-light' : 'vs-dark',
      automaticLayout: true,
    });

    editorInstance.onDidChangeModelContent(() => {
      emits('input', editorInstance.getValue());
    });
    editorInstance.setValue(props.init);

    // Resize the editor to fit the window
    window.addEventListener('resize', () => editorInstance.render());
  }
});
</script>

<template>
  <div ref="editor"></div>
</template>

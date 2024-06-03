<script setup lang="ts">
import VueMarkdown from 'vue-markdown-render';

const { src } = defineProps<{
  src: string;
}>();

const options = {
  html: true,
  linkify: true,
  typographer: true,
};
</script>

<template>
  <div class="px-2 py-4 bg-black text-white">
    <vue-markdown :source="src" :options="options" />
  </div>
</template>

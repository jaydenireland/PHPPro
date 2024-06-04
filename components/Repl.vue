<script setup lang="ts">
import { ref, watch, onMounted } from 'vue';
const { PhpWeb } = await import('https://cdn.jsdelivr.net/npm/php-wasm/PhpWeb.mjs');
import _ from 'lodash';
import { gzip, inflate } from 'pako';

const code = ref<string>('');
const output = ref<string>('');
const php = new PhpWeb();

watch(code, _.debounce((newCode) => {
  if (newCode.length < 0) {
    output.value = '';
    return;
  }
  output.value = '';
  php.run(newCode);
  const compressed = gzip(newCode);
  const base64 = btoa(String.fromCharCode(...new Uint8Array(compressed)));
  const urlFragment = `#${base64}`;
  window.history.replaceState(null, '', urlFragment);
}, 200));

php.addEventListener('output', (event: any) => {
  output.value += event.detail.toString();
});

onMounted(() => {
  if (window.location.hash) {
    const base64 = window.location.hash.slice(1);
    const binaryString = atob(base64);
    const len = binaryString.length;
    const bytes = new Uint8Array(len);
    for (let i = 0; i < len; i++) {
      bytes[i] = binaryString.charCodeAt(i);
    }
    const decompressed = inflate(bytes, { to: 'string' });
    code.value = decompressed;
  }
});
</script>

<template>
  <div class="w-screen h-screen grid grid-cols-2">
    <ClientOnly>
      <Editor :init="code" @input="(val) => (code = val)" class="overflow-scroll"/>
      <div v-html="output" class="overflow-scroll bg-black text-white py-8 px-2"/>
    </ClientOnly>
  </div>
</template>
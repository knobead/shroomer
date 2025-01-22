<script setup lang="ts">
defineProps({
  genus: String,
})
</script>

<template>
<pre v-if="genus=='boletus'">














      |. |
_/_\_/ .  \
</pre>
<pre v-else-if="genus=='amanita'">














      |. |
_/_\_/ .  \
</pre>
<pre v-else-if="genus=='cantharellus'">














      |. |
_/_\_/ .  \
</pre>
  <pre v-else-if="genus=='pleurotus'">














      |. |
_/_\_/ .  \
</pre>
  <pre v-else-if="genus=='xerocomus'">














      |. |
_/_\_/ .  \
</pre>
<pre v-else-if="genus=='morchella'">














      |. |
_/_\_/ .  \
</pre>
</template>

<style>
</style>

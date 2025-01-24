<script setup lang="ts">
defineProps({
  sporocarp: Object,
})
</script>

<template>
<pre v-if="sporocarp.genus=='boletus'">
    _---_
  /       \
 :_.-( )-._:
\_._(   )_._
</pre>
<pre v-else-if="sporocarp.genus=='amanita'">
    _---_
  /* * * *\
 :_.-| |-._:
\_._.| |__._
</pre>
<pre v-else-if="sporocarp.genus=='cantharellus'">
_Y_
</pre>
  <pre v-else-if="sporocarp.genus=='pleurotus'">
 |P
/._.
</pre>
<pre v-else-if="sporocarp.genus=='xerocomus'">
.XCM.
_/_\_
</pre>
<pre v-else-if="sporocarp.genus=='morchella'">
  0
_/_\_
</pre>
</template>

<style>
</style>

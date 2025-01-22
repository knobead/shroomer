<script setup lang="ts">
import {useRoute} from "vue-router";
import {onMounted, ref, watchEffect} from "vue";

const route = useRoute()
let zone = ref({})

onMounted(async () => {

  zone.value = await fetch('https://localhost:443/api/zone/'+route.params.id)
    .then(response => response.json())
    .then(data => {return data})
})
</script>

<template>
  <div v-if="zone">
    <p>{{zone.name}}</p>
    <div v-for="tree in zone.trees">
      {{tree.genus}}
    </div>
  </div>
  <div v-else>
    Loading
  </div>
</template>

<style>
</style>

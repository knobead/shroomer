<script setup lang="ts">
import {onMounted, ref} from "vue";
import {RouterLink} from "vue-router";

const zones = ref([])

onMounted(async () => {
  zones.value = await fetch('https://localhost:443/api/zones')
    .then(response => response.json())
    .then(data => {
      return data["hydra:member"]
    })
})
</script>

<template>
  <div v-if="zones.length > 0">
    <p v-for="zone in zones" :key="zone.id">
      <RouterLink :to="{name: 'zone', params: {'id': zone.id}}">{{ zone.name }}</RouterLink>
    </p>
  </div>
  <div v-else>
    <p>Loading</p>
  </div>
</template>

<style>
</style>

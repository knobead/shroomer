<script setup lang="ts">
import {onMounted, ref, inject} from "vue";
import {RouterLink} from "vue-router";

const host = inject('host')
const zones = ref([])

onMounted(async () => {
  zones.value = await fetch(host + '/api/zones')
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

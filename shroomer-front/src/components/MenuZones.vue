<script setup lang="ts">
import {onMounted, ref} from "vue";
import {RouterLink} from "vue-router";
import authService from "@/services/auth.service.ts";

const zones = ref([])

onMounted(async () => {
  zones.value = await authService.get('/api/zones')
    .then(response => response.data)
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
  <div>
  </div>
</template>

<style>
</style>

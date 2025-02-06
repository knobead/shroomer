<script setup lang="ts">
import {onMounted, ref} from "vue";
import authService from "@/services/auth.service.ts";

const user = ref({
  email: '',
  resourceFlora: 0,
  resourceFauna: 0,
  resourceEntomofauna: 0,
})

onMounted(async () => {
  user.value = await authService.get('/api/user')
    .then(response => response.data)
    .then(data => {
      return data
    })
})
</script>

<template>
  <div v-if="user.email">
    <p>Resource Flora: {{ user.resourceFlora }}</p>
    <p>Resource Fauna: {{ user.resourceFauna }}</p>
    <p>Resource Entomofauna: {{ user.resourceEntomofauna }}</p>
  </div>
</template>

<style>
</style>

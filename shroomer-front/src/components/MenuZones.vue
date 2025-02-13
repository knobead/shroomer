<script setup lang="ts">
import {onMounted, ref} from "vue";
import {RouterLink, useRoute} from "vue-router";
import authService from "@/services/auth.service.ts";
import TreeAdd from "@/components/TreeAdd.vue";

const zones = ref([])
const route = useRoute()

onMounted(async () => {
  zones.value = await authService.get('/api/zones')
    .then(response => response.data)
    .then(data => {
      return data["member"]
    })
})
</script>

<template>
  <div v-if="zones.length > 0">
    <div v-for="zone in zones" :key="zone['id']">
      <RouterLink :to="{name: 'zone', params: {'id': zone['id']}}">{{ zone['name'] }}</RouterLink>
      <div v-if="zone['id'] == route.params.id">
        <TreeAdd :zone="zone"/>
      </div>
    </div>
  </div>
</template>

<style>
</style>

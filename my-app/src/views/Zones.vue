<script setup lang="ts">
import ZoneLink from '../components/ZoneLink.vue'
import {onMounted, ref} from "vue";

let zones = ref([])

onMounted(async () => {
  zones.value = await fetch('https://localhost:443/api/zones')
    .then(response => response.json())
    .then(data => {
      return data["hydra:member"]
    })
})
</script>

<template>
  <div class="shroomer">
    <p>Lets discover availables zones.</p>

    <div v-if="zones.length > 0">
      <p v-for="zone in zones">
        <zone-link :id="zone.id" :name="zone.name"/>
      </p>
    </div>
    <div v-else>
      <p>Loading</p>
    </div>
  </div>
</template>

<style>
</style>

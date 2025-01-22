<script setup lang="ts">
import {RouterLink} from "vue-router";

defineProps({
  id: Number,
  name: String,
})
</script>

<template>
  <div class="zone-link">
    <RouterLink :to="{name: 'zone', params: {'id': id}}">{{ name }}</RouterLink>
  </div>
</template>

<style>
  .zone-link{
    display: grid;
    grid-template-columns: 1fr 3fr;

    b {
      font-weight: bold;
    }
  }
</style>

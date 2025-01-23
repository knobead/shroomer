<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
import MenuZones from "@/components/MenuZones.vue";
</script>

<template>
  <header>
    <div class="wrapper">
      <nav>
        <RouterLink to="/shroomer">Shroomer</RouterLink>
        <menu-zones/>
      </nav>
    </div>
  </header>

  <RouterView :key="$route.fullPath"/>
</template>

<style scoped>
</style>

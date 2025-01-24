<script setup lang="ts">
import ZoneComponent from "@/components/ZoneComponent.vue";
import {ref} from "vue";
const componentKey = ref(0)
setInterval(function () {
  componentKey.value++
}, 5000)
</script>

<template>
  <zone-component :key="componentKey"/>
</template>

<style>
</style>

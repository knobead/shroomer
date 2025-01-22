<script setup lang="ts">
import {useRoute} from "vue-router";
import {onMounted, ref} from "vue";
import Tree from "@/components/Tree.vue";

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
    <div class="trees">
      <tree v-for="tree in zone.trees" :genus="tree.genus"/>
    </div>
  </div>
  <div v-else>
    Loading
  </div>
</template>

<style>
.trees {
  > pre {
    display: inline-block;
  }
}
</style>

<script setup lang="ts">
import {useRoute} from "vue-router";
import {onMounted, ref} from "vue";
import Tree from "@/components/Tree.vue";
import Sporocarp from "@/components/Sporocarp.vue";

const route = useRoute()
const zone = ref({})

onMounted(async () => {
  zone.value = await fetch('https://localhost:443/api/zone/'+route.params.id)
    .then(response => response.json())
    .then(data => {return data})
})
</script>

<template>
  <div v-if="zone">
    <h1>{{zone.name}}</h1>
    <div class="zone">
      <tree v-for="tree in zone.trees" :genus="tree.genus" :key="tree.id"/>
      <sporocarp v-for="sporocarp in zone.sporocarps" :genus="sporocarp.genus" :key="sporocarp.id"/>
    </div>
  </div>
  <div v-else>
    <h1>Loading ...</h1>
  </div>
</template>

<style>
.zone {
  > pre {
    display: inline-block;
    margin-bottom: 40px;
    margin-top: 100px;
  }
}
</style>

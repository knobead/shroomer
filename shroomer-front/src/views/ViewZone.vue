<script setup lang="ts">
import {useRoute} from "vue-router";
import {onMounted, ref, inject} from "vue";
import ZoneItem from "@/components/item/ZoneItem.vue";

const route = useRoute()
const zone = ref({})
const host = inject('host')

onMounted(async () => {
  zone.value = await fetch(host+'/api/zone/'+route.params.id)
    .then(response => response.json())
    .then(data => {return data})
})
</script>

<template>
  <div v-if="zone">
    <h1>{{zone.name}}</h1>
    <div class="zone">
      <zone-item v-for="item in zone.items" :item="item" :type="item['@type']" :key="item['@type']+item.id"/>
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

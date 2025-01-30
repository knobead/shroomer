<script setup lang="ts">
import {useRoute} from "vue-router";
import {onMounted, ref} from "vue";
import ZoneItem from "@/components/item/ZoneItem.vue";
import authService from "@/services/auth.service.ts";

const route = useRoute()
const zone = ref({})

onMounted(async () => {
  zone.value = await authService.get('/api/zone/'+route.params.id)
    .then(response => response.data)
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
</template>

<style>
.zone {
  > pre {
    font-size: 10px;
    display: inline-block;
    margin-bottom: 40px;
    margin-top: 100px;
  }
}
</style>

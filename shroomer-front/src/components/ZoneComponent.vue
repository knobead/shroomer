<script setup lang="ts">
import {useRoute} from "vue-router";
import {onMounted, onUnmounted, ref} from "vue";
import ZoneItem from "@/components/item/ZoneItem.vue";
import authService from "@/services/auth.service.ts";
import TreeAdd from "@/components/TreeAdd.vue";

const route = useRoute()
const zone = ref({name: String, items: {}})

onMounted(async () => {
  await refresh()
})

onUnmounted(() => clearInterval(interval))
const interval = setInterval(function () {
  refresh()
}, 5000)

async function refresh() {
  zone.value = await authService.get('/api/zones/'+route.params.id)
    .then(response => response.data)
    .then(data => {return data})
}
</script>

<template>
  <div v-if="zone">
    <TreeAdd :zone="zone"/>
    <p class="text-center text-gray-600">You are viewing {{zone.name}}</p>
    <div class="zone">
      <zone-item v-for="item in zone.items" :item="item" :type="item['@type']" :key="item['@type']+item['id']"/>
    </div>
  </div>
</template>

<style>
</style>

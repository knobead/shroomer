<script setup lang="ts">
import Sporocarp from "@/components/item/ItemSporocarp.vue";
import Tree from "@/components/item/ItemTree.vue";

defineProps({
  type: String,
  item: Object,
})
</script>

<template>
  <sporocarp v-if="type=='Sporocarp'" :sporocarp="item"></sporocarp>
  <tree v-else-if="type=='Tree'" :tree="item"></tree>
</template>

<style>
</style>

<script setup lang="ts">
import Tree from "@/components/item/ItemTree.vue";

const props = defineProps({
  type: {type: String, required: true},
  item: {type: Object, required: true},
})
</script>

<template>
    <tree v-if="props.type=='Tree'"
          :tree="props.item"
    ></tree>
</template>

<style>
</style>

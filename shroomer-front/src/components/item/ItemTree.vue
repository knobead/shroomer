<script setup lang="ts">
import {onBeforeMount, onUnmounted, ref, watch} from "vue";
import ItemSporocarp from "@/components/item/ItemSporocarp.vue";
import treeAsciinator from "@/asciinator/tree.asciinator.ts";

const props = defineProps({
  tree: {
    genus: {type: String, required: true},
    id: {type: Number, required: true},
    slot: {type: Number, required: true},
    letter: {type: String, required: true},
  }
})

const empty = { genus: 'empty'}
const pied = { genus: 'pied'}
const template = ref('')

watch(() => props.tree, () => {
  refresh()
})

function refresh() {
  let used_template = treeAsciinator.prepareTemplate(props.tree.slot, props.tree.id)
  used_template = treeAsciinator.prepareTrunk(used_template)
  used_template = treeAsciinator.prepareLeaf(used_template, props.tree.letter)

  template.value = used_template
}

onBeforeMount(() => {
  refresh()
})

onUnmounted(() => clearInterval(interval))
const interval = setInterval(function () {
  refresh()
}, 1000)

</script>

<template>
  <div class="inline-block" v-if="props.tree.slot == 0" >
    <pre class="text-gray-200" v-html="template"></pre>
    <item-sporocarp :sporocarp="props.tree.slot_3"/>
    <item-sporocarp :sporocarp="props.tree.slot_1"/>
    <item-sporocarp :sporocarp="pied"/>
    <item-sporocarp :sporocarp="props.tree.slot_2"/>
    <item-sporocarp :sporocarp="props.tree.slot_4"/>
  </div>

  <div class="inline-block" v-else-if="props.tree.slot <= 2" >
    <pre class="text-gray-200" v-html="template"></pre>
    <item-sporocarp :sporocarp="empty"/>
    <item-sporocarp :sporocarp="props.tree.slot_1"/>
    <item-sporocarp :sporocarp="pied"/>
    <item-sporocarp :sporocarp="props.tree.slot_2"/>
    <item-sporocarp :sporocarp="empty"/>
  </div>

  <div class="box-content inline-block" v-else >
    <pre class="text-gray-200" v-html="template"></pre>
    <item-sporocarp :sporocarp="empty"/>
    <item-sporocarp :sporocarp="props.tree.slot_3"/>
    <item-sporocarp :sporocarp="props.tree.slot_1"/>
    <item-sporocarp :sporocarp="pied"/>
    <item-sporocarp :sporocarp="props.tree.slot_2"/>
    <item-sporocarp :sporocarp="props.tree.slot_4"/>
    <item-sporocarp :sporocarp="empty"/>
  </div>
</template>

<style>
pre {
  font-size: 9px;
}
</style>

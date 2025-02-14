<script setup lang="ts">
import {onBeforeMount, ref, watch} from "vue";

const props = defineProps({
  sporocarp: Object,
})

let used_template = ref('')

const templates = {
  'boletus':
    '   _---_    \n' +
    ' /       \\   \n' +
    ':_.-( )-._:  \n' +
    '<span class="text-green-800">_._</span>(   )<span class="text-green-800">_.__</span>',

  'amanita':
    '    _---_   \n' +
    '  /  * *  \\ \n' +
    ' :_.-| |-._:\n' +
    '<span class="text-green-800">__._.</span>| |<span class="text-green-800">__._</span>',

  'cantharellus':
    '\n' +
    '\n' +
    '    \\  /   \n' +
    '<span class="text-green-800">.__.__</span>Y<span class="text-green-800">__.__</span>',

  'pleurotus':
    '\n' +
    '\n' +
    '     P|P    \n' +
    '<span class="text-green-800">.__.__</span>Y<span class="text-green-800">__.__</span>',

  'xerocomus':
    '\n' +
    '     ...    \n' +
    '   .XXCMM.  \n' +
    '<span class="text-green-800">.__._</span>) (<span class="text-green-800">_.__</span>',

  'morchella':
    '     0      \n' +
    '    000     \n' +
    '     0      \n' +
    '<span class="text-green-800">__._</span>/_\\<span class="text-green-800">__.__</span>',

  'empty':
    '            \n' +
    '            \n' +
    '            \n' +
    '<span class="text-green-800">__.__.__.___</span>',
  'pied':
    '    |\\|\\    \n' +
    '    |/||    \n' +
    '    ||\\|    \n' +
    '__./|||/\\.._',
}


watch(() => props.sporocarp, () => {
  refresh()
})

function refresh() {
  if (!props.sporocarp) {
    used_template.value = templates['empty']

    return
  }

  used_template.value = templates[props.sporocarp.genus]

  if (props.sporocarp.genus == 'pied') {
    used_template.value = used_template.value.replaceAll('/', "<span class='text-amber-700'>/</span>")
    used_template.value = used_template.value.replaceAll('.', "<span class='text-amber-700'>.</span>")
    used_template.value = used_template.value.replaceAll('|', "<span class='text-amber-800'>|</span>")
    used_template.value = used_template.value.replaceAll('\\', "<span class='text-amber-900'>\\</span>")
    used_template.value = used_template.value.replaceAll('_', "<span class='text-amber-800'>_</span>")

    return
  }
}

onBeforeMount(() => {
  refresh()
})
</script>

<template><pre class="inline-block text-gray-300" v-html="used_template"></pre></template>

<style>
</style>

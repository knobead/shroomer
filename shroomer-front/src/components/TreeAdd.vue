<script setup lang="ts">
import {onMounted, ref} from "vue";
import {useRoute} from "vue-router";
import CostComponent from "@/components/CostComponent.vue";
import authService from "@/services/auth.service.ts";
import userInfos from "@/services/user.infos.ts";

const genuses = ref( {})
const route = useRoute()

onMounted(async () => {
  genuses.value = await authService.get('/api/tree_genuses_enums')
    .then(response => response.data)
    .then(data => {
      return data.member
    })
})

async function addATree(genus: string) {
  await authService.post('/api/trees', {
    'genus': genus,
    'zone': 'api/zones/'+ route.params.id
  }).then(() => userInfos.refresh())
}
</script>

<template>
  <div v-if="genuses">
    <button @click="addATree(genus['@id'])"
            v-for="genus in genuses"
            :key="genus['@id']"
            :disabled="!userInfos.affordable(genus['cost'])">
      Add a {{genus['name']}}
      <CostComponent :cost="genus['cost']" />
    </button>
  </div>
</template>

<style scoped>

</style>

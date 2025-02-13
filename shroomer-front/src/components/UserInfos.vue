<script setup lang="ts">
import {onMounted, onUnmounted} from "vue";
import userInfos from "@/services/user.infos";

onUnmounted(() => clearInterval(interval))
const interval = setInterval(function () {
  userInfos.refresh()
}, 10000)

onMounted(async () => {
  await userInfos. refresh()
})
</script>

<template>
  <div v-if="userInfos.user.value['email']">
    <p>Resource Flora: {{ userInfos.user.value['resourceFlora'] }}</p>
    <p>Resource Fauna: {{ userInfos.user.value['resourceFauna'] }}</p>
    <p>Resource Entomofauna: {{ userInfos.user.value['resourceEntomofauna'] }}</p>
  </div>
</template>

<style>
</style>

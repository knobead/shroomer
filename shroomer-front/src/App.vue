<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
import MenuZones from "@/components/MenuZones.vue";
import UserInfos from "@/components/UserInfos.vue";
import authService from "@/services/auth.service.ts";
import {ref} from "vue";

const userKey = ref(0)
setInterval(function () {
  userKey.value++
}, 1000)
</script>

<template>
  <header>
    <div class="wrapper">
      <nav>
        <RouterLink to="/shroomer">Shroomer</RouterLink>

        <div v-if="authService.authenticated()">
          <user-infos :key="userKey"/>
          <menu-zones/>
          <p><RouterLink to="/" @click="authService.logout()">Logout</RouterLink></p>
        </div>
        <div v-else>
          <p><RouterLink to="/login">Login</RouterLink></p>
          <p><RouterLink to="/register">Register</RouterLink></p>
        </div>
      </nav>
    </div>
  </header>

  <RouterView :key="$route.fullPath"/>
</template>

<style scoped>
</style>

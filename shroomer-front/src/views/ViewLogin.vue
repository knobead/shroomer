<script lang="ts" setup>
import {ref} from "vue";
import authService from "@/services/auth.service.ts";
import router from "@/router";

const username = ref('')
const password = ref('')
const errors = ref<string[]>([])

function login(event: Event){
  event.preventDefault()
  errors.value = []

  if (3 >= username.value.length) {
    errors.value.push('Username must be at least 3 chars.')
  }

  if (3 >= password.value.length) {
    errors.value.push('Password must be at least 3 chars.')
  }

  if (0 < errors.value.length) {
    return
  }

  authService.login(username.value, password.value)
    .then(() => router.push('/'))
    .catch(() => {
      errors.value.push('Authentication failure')
    })
}
</script>

<template>
  <div>
    <h1>Login</h1>
    <div class="login">
      <form>
        <input v-model="username" placeholder="Username" />
        <input v-model="password" type="password" placeholder="Password" />
        <button @click="login($event)">Login</button>
      </form>
    </div>

    <div class="error" v-if="errors.length">
      <b>Please correct the following error(s):</b>
      <p v-for="error in errors">- {{ error }}</p>
    </div>
  </div>
</template>

<style>
.login {
  padding: 20px;

  input, button {
    display: block;
    margin: 0 auto;
    min-width: 200px;
    text-align: center;
  }
}

.error {
  margin: 0 auto;
  text-align: center;
}
</style>

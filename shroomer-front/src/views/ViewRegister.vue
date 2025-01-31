<script lang="ts" setup>
import {ref} from "vue";
import authService from "@/services/auth.service.ts";

const username = ref('')
const password = ref('')
const passwordConfirm = ref('')

const errors = ref<string[]>([])
const successful = ref(false)

function register(event: Event){
  event.preventDefault()
  errors.value = []

  if (3 > username.value.length) {
    errors.value.push('Email must be at least 3 chars.')
  }

  if (3 > password.value.length) {
    errors.value.push('Password must be at least 3 chars.')
  }

  if (password.value !== passwordConfirm.value) {
    errors.value.push('Password and confirm does not match.')
  }

  if (0 < errors.value.length) {
    return
  }

  authService.post('/api/register', {email: username.value, plainPassword: password.value})
    .then(() => successful.value = true)
    .catch(error => error.response.data.violations.forEach(
      (violation: {message: string}) => errors.value.push(violation.message)
    ))
    .catch(() => errors.value.push('Request went wrong.'))
}
</script>

<template>
  <div>
    <h1>Register to Shroomer</h1>

    <div class="register" v-if="!successful">
      <form>
        <input v-model="username" placeholder="Email" />
        <input v-model="password" type="password" placeholder="Password" />
        <input v-model="passwordConfirm" type="password" placeholder="Password Confirmation" />
        <button @click="register($event)">Register</button>
      </form>
    </div>
    <div v-else>
      <p>Account created, proceed to login</p>
    </div>

    <div class="error" v-if="errors.length">
      <b>Please correct the following error(s):</b>
      <p v-for="(error, index) in errors" :key="index">- {{ error }}</p>
    </div>
  </div>
</template>

<style>
.register {
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

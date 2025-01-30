<script lang="ts" setup>
import {ref} from "vue";
import authService from "@/services/auth.service.ts";
import router from "@/router";

const username = ref('')
const password = ref('')
const passwordConfirm = ref('')

const errors = ref<string[]>([])

function register(event: Event){
  event.preventDefault()
  errors.value = []

  if (3 >= username.value.length) {
    errors.value.push('Username must be at least 3 chars.')
  }

  if (3 >= password.value.length) {
    errors.value.push('Password must be at least 3 chars.')
  }

  if (password.value !== passwordConfirm.value) {
    errors.value.push('Password and confirm does not match.')
  }

  if (0 < errors.value.length) {
    return
  }

  authService.register(username.value, password.value)
    .then(() => router.push('/'))
    .catch(() => {
      errors.value.push('Registration failure')
    })
}
</script>

<template>
  <div>
    <h1>Register to Shroomer</h1>
  </div>
</template>

<style>
</style>

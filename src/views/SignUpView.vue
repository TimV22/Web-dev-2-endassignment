<template>
  <main class="container h-75">
      <sign-up-form/>
  </main>
</template>

<script>
import SignUpForm from "@/components/signUpForm.vue";

export default {
    name: "SignUpView",
    components: {SignUpForm},
}
</script>

<style scoped>

</style>
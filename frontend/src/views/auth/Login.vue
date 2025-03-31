<template>
    <div>
      <BCard
        title="Login"
        img-src="https://picsum.photos/id/25/600/300"
        img-alt="Login-Image"
        img-top
        tag="article"
        style="max-width: 25rem"
        class="mx-auto my-auto ptex"
      >
        <BCardText class="align-right">
          Some quick example text to build on the card title and make up the bulk of the card's content.
        </BCardText>
        <BButton href="#" variant="primary" @click="loginUser()">Login</BButton>
      </BCard>
    </div>
  </template>
  
  <script>
  import { useAuthStore } from '../../stores/auth/auth'

  export default {
    name: "Login",
    setup() {
      const authStore = useAuthStore()
      return { authStore }
    },
    data() {
      return {
        email: null,
        password: null
      }
    },
    methods: {
      loginUser() {
        console.log("TEST")
        this.authStore.login({
          email: this.email,
          password: this.password
        })
      }
    }
  };
  </script>
  
  <style scoped>
  h2 {
    color: #42b983;
  }
  </style>
  
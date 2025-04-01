<template>
  <div>
    <BCard
      title="Sign In"
      img-src="https://picsum.photos/id/25/600/300"
      img-alt="Login-Image"
      img-top
      tag="article"
      style="max-width: 25rem"
      class="mx-auto my-auto text-left d-flex align-center justify-cente"
    >
      <BForm @submit.prevent="loginUser()">
        <BCardText class="align-right mt-4">
          <BFormInput
            id="input-1"
            v-model="email"
            type="email"
            placeholder="Enter email"
            class="login-input px-2"
            required
            autofocus
          />
          <span class="text-red-700 font-bold error-msg" v-if="validationErrors?.email">{{ validationErrors.email[0] }}</span>

          <BFormInput
            id="input-2"
            v-model="password"
            type="password"
            placeholder="Enter password"
            class="login-input mt-3 px-2"
            required
          />
          <span class="text-blue-500 font-bold forgot-password mt-1">Forgot Password?</span>
          <span class="text-red-700 font-bold error-msg" v-if="validationErrors?.password">{{ validationErrors.password[0] }}</span>

        </BCardText>

        <div class="text-red-700 row mx-0 d-flex">
          <!--<span class="col-12 text-center mt-1 mb-2">Invalid login credentials provided</span>-->
        </div>
        <div class="col-12 px-0 text-center align-items-center justify-content-center mt-3">
          <BButton class="col-8" pill variant="primary" type="submit" v-if="!requestProcessing">Sign In</BButton>
          <BButton class="col-8" pill variant="primary" v-else :disabled="true">Processing...</BButton>
        </div>
        <span class="col-12 px-0 justify-content-center d-flex my-2 or-span">or</span>
        <div class="col-12 px-0 text-center">
          <BButton class="col-6" pill variant="outline-secondary">Register</BButton>
        </div>
      </BForm>
    </BCard>
  </div>
</template>

<script>
import { BButton, BForm, BFormGroup, BFormInput } from 'bootstrap-vue-next';
import { useAuthStore } from '../../stores/auth/auth'
import { useToast } from "vue-toastification";

export default {
  name: "Login",
  setup() {
    const authStore = useAuthStore()
    return { authStore }
  },
  data() {
    return {
      email: null,
      password: null,
      requestProcessing: false,
      validationErrors: null,
      loginError: null
    }
  },
  methods: {
    loginUser() {
      this.errors = null
      this.requestProcessing = true

      this.authStore.login({
        email: this.email,
        password: this.password
      }).then(response => {
        this.requestProcessing = false
        console.log(response)
        
      }, this).catch(error => {
        if (error.response.status === 422) {
          this.validationErrors = error.response.data.errors
        }

        if (error.status === 401) {
          this.loginError = error.response?.data?.message
          useToast().error(this.loginError)
        }
      })
    }
  }
};
</script>
  
<style scoped>

h2 {
  color: #42b983;
}

.login-input {
  border-radius: 0px;
  padding-left: 5px;
  color: rgb(90, 90, 90) !important;
  height: 3rem;
  border: 0px 0px 1px 1px gray solid;
}

.error-msg {
  color: red !important;
}

.forgot-password {
  color: rgb(0, 174, 255) !important;
  cursor: pointer !important;
  font-size: 14px;
  font-weight: 600 !important;
}

.forgot-password:hover {
  text-decoration: underline;
}

.new-account-text {
  cursor: pointer !important;
}

.new-account-text:hover {
  text-decoration: underline;
}

.or-span {
  padding-left: 10px;
}

.or-span::before, .or-span::after {
  content: "";
  flex: 1 1;
  margin: auto;
}

.or-span::after, .or-span::before {
  border-bottom: 1px #8080806b solid;
  margin-right: 10px;
  margin-left: 10px;
}

.card-body > h4 {
  font-size: 30px !important;
}
</style>
  
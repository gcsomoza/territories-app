<template>
  <section class="login">
    <main class="form-signin">
      <form>
        <img class="mb-4" src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b2/Bootstrap_logo.svg/512px-Bootstrap_logo.svg.png" alt="" width="72" height="57">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

        <div class="form-floating">
          <input 
            type="text" 
            v-model="username" 
            class="form-control"
            :class="{'is-invalid': isErrorOccured}"
            id="floatingInput" 
            placeholder="Username"
            @input="inputUsernameHandler"
          >
          <label for="floatingInput">Username</label>
        </div>
        <div class="form-floating">
          <input 
            type="password" 
            v-model="password" 
            class="form-control" 
            :class="{'is-invalid': isErrorOccured}"
            id="floatingPassword" 
            placeholder="Password"
          >
          <label for="floatingPassword">Password</label>
        </div>

        <div v-if="isErrorOccured" class="form-floating">
          <p class="text-danger">
            {{errorMessage}}
          </p>
        </div>

        <div class="checkbox mb-3">
          <label>
            <input type="checkbox" v-model="isRememberMe" value="remember-me"> Remember me
          </label>
        </div>
        <button 
          class="w-100 btn btn-lg btn-primary btn-login" 
          type="button" 
          :disabled="isLoggingIn"
          @click="login"
        >
          <loading 
            v-if="isLoggingIn" 
            width="2rem" 
            height="2rem" 
            fill="#fff"
          ></loading>
          Sign in
        </button>
        <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
      </form>
    </main>
  </section>
</template>

<script>
import Loading from '../components/Loading.vue'

export default {
  components: {
    Loading,
  },
  data() {
    return {
      username: "",
      password: "",
      isRememberMe: false,
      isLoggingIn: false,
      isErrorOccured: false,
      errorMessage: "",
    }
  },
  created() {
    if(this.$store.getters.isLoggedIn) {
      this.$router.push({ name: "app" })
      return
    }
    this.isRememberMe = this.$store.getters.getIsRememberMe
    if(this.isRememberMe) {
      this.username = this.$store.getters.getUsername
    }
  },
  watch: {
    isRememberMe(isRemember) {
      if(isRemember) {
        this.$store.commit("rememberUser", this.username)
      }
      else {
        this.$store.commit("forgetUser")
      }
    }
  },
  methods: {
    inputUsernameHandler() {
      if(this.isRememberMe) this.$store.commit("setUsername", this.username)
    },
    login() {
      this.isLoggingIn = true
      this.isErrorOccured = false

      this.$http.post("/api/login", {
        username: this.username,
        password: this.password,
      })
      .then((response) => {
        if(response.data.status == "OK") {
          this.$store.commit('startSession', {
            token: response.data.token,
            profile: response.data.profile
          })
          this.$router.push({ name: "app" })
          return
        }
        this.errorMessage = response.data.message
        this.isErrorOccured = true
        this.isLoggingIn = false
      })
    }
  }
}
</script>

<style scoped>
.login {
  display: flex;
  align-items: center;
  padding-top: 40px;
  padding-bottom: 40px;
}

.form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: auto;
}

.form-signin form {
  text-align: center;
}

.form-signin .checkbox {
  font-weight: 400;
}

.form-signin .form-floating:focus-within {
  z-index: 2;
}

.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}

.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}

.form-signin button {
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>
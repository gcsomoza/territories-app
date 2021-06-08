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
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="button" @click="login">Sign in</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
      </form>
    </main>
  </section>
</template>

<script>
export default {
  data() {
    return {
      username: "",
      password: "",
      isErrorOccured: false,
      errorMessage: "",
    }
  },
  methods: {
    login() {
      this.isErrorOccured = false

      this.$http.post("/api/login", {
        username: this.username,
        password: this.password,
      })
      .then((response) => {
        if(response.data.status == "OK") {
          this.$router.push({ name: "app" });
          return
        }
        this.errorMessage = response.data.message
        this.isErrorOccured = true
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
</style>
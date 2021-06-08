<template>
  <div>
    <header class="p-3 mb-3 border-bottom">
      <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
          <a href="#" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b2/Bootstrap_logo.svg/512px-Bootstrap_logo.svg.png" width="40" height="32"></img>
          </a>

          <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            <li><a href="#" class="nav-link px-2 link-secondary">Territories</a></li>
          </ul>

          <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
            <input type="search" v-model="filter" :disabled="territories.length == 0" class="form-control" placeholder="Search..." aria-label="Search">
          </form>

          <div class="dropdown text-end">
            <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="mdo" width="32" height="32" class="rounded-circle">
            </a>
            <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
              <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#profile">Profile</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" @click="logout">Sign out</a></li>
            </ul>
          </div>
        </div>
      </div>
    </header>
    <main class="p-3 mb-3">
      <div class="container">
        <h2 class="pb-3">Here are the list of territories</h2>
        <p v-if="territories.length == 0">
          <loading width="4rem" height="4rem"></loading> Loading please wait...
        </p>
        <tree-browser
          v-for="territory in territories"
          :key="territory.id"
          :node="territory"
          childrenKey="territories"
          :filter="filter"
        ></tree-browser>
      </div>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="profile" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="profileModalLabel">PROFILE</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="profile-content">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150">
                    <div class="mt-3">
                      <h4>{{$store.getters.getProfile.displayName}}</h4>
                      <p class="text-secondary mb-1">{{$store.getters.getProfile.username}}</p>
                      <p v-for="(role, index) in $store.getters.getProfile.roles" :key="index" class="text-muted font-size-sm">{{role}}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>    
  </div>
</template>

<script>
import TreeBrowser from '../components/TreeBrowser.vue'
import Loading from '../components/Loading.vue'

export default {
  components: {
    TreeBrowser,
    Loading,
  },
  data() {
    return {
      filter: "",
      territories: [],
    }
  },
  created() {
    if(!this.$store.getters.isLoggedIn) {
      this.logout()
    }
    this.$http.get("/api/territories", { 
      headers: { 
        token: this.$store.getters.getToken 
      }
    })
    .then((response) => {
      if(response.status == 200) {
        if(response.data.status == "OK") {
          this.territories = response.data.territories
          return
        }
      }
      this.logout()
    })    
  },
  methods: {
    logout() {
      this.$store.commit("clearSession")
      this.$router.push({ name: "login" }).catch(()=>{})
    },
    showProfile() {

    },
  }
}
</script>

<style>
a {
  cursor: pointer;
}
</style>
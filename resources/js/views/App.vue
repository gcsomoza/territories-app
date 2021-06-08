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
            <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
          </form>
  
          <div class="dropdown text-end">
            <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQHs2X1uRshHlhW76wZIswaHc-mvdHOrC86Kg&usqp=CAU" alt="mdo" width="32" height="32" class="rounded-circle">
            </a>
            <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
              <li><a class="dropdown-item" href="#">Profile</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Sign out</a></li>
            </ul>
          </div>
        </div>
      </div>
    </header>
    <main class="p-3 mb-3">
      <div class="container">
        <tree-browser
          v-for="territory in territories"
          :key="territory.id"
          :node="territory"
          childrenKey="territories"
        ></tree-browser>
      </div>
    </main>
  </div>
</template>

<script>
import TreeBrowser from '../components/TreeBrowser.vue'

export default {
  components: {
    TreeBrowser,
  },
  data() {
    return {
      territories: [],
    }
  },
  mounted() {
    this.$http.get("/api/territories").then((response) => {
      if(response.status == 200) {
        this.territories = response.data
      }
    })    
  },
}
</script>
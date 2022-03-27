<template>
  <div>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
      <router-link :to="{ name: 'dashboard' }" class="navbar-brand"
        >Laravel-Vue SPA</router-link
      >
      <button
        class="navbar-toggler"
        data-toggle="collapse"
        data-target="#navbarCollapse"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="navbarCollapse" class="collapse navbar-collapse">

        <ul v-if="showAuth" class="navbar-nav ml-auto">

          <li class="nav-item">
            <router-link
              class="nav-link"
              data-toggle="collapse"
              :to="{ name: 'login' }"
            >
              Login
            </router-link>
          </li>

          <li class="nav-item">
            <router-link
              class="nav-link"
              data-toggle="collapse"
              :to="{ name: 'register' }"
            >
              Register
            </router-link>
          </li>

        </ul>

      </div>
    </nav>
  </div>

  <div class="container-fluid">
    <router-view />
  </div>
</template>

<script>
import router from './router'
export default {
    router: router,
    computed: {
      showAuth() {
        return !this.$store.state.loggedIn;
      }
    }
};
</script>
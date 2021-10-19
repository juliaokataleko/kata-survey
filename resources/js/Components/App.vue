<template>
  <div class="mt-4">
    <!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark my-3">
            <router-link class="navbar-brand" :to="{ name: 'Home' }">Inicio</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                <li class="nav-item">
                    <router-link class="nav-link" :to="{ name: 'About' }">Sobre</router-link>
                </li>
                </ul>
            </div>
        </nav> -->

    <div class="">
        <router-view></router-view>
        <vue-progress-bar></vue-progress-bar>
    </div>
  </div>
</template>

<script>
export default {
  setup() {},
  created () {
    //  [App.vue specific] When App.vue is first loaded start the progress bar
    this.$Progress.start()
    //  hook the progress bar to start before we move router-view
    this.$router.beforeEach((to, from, next) => {
      //  does the page we want to go to have a meta.progress object
      if (to.meta.progress !== undefined) {
        let meta = to.meta.progress
        // parse meta tags
        this.$Progress.parseMeta(meta)
      }
      //  start the progress bar
      this.$Progress.start()
      //  continue to next page
      next()
    })
    //  hook the progress bar to finish after we've finished moving router-view
    this.$router.afterEach((to, from) => {
      //  finish the progress bar
      this.$Progress.finish()
    })
  }
};
</script>

<template>
  <v-app>
    <v-content>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md6 lg4 xl3>
            <transition>
              <v-expand-transition>
                  <router-view />
              </v-expand-transition>
            </transition>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </v-app>

</template>

<script>


export default {
  components: {

  },

  data() {
    return {
      email: "",
      password: "",
      rules: {
        required: value => !!value || 'Digite o email'
      }
    }
  },

  methods: {
    login() {
    },

    register() {
      this.$nextTick(() => {
        this.$router.push({ name: 'UserRegister' });
      });
    }
  }
}
</script>

<style></style>

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

            <!--Aviso gerado durante o sistema, sua configuração encontra no helpers/aviso.js-->
            <v-dialog :value="$root.gAviso" @input="$root.gAviso = $event" max-width="450">
              <v-alert prominent border="left" :value="true" :type="($root.gAvisoError) ? 'error' : 'success'"
                class="ma-0">
                <div v-html="$root.gAvisoMsg"></div> <!-- Usando v-html para permitir HTML -->
              </v-alert>
            </v-dialog>
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

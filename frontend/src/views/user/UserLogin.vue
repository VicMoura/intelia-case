<template>
  <FormsComponent title="INTELIA">
    <span class="text-decoration-none">Faça o login para entrar no sistema</span>

    <v-text-field
      class="mt-5"
      prepend-inner-icon="mdi-account"
      name="email"
      label="Email"
      v-model="email"
      type="text"
      outlined
      :rules="[vRequired]"
    ></v-text-field>

    <v-text-field
      class="mb-2"
      prepend-inner-icon="mdi-lock"
      name="senha"
      label="Senha"
      type="password"
      outlined
      :rules="[vRequired]"
      hide-details
    ></v-text-field>

    <a href="#" class="text-decoration-none">Esqueceu a senha?</a>

    <template #actions>
      <v-btn
        dark
        color="primary"
        class="mb-3"
        style="width: 95%;"
        type="submit"
      >
        Entrar
      </v-btn>

      <v-card-text class="text-center">
        <a
          class="text-decoration-none text-subtitle-1"
          @click="register"
          rel="noopener noreferrer"
        >
          Cadastre-se <v-icon>mdi-chevron-right</v-icon>
        </a>
      </v-card-text>
    </template>
  </FormsComponent>
</template>

<script>
import FormsComponent from '@/components/forms/FormsComponent.vue';

export default {
  components: {
    FormsComponent
  },

  data() {
    return {
      email: "",
      password: ""
    };
  },

  methods: {

    register() {

        this.$router.push({ name: 'UserRegister' });
      
    }
  },

}
</script>
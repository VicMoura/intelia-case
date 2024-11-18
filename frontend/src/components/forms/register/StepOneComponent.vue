<template>
  <FormsComponent title="Cadastrar" ref="form" :currentStep="currentStep">
    <v-text-field
      prepend-inner-icon="mdi-account"
      v-model="user.full_name"
      label="Nome completo"
      type="text"
      outlined
      :rules="[vRequired]"
    />

    <v-text-field
      prepend-inner-icon="mdi-calendar"
      v-model="user.birth_date"
      label="Data de nascimento"
      outlined
      v-mask="maskData"
      :rules="[vRequired, v => vDateLte(v, getDataAtual(), 'atual'), vIsAdult]"
    />

    <template #actions>
      <v-btn
        dark
        color="primary"
        class="action-button"
        @click="handleSubmit"
        :disabled="isSubmitting" 
      >
        Continuar
      </v-btn>

      <v-btn
        dark
        color="primary"
        class="action-button ml-0"
        outlined
        @click="$router.push('/login')"
      >
        Voltar
      </v-btn>
    </template>
  </FormsComponent>
</template>

<script>
import FormsComponent from '../FormsComponent.vue';
import { mapGetters, mapActions } from 'vuex';

export default {
  name: 'StepOneComponent',

  components: {
    FormsComponent
  },

  data() {
    return {
      initialUser: {},
      isSubmitting : false
    };
  },

  computed: {
    ...mapGetters('register', ['user', 'currentStep']),
    model: {
      get() {
        return this.user;
      },
      set(value) {
        this.$store.commit('register/SET_USER', value);
      },
    },
  },

  activated() {
    this.initialUser = { ...this.user };
  },

  methods: {
    ...mapActions('register', ['setStep', 'createUser', 'updateUser']),

    getDataAtual() {
      return new Date();
    },

    async handleSubmit() {
      if (this.isSubmitting) return; // Evita múltiplas execuções

      const isValid = await this.$refs.form.validate();

      if (isValid) {

        this.isSubmitting = true; // Inicia a submissão
        
        try {
          if (!this.user.id) {

            await this.createUser();
            localStorage.setItem("step", this.currentStep+1);
            this.aviso('Primeira etapa concluída com sucesso!');

          } else {

            const updatedFields = this.$clearData(this.user, this.initialUser);

            if (Object.keys(updatedFields).length > 0) {
              const msg = await this.updateUser(updatedFields);
              this.aviso(msg);
            }

          }
          
          this.setStep(this.currentStep + 1);
          
        } catch (err) {
          this.avisoErro(err);
        } finally {
          this.isSubmitting = false;
        }

      } else {
        this.avisoErro('Por favor, preencha os campos obrigatórios para prosseguir para a próxima etapa.');
      }
    },
  },
};
</script>

<template>
  <FormsComponent 
    title="Cadastrar" 
    @submit="cadastro"
  >
    <div>
      <v-stepper  v-model="step" style="box-shadow: none">
        <v-stepper-header style="box-shadow: none">
          <v-stepper-step :complete="step > 1" step="1"></v-stepper-step>
          <v-divider></v-divider>
          <v-stepper-step :complete="step > 2" step="2"></v-stepper-step>
          <v-divider></v-divider>
          <v-stepper-step step="3"></v-stepper-step>
        </v-stepper-header>

        <v-stepper-items>
          <v-expand-transition>
            <component 
              :is="currentStepComponent" 
              :key="step"
            />
          </v-expand-transition>
        </v-stepper-items>
      </v-stepper>
    </div>

    <template #actions>
      <v-btn 
        dark
        color="primary"
        class="action-button"
        type="submit"
      >
        {{ nameButtonLabel }}
      </v-btn>

      <v-btn 
        dark
        color="primary"
        class="action-button ml-0"
        outlined
        @click="voltar"
      >
        Voltar
      </v-btn>
    </template>
  </FormsComponent>
</template>

<script>
import FormsComponent from '@/components/forms/FormsComponent.vue';
import StepOneComponent from '@/components/forms/register/StepOneComponent.vue';
import StepTwoComponent from '@/components/forms/register/StepTwoComponent.vue';
import StepThreeComponent from '@/components/forms/register/StepThreeComponent.vue';

export default {
  components: {
    FormsComponent,
    StepOneComponent,
    StepTwoComponent,
    StepThreeComponent,
  },

  data() {
    return {
      step: 1,
    };
  },

  computed: {
    nameButtonLabel() {
      return this.step === 3 ? 'Confirmar' : 'Continuar';
    },

    currentStepComponent() {
      return [StepOneComponent, StepTwoComponent, StepThreeComponent][this.step - 1];
    },
  },

  methods: {
    cadastro() {
      if (this.step < 3) this.step++;
      this.saveInLocalStorage();
    },

    voltar() {
      if (this.step === 1) {
        this.$router.push({ name: 'Login' });
      } else {
        this.step--;
      }
    },

    saveInLocalStorage() {
      localStorage.setItem('Teste', '123');
    }
  },
};
</script>

<style scoped>

.action-button {
  width: 90%;
  margin-bottom: 1rem;
}


</style>

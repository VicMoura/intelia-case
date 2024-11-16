<template>
  <v-expand-transition>
    <component :is="currentStepComponent" :key="step" ref="stepComponent" @submit="cadastro" @voltar="voltar"/>
  </v-expand-transition>

</template>

<script>
import StepOneComponent from '@/components/forms/register/StepOneComponent.vue';
import StepTwoComponent from '@/components/forms/register/StepTwoComponent.vue';
import StepThreeComponent from '@/components/forms/register/StepThreeComponent.vue';

export default {
  components: {
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
      if (this.step < 3) {
        this.step++;
      }

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


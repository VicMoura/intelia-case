<template>
  <v-expand-transition>
    <keep-alive>
        <component :is="currentStepComponent" ref="stepComponent"> </component>
    </keep-alive>
  </v-expand-transition>
</template>

<script>
import StepOneComponent from "@/components/forms/register/StepOneComponent.vue";
import StepTwoComponent from "@/components/forms/register/StepTwoComponent.vue";
import StepThreeComponent from "@/components/forms/register/StepThreeComponent.vue";

import { mapGetters, mapActions } from "vuex";


export default {
  components: {
    StepOneComponent,
    StepTwoComponent,
    StepThreeComponent,
  },

  computed: {
    ...mapGetters("register", ["currentStep"]),
    currentStepComponent() {
      return [StepOneComponent, StepTwoComponent, StepThreeComponent][this.currentStep - 1];
    },
  },

  created() {
    this.initializeUser();
  },

  destroyed(){
    localStorage.removeItem(['userId', 'step']);
  },

  methods: {
    ...mapActions('register', ['initializeUser']),
  },


};
</script>

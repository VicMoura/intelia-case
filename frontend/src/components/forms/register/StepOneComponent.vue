<template>
    <FormsComponent 
      title="Cadastrar"
      ref="form"
    >
        <v-text-field 
          prepend-inner-icon="mdi-account" 
          v-model="model.full_name" 
          label="Nome completo"
          type="text"
          outlined 
          :rules="[vRequired]">
        </v-text-field>

        <v-text-field
          prepend-inner-icon="mdi-calendar" 
          v-model="model.birth_date" 
          label="Data de nascimento"
          outlined 
          v-mask="maskData"
          :rules="[vRequired, v => vDateLte(v, getDataAtual(), 'atual')]">
        </v-text-field>

        <template #actions>
            <v-btn 
              dark
              color="primary"
              class="action-button"
              @click="handleSubmit"
              
            >
              Continuar 
            </v-btn>

            <v-btn 
              dark
              color="primary"
              class="action-button ml-0"
              outlined
              @click="$emit('voltar')"
            >
              Voltar
            </v-btn>
          </template>

      </FormsComponent>
</template>

<script>

import FormsComponent from '../FormsComponent.vue';

export default {
  name: 'StepOneComponent',

  components : {
    FormsComponent
  },

  data() {
    return {
      model: {
        birth_date: '',
        full_name: ''
      },
      step : 1
    };
  },
  methods: {
    getDataAtual() {
      let data = new Date();
      return data;
    },

    async handleSubmit() {
      const isValid = await this.$refs.form.validate(); 
      if (isValid) {
        this.$emit('submit', this.model); 
      } else {
        console.error('Formulário inválido!');
      }
    }


  }
};
</script>
<template>
    <FormsComponent 
      title="Cadastrar"
      ref="form"
    >
      <v-text-field 
        prepend-inner-icon="mdi-map-marker" 
        label="CEP" 
        type="text" 
        outlined
        v-mask="maskCEP"
        v-model="modal.zip_code"
        :rules="[vRequired]"
        >
      </v-text-field>
  
      <v-text-field 
        label="Rua" 
        type="text" 
        v-model="modal.street"
        outlined
        :rules="[vRequired]"
      />

      <v-text-field 
        label="Numero" 
        type="number" 
        v-model="modal.number"
        outlined
        :rules="[vRequired, vPositive]"
      />

      <v-select
        label="Estado"
        :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
        v-model="modal.state"
        outlined
        :rules="[vRequired]"
      />

      <v-select
        label="Cidade"
        :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
        v-model="modal.city"
        outlined
        :rules="[vRequired]"
      />

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
    name: 'StepTwoComponent',
    components : {
      FormsComponent
    },
  
    data() {
      return {
        modal : {
          zip_code : '',
          street : '',
          number : null, 
          state : '',
          city : ''
        }
      };
    },
    methods: {
      async handleSubmit() {
        const isValid = await this.$refs.form.validate(); 
        if (isValid) {
          this.$emit('submit', this.model); 
        } else {
          console.error('Formulário inválido!');
        }
      }
    },
  };
  </script>
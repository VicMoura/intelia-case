<template>
    <div>
    <v-container>
      <v-text-field 
        prepend-inner-icon="mdi-map-marker" 
        name="zip_code" 
        label="CEP" 
        type="text" 
        outlined
        v-mask="'#####-###'"
        v-model="item"
        >
      </v-text-field>
  
      <v-text-field 
        label="Rua" 
        type="text" 
        outlined
      />

      <v-text-field 
        label="Numero" 
        type="number" 
        outlined
      />

      <v-select
        label="Estado"
        :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
        outlined
      />

      <v-select
        label="Cidade"
        :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
        outlined
      />

    
    </v-container>
  </div>
  
  </template>
  
  
  <script>
  export default {
    name: 'StepTwoComponent',
  
    data() {
      return {
        item : '',
        data: ''
      };
    },
    methods: {
  
    },
  };
  </script>
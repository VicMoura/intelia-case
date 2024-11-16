<template>
    <v-container>
      <v-text-field 
        prepend-inner-icon="mdi-phone" 
        name="zip_code" 
        label="Telefone fixo" 
        outlined
        v-mask="mask"
        v-model="phone"
        >
      </v-text-field>

      <v-text-field 
        prepend-inner-icon="mdi-phone" 
        name="zip_code" 
        label="Telefone Celular" 
        outlined
        v-mask="mask"
        v-model="phone"
        >
      </v-text-field>
    
    </v-container>
  
  
  </template>
  
  
  <script>
  export default {
    name: 'StepThreeComponent',
  
    data() {
      return {
        item : '',
        data: '',
        phone: ''
      };
    },
    computed : {
        mask() {
            //Retirando mask 
            let phoneOnlyNumbers = this.phone.replace(/[\s()-]/g, '');
            
            return phoneOnlyNumbers.length > 10 ? '(##) #####-####' : '(##) ####-####';
        }
    },
    methods: {
  
    },


  };
  </script>
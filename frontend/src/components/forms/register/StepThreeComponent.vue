<template>
    <FormsComponent 
      title="Cadastrar"
      ref="form"
    >
      <v-text-field 
        prepend-inner-icon="mdi-phone" 
        label="Telefone fixo" 
        outlined
        v-mask="maskTel"
        v-model="model.telephone"
        :rules="[vRequired]"
        >
      </v-text-field>

      <v-text-field 
        prepend-inner-icon="mdi-phone" 
        label="Telefone Celular" 
        outlined
        v-model="model.celular"
        v-mask="mask"
        >
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
    name: 'StepThreeComponent',

    components : {
        FormsComponent
    },
  
    data() {
      return {
        model : {
            telephone : '',
            celular : ''
        }
      };
    },
    computed : {
        mask() {
            
            let phoneOnlyNumbers = this.model.celular.replace(/[\s()-]/g, '');
            
            return phoneOnlyNumbers.length > 10 ? this.maskTelCel : this.maskTel;
        }
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
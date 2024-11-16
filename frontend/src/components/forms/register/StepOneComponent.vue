<template>
  <FormsComponent title="Cadastrar" ref="form">
    <v-text-field 
      prepend-inner-icon="mdi-account" 
      v-model="modelLocal.full_name" 
      label="Nome completo" 
      type="text" 
      outlined 
      :rules="[vRequired]"
    />

    <v-text-field 
      prepend-inner-icon="mdi-calendar" 
      v-model="modelLocal.birth_date" 
      label="Data de nascimento" 
      outlined 
      v-mask="maskData" 
      :rules="[vRequired, v => vDateLte(v, getDataAtual(), 'atual')]"
    />

    <template #actions>
      <v-btn dark color="primary" class="action-button" @click="handleSubmit">
        Continuar
      </v-btn>

      <v-btn dark color="primary" class="action-button ml-0" outlined @click="$emit('voltar')">
        Voltar
      </v-btn>
    </template>
  </FormsComponent>
</template>

<script>
import FormsComponent from '../FormsComponent.vue';

export default {
  name: 'StepOneComponent',

  components: {
    FormsComponent
  },

  props : {
    model : {
        type : Object,
        default: () => ({})
    }
  },

  data() {
    return {
      step: 1,
      modelLocal : {}
    };
  },
  
  methods: {
    getDataAtual() {
      return new Date();
    },

    async handleSubmit() {
      const isValid = await this.$refs.form.validate();

      if (isValid) {
        this.$emit('submit', this.modelLocal);
      } else {
        console.error('Formulário inválido!');
      }
    },
  },

  watch: {
    model: {
      immediate: true, 
      handler(newValue) {
        if(newValue){
          this.modelLocal = { ...newValue }; 
          console.log('Model atualizado:', this.modelLocal);
        }
      },
    },
  },

};
</script>

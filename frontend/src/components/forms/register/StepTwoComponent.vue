<template>
  <FormsComponent title="Cadastrar" ref="form">
    <v-text-field prepend-inner-icon="mdi-map-marker" label="CEP" type="text" outlined v-mask="maskCEP"
      v-model="modelLocal.zip_code" :rules="[vRequired]">
    </v-text-field>

    <v-text-field label="Rua" type="text" v-model="modelLocal.street" outlined :rules="[vRequired]" />

    <v-text-field label="Numero" type="number" v-model="modelLocal.number" outlined :rules="[vRequired, vPositive]" />

    <v-select label="Estado" :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
      v-model="modelLocal.state" outlined :rules="[vRequired]" />

    <v-select label="Cidade" :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
      v-model="modelLocal.city" outlined :rules="[vRequired]" />

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
  name: 'StepTwoComponent',
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
      modelLocal: {
      }
    };
  },
  methods: {
    async handleSubmit() {
      const isValid = await this.$refs.form.validate();
      if (isValid) {
        console.log(this.modelLocal);
        this.$emit('submit', this.modelLocal);
      } else {
        console.error('Formulário inválido!');
      }
    }
  },

  watch: {
    model: {
      immediate: true,
      handler(newValue) {
        if(newValue){
          this.modelLocal = { ...newValue.addresses[0] };
          console.log('Model atualizado:', this.modelLocal);
        }
      },
    },
  },
};
</script>
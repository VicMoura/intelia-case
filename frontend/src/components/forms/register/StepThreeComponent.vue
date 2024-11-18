<template>
  <FormsComponent title="Cadastrar" ref="form" :currentStep="currentStep">
    <div v-for="(item, index) in phone.phones" :key="index" class="phone-item">
      <v-switch
        v-model="item.phone_type"
        inset
        :label="item.phone_type === 'mobile' ? 'Celular' : 'Fixo'"
        :false-value="'fixed'"
        :true-value="'mobile'"
      ></v-switch>

      <v-text-field
        prepend-inner-icon="mdi-phone"
        :label="'Telefone ' + (item.phone_type === 'mobile' ? 'Celular' : 'Fixo')"
        outlined
        v-model="item.phone_number"
        v-mask="item.phone_type === 'mobile' ? maskTelCel : maskTel"
        :rules="[vRequired]"
      >
        <!-- Botão de excluir dentro do campo de telefone -->
        <template #append>
          <v-btn
            v-if="phone.phones.length > 1"
            class="delete-btn"
            icon
            @click="removePhone(index)"
            :aria-label="'Excluir telefone ' + (item.phone_type === 'mobile' ? 'Celular' : 'Fixo')"
          >
            <v-icon>mdi-delete</v-icon>
          </v-btn>
        </template>
      </v-text-field>
    </div>

    <!-- Botão para adicionar mais telefones -->
    <v-container class="d-flex justify-center">
      <v-btn dark color="primary" @click="addPhone" icon outlined>
        <v-icon>mdi-plus</v-icon>
      </v-btn>
    </v-container>

    <template #actions>
      <v-btn dark color="primary" class="action-button" @click="handleSubmit" :disabled="isSubmitting">
        Continuar
      </v-btn>

      <v-btn dark color="primary" class="action-button ml-0" outlined @click="setStep(currentStep - 1)">
        Voltar
      </v-btn>
    </template>
  </FormsComponent>
</template>


<script>
import FormsComponent from '../FormsComponent.vue';

import { mapGetters, mapActions } from "vuex";


export default {
  name: 'StepThreeComponent',

  components: {
    FormsComponent
  },


  data() {
    return {
      isSubmitting : false
    };
  },

  computed: {
    ...mapGetters("register", ["currentStep", "phone"]),
    model: {
      get() {
        return this.phone;
      },
      set(value) {
        this.$store.commit("register/SET_PHONE", value);
      }
    },
  },

  methods: {
    ...mapActions("register", ["setStep", "createPhone", "resetState"]),

    async handleSubmit() {

      if (this.isSubmitting) return;

      const isValid = await this.$refs.form.validate();

      if (isValid) {

        this.isSubmitting = true;

        this.createPhone(this.phone.phones)
          .then((result) => {
            this.aviso(result);
            this.resetState();
            this.$router.push('login');
            this.isSubmitting = true;
          })
          .catch((error) => {
            this.isSubmitting = true;
            this.avisoErro(error);
          });

        
      } else {
        this.avisoErro('Por favor, preencha os campos obrigatórios para finalizar o cadastro.');
      }
      
    },

    addPhone() {
      this.phone.phones.push({
        phone_type: 'mobile',
        phone_number: ''
      });

    },

    removePhone(index) {
      this.phone.phones.splice(index, 1);
    },
  },

};
</script>

<style scoped>
.phone-item {
  margin-bottom: 10px;
}

.delete-btn {
  position: absolute;
  right: 5px;
  top: 50%;
  transform: translateY(-50%);
}
</style>

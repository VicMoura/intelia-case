<template>
  <FormsComponent 
    title="Cadastrar"
    ref="form"
  >
    <div v-for="(phone, index) in modelLocal.phones" :key="index" class="phone-item">
      <v-switch
        v-model="phone.phone_type"
        inset
        :label="phone.phone_type === 'mobile' ? 'Celular' : 'Fixo'"
        :false-value="'fixed'"
        :true-value="'mobile'"
      >
      </v-switch>

      <v-text-field 
        prepend-inner-icon="mdi-phone" 
        :label="'Telefone ' + (phone.phone_type === 'mobile' ? 'Celular' : 'Fixo')" 
        outlined
        v-model="phone.phone_number"
        v-mask="phone.phone_type === 'mobile' ? maskTelCel : maskTel"
        :rules="[vRequired]"
      >
        <!-- Botão de excluir dentro do campo de telefone -->
        <template #append>
          <v-btn
            v-if="modelLocal.phones.length > 1"
            class="delete-btn"
            icon 
            @click="removePhone(index)"
            :aria-label="'Excluir telefone ' + (phone.phone_type === 'mobile' ? 'Celular' : 'Fixo')"
          >
            <v-icon>mdi-delete</v-icon>
          </v-btn>
        </template>
      </v-text-field>
    </div>

    <!-- Botão para adicionar mais telefones -->
     <v-container class="d-flex justify-center">
        <v-btn 
            dark
            color="primary"
            @click="addPhone"
            icon
            outlined
            >
            <v-icon>mdi-plus</v-icon>
        </v-btn>
     </v-container>
    
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
        phones: [
          {
            phone_type: 'mobile', 
            phone_number: ''
          }
        ],
      },
    };
  },

  computed : {
        mask() {
            
            let phoneOnlyNumbers = this.modelLocal.celular.replace(/[\s()-]/g, '');
            
            return phoneOnlyNumbers.length > 10 ? this.maskTelCel : this.maskTel;
        }
    },

  methods: {
    async handleSubmit() {
      const isValid = await this.$refs.form.validate(); 
      if (isValid) {
        this.$emit('submit', this.modelLocal.phones); 
      } else {
        console.error('Formulário inválido!');
      }
    },

    addPhone() {

        this.modelLocal.phones.push({
        phone_type: 'mobile', 
        phone_number: ''
      });

    },

    removePhone(index) {
        this.modelLocal.phones.splice(index, 1);
    },
  },

  watch: {
      model: {
        immediate: true,
        handler(newValue) {
          console.log(newValue);
          if(newValue.phones.length > 0){
            this.modelLocal.phones = { ...newValue.phones };
            console.log('Model atualizado:', this.modelLocal);
         }
        },
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

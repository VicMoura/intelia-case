<template>
  <v-expand-transition>
    <keep-alive>
      <component :is="currentStepComponent" :model="model.user" :key="step" ref="stepComponent" @submit="cadastro" @voltar="voltar" />
    </keep-alive>
  </v-expand-transition>

</template>

<script>
import StepOneComponent from '@/components/forms/register/StepOneComponent.vue';
import StepTwoComponent from '@/components/forms/register/StepTwoComponent.vue';
import StepThreeComponent from '@/components/forms/register/StepThreeComponent.vue';

import UserProvider from '@/API/UserProvider';
import AddressProvider from '@/API/AddressProvider';
import PhoneProvider from '@/API/PhoneProvider';

export default {
  components: {
    StepOneComponent,
    StepTwoComponent,
    StepThreeComponent,
  },

  data() {
    return {
      UserProvider,
      AddressProvider,
      PhoneProvider,
      step: 1,
      model: {
        address: {

        },
        user: {

        },
        phone: {

        }
      }
    };
  },

  computed: {
    nameButtonLabel() {
      return this.step === 3 ? 'Confirmar' : 'Continuar';
    },

    currentStepComponent() {
      return [StepOneComponent, StepTwoComponent, StepThreeComponent][this.step - 1];
    }
  },

  beforeCreate () {
    let userId = localStorage.getItem('userId');
    let currentStepUser = localStorage.getItem('step');

    if(userId && currentStepUser){
        UserProvider.detail(userId, {
          success: (user) => {
            this.model.user = { ...this.model.user, ...user.user };
            this.step = currentStepUser;
            console.log(user);

          },
          error: (err) => {
            console.log('Erro ao buscar usuário', err);
          }
      })
    }
    
  },

  methods: {
    cadastro(data) {

      let newData;

      if (this.step == 1) {
        newData = this.clearData(data, this.model.user);
        if (!this.model.user.id) {
          this.createUser(newData);
        } else {
          this.updateUser(newData, this.model.user.id);
        }
      }

      if (this.step == 2) {
        newData = this.clearData(data, this.model.address);
        if (!this.model.address.id) {
          newData = { ...newData, user_id: this.model.user.id };
          this.createAddress(newData);
        } else {
          this.updateAddress(newData, this.model.address.id);
        }
      }

      if (this.step == 3) {
        newData = this.clearData(data, this.model.phone);
        if (!this.model.phone.id) {
          newData = { ...newData, user_id: this.model.user.id };
          this.createPhone(newData);
        } else {
          this.updatePhone(newData, this.model.phone.id);
        }
      }

      if (this.step < 3) {
        this.step++;
      }else{
        this.clearLocalStorage();
        this.$router.push({ name: 'Login' });
      }

    },

    voltar() {
      if (this.step === 1) {
        this.$router.push({ name: 'Login' });
      } else {
        this.step--;
      }
    },

    clearData(data, otherData) {

      let newData = {}

      if (data && Object.keys(data).length > 0) {
        for (const key in data) {
          if (Object.prototype.hasOwnProperty.call(data, key) && otherData[key] !== data[key]) {
            newData[key] = data[key];
          }
        }
      }

      return newData;
    },

    saveInLocalStorage() {
      localStorage.setItem('userId', this.model.user.id);
      localStorage.setItem('step', this.step);
    },

    clearLocalStorage() {
      localStorage.removeItem('userId');
      localStorage.removeItem('step');
    },

    async createUser(data) {
      UserProvider.create({
        data,
        success: (user) => {
          this.model.user = { ...this.model.user, ...user.user };
          this.saveInLocalStorage();

        },
        error: (err) => {
          console.log('Erro ao buscar usuário', err);
        }
      })
    },

    async updateUser(data, id) {
      UserProvider.update(id, {
        data,
        success: (user) => {
          this.model.user = { ...this.model.user, ...user.user };
          console.log(this.model);

        },
        error: (err) => {
          console.log('Erro ao buscar usuário', err);
        }
      })
    },

    async createAddress(data) {
      AddressProvider.create({
        data,
        success: (address) => {
          this.model.address = { ...this.model.address, ...address.address };
          console.log(this.model);

        },
        error: (err) => {
          console.log('Erro ao buscar usuário', err);
        }
      })
    },

    async updateAddress(data, id) {
      AddressProvider.update(id, {
        data,
        success: (address) => {
          this.model.address = { ...this.model.address, ...address.address };
          console.log(this.model);

        },
        error: (err) => {
          console.log('Erro ao buscar usuário', err);
        }
      })
    },

    async createPhone(data) {
      PhoneProvider.create({
        data,
        success: (phone) => {
          this.model.phone = { ...this.model.phone, ...phone.phone };
          console.log(this.model);

        },
        error: (err) => {
          console.log('Erro ao buscar usuário', err);
        }
      })
    },

    async updatePhone(data, id) {
      PhoneProvider.update(id, {
        data,
        success: (phone) => {
          this.model.phone = { ...this.model.phone, ...phone.phone };
          console.log(this.model);

        },
        error: (err) => {
          console.log('Erro ao buscar usuário', err);
        }
      })
    },

  },
};
</script>

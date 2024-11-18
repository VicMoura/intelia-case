<template>
  <FormsComponent title="Cadastrar" ref="form" :currentStep="currentStep">
    <v-text-field
      prepend-inner-icon="mdi-map-marker"
      label="CEP"
      type="text"
      outlined
      v-mask="maskCEP"
      v-model="address.zip_code"
      :rules="[vRequired, vValidCEP]"
    />

    <v-text-field
      label="Rua"
      type="text"
      v-model="address.street"
      outlined
       :rules="[vRequired]"
    />

    <v-text-field
      label="Número"
      type="number"
      v-model="address.number"
      outlined
       :rules="[vRequired, vPositive, v => vMaxLength(v, 5)]"
    />

    <v-select
      label="Estado"
      :items="states"
      v-model="address.state"
      outlined
      @change="fetchCities"
      :rules="[vRequired]"
    />

    <v-select
      label="Cidade"
      :items="cities"
      v-model="address.city"
      outlined
      :rules="[vRequired]"
    />

    <template #actions>
      <v-btn
        dark
        color="primary"
        class="action-button"
        @click="handleSubmit"
        :disabled="isSubmitting" 
      >
        Continuar
      </v-btn>

      <v-btn
        dark
        color="primary"
        class="action-button ml-0"
        outlined
        @click="setStep(currentStep - 1)"
      >
        Voltar
      </v-btn>
    </template>
  </FormsComponent>
</template>

<script>
import FormsComponent from "../FormsComponent.vue";
import { mapGetters, mapActions } from "vuex";

export default {
  name: "StepTwoComponent",
  components: {
    FormsComponent,
  },
  data() {
    return {
      states: [], // Lista de estados
      cities: [], // Lista de cidades
      initialAddress: {},
      isSubmitting : false
    };
  },
  computed: {
    ...mapGetters("register", ["currentStep", "user", "address"]),
    model: {
      get() {
        return this.address;
      },
      set(value) {
        this.$store.commit("register/SET_ADDRESS", value);
      },
    },
  },
  activated() {
    this.initialAddress = { ...this.address, user_id: this.user.id };
  },
  mounted() {
    this.loadInitialData();
  },
  methods: {
    ...mapActions("register", ["setStep", "createAddress", "updateAddress"]),
    
    async loadInitialData() {
      await this.fetchStates();
      if (this.address.state) {
        await this.fetchCities(this.address.state, true);
      }
    },

    async fetchStates() {
      try {
        const response = await fetch(
          "https://servicodados.ibge.gov.br/api/v1/localidades/estados"
        );
        const data = await response.json();
        this.states = data.map((state) => ({
          text: state.nome,
          value: state.sigla,
        }));
      } catch (error) {
        this.avisoErro("Erro ao buscar estados:", error);
      }
    },

    async fetchCities(state, comeMounted = false) {
      if (!state && !comeMounted) return;

      if (!comeMounted) {
        this.address.city = "";
      }

      try {
        const response = await fetch(
          `https://servicodados.ibge.gov.br/api/v1/localidades/estados/${state}/municipios`
        );
        const data = await response.json();
        this.cities = data.map((city) => ({
          text: city.nome,
          value: city.nome,
        }));
      } catch (error) {
        this.avisoErro("Erro ao buscar cidades:", error);
      }
    },

    async handleSubmit() {

      if (this.isSubmitting) return;

      const isValid = await this.$refs.form.validate();

      if (isValid) {

        this.isSubmitting = true;

        try {
          if (!this.address.id) {
            await this.createAddress(this.model);
            localStorage.setItem("step", this.currentStep+1);
            
            this.aviso("Segunda etapa finalizada com sucesso!");
          } else {
            const updatedFields = this.$clearData(this.address, this.initialAddress);
            if (Object.keys(updatedFields).length > 0) {
              await this.updateAddress(updatedFields);
              this.aviso("Endereço atualizado com sucesso!");
            }
          }

          this.setStep(this.currentStep + 1);
          
        } catch (err) {
          this.avisoErro(err);
        } finally {
          this.isSubmitting = false;
        }

      } else {
        this.avisoErro(
          "Por favor, preencha os campos obrigatórios para prosseguir para a próxima etapa."
        );
      }
    },
  },
};
</script>
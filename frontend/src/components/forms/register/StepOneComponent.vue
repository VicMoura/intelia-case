<template>
  <div>
  <v-container>
    <v-text-field 
      prepend-inner-icon="mdi-account" 
      name="full_name" 
      label="Nome completo" 
      type="text" 
      outlined>
    </v-text-field>

    <v-text-field 
      prepend-inner-icon="mdi-calendar" 
      name="birth_date" 
      label="Data de nascimento" 
      type="date" 
      outlined
      hide-details
      >
    </v-text-field>
  </v-container>
</div>

</template>


<script>
export default {
  name: 'StepOneComponent',

  data() {
    return {
    };
  },
  methods: {

  },
};
</script>
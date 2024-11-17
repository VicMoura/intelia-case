import Vue from "vue";

// Organizar as chamadas de aviso no sistema, quando for necessário mostrar alerta de sucesso, utilize aviso.
// Caso o contrário, utilize avisoError

Vue.mixin({
  methods: {
    aviso: function (msg) {
      this.$root.gAviso = true;
      this.$root.gAvisoError = false;
      this.$root.gAvisoMsg = msg;

      this.setAvisoTimer();
    },

    avisoErro: function (erro) {
      this.$root.gAviso = true;
      this.$root.gAvisoError = true;
      if(Array.isArray(erro) && erro.length > 0) {
        let errorMessage = "<ul>";
        erro.forEach((error) => {
          errorMessage += `<li>${error}</li>`;
        });
        errorMessage += "</ul>";
        this.$root.gAvisoMsg = errorMessage;
      }else{
        this.$root.gAvisoMsg = erro;
      }

      this.setAvisoTimer();
    },

    setAvisoTimer() {
      if (this.$root.gAvisoTimer) window.clearTimeout(this.$root.gAvisoTimer);

      this.$root.gAvisoTimer = setTimeout(() => {
        this.$root.gAviso = false;
      }, 10000);
    },
  },
});

import Vue from "vue";

Vue.mixin({
    data() {
        return {
            maskData: "##/##/####", 
            maskCEP: "#####-###",
            maskTel: "(##) ####-####", 
            maskTelCel: "(##) #####-####"
        }
    }
})
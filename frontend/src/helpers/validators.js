import Vue from "vue";
import _ from 'lodash';
import moment from 'moment';

function dateValidation(v, date, dateName=false, op) {
    if (!v || !date) {
        return true;
    }

    v = moment(v, "DD/MM/YYYY");
    date = moment(date, "YYYY-MM-DD");

    if (!v.isValid() || !date.isValid()) {
        return true;
    }

    let ruleForError = false;
    let wording = "";

    if (op == ">") {
        ruleForError = v.diff(date, 'days') < 1;
        wording = "maior que";

    } else if (op == ">=") {
        ruleForError = v.diff(date, 'days') < 0;
        wording = "maior ou igual";
    } else if (op == "<=") {
        ruleForError = v.diff(date, 'days') > 0;
        wording = "menor ou igual";
    }

    if (ruleForError) {
        if (dateName) {
            return `A data precisa ser ${wording} a data ${dateName}`;
        }

        return `A data precisa ser ${wording} a outra`;
    }

    return true;
}

Vue.mixin({
    methods : {
        vRequired(v) {
            if (v === "" || v === null || typeof v === "undefined") {
                return "Esse campo é obrigatório!";

            } else if (_.isObject(v) && _.isEmpty(v)) {
                return "Esse campo é obrigatório!";

            } else {
                return true;
            }
        },

        vDateLte(v, date, dateName=false) {
            return dateValidation(v, date, dateName, "<=")
        },

        vPositive(v){
           return v < 0 ? 'O número precisa ser positivo.' : true
        },

        vValidDate(v) {
            const date = moment(v, "DD/MM/YYYY", true);
            return date.isValid() ? true : "Data inválida!";
        },

        vIsAdult(v) {
            const date = moment(v, "DD/MM/YYYY", true);

            const today = moment();
            const age = today.diff(date, "years");
            return age >= 18 ? true : "Você precisa ter pelo menos 18 anos!";
        },

        vMaxLength(v, maxLength) {
            const stringValue = v ? v.toString() : "";
            return stringValue.length > maxLength
                ? `O campo deve ter no máximo ${maxLength} caracteres.`
                : true;
        },

        vValidCEP(v) {
            const cepPattern = /^\d{5}-\d{3}$/;
            if (!v) {
                return true;
            }

            if (!cepPattern.test(v)) {
                return "O CEP deve estar no formato XXXXX-XXX.";
            }

            return true;
        },

        vValidPhoneNumber(v) {
            // Padrão para telefones no formato: (99) 99999-9999 ou (99) 9999-9999
            const phonePattern = /^\(?\d{2}\)? ?\d{4,5}-\d{4}$/;
        
            // Permite valor vazio
            if (!v) {
                return true;
            }
        
            if (!phonePattern.test(v)) {
                return "O telefone deve estar no formato (XX) XXXXX-XXXX ou (XX) XXXX-XXXX.";
            }
        
            return true;
        }
        
    }
})
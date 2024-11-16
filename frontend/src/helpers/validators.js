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
        }
    }
})
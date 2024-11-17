<template>
    <v-card class="elevation-12">


        <v-form ref="form" @submit.prevent="$emit('submit')">
            <v-toolbar :height="'auto'" style="min-height: 110px">
                <v-spacer />
                <img class="mt-2" src="@/assets/logo.png" alt="Logo" />
                <v-spacer />
            </v-toolbar>

            <v-stepper v-if="currentStep" non-linear style="box-shadow: none;" v-model="localCurrentStep">
                <v-stepper-header>
                    <div v-for="x in totalStep" :key="x">
                        <v-stepper-step :step="x" disabled />
                        <v-divider></v-divider>

                    </div>


                </v-stepper-header>
            </v-stepper>

            <v-card-text>
                <slot></slot>
            </v-card-text>

            <v-card-actions class="d-flex flex-column justify-center">
                <slot name="actions">
                    <v-btn dark color="primary" class="mb-3" style="width: 95%;" type="submit">
                        {{ buttonLabel }}
                    </v-btn>
                </slot>
            </v-card-actions>
        </v-form>
    </v-card>
</template>

<script>

export default {
    name: 'FormsComponent',
    props: {
        title: {
            type: String,
            default: "Intelia"
        },
        buttonLabel: {
            type: String,
            default: "Confirmar"
        },
        currentStep: {
            type: Number,
            default: null
        },
        totalStep: {
            type: Number,
            default: 3
        }
    },

    data() {
        return {
            localCurrentStep: this.currentStep
        }
    },

    methods: {
        validate() {
            return this.$refs.form.validate();
        }
    },

    beforeUpdate(){
        this.localCurrentStep = this.currentStep;
    },

    watch: {
        currentStep(newStep) {
            this.localCurrentStep = newStep;
        }
    }
}
</script>

<style></style>
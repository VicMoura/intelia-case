<template>
    <v-card class="elevation-12">
        <v-form ref="form" @submit.prevent="$emit('submit')">
            <v-toolbar :height="'auto'" style="min-height: 110px">
                <v-spacer />
                    <img class="mt-2" src="@/assets/logo.png" alt="Logo" />
                <v-spacer />
            </v-toolbar>

            <v-card-text>
                <slot></slot>
            </v-card-text>

            <v-card-actions class="d-flex flex-column justify-center">
                <slot name="actions">
                    <v-btn 
                        dark
                        color="primary"
                        class="mb-3"
                        style="width: 95%;"
                        type="submit"
                        >
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
    props:{
        title: {
            type: String, 
            default: "Intelia"
        },
        buttonLabel: {
            type: String,
            default : "Confirmar"
        }
    },

    data() {
        return {
        }
    },

    methods: {
        validate() {
            return this.$refs.form.validate();
        }
    }
}
</script>

<style></style>
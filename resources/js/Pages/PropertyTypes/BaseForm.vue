<script>
import InputError from "@/Components/InputError.vue";

export default {
    name: "BaseForm",
    components: {InputError},
    props: {
        mainForm: Object,
        mainDisable: Boolean,
        errors: Object,
    },

    data(){
        return{
            form: {
                name: "",
            },
            isDisable: false,
        }
    },

    created() {
        this.form = this.mainForm
        this.isDisable = this.mainDisable
    },
}
</script>

<template>
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <label class="mb-1">Tipologia</label>
                    <input type="text" class="form-control" v-model="form.name" :disabled="isDisable">
                    <InputError class="mt-1 mb-2" :message="errors['name']"/>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success mr-2" v-if="!isDisable">Submeter</button>
            <a href="/property-types" type="button" class="btn btn-warning">Voltar</a>
        </div>
    </div>
</template>

<style scoped>

</style>

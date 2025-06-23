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
                tipo: "",
                descricao: "",
                ativo: "",
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
                <div class="col-md-6">
                    <label class="mb-1">Tipologia</label>
                    <input type="text" class="form-control" v-model="form.tipo" :disabled="isDisable">
                    <InputError class="mt-1 mb-2" :message="errors['tipo']"/>
                </div>
                <div class="col-md-6">
                    <label class="mb-1">Estado</label>
                    <select name="" id="" class="form-control" v-model="form.ativo" :disabled="isDisable">
                        <option value="">selecione</option>
                        <option value="1">Disponivel</option>
                        <option value="0">Indisponivel</option>
                    </select>
                    <InputError class="mt-1 mb-2" :message="errors['ativo']"/>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <label class="mb-1">Descricao</label>
                    <textarea class="form-control" v-model="form.descricao" :disabled="isDisable"></textarea>
                    <InputError class="mt-1 mb-2" :message="errors['descricao']"/>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success mr-2" v-if="!isDisable">Submeter</button>
            <a href="/tipologias" type="button" class="btn btn-warning">Voltar</a>
        </div>
    </div>
</template>

<style scoped>

</style>

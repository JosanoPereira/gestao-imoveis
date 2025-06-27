<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import InputError from "@/Components/InputError.vue";
import BaseForm from "@/Pages/Tipologias/BaseForm.vue";
import {toast} from "vue3-toastify";

export default {
    name: "Edit",
    components: {BaseForm, InputError, DashboardLayout},

    props: {
        errors: Object,
        tipologia: Object
    },

    data() {
        return {
            form: {
                tipo: this.tipologia.tipo,
                descricao: this.tipologia.descricao,
                ativo: this.tipologia.ativo ? 1 : 0,
            }
        }
    },

    methods: {
        gravar(id) {
            this.$inertia.put(route('tipologias.update', id), {
                ...this.form
            }, {
                onSuccess: () => {
                    toast("Dados Alterados Com Sucesso!", {
                        autoClose: 2000,
                        pauseOnHover: true,
                    });

                },
                onError: () => {
                    toast('Erro Ao Alterar!!', {
                        autoClose: 2000,
                        pauseOnHover: true,
                    })
                }
            })
        }
    }
}
</script>

<template>
    <DashboardLayout :crud-name="'Tipologias / Editar'">
        <div class="d-flex justify-content-between mb-4">
            <h1 class="card-title mb-0">Tipologias</h1>
        </div>
        <form @submit.prevent="gravar(tipologia.id)" enctype="multipart/form-data">
            <BaseForm
                :main-disable="false"
                :main-form="form"
                :errors="errors"
            />
        </form>
    </DashboardLayout>
</template>

<style scoped>

</style>

<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import {toast} from "vue3-toastify";
import BaseForm from "@/Pages/Tipologias/BaseForm.vue";

export default {
    name: "Create",
    components: {BaseForm, DashboardLayout},
    props: {
        errors: Object,
        tipologia: Object
    },

    data() {
        return {
            form: {
                tipo: "",
                descricao: "",
                ativo: "",
            }
        }
    },

    methods: {
        gravar() {
            this.$inertia.post(route('tipologias.store'), {
                ...this.form
            }, {
                onSuccess: () => {
                    toast("Dados Gravados Com Sucesso!", {
                        autoClose: 2000,
                        pauseOnHover: true,
                    });

                },
                onError: () => {
                    toast('Erro Ao Gravar!!', {
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
    <DashboardLayout>
        <div class="d-flex justify-content-between mb-4">
            <h1 class="card-title mb-0">Tipologias</h1>
        </div>
        <form @submit.prevent="gravar" enctype="multipart/form-data">
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

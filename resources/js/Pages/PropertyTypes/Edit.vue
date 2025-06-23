<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import InputError from "@/Components/InputError.vue";
import BaseForm from "@/Pages/PropertyTypes/BaseForm.vue";
import {toast} from "vue3-toastify";

export default {
    name: "Edit",
    components: {BaseForm, InputError, DashboardLayout},

    props: {
        errors: Object,
        propertyType: Object
    },

    data() {
        return {
            form: {
                name: this.propertyType.name,
            }
        }
    },

    methods: {
        gravar(id) {
            this.$inertia.put(route('property-types.update', id), {
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
    <DashboardLayout>
        <div class="d-flex justify-content-between mb-4">
            <h1 class="card-title mb-0">Tipo de Imoveis</h1>
        </div>
        <form @submit.prevent="gravar(propertyType.id)" enctype="multipart/form-data">
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

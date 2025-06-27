<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import {toast} from "vue3-toastify";
import BaseForm from "@/Pages/Clientes/BaseForm.vue";

export default {
    name: "Create",
    components: {BaseForm, DashboardLayout},
    props: {
        errors: Object,
        generos: Object,
        estados: Object,
        tipoClientes: Object,
        provincias: Object,
        municipios: Object,
        tipoDocumentos: Object,
    },

    data() {
        return {
            form: {
                //Clientes
                tipo_clientes_id: "",
                nif: "",

                //Contactos
                telefone: '',
                email: '',

                //Documentos
                tipo_documentos_id: '',
                numero: '',
                emissao: '',
                path: '',
                validade: '',
                vitalicio: '',

                documentos:[],
                contactos:[],

                //Empresas
                nome_social: "",
                nome_fantasia: "",
                tipo_empresa: "",
                responsavel: "",
                data_registo: "",

                //Enderecos
                municipios_id: "",
                endereco: "",
                bairro: "",
                provincias_id: "",

                //Pessoas
                nome: "",
                data_nascimento: "",
                generos_id: "",
                estado_civil_id: "",
                nacionalidade: "",
            }
        }
    },

    methods: {
        gravar() {
            this.$inertia.post(route('clientes.store'), {
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
    <DashboardLayout crud-name="Clientes / Criar">
        <form @submit.prevent="gravar" enctype="multipart/form-data">
            <BaseForm
                :main-disable="false"
                :main-form="form"
                :errors="errors"
                :tipo-clientes="tipoClientes"
                :generos="generos"
                :estados="estados"
                :municipios="municipios"
                :provincias="provincias"
                :tipo-documentos="tipoDocumentos"
            />
        </form>
    </DashboardLayout>
</template>

<style scoped>

</style>

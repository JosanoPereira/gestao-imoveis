<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import {toast} from "vue3-toastify";
import BaseForm from "@/Pages/Imoveis/BaseForm.vue";

export default {
    name: "Create",
    components: {BaseForm, DashboardLayout},
    props: {
        errors: Object,
        tipologias: Object,
        tipoImoveis: Object,
        proprietarios: Object,
        provincias: Object,
        municipios: Object,
        tipoDocumentos: Object,
    },

    data() {
        return {
            form: {
                //Imoveis
                area_util: "",
                numero_compartimentos: "",
                estado_conservacao: "",
                tipologias_id: "",
                property_types_id: "",
                proprietarios_id: "",

                //Documentos
                tipo_documentos_id: '',
                numero: '',
                emissao: '',
                path: '',
                validade: '',
                vitalicio: '',

                documentos: [],
                imagens: [],

                //Enderecos
                municipios_id: "",
                endereco: "",
                bairro: "",
                provincias_id: "",
            }
        }
    },

    methods: {
        gravar() {
            this.$inertia.post(route('imoveis.store'), {...this.form}, {
                forceFormData: true,
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
            },)
        }
    }
}
</script>

<template>
    <DashboardLayout crud-name="Imoveis / Criar">
        <form @submit.prevent="gravar" enctype="multipart/form-data">
            <BaseForm
                :main-disable="false"
                :main-form="form"
                :errors="errors"
                :municipios="municipios"
                :provincias="provincias"
                :tipo-documentos="tipoDocumentos"
                :proprietarios="proprietarios"
                :tipo-imoveis="tipoImoveis"
                :tipologias="tipologias"
            />
        </form>
    </DashboardLayout>
</template>

<style scoped>

</style>

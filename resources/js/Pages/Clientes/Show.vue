<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import BaseForm from "@/Pages/Clientes/BaseForm.vue";

export default {
    name: "Show",
    components: {BaseForm, DashboardLayout},
    props: {
        errors: Object,
        generos: Object,
        estados: Object,
        tipoClientes: Object,
        provincias: Object,
        municipios: Object,
        tipoDocumentos: Object,
        cliente: Object,
    },
    data() {
        return {
            form: {
                //Clientes
                tipo_clientes_id: this.cliente.tipo_clientes_id,
                nif: this.cliente.nif,

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

                documentos: this.cliente.documentos,
                contactos: this.cliente.contactos,

                //Empresas
                nome_social: this.cliente.nome_social,
                nome_fantasia: this.cliente.nome_fantasia,
                tipo_empresa: this.cliente.tipo_empresa,
                responsavel: this.cliente.responsavel,
                data_registo: this.cliente.data_registo,

                //Enderecos
                provincias_id: this.cliente.provincias_id,
                municipios_id: this.cliente.municipios_id,
                endereco: this.cliente.endereco,
                bairro: this.cliente.bairro,

                //Pessoas
                nome: this.cliente.nome,
                data_nascimento: this.cliente.data_nascimento,
                generos_id: this.cliente.generos_id,
                estado_civil_id: this.cliente.estado_civil_id,
                nacionalidade: this.cliente.nacionalidade,
            }
        }
    },
}
</script>

<template>
    <DashboardLayout crud-name="Clientes">
        <form enctype="multipart/form-data">
            <BaseForm
                :main-disable="true"
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

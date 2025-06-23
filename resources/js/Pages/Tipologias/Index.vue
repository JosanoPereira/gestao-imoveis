<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import {ref} from 'vue'
import DataTablesCore from 'datatables.net-bs5';
import DataTable from 'datatables.net-vue3';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

DataTable.use(DataTablesCore);

export default {
    name: "Index",
    components: {DashboardLayout, DataTable, DataTablesCore},
    props: {
        typologies: Object
    },

    data() {
        return {
            visibleStaticBackdropDemo: ref(false)
        }
    },
    methods: {
        eliminar(id) {
            toast("Wow so easy !", {
                autoClose: 1000,
            });
            this.$inertia.delete(route('tipologias.destroy', id), {
                onSuccess: () => {
                    this.$toast.success('Tipologia eliminada com sucesso!');
                },
                onError: () => {
                    this.$toast.error('Erro ao eliminar a tipologia.');
                }
            });
        }
    }
}
</script>

<template>
    <DashboardLayout>

        <CButton color="primary" @click="() => { visibleStaticBackdropDemo = true }">Launch demo modal</CButton>
        <CModal
            backdrop="static"
            :visible="visibleStaticBackdropDemo"
            @close="() => { visibleStaticBackdropDemo = false }"
            aria-labelledby="StaticBackdropExampleLabel"
        >
            <CModalHeader>
                <CModalTitle id="StaticBackdropExampleLabel">Modal title</CModalTitle>
            </CModalHeader>
            <CModalBody>Woohoo, you're reading this text in a modal!</CModalBody>
            <CModalFooter>
                <CButton color="secondary" @click="() => { visibleStaticBackdropDemo = false }">
                    Close
                </CButton>
                <CButton color="primary">Save changes</CButton>
            </CModalFooter>
        </CModal>
        <DataTable class="table table-sm table-bordered">
            <thead class="head-datatable bg-gray-300" style="background: grey">
            <tr>
                <th class="gest-bg-grey-table">ID</th>
                <th class="gest-bg-grey-table">Tipologia</th>
                <th class="gest-bg-grey-table">Descricao</th>
                <th class="gest-bg-grey-table">Ativo</th>
                <th class="gest-bg-grey-table">-</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="tipo in typologies" :key="tipo.id">
                <td>{{ tipo.id }}</td>
                <td>{{ tipo.tipo }}</td>
                <td>{{ tipo.descricao }}</td>
                <td>{{ tipo.ativo }}</td>
                <td>
                    <Link class="btn btn-sm btn-info mr-2" :href="`/tipologias/${tipo.id}`">
                        <i class="fa fa-eye"></i>
                    </Link>
                    <a class="btn btn-sm btn-danger mr-2" @click="eliminar(tipo.id)">
                        <i class="fa fa-trash"></i>
                    </a>
                    <Link class="btn btn-sm btn-primary mr-2" :href="`/tipologias/${tipo.id}/edit`">
                        <i class="fa fa-edit"></i>
                    </Link>
                </td>
            </tr>
            </tbody>
        </DataTable>


    </DashboardLayout>
</template>

<style scoped>

</style>

<script>
import InputError from "@/Components/InputError.vue";

export default {
    name: "BaseForm",
    components: {InputError},
    props: {
        mainForm: Object,
        mainDisable: Boolean,
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

                documentos: [],
                contactos: [],

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
            },
            isDisable: false,
            municipiosSearch: []
        }
    },

    methods: {
        getMunicipios() {
            if (this.form.provincias_id) {
                this.form.municipios_id = ''
                this.municipiosSearch = this.municipios.filter(municipio =>
                    municipio.provincias_id === this.form.provincias_id
                );
            } else {
                this.form.municipios_id = ''
                this.municipiosSearch = [];
            }
        },

        addDocument() {
            if (this.form.tipo_documentos_id && this.form.numero && this.form.emissao && this.form.path) {
                const novoDocumento = {
                    tipo_documento: this.tipoDocumentos.find(doc => doc.id === this.form.tipo_documentos_id).tipo,
                    numero: this.form.numero,
                    emissao: this.form.emissao,
                    path: this.form.path,
                    validade: this.form.validade || null,
                    tipo_documentos_id: this.form.tipo_documentos_id
                };

                this.form.documentos.push(novoDocumento);

                this.form.numero = '';
                this.form.emissao = '';
                this.form.path = '';
                this.form.validade = '';
                this.form.tipo_documentos_id = '';

                this.errors['tipo_documentos_id'] = '';
                this.errors['numero'] = '';
                this.errors['emissao'] = '';
                this.errors['path'] = '';
            } else {
                // Mostrar erro de validação se algum campo estiver vazio
                this.errors['tipo_documentos_id'] = 'Selecione o tipo de documento';
                this.errors['numero'] = 'Informe o número do documento';
                this.errors['emissao'] = 'Informe a data de emissão';
                this.errors['path'] = 'Carregue o documento, por favor';
            }
        },

        removeDocument(index) {
            this.form.documentos.splice(index, 1);
        },

        removeAllDocs() {
            this.form.documentos = []
        },

        addContact() {
            if (this.form.telefone) {
                const novoContacto = {
                    telefone: this.form.telefone,
                    email: this.form.email,
                };

                this.form.contactos.push(novoContacto);
                this.form.telefone = '';
                this.form.email = '';

                this.errors['telefone'] = '';
                this.errors['email'] = '';
            } else {
                this.errors['telefone'] = 'Insira um número de telefone';
                this.errors['email'] = 'Informe o seu email';
            }
        },

        removeContact(index) {
            this.form.contactos.splice(index, 1);
        },

        removeAllContacts() {
            this.form.contactos = []
        },
    },

    created() {
        this.form = this.mainForm
        this.isDisable = this.mainDisable
        this.getMunicipios()
    },
}
</script>

<template>
    <div class="card mb-4">
        <h3 class="bg-body-secondary text-xl-center p-2" style="font-size: 20px">Dados Clientes</h3>
        <div class="card-body mb-2">
            <div class="row">
                <div class="col-md-6">
                    <label class="mb-1">Tipo de Cliente</label>
                    <select v-model="form.tipo_clientes_id" :disabled="isDisable" class="form-control">
                        <option value="">Selecione</option>
                        <option v-for="tipo in tipoClientes" :value="tipo.id" :key="tipo.id">{{ tipo.tipo }}</option>
                    </select>
                    <InputError class="mt-1 mb-2" :message="errors['tipo_clientes_id']"/>
                </div>
                <div class="col-md-6">
                    <label class="mb-1">NIF</label>
                    <input type="text" class="form-control" v-model="form.nif" :disabled="isDisable">
                    <InputError class="mt-1 mb-2" :message="errors['nif']"/>
                </div>
            </div>
        </div>

        <h3 v-if="form.tipo_clientes_id===1" class="bg-body-secondary text-xl-center p-2" style="font-size: 20px">Pessoa
            Singular</h3>
        <div v-if="form.tipo_clientes_id===1" class="card-body mb-2">
            <div class="row">
                <div class="col-md-6">
                    <label class="mb-1">Nome</label>
                    <input type="text" class="form-control" :required="form.tipo_clientes_id===1" v-model="form.nome"
                           :disabled="isDisable">
                    <InputError class="mt-1 mb-2" :message="errors['nome']"/>
                </div>
                <div class="col-md-6">
                    <label class="mb-1">Nacionalidade</label>
                    <input type="text" class="form-control" v-model="form.nacionalidade" :disabled="isDisable">
                    <InputError class="mt-1 mb-2" :message="errors['nacionalidade']"/>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-4">
                    <label class="mb-1">Data de Nascimento</label>
                    <input type="date" class="form-control" v-model="form.data_nascimento" :disabled="isDisable">
                    <InputError class="mt-1 mb-2" :message="errors['data_nascimento']"/>
                </div>
                <div class="col-md-4">
                    <label class="mb-1">Genero</label>
                    <select v-model="form.generos_id" :required="form.tipo_clientes_id===1" :disabled="isDisable"
                            class="form-control">
                        <option value="">Selecione</option>
                        <option v-for="dado in generos" :value="dado.id" :key="dado.id">{{ dado.genero }}</option>
                    </select>
                    <InputError class="mt-1 mb-2" :message="errors['generos_id']"/>
                </div>
                <div class="col-md-4">
                    <label class="mb-1">Estado Civil</label>
                    <select v-model="form.estado_civil_id" :required="form.tipo_clientes_id===1" :disabled="isDisable"
                            class="form-control">
                        <option value="">Selecione</option>
                        <option v-for="dado in estados" :value="dado.id" :key="dado.id">{{ dado.estado }}</option>
                    </select>
                    <InputError class="mt-1 mb-2" :message="errors['estado_civil_id']"/>
                </div>
            </div>
        </div>

        <h3 v-if="form.tipo_clientes_id===2" class="bg-body-secondary text-xl-center p-2" style="font-size: 20px">Pessoa
            Colectiva</h3>
        <div v-if="form.tipo_clientes_id===2" class="card-body mb-2">
            <div class="row">
                <div class="col-md-6">
                    <label class="mb-1">Nome Social</label>
                    <input type="text" class="form-control" :required="form.tipo_clientes_id===2"
                           v-model="form.nome_social" :disabled="isDisable">
                    <InputError class="mt-1 mb-2" :message="errors['nome_social']"/>
                </div>
                <div class="col-md-6">
                    <label class="mb-1">Nome Comercial</label>
                    <input type="text" class="form-control" v-model="form.nome_fantasia" :disabled="isDisable">
                    <InputError class="mt-1 mb-2" :message="errors['nome_fantasia']"/>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-4">
                    <label class="mb-1">Data de Registo</label>
                    <input type="date" class="form-control" v-model="form.data_registo" :disabled="isDisable">
                    <InputError class="mt-1 mb-2" :message="errors['data_registo']"/>
                </div>
                <div class="col-md-4">
                    <label class="mb-1">Responsavel</label>
                    <input type="text" class="form-control" v-model="form.responsavel" :disabled="isDisable">
                    <InputError class="mt-1 mb-2" :message="errors['responsavel']"/>
                </div>
                <div class="col-md-4">
                    <label class="mb-1">Tipo de Empresa</label>
                    <input type="text" class="form-control" v-model="form.tipo_empresa" :disabled="isDisable">
                    <InputError class="mt-1 mb-2" :message="errors['tipo_empresa']"/>
                </div>
            </div>
        </div>

        <h3 v-if="form.tipo_clientes_id" class="bg-body-secondary text-xl-center p-2" style="font-size: 20px">
            Documentos</h3>
        <div v-if="form.tipo_clientes_id" class="card-body mb-2">
            <div class="row">
                <div class="col-md-6">
                    <label class="mb-1">Tipo de Documento</label>
                    <select v-model="form.tipo_documentos_id"
                            :required="form.tipo_clientes_id && !form.documentos.length" :disabled="isDisable"
                            class="form-control">
                        <option value="">Selecione</option>
                        <option v-for="dado in tipoDocumentos" :value="dado.id" :key="dado.id">{{ dado.tipo }}</option>
                    </select>
                    <InputError class="mt-1 mb-2" :message="errors['tipo_documentos_id']"/>
                </div>
                <div class="col-md-6">
                    <label class="mb-1">Path</label>
                    <input type="file" class="form-control" @input="form.path = $event.target.files[0]"
                           accept="application/pdf" :required="form.tipo_clientes_id  && !form.documentos.length">
                    <InputError class="mt-1 mb-2" :message="errors['path']"/>
                </div>

            </div>
            <div class="row mt-3">
                <div class="col-md-4 ">
                    <label class="mb-1">Numero</label>
                    <input type="text" class="form-control"
                           :required="form.tipo_clientes_id  && !form.documentos.length" v-model="form.numero"
                           :disabled="isDisable">
                    <InputError class="mt-1 mb-2" :message="errors['numero']"/>
                </div>
                <div class="col-md-4 ">
                    <label class="mb-1">Emissao</label>
                    <input type="date" class="form-control"
                           :required="form.tipo_clientes_id  && !form.documentos.length" v-model="form.emissao"
                           :disabled="isDisable">
                    <InputError class="mt-1 mb-2" :message="errors['emissao']"/>
                </div>
                <div class="col-md-4 ">
                    <label class="mb-1">Validade (Se vazio, sera vitalicio)</label>
                    <input type="date" class="form-control" v-model="form.validade"
                           :disabled="isDisable">
                    <InputError class="mt-1 mb-2" :message="errors['validade']"/>
                </div>
            </div>

            <!-- Botão para adicionar documentos -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <button v-if="!isDisable" type="button" class="btn btn-primary" @click="addDocument">+</button>
                    <button v-if="form.documentos.length>1" type="button" class="btn btn-danger ml-3"
                            @click="removeAllDocs">Remover Todos
                    </button>
                </div>
            </div>

            <h5 class="mt-3" v-if="form.documentos.length">Documentos Adicionados</h5>

            <!-- Lista de documentos adicionados -->
            <div v-if="form.documentos.length" class="row mt-3" v-for="(doc, index) in form.documentos" :key="index">
                <div class="col-md-3">
                    <label class="">Tipo de Documento</label>
                    <select v-model="form.documentos[index].tipo_documentos_id" :disabled="true"
                            class="form-control">
                        <option v-for="dado in tipoDocumentos" :value="dado.id" :key="dado.id">{{ dado.tipo }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="">Numero</label>
                    <input type="text" class="form-control" :required="form.tipo_clientes_id"
                           v-model="form.documentos[index].numero"
                           :disabled="true">
                </div>
                <div class="col-md-2">
                    <label class="">Emissao</label>
                    <input type="date" class="form-control" :required="form.tipo_clientes_id"
                           v-model="form.documentos[index].emissao"
                           :disabled="true">
                </div>
                <div class="col-md-2">
                    <label class="">Validade</label>
                    <input type="date" class="form-control" v-model="form.documentos[index].validade"
                           :disabled="true">
                </div>

                <div class="col-md-2 mt-4">
                    <button v-if="!isDisable" type="button" @click="removeDocument(index)"
                            class="btn btn-danger btn-sm ml-2">Remover
                    </button>
                    <a v-if="form.documentos[index].download" :href="form.documentos[index].download_link"
                       target="_blank" class="btn btn-success btn-sm ml-2">
                        <i class="fa fa-eye"></i>
                    </a>
                </div>
            </div>
        </div>

        <h3 v-if="form.tipo_clientes_id" class="bg-body-secondary text-xl-center p-2" style="font-size: 20px">
            Contactos</h3>
        <div v-if="form.tipo_clientes_id" class="card-body mb-2">
            <div class="row mt-3">
                <div class="col-md-6">
                    <label class="mb-1">Telefone</label>
                    <input type="text" class="form-control" :required="form.tipo_clientes_id && !form.contactos.length"
                           v-model="form.telefone"
                           :disabled="isDisable">
                    <InputError class="mt-1 mb-2" :message="errors['telefone']"/>
                </div>
                <div class="col-md-6">
                    <label class="mb-1">Email</label>
                    <input type="email" class="form-control" v-model="form.email"
                           :disabled="isDisable">
                    <InputError class="mt-1 mb-2" :message="errors['email']"/>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <button v-if="!isDisable" type="button" class="btn btn-primary" @click="addContact">+</button>
                    <button v-if="form.contactos.length>1" type="button" class="btn btn-danger ml-3"
                            @click="removeAllContacts">Remover Todos
                    </button>
                </div>
            </div>


            <div v-if="form.contactos.length" class="row mt-3" v-for="(doc, index) in form.contactos" :key="index">
                <div :class="!isDisable?'col-md-5': 'col-md-6'">
                    <label class="">Telefone</label>
                    <input type="text" class="form-control" :required="form.tipo_clientes_id"
                           v-model="form.contactos[index].telefone"
                           :disabled="true">
                </div>
                <div :class="!isDisable?'col-md-5': 'col-md-6'">
                    <label class="">Email</label>
                    <input type="email" class="form-control" v-model="form.contactos[index].email"
                           :disabled="true">
                </div>

                <div class="col-md-2 mt-4">
                    <button v-if="!isDisable" type="button" @click="removeContact(index)"
                            class="btn btn-danger btn-sm ml-2">Remover
                    </button>
                </div>
            </div>
        </div>

        <h3 v-if="form.tipo_clientes_id" class="bg-body-secondary text-xl-center p-2" style="font-size: 20px">Endereco
            Sede</h3>
        <div v-if="form.tipo_clientes_id" class="card-body mb-2">
            <div class="row">
                <div class="col-md-4">
                    <label class="mb-1">Provincia</label>
                    <select v-model="form.provincias_id" :required="form.tipo_clientes_id" :disabled="isDisable"
                            class="form-control" @change="getMunicipios">
                        <option value="">Selecione</option>
                        <option v-for="dado in provincias" :value="dado.id" :key="dado.id">{{ dado.provincia }}</option>
                    </select>
                    <InputError class="mt-1 mb-2" :message="errors['provincias_id']"/>
                </div>
                <div class="col-md-4">
                    <label class="mb-1">Municipio</label>
                    <select v-model="form.municipios_id" :required="form.tipo_clientes_id" :disabled="isDisable"
                            class="form-control">
                        <option value="">Selecione</option>
                        <option v-for="dado in municipiosSearch" :value="dado.id" :key="dado.id">{{
                                dado.municipio
                            }}
                        </option>
                    </select>
                    <InputError class="mt-1 mb-2" :message="errors['municipios_id']"/>
                </div>
                <div class="col-md-4">
                    <label class="mb-1">Bairro</label>
                    <input type="text" class="form-control"
                           v-model="form.bairro" :disabled="isDisable">
                    <InputError class="mt-1 mb-2" :message="errors['bairro']"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-3">
                    <label class="mb-1">Referencia</label>
                    <input type="text" class="form-control" :required="form.tipo_clientes_id" v-model="form.endereco"
                           :disabled="isDisable">
                    <InputError class="mt-1 mb-2" :message="errors['endereco']"/>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success mr-2" v-if="!isDisable">Submeter</button>
            <a href="/clientes" type="button" class="btn btn-warning">Voltar</a>
        </div>
    </div>
</template>

<style scoped>

</style>

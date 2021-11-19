<template>
  <v-data-table
    :items="usuarios"
    :headers="headers"
    :search="search"
    :no-data-text="'0 Registros encontrados  ):'"
    :footer-props="{
      itemsPerPageAllText: 'Tudo',
      itemsPerPageText: 'Registros por página',
      pageText: 'Registros: ' + usuarios.length,
    }"
    :header-props="{
      sortByText: 'Filtro:',
    }"
    :no-results-text="'Registro não encontrado'"
    sortBy="idLoja"
    class="elevation-6"
  >
    <!-- Dialogs de edit -->
    <!-- id loja -->
    <template v-slot:item.idLoja="props">
      <v-edit-dialog
        :return-value.sync="props.item.idLoja"
        @save="save(props.item.id)"
        @cancel="cancel"
        @open="open"
        @close="close"
      >
        {{ props.item.idLoja }}
        <template v-slot:input>
          <v-text-field
            v-model="props.item.idLoja"
            label="Edit"
            single-line
            counter
          ></v-text-field>
        </template>
      </v-edit-dialog>
    </template>
    <!-- código de funcionário -->
    <template v-slot:item.cdFunc="props">
      <v-edit-dialog
        :return-value.sync="props.item.cdFunc"
        @save="save(props.item.id)"
        @cancel="cancel"
        @open="open"
        @close="close"
      >
        {{ props.item.cdFunc }}
        <template v-slot:input>
          <v-text-field
            v-model="props.item.cdFunc"
            label="Edit"
            single-line
            counter
          ></v-text-field>
        </template>
      </v-edit-dialog>
    </template>
    <!-- Nome -->
    <template v-slot:item.name="props">
      <v-edit-dialog
        :return-value.sync="props.item.name"
        @save="save(props.item.id)"
        @cancel="cancel"
        @open="open"
        @close="close"
      >
        {{ props.item.name }}
        <template v-slot:input>
          <v-text-field
            v-model="props.item.name"
            label="Edit"
            single-line
            counter
          ></v-text-field>
        </template>
      </v-edit-dialog>
    </template>
    <!-- Login -->
    <template v-slot:item.login="props">
      <v-edit-dialog
        :return-value.sync="props.item.login"
        @save="save(props.item.id)"
        @cancel="cancel"
        @open="open"
        @close="close"
      >
        {{ props.item.login }}
        <template v-slot:input>
          <v-text-field
            v-model="props.item.login"
            label="Edit"
            single-line
            counter
          ></v-text-field>
        </template>
      </v-edit-dialog>
    </template>
    <!-- Nivel -->
    <template v-slot:item.nivel="props">
      <v-edit-dialog
        :return-value.sync="props.item.nivel"
        @save="save(props.item.id)"
        @cancel="cancel"
        @open="open"
        @close="close"
      >
        {{ props.item.nivel }}
        <template v-slot:input>
          <v-text-field
            v-model="props.item.nivel"
            label="Edit"
            single-line
            counter
          ></v-text-field>
        </template>
      </v-edit-dialog>
    </template>

    <template v-slot:top>
      <v-toolbar flat>
        

        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Pesquisar por usuário"
          single-line
          hide-details
        ></v-text-field>

        <!-- novo usuário -->
        <v-dialog v-model="dialog" max-width="500px">
          <template v-slot:activator="{ on, attrs }">
            <v-btn color="primary" dark class="mb-2 ml-4" v-bind="attrs" v-on="on">
              <v-icon>
                mdi-plus
              </v-icon>
            </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="text-h5">Novo usuário:</span>
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="newItem.name"
                      label="Nome"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="newItem.idLoja"
                      label="Loja"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="newItem.login"
                      label="Login"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="newItem.nivel"
                      label="Nivel"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="newItem.cdFunc"
                      label="Código de funcionário do fcerta"
                    ></v-text-field>
                  </v-col>

                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close"> Cancelar </v-btn>
              <v-btn color="blue darken-1" text @click="save(undefined)"> Salvar </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>

    <template v-slot:item.actions="{ item }">
      <!-- <v-icon small class="mr-2" @click="teste(item)" color="blue darken-2">
        mdi-pencil
      </v-icon> -->
      <v-icon small class="mr-2" @click="teste(item)" color="orange darken-2">
        mdi-lock-open
      </v-icon>
    </template>
  </v-data-table>
</template>

<script>
import axios from "axios";
export default {
  data: () => ({
    headers: [
      { text: "Loja", value: "idLoja", align: "start" },
      { text: "Código de funcionário(Fórmula Certa)", value: "cdFunc" },
      { text: "Nome", value: "name" },
      { text: "Login", value: "login" },
      { text: "Nível", value: "nivel" },
      { text: "Ativo", value: "ativo" },
      { text: "Ações", value: "actions", sortable: false },
    ],
    newItem: {
      name: '',
      login: '',
      idLoja: '',
      cdfunc: '',
      nivel: '',
      ativo: 1
    },
    dialog: false,
    usuarios: [],
    search: "",
    api: "http://10.10.1.241/apps/manutencao-usuario/api/",
  }),

  methods: {
    teste(item) {
      console.log("teste", item);
    },

    resetPass(id) {
      const config = {
        url: this.url,
        method: "post",
        data: {
          resetPass: true,
          id,
        },
      };
      try {
        axios(config);
      } catch (err) {
        console.log(err);
      }
    },

    async save(itemId) {
      
      if(itemId === undefined) {
        this.dialog = false
        this.usuarios.push(this.newItem)
      }
      
    },

    cancel() {
    },

    open() {
      
    },

    close() {
            this.dialog = false

    },

    async getUsers() {
      const config = {
        method: "get",
        url: this.api,
      };

      try {
        const response = await (await axios(config)).data;

        const responseObj = response.map((item) => {
          const obj = {};
          item.forEach(() => {
            obj.id = item[0];
            obj.idLoja = item[1];
            obj.cdFunc = item[2];
            obj.name = item[3];
            obj.login = item[4];
            obj.nivel = item[6];
            obj.ativo = item[8];
          });
          return obj;
        });

        // console.log(responseObj)

        this.usuarios = responseObj;
        console.log(this.usuarios);
      } catch (err) {
        console.log(err);
      }
    },
  },

  mounted() {
    this.getUsers();
  },
};
</script>

<style>
</style>
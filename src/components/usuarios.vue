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
    sortBy="cdcon"
    class="elevation-6"
  >
    <!-- Dialogs de edit -->
    <!-- id loja -->
    <template v-slot:item.cdcon="props">
      <v-edit-dialog
        :return-value.sync="props.item.cdcon"
        @save="save(props.item.id, props.item.cdcon, 'cdcon')"
        @cancel="cancel"
        @open="open"
        @close="close"
      >
        {{ props.item.cdcon }}
        <template v-slot:input>
          <v-text-field
            v-model="props.item.cdcon"
            label="Edit"
            single-line
            counter
          ></v-text-field>
        </template>
      </v-edit-dialog>
    </template>
    <!-- código de funcionário -->
    <template v-slot:item.cdfunc="props">
      <v-edit-dialog
        :return-value.sync="props.item.cdfunc"
        @save="save(props.item.id, props.item.cdfunc, 'cdfunc')"
        @cancel="cancel"
        @open="open"
        @close="close"
      >
        {{ props.item.cdfunc }}
        <template v-slot:input>
          <v-text-field
            v-model="props.item.cdfunc"
            label="Edit"
            single-line
            counter
          ></v-text-field>
        </template>
      </v-edit-dialog>
    </template>
    <!-- Nome -->
    <template v-slot:item.nome="props">
      <v-edit-dialog
        :return-value.sync="props.item.nome"
        @save="save(props.item.id, props.item.nome, 'nome')"
        @cancel="cancel"
        @open="open"
        @close="close"
      >
        {{ props.item.nome }}
        <template v-slot:input>
          <v-text-field
            v-model="props.item.nome"
            label="Edit"
            single-line
            counter
          ></v-text-field>
        </template>
      </v-edit-dialog>
    </template>
    <!-- usuario -->
    <template v-slot:item.usuario="props">
      <v-edit-dialog
        :return-value.sync="props.item.usuario"
        @save="save(props.item.id, props.item.usuario, 'usuario')"
        @cancel="cancel"
        @open="open"
        @close="close"
      >
        {{ props.item.usuario }}
        <template v-slot:input>
          <v-text-field
            v-model="props.item.usuario"
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
        @save="save(props.item.id, props.item.nivel, 'nivel')"
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
            <v-btn
              color="primary"
              dark
              class="mb-2 ml-4"
              v-bind="attrs"
              v-on="on"
            >
              <v-icon> mdi-plus </v-icon>
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
                      v-model="newItem.nome"
                      label="Nome"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="newItem.cdcon"
                      label="Loja"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="newItem.usuario"
                      label="usuario"
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
                      v-model="newItem.cdfunc"
                      label="Código de funcionário do fcerta"
                    ></v-text-field>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close">
                Cancelar
              </v-btn>
              <v-btn color="blue darken-1" text @click="save(undefined)">
                Salvar
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>

    <template v-slot:item.actions="{ item }">
      <!-- <v-icon small class="mr-2" @click="teste(item)" color="blue darken-2">
        mdi-pencil
      </v-icon> -->
      <v-icon
        small
        class="mr-2"
        @click="resetPass(item.id)"
        color="orange darken-2"
      >
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
      { text: "Loja", value: "cdcon", align: "start" },
      { text: "Código de funcionário(Fórmula Certa)", value: "cdfunc" },
      { text: "Nome", value: "nome" },
      { text: "Usuario", value: "usuario" },
      { text: "Nível", value: "nivel" },
      { text: "Ativo", value: "ativo" },
      { text: "Ações", value: "actions", sortable: false },
    ],
    newItem: {
      nome: "",
      usuario: "",
      cdcon: "",
      cdfunc: "",
      nivel: "",
      ativo: 1,
    },
    dialog: false,
    usuarios: [],
    search: "",
    api: "http://10.10.1.241/apps/manutencao-usuario/api/?v1/",
  }),

  methods: {
    resetPass(id) {
      const config = {
        url: this.url + "users-update",
        method: "post",
        data: new URLSearchParams({
          id,
          column: "senha",
          data: "senha",
        }),
      };
      try {
        axios(config);
      } catch (err) {
        console.log(err);
      }
    },

    async save(itemId, value, column) {
      this.dialog = false;

      if (itemId === undefined) {
        this.usuarios.push(this.newItem);
        const config = {
          url: this.api + "user-save",
          method: "post",
          Headers: {
            "Content-Type": "application/json",
          },
          data: new URLSearchParams({...this.newItem}),
        };
        try {
          await axios(config);
        } catch (err) {
          console.log(err);
        }
      }

      const data = new URLSearchParams({
        id: itemId,
        column,
        value
      })

      const config = {
        url: this.api + "user-update",
        method: "post",
        headers: {
         "Content-Type": "application/x-www-form-urlencoded"
          
        },
        data: data,
      };

      try {
        await axios(config);
      } catch (err) {
        console.log(err);
      }
    },

    cancel() {},

    open() {},

    close() {
      this.dialog = false;
    },

    async getUsers() {
      const config = {
        method: "get",
        url: this.api + "users",
        // url: "http://10.10.1.241/apps/manutencao-usuario/api/",
      };

      try {
        const response = await (await axios(config)).data;
        
        const responseObj = response.map((item) => {
          const obj = {};
          item.forEach(() => {
            obj.id = item[0];
            obj.cdcon = item[1];
            obj.cdfunc = item[2];
            obj.nome = item[3];
            obj.usuario = item[4];
            obj.nivel = item[6];
            obj.ativo = item[8];
          });
          return obj;
        });

      

        this.usuarios = responseObj;
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
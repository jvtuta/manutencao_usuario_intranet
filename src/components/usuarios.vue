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
    sortBy="cdlj"
    class="elevation-6"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Pesquisar por usuário"
          single-line
          hide-details
        ></v-text-field>
      </v-toolbar>
    </template>

    <template v-slot:item.actions="{ item }">
      <v-icon small class="mr-2" @click="teste(item)" color="blue darken-2">
        mdi-pencil
      </v-icon>
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
      { text: "Loja", value: "cdlj", align: "start" },
      { text: "Código de funcionário(Fórmula Certa)", value: "cdfunc" },
      { text: "Nome", value: "name" },
      { text: "Login", value: "login" },
      { text: "Nível", value: "nivel" },
      { text: "Ativo", value: "ativo" },
      { text: "Actions", value: "actions", sortable: false },
    ],
    usuarios: [],
    search: "",
  }),

  methods: {
    teste(item) {
      console.log("teste", item);
    },

    async getUsers() {
      const config = {
        method: "get",
        url: "http://10.10.1.241/apps/manutencao-usuario/api/",
      };

      try {
        const response = await (await axios(config)).data;

        const responseObj = response.map((item) => {
          const obj = {};
          item.forEach(() => {
            obj.cdlj = item[1];
            obj.cdfunc = item[2];
            obj.name = item[3];
            obj.login = item[4];
            obj.nivel = item[6];
            obj.ativo = item[8];
          });
          return obj;
        });

        // console.log(responseObj)

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
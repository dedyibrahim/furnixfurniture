<template>
  <v-data-table
    :headers="headers"
    :items="Tamus"
    sort-by="id_kategori"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar
        flat
      >
        <v-toolbar-title>Data Tamu</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="text-h5 text-center">yakin ingin menghapus buku ini ?</v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
              <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:[`item.actions`]="{ item }">

      <v-icon
        small
        @click="deleteItem(item)"
      >
        mdi-delete
      </v-icon>
    </template>
    <template v-slot:no-data>
      <v-btn
        color="primary"
        @click="initialize"
      >
        Reset
      </v-btn>
    </template>
  </v-data-table>
</template>
<script>
  export default {
    data: () => ({
      dialog: false,
      dialogDelete: false,
    headers: [
        {
          text: 'ID Tamu',
          align: 'start',
          sortable: false,
          value: 'id_tamu',
        },
        { text: 'Nama ', value: 'nama' },
        { text: 'Email', value: 'email' },
        { text: 'Tlp', value: 'tlp' },
        { text: 'Katerangan', value: 'keterangan' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],

      Tamus: [],
      editedIndex: -1,
      editedItem: {
        name: '',
        calories: 0,
        fat: 0,
        carbs: 0,
        protein: 0,
      },
      defaultItem: {
        name: '',
        calories: 0,
        fat: 0,
        carbs: 0,
        protein: 0,
      },
    }),

    computed: {
      formTitle () {
        if(this.editedIndex === -1){
            this.kategori.nama_kategori ='';

        }
        return this.editedIndex === -1 ? 'Kategori Baru' : 'Edit  Kategori'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
      dialogDelete (val) {
        val || this.closeDelete()
      },
    },

    created () {
      this.initialize()
    },

    methods: {
      initialize () {
        this.$root.$emit("PesanLoading", "Mengambil data kategori");
      axios
        .get(
          "/api/auth/DataTamu",
          {
            headers: {
              Authorization: "Bearer " + this.$cookies.get("token"),
            },
          }
        )
        .then((res) => {
          if (res.data.status == true) {
            this.Tamus = res.data.data;
          }
          this.$root.$emit("PesanResponse", res.data.message, "primary");
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
          this.$root.$emit("PesanResponse", error.response.data.message, "red");
        });
      },

      editItem (item) {
        this.editedIndex = this.Tamus.indexOf(item)
        this.kategori = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
  this.editedIndex = this.Tamus.indexOf(item)
        this.kategori = Object.assign({}, item)

        this.dialogDelete = true
      },

      deleteItemConfirm () {

             axios
        .post(
          "/api/auth/DeleteTamu",this.kategori,
          {
            headers: {
              Authorization: "Bearer " + this.$cookies.get("token"),
            },
          }
        )
        .then((res) => {
          if (res.data.status == true) {
             this.initialize();
          }


          this.$root.$emit("PesanResponse", res.data.message, "primary");
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
          this.$root.$emit("PesanResponse", error.response.data.message, "red");
        });
        this.closeDelete()
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      save () {

         axios
        .post(
          "/api/auth/SimpanKategori",this.kategori,
          {
            headers: {
              Authorization: "Bearer " + this.$cookies.get("token"),
            },
          }
        )
        .then((res) => {
          if (res.data.status == true) {
             this.initialize();
          }


          this.$root.$emit("PesanResponse", res.data.message, "primary");
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
          this.$root.$emit("PesanResponse", error.response.data.message, "red");
        });


        this.close()
      },
    },
  }
</script>

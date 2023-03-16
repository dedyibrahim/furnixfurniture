<template>
  <v-data-table
    :headers="headers"
    :items="Banners"
    class="elevation-1"
     item-key="id_berita"

  >
    <template v-slot:top>
      <v-toolbar
        flat
      >
        <v-toolbar-title>Data Banner</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-dialog
          v-model="dialog"
          max-width="1000px"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              color="primary"
              dark
              class="mb-2 text-capitalize"
              v-bind="attrs"
              v-on="on"
            >
              Tambah data  Banner
            </v-btn>
          </template>
          <v-card>
                   <form @submit="save" enctype="multipart/form-data">
                 <v-card-title>
              <span class="text-h5">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                  <v-row>
                      <v-col>
                          <v-file-input
                            class="mt-5"
                            accept="image/*"
                            v-model="newsinsert.gambar"
                            chips
                            label="Gambar Banner"
                            dense outlined
                            prepend-icon="mdi-camera"
                           ></v-file-input>
                       </v-col>
                      </v-row>
               </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                color="blue darken-1"
                text
                @click="close"
              >
                Cancel
              </v-btn>
              <v-btn
                color="blue darken-1"
                text
                @click="save"
              >
                Save
              </v-btn>

            </v-card-actions>

            </form>
              </v-card>
        </v-dialog>
        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="text-h5 text-center">Yakin ingin menghapus banner ini ?</v-card-title>
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
     <template v-slot:[`item.gambar`]="{ item }">
      <v-img  contain min-height="150" max-height="150" max-width="150" :src='"../assets/imgbanner/"+item.gambar'>
      </v-img>
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
      expanded: [],
      editgambar :1,
      singleExpand: false,
      dialog: false,
      dialogDelete: false,
      headers: [
        {
          text: 'ID Banner',
          align: 'start',
          sortable: false,
          value: 'id_banner',
        },
        { text: 'Banner', value: 'gambar' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
     Banners: [],
     filesedit: [],
     newsinsert :{
        gambar :1,
      },
      editedIndex: -1,
      defaultItem: {
      },
    }),

    computed: {
      formTitle () {
          if(this.editedIndex === -1){
            this.newsinsert.judul   ='';
            this.newsinsert.keterangan    ='';
            this.newsinsert.gambar =[];
          this.editgambar = 1;
          }
        return this.editedIndex === -1 ? 'Banner Baru' : 'Edit Berita'
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
      this.initialize();
    },

    methods: {


      initialize() {

        this.$root.$emit("PesanLoading", "Mengambil data Banner");
      axios
        .get(
          "/api/auth/DataBanner",
          {
            headers: {
              Authorization: "Bearer " + this.$cookies.get("token"),
            },
          }
        )
        .then((res) => {
          if (res.data.status == true) {
            this.Banners = res.data.data;
          }
          this.$root.$emit("PesanResponse", res.data.message, "primary");
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
          this.$root.$emit("PesanResponse", error.response.data.message, "red");
        });
      },



      deleteItem (item) {
        this.editedIndex = this.Banners.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
             axios
        .post(
          "/api/auth/DeleteBanner",this.editedItem,
          {
            headers: {
              Authorization  : "Bearer " + this.$cookies.get("token"),
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

        const data = new FormData()
        data.append('file', this.newsinsert.gambar)

       axios
        .post(
          "/api/auth/SimpanBanner",data,
          {
            headers: {
              Authorization  : "Bearer " + this.$cookies.get("token"),
            },
          }
        )
        .then((res) => {
          if (res.data.status == true) {

            this.newsinsert.gambar =[];
            this.editgambar = 1;
           }

           this.initialize();

          this.$root.$emit("PesanResponse", res.data.message, "primary");
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
          this.$root.$emit("PesanResponse", error.response.data.message, "red");
        });

        this.close();
     }
    }

  }
</script>

<template>
  <v-data-table
    :headers="headers"
    :items="Beritas"
    class="elevation-1"
     :expanded.sync="expanded"
    :single-expand="singleExpand"
    show-expand
     item-key="id_berita"

  >
    <template v-slot:top>
      <v-toolbar
        flat
      >
        <v-toolbar-title>Data Berita</v-toolbar-title>
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
              Tambah data  News
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
                            <v-text-field v-model="newsinsert.judul" dense label="Judul Berita" outlined placeholder="Nama Produk"></v-text-field>
                                <ckeditor :editor="editor"  :config="editorConfig" v-model="newsinsert.keterangan"></ckeditor>
                          <v-divider></v-divider>
                       </v-col>



                  </v-row>
                  <v-row>
                      <v-col  v-if="editgambar == 1 ">
                          <v-file-input

                          class="mt-5"
                            accept="image/*"
                            v-model="newsinsert.gambar"
                            chips
                            label="Gambar Berita"
                            dense outlined
                            prepend-icon="mdi-camera"
                           ></v-file-input>
                       </v-col>
                     <v-col v-else >

                        <v-img  contain min-height="150" max-height="150" max-width="150" :src='"../assets/imgberita/"+newsinsert.gambar'></v-img>
                        <v-btn class="red" dense small @click="HapusGambar()">Hapus</v-btn>

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
            <v-card-title class="text-h5 text-center">Yakin ingin menghapus berita ini ?</v-card-title>
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
    <template v-slot:expanded-item="{headers,item}">
        <td :colspan="headers.length" class="p-3">

                    <v-row>
                      <v-col class="col-md-3 mx-auto" >
                             <v-img contain min-height="150" max-height="150" max-width="150" :src='"../assets/imgberita/"+item.gambar'></v-img>
                      </v-col>
                      <v-col class="col-md-9">
                                 <div v-html="item.keterangan"></div>

                      </v-col>
                  </v-row>
      </td>
    </template>
    <template v-slot:[`item.actions`]="{ item }">
      <v-icon
        small
        class="mr-2"
        @click="editItem(item)"
      >
        mdi-pencil
      </v-icon>
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
   import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

  export default {
    data: () => ({
      expanded: [],
      editgambar :1,
      singleExpand: false,
      editor: ClassicEditor,
     editorData: '<p>Content of the editor.</p>',
    editorConfig: {


                    toolbar: {
                        items: [

                        ]
                    }
                },
      dialog: false,
      dialogDelete: false,
      headers: [
        {
          text: 'ID Berita',
          align: 'start',
          sortable: false,
          value: 'id_berita',
        },
        { text: 'Judul Berita', value: 'judul' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
     Beritas: [],
     filesedit: [],
     newsinsert :{
        judul  :'',
        keterangan :'',
        gambar :1,
      },
      editedIndex: -1,
      editedItem: {

      },
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
        return this.editedIndex === -1 ? 'Berita Baru' : 'Edit Berita'
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
    HapusGambar(){
     this.editgambar =1;
       this.newsinsert.gambar =[];
    },

      DataKategori(){
     this.$root.$emit("PesanLoading", "Mengambil data kategori");
      axios
        .get(
          "/api/auth/DataKategori",
          {
            headers: {
              Authorization: "Bearer " + this.$cookies.get("token"),
            },
          }
        )
        .then((res) => {
          if (res.data.status == true) {
            this.kategoris = res.data.data;
          }
          this.$root.$emit("PesanResponse", res.data.message, "primary");
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
          this.$root.$emit("PesanResponse", error.response.data.message, "red");
        });
      },
      initialize() {

        this.$root.$emit("PesanLoading", "Mengambil data Produk");
      axios
        .get(
          "/api/auth/DataBerita",
          {
            headers: {
              Authorization: "Bearer " + this.$cookies.get("token"),
            },
          }
        )
        .then((res) => {
          if (res.data.status == true) {
            this.Beritas = res.data.data;
          }
          this.$root.$emit("PesanResponse", res.data.message, "primary");
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
          this.$root.$emit("PesanResponse", error.response.data.message, "red");
        });
      },

      editItem (item) {

        this.dialog = true;
        this.newsinsert.judul =item.judul
        this.newsinsert.keterangan =item.keterangan;
        this.newsinsert.gambar =item.gambar;
        this.newsinsert.id_berita    =item.id_berita;
         this.editgambar   = 2;
       this.editedIndex = this.Beritas.indexOf(item)
        this.editedItem = Object.assign({}, item)
           },

      deleteItem (item) {
        this.editedIndex = this.Beritas.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
             axios
        .post(
          "/api/auth/DeleteBerita",this.editedItem,
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

        data.append('keterangan' ,  this.newsinsert.keterangan);
        data.append('judul', this.newsinsert.judul);

        if(this.editedIndex != -1){
        data.append('id_berita', this.newsinsert.id_berita);
        }

       axios
        .post(
          "/api/auth/SimpanBerita",data,
          {
            headers: {
              Authorization  : "Bearer " + this.$cookies.get("token"),
            },
          }
        )
        .then((res) => {
          if (res.data.status == true) {

            this.newsinsert.judul   ='';
            this.newsinsert.keterangan    ='';
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

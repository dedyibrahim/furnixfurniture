<template>
  <v-data-table
    :headers="headers"
    :items="Produks"
    class="elevation-1"
     :expanded.sync="expanded"
    :single-expand="singleExpand"
    show-expand
     item-key="id_produk"

  >
    <template v-slot:top>
      <v-toolbar
        flat
      >
        <v-toolbar-title>Data Produk</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-dialog
          v-model="dialog"
          max-width="900px"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              color="primary"
              dark
              class="mb-2 text-capitalize"
              v-bind="attrs"
              v-on="on"
            >
              Tambah data Produk
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
                         <v-select :items="kategoris" item-text="nama_kategori" item-value="id_kategori" v-model="produkinsert.kategori"  label="Kategori" dense outlined placeholder="Kategori"></v-select>
                            <v-text-field v-model="produkinsert.nama_produk" dense label="Nama Produk" outlined placeholder="Nama Produk"></v-text-field>
                            <v-text-field type="number" v-model="produkinsert.harga_produk" dense label="Harga Produk" outlined placeholder="Harga Produk"></v-text-field>
                            <v-file-input
                            accept="image/*"
                             v-model="files"
                             multiple
                             chips
                            label="Gambar File"
                            dense outlined
                            prepend-icon="mdi-camera"
                           ></v-file-input>
                      </v-col>
                      <v-col>
                            <v-textarea rows="8"   v-model="produkinsert.keterangan" dense label="Keterangan" outlined placeholder="Keterangan"></v-textarea>
                      </v-col>
                  </v-row>
                  <v-row v-show="editedIndex != -1">
                      <v-col class="co-md-3text-center" v-for="i in filesedit"
                             :key="i.gambar"
                             >
                          <p>   <v-img contain min-height="150" max-height="150" max-width="150" :src='"../assets/imgproduk/"+i.name'></v-img>
                           <v-btn  class="text-center mx-auto text-capitalize" absolute  small color="red" @click="HapusGambar(i.id_gambar,i)">Hapus</v-btn>
                            <br></p>
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
            <v-card-title class="text-h5 text-center">Yakin ingin menghapus produk ini ?</v-card-title>
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
                      <v-col class="col-md-3 mx-auto" v-for="i in item.gambar"
                             :key="i.gambar"
                             >
                             <v-img contain min-height="150" max-height="150" max-width="150" :src='"../assets/imgproduk/"+i.name'></v-img>
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
  export default {
    data: () => ({
            expanded: [],
      singleExpand: false,

      dialog: false,
      dialogDelete: false,
      headers: [
        {
          text: 'ID Produk',
          align: 'start',
          sortable: false,
          value: 'id_produk',
        },
        { text: 'Nama Produk', value: 'nama_produk' },
        { text: 'Kategori', value: 'nama_kategori' },
        { text: 'Harga', value: 'harga_produk' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
     Produks: [],
     files: [],
     filesedit: [],
     readers: [],
     kategoris :[],
      produkinsert :{
        nama_produk  :'',
        kategori :'',
        keterangan :'',
        harga_produk :'',
        id_produk    :'',
      },
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
               this.produkinsert.nama_produk   ='';
            this.produkinsert.kategori      ='';
            this.produkinsert.keterangan    ='';
            this.produkinsert.harga_produk  ='';
            this.files =[];
          }
        return this.editedIndex === -1 ? 'New Produk' : 'Edit Produk'
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
      this.DataKategori();
    },

    methods: {
    HapusGambar(id_gambar,i){
        this.filesedit.splice(i, 1);
         this.$root.$emit("PesanLoading", "Menghapus Gambar");
      axios
        .post(
          "/api/auth/HapusGambarProduk",{id_gambar : id_gambar},
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
          "/api/auth/DataProduk",
          {
            headers: {
              Authorization: "Bearer " + this.$cookies.get("token"),
            },
          }
        )
        .then((res) => {
          if (res.data.status == true) {
            this.Produks = res.data.data;
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
        this.produkinsert.nama_produk  =item.nama_produk;
        this.produkinsert.kategori     =item.id_kategori;
        this.produkinsert.keterangan   =item.keterangan;
        this.produkinsert.harga_produk =item.harga_produk;
        this.produkinsert.id_produk    =item.id_produk;
        this.filesedit =item.gambar;

        this.editedIndex = this.Produks.indexOf(item)
        this.editedItem = Object.assign({}, item)
           },

      deleteItem (item) {
        this.editedIndex = this.Produks.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
             axios
        .post(
          "/api/auth/DeleteProduk",this.editedItem,
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
         for (let file of this.files) {
           data.append('files[]', file, file.name)
         }
        data.append('nama_produk',  this.produkinsert.nama_produk);
        data.append('kategori',     this.produkinsert.kategori);
        data.append('keterangan' ,  this.produkinsert.keterangan);
        data.append('harga_produk', this.produkinsert.harga_produk);
        if(this.editedIndex != -1){
        data.append('id_produk', this.produkinsert.id_produk);
        }

       axios
        .post(
          "/api/auth/SimpanProduk",data,
          {
            headers: {
              Authorization  : "Bearer " + this.$cookies.get("token"),
            },
          }
        )
        .then((res) => {
          if (res.data.status == true) {
            this.produkinsert.nama_produk   ='';
            this.produkinsert.kategori      ='';
            this.produkinsert.keterangan    ='';
            this.produkinsert.harga_produk  ='';
            this.files =[];
           this.initialize();
           }

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

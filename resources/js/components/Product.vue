<template>
<v-sheet>
<v-container class="mt-5 mb-5"  style="padding:0px">
    <v-row>
        <v-col>
         <v-tabs  centered class="primary text-left">
      <v-tab class="text-capitalize ">
         Semua Produk
       </v-tab>
          <v-tab
             :active-class="$route.query.kategori"
            :to="{path:'/product', query:{'kategori': p.nama_kategori }}"
            v-for="p in Kategoris"
            :key="p.id_kategori"
            class="text-capitalize">
            {{p.nama_kategori}}
          </v-tab>
         </v-tabs>
        </v-col>
    </v-row>

 <v-container fluid>

                <v-row>
                    <v-col class="col-md-3 col-sm-6 col-xs-12"  v-for="dt in Produks" :key="dt.id_produk">
                         <v-hover  v-slot="{ hover }">
                               <v-card
                                 :to="{path :'/detail-produk',query:{'nama_produk':dt.nama_produk}}"
                                :loading="loading"
                                :elevation="hover ? 12 : 2"
                                  :class="{ 'on-hover': hover }"
                                class="mx-auto "
                                max-height="360"
                                min-height="360"
                            >
                                <template slot="progress">
                                <v-progress-linear
                                    color="deep-purple"
                                    height="10"
                                    indeterminate
                                ></v-progress-linear>
                                </template>

                                <v-img
                                contain
                                height="250"
                                :src="'assets/imgproduk/'+dt.gambar"
                                ></v-img>

                                 <v-card-text style="min-height:60px;">
                                 <p>Furnix Furniture</p>
                                 <h3>{{dt.nama_produk}}</h3>
                                 </v-card-text>

                            </v-card>
                          </v-hover>
                            </v-col>
                        </v-row>

                <p class="text-center">   <infinite-loading ref="infiniteLoading" @infinite="ProdukWhere">
                    <template slot="no-more">Tidak ada lagi produk</template>
                    </infinite-loading> </p>

 </v-container>
</v-container>
 </v-sheet>
</template>

<script>
import Banner  from './Banner.vue'
export default {
  metaInfo: {
      title: 'Furnix Furniture',
      titleTemplate: '%s - Produk!',
      htmlAttrs: {
        lang: 'en',
        amp: true
      }
    },
  mounted(){
  this.DataProduk();
  this.ProdukWhere();
  this.query = this.$route.query.kategori;
  },
  data: () => ({
     transparent: 'rgba(255, 255, 255, 0)',
     loading   :false,
     page      :1,
      active_tab: 0,
      selectedTab :"KTG0004",
     Kategoris :[],
     Produks   :[],
     query     :''
    }),
    components:{
        'Banner' :Banner
    },
    watch: {
    $route(to, from) {
        this.$refs.infiniteLoading.stateChanger.reset();
      this.Produks = [];
      this.page = 1;
      this.query = to.query.kategori;
      this.ProdukWhere();
   //   console.log(this.$refs.infiniteLoading.stateChanger.loaded.reset());
    }
    },
    methods:{


        ProdukWhere($state){

      axios
        .post(
          "/api/HomeDataProdukWhere",{nama_kategori : this.query, limit:this.page},
          {
            headers: {
              Authorization: "Bearer " + this.$cookies.get("token"),
            },
          }
        ).then(({ data }) => {
         if (data.data.batas != this.Produks.length ) {
          this.page += 4;
          this.Produks = data.data.detail;
          $state.loaded();
        } else {
          $state.complete();
        }
      })
        .catch((error) => {
        });
        },
          DataProduk(){

      axios
        .get(
          "/api/HomeDataProduk",
          {
            headers: {
              Authorization: "Bearer " + this.$cookies.get("token"),
            },
          }
        )
        .then((res) => {
          if (res.data.status == true) {
            this.Kategoris = res.data.data;
          }
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
          this.$root.$emit("PesanResponse", error.response.data.message, "red");
        });

        }
    },

}

</script>

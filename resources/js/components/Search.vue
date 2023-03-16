<template>
<v-sheet>
<v-container class="mt-5 mb-5"  style="padding:0px">

                <v-row>
                    <v-col class="col-md-3" v-for="dt in Produks" :key="dt.id_produk">
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

                                 <v-card-title class="font-italic">Furnix Furniture<br> </v-card-title>
                                 <v-card-text style="min-height:60px;">
                                 <span class="h6" >{{dt.nama_produk}}</span>
                                 </v-card-text>

                            </v-card>
                          </v-hover>
                            </v-col>
                        </v-row>


</v-container>
 </v-sheet>
</template>

<script>
import Banner  from './Banner.vue'
export default {
     metaInfo: {
      title: 'Furnix Furniture',
      titleTemplate: '%s - Pencarian!',
      htmlAttrs: {
        lang: 'en',
        amp: true
      }
    },

  mounted(){
  this.ProdukPencarian();
  },
  data: () => ({
     transparent: 'rgba(255, 255, 255, 0)',
     loading   :false,
     Produks   :[],
     query     :''
    }),
    components:{
        'Banner' :Banner
    },
    methods:{

        ProdukPencarian(){

        this.$root.$emit("PesanLoading", "Melakukan Pencarian");
      axios
        .post(
          "/api/Pencarian",{kata_kunci : this.$route.query.search},
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
        }

    },

}

</script>

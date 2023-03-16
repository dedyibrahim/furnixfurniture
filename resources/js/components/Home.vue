<template>
<v-sheet>
<v-container fluid style="padding:0px">
     <Banner/>
</v-container>



<v-container   fluid style="padding:0px">
 <v-container>
       <v-row>
            <v-col >

        <h1  class="blue--text  text-center font-weight-medium  mb-5 fw-bold text--secondary">Office Furniture Specialist</h1>

              <p class="text-justify">
              Menjawab kebutuhan tata ruang dan perlengkapan kantor yang berkualitas, Furnix Furniture memberikan solusi penataan ruang dengan menyediakan beragam pilihan office furniture lengkap meliputi partisi kantor, meja kerja kantor, kursi kantor, meja meeting hingga pembuatan workstation yang dapat disesuaikan dengan kebutuhan anda. Berbagai tipe, ukuran dan warna memberikan keleluasaan bagi anda dalam merancang ruang kantor yang nyaman, fleksibel dan fungsional. Kualitas dan ragam pilihan produk membuat Furnix Furniture mendapat kepercayaan dari banyak perusahaan sebagai solusi kebutuhan office furniture.

              </p>
            </v-col>

       </v-row>
 </v-container>
</v-container>

<v-container   fluid style="padding:0px">
 <v-container>
       <v-row>
            <v-col >
                <h1  class="blue--text  text-center font-weight-medium text--secondary  mb-5 fw-bold">Our Products</h1>
                 <v-row v-for="p in Produks" :key="p.id_kategori">
                   <v-col>
                       <h2 class=" blue--text mb-5">{{p.nama_kategori}}  <v-btn :to="{path:'/product', query:{'kategori':p.nama_kategori}}" class="text-capitalize" text right> Lihat Selengkapnya</v-btn></h2>

                        <v-row>

                            <v-col class="col-md-3" v-for="dt in p.detail.slice(0,4)" :key="dt.id_produk">
                         <v-hover v-slot="{ hover }">
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

                   </v-col>
                </v-row>
            </v-col>
       </v-row>
 </v-container>
</v-container>



</v-sheet>
</template>

<script>
import Banner  from './Banner.vue'
export default {
     metaInfo: {
      title: 'Furnix Furniture',
      titleTemplate: '%s - Home!',
      htmlAttrs: {
        lang: 'en',
        amp: true
      },
      meta: [
      { charset: 'utf-8' },
      { name: 'Furnix Furniture merupakan produsen office furniture untuk partisi kantor dan produk kantor dengan desain yang minimalis dan kualitas terbaik. Furnix Furniture memiliki berbagai macam tipe partisi kantor, meja kantor, kursi kantor dan perlengkapan kantor lainya. Furnix Furniture telah di percaya banyak perusahaan dalam memberikan solusi kebutuhan office furniture. Furnix Furniture menyediakan beberapa model furniture yang dapat disesuaikan dengan ukuran, warna dan tipe sesuai kebutuhan dan keinginan. ,OFFICE FURNITURE',
      content: 'foo',
      keyword :'Peralatan Kantor - Meja Kerja Kantor, Kursi Kerja Kantor, Furniture Kantor,Partisi Kantor,',
       }
     ]
          },
  mounted(){
  this.DataProduk();
  },
  data: () => ({
       transparent: 'rgba(255, 255, 255, 0)',
      loading:false,
     Produks :[],
    }),
    components:{
        'Banner' :Banner
    },
    methods:{

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
            this.Produks = res.data.data;
          }

        })
        .catch((error) => {
          this.errors = error.response.data.errors;
          this.$root.$emit("PesanResponse", error.response.data.message, "red");
        });

        }
    }
}

</script>

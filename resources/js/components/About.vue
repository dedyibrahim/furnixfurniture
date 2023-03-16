<template>
<v-sheet>
<v-container  class="mt-11 mb-11" style="padding:0px">
     <h1  class="blue--text  text-center font-weight-medium  mb-5 fw-bold text--secondary">About Us</h1>
<v-row>
    <v-col class="col-md-9 mx-auto">
  <p class="text-justify">Furnix Furniture merupakan produsen office furniture untuk partisi kantor dan produk kantor dengan desain yang minimalis dan kualitas terbaik. Furnix Furniture memiliki berbagai macam tipe partisi kantor, meja kantor, kursi kantor dan perlengkapan kantor lainya. Furnix Furniture telah di percaya banyak perusahaan dalam memberikan solusi kebutuhan office furniture. Furnix Furniture menyediakan beberapa model furniture yang dapat disesuaikan dengan ukuran, warna dan tipe sesuai kebutuhan dan keinginan.</p>
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
      titleTemplate: '%s - About!',
      htmlAttrs: {
        lang: 'en',
        amp: true
      }
    },
  mounted(){
 // this.DataProduk();
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

        this.$root.$emit("PesanLoading", "Mengambil data Produk");
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
          this.$root.$emit("PesanResponse", res.data.message, "primary");
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
          this.$root.$emit("PesanResponse", error.response.data.message, "red");
        });

        }
    }
}

</script>

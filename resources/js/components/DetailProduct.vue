<template>
<v-sheet>
<v-container class="mt-5 mb-5"  style="padding:0px">
 <v-row v-for="dt in Produks" :key="dt.id_produk">
     <v-col class="col-md-6">
         <v-carousel
    cycle
    height="400"
    hide-delimiter-background
    show-arrows-on-hover
  >

    <v-carousel-item
      v-for="(item,i) in dt.gambar"
      :key="i"
      contain
      :src="'assets/imgproduk/'+item.name"
      reverse-transition="fade-transition"
      transition="fade-transition"
    ></v-carousel-item>


  </v-carousel>
     </v-col >
     <v-col class="col-md-6">
         <h2 class="text-secondary">{{dt.nama_produk}}</h2>
         <p>{{dt.keterangan}}</p>
     </v-col>
 </v-row>
</v-container>
 </v-sheet>
</template>


<script>
import Banner  from './Banner.vue'
export default {
  mounted(){
  this.DetailProduct();
  },
  data: () => ({
     Produks :[],
    }),
    components:{
        'Banner' :Banner
    },
    methods:{

        DetailProduct(){

      axios
        .post(
          "/api/DetailProduct",{nama_produk : this.$route.query.nama_produk },
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

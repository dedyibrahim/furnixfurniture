<template>
<v-sheet>
<v-container class="mt-5 mb-5"  style="padding:0px">
  <v-row >
       <v-col >
           <v-card   elevation="2">
               <v-card-text>
            <v-row class="mb-6">
                <v-col class="col-md-6">
                              <v-img contain max-height="400" min-height="400"  :src='"../assets/imgberita/"+DetailBerita.gambar'></v-img>
                </v-col>
                 <v-col >
                     <h1>{{DetailBerita.judul}}</h1>
                      <p class="mt-2">{{DetailBerita.create}}</p>
                     <div v-html="DetailBerita.keterangan"></div>
                 </v-col>

            </v-row>
               </v-card-text>
           </v-card>

       </v-col>
    </v-row>
</v-container>
 </v-sheet>
</template>


<script>
export default {
  mounted(){
  this.getsBerita();
  },
  data: () => ({
     DetailBerita :[],
    }),

    methods:{

        getsBerita(){

        this.$root.$emit("PesanLoading", "Mengambil data berita");
      axios
        .post(
          "/api/DetailBerita",{nama_berita : this.$route.query.nama_berita },
          {
            headers: {
              Authorization: "Bearer " + this.$cookies.get("token"),
            },
          }
        )
        .then((res) => {
          if (res.data.status == true) {
            this.DetailBerita = res.data.data;
            console.log(this.DetailBerita);
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

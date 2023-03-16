<template>
<v-sheet>
<v-container class="mt-11 mb-11"  style="padding:0px">
     <v-row v-for="b in Beritas" :key="b.id_berita">
       <v-col >
           <v-card  :to="{path :'/detail-berita',query:{'nama_berita':b.judul}}" elevation="2">
               <v-card-text>
            <v-row class="mb-6">
                <v-col class="col-md-6">
                              <v-img contain max-height="400" min-height="400"  :src='"../assets/imgberita/"+b.gambar'></v-img>
                </v-col>
                 <v-col >
                     <h1>{{b.judul}}</h1>
                      <p class="mt-2">{{b.create}}</p>
                     <div v-html="b.keterangan.substring(0,1000)+'...'"></div>
                 </v-col>

            </v-row>
               </v-card-text>
           </v-card>

       </v-col>
    </v-row>
        <p class="text-center">   <infinite-loading ref="infiniteLoading" @infinite="DataBerita"></infinite-loading></p>

</v-container>
 </v-sheet>
</template>


<script>
export default {
     metaInfo: {
      title: 'Furnix Furniture',
      titleTemplate: '%s - News!',
      htmlAttrs: {
        lang: 'en',
        amp: true
      }
    },
  mounted(){
      this.DataBerita();
  },
  data: () => ({
     transparent: 'rgba(255, 255, 255, 0)',
     loading:false,
     page : 1,
     Beritas :[],
    }),
    components:{
    },
    methods:{

    DataBerita($state){
      axios
        .post(
          "/api/DataBerita",{limit:this.page},
          {
            headers: {
              Authorization: "Bearer " + this.$cookies.get("token"),
            },
          }
        )
        .then((res) => {
          if (res.data.data.batas != this.Beritas.length ) {
            this.Beritas = res.data.data.detail;
             this.page += 1;
             $state.loaded();
          } else {
           $state.complete();
         }

        })
        .catch((error) => {
        });

        }
    }
}

</script>

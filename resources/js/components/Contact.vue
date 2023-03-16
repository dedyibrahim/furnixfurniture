<template>
<v-sheet>
<v-container class="mt-10 mb-10"  style="padding:0px">
    <v-row>
      <v-col class="col">
       <h1  class="blue--text  text-center font-weight-medium  mb-5 fw-bold text--secondary">Contact Us</h1>
       <v-row>
           <v-col>
        <v-card class="p-2">
            <v-card-text>
       <h2  class="blue--text  text-center font-weight-medium  mb-5 fw-bold text--secondary">Anda dapat menghubungi kami di</h2>
              <p class="text-left"  > Address : <br>Pergudangan Kamal Muara 2 Blok B No 8
<br>Jl. Pergudangan Kapuk Kamal Utara, Kamal Muara,<br>
Kec. Penjaringan, Kota Jakarta Utara 14470 <br>
Telp: 0813-1813-5929</p>
<v-row>
        <v-col >       <iframe style="width:100%;" height="280px;"  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3967.269715335428!2d106.710889314309!3d-6.094325661478495!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6a03e4624e7f0d%3A0x9f8d83e012bb7250!2sFurnix%20Furniture!5e0!3m2!1sid!2sid!4v1678781835541!5m2!1sid!2sid" allowfullscreen></iframe>
                    </v-col>
      </v-row>

             </v-card-text>
        </v-card>
           </v-col>
           <v-col>
        <v-card class="p-2">
            <v-card-text>
       <h2  class="blue--text  text-center font-weight-medium  mb-5 fw-bold text--secondary">Atau Mengisi Form Dibawah ini</h2>
            <v-text-field v-model="tamu.nama" solo dense outlined placeholder="name"></v-text-field>
            <v-text-field v-model="tamu.email" solo dense outlined placeholder="Email"></v-text-field>
            <v-text-field v-model="tamu.tlp"    solo dense outlined placeholder="Telp"></v-text-field>
            <v-textarea   v-model="tamu.keterangan" solo dense outlined placeholder="Message"></v-textarea>
            <v-divider></v-divider>
            <v-btn block class="blue white--text" @click="SimpanTamu">Simpan</v-btn>
            </v-card-text>
        </v-card>
           </v-col>
       </v-row>
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
      titleTemplate: '%s - Contact!',
      htmlAttrs: {
        lang: 'en',
        amp: true
      }
    },
  mounted(){
  //this.DataProduk();
  },
  data: () => ({
       transparent: 'rgba(255, 255, 255, 0)',
      loading:false,
     tamu :{
         nama    :'',
         email   :'',
         tlp    :'',
         keterangan :'',
     },
    }),
    components:{
        'Banner' :Banner
    },
    methods:{

        SimpanTamu(){

        this.$root.$emit("PesanLoading", "Menyimpan Pesan");
      axios
        .post(
          "/api/SimpanTamu",this.tamu,
          {
            headers: {
              Authorization: "Bearer " + this.$cookies.get("token"),
            },
          }
        )
        .then((res) => {
          if (res.data.status == true) {
         this.tamu.nama       ='';
         this.tamu.email      ='';
         this.tamu.tlp       ='';
         this.tamu.keterangan ='';

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

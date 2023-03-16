<template>
  <v-carousel
    cycle
    height="400"
    hide-delimiter-background
    show-arrows-on-hover
  >

    <v-carousel-item
      v-for="(item,i) in Banners"
      :key="i"
      :src="'assets/imgbanner/'+item.gambar"
      reverse-transition="fade-transition"
      transition="fade-transition"
    >


    </v-carousel-item>


  </v-carousel>
</template>

<script>
  export default {
       mounted(){
     this.DataBanner();
   },
    data () {
      return {
          Banners :[],
      }
    },
    methods :{
        DataBanner() {

      axios
        .get(
          "/api/DataBanner",
          {
            headers: {
              Authorization: "Bearer " + this.$cookies.get("token"),
            },
          }
        )
        .then((res) => {
          if (res.data.status == true) {
            this.Banners = res.data.data;
          }
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
          this.$root.$emit("PesanResponse", error.response.data.message, "red");
        });
      },

    }
  }
</script>

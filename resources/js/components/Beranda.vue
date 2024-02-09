<template>
    <v-app>
        <v-navigation-drawer v-model="drawer" fixed temporary>
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title>
                        <router-link
                            class="text-decoration-none"
                            :to="{ path: '/' }"
                        >
                            <v-img
                                class="float-left"
                                height="auto"
                                max-width="200"
                                contain
                                src="./assets/logo.jpg"
                            ></v-img
                        ></router-link>
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

            <v-list color="white" nav dense>
                <v-list-item-group
                    active-class="deep-purple--text text--accent-4"
                >
                    <v-list-item
                        v-for="item in items"
                        :key="item.name"
                        :to="{ path: item.link }"
                    >
                        <v-list-item-title
                            >{{ item.name }}
                            <v-icon right>
                                {{ item.icon }}
                            </v-icon>
                        </v-list-item-title>
                    </v-list-item>
                </v-list-item-group>
            </v-list>

            <v-divider></v-divider>

            <v-list-item>
                <v-list-item-content>
                    <v-btn
                        v-if="statuslogin"
                        class="block text-capitalize"
                        color="primary"
                    >
                        Profil <v-icon>mdi-account</v-icon>
                    </v-btn>

                    <router-link
                        :to="{ path: '/login' }"
                        v-else
                        class="block text-decoration-none"
                    >
                        <v-btn block color="primary" class="text-capitalize">
                            Masuk <v-icon>mdi-login</v-icon>
                        </v-btn>
                    </router-link>
                </v-list-item-content>
            </v-list-item>
        </v-navigation-drawer>

        <v-app-bar color="white" app height="100" hide-on-scroll>
            <v-toolbar-title>
                <router-link class="text-decoration-none" :to="{ path: '/' }">
                    <router-link :to="{ path: '/' }">
                        <v-img
                            class="d-none d-sm-flex d-sm-none d-md-flex"
                            height="auto"
                            max-width="190"
                            src="./assets/logo.jpg"
                        ></v-img
                    ></router-link>
                </router-link>
            </v-toolbar-title>
            <v-spacer class="d-none d-sm-flex d-sm-none d-md-flex"></v-spacer>
            <v-spacer class="d-none d-sm-flex d-sm-none d-md-flex"></v-spacer>

            <v-text-field
                dense
                solo
                color="white"
                class="mt-6 ml-9"
                v-model="itempencarian"
                :items="pakets"
                placeholder="Cari Produk"
            ></v-text-field>

            <v-btn
                @click="DetailPaket()"
                icon
                color="blue"
                primary
                class="mr-2"
            >
                <v-icon>mdi-magnify</v-icon>
            </v-btn>

            <template v-slot:extension>
                <v-row>
                    <v-col class="d-none d-sm-flex d-sm-none d-md-flex">
                        <v-tabs align-with-title>
                            <v-tabs-slider color="red"></v-tabs-slider>
                            <v-tab
                                class="text-capitalize blue--text"
                                v-for="item in items"
                                :key="item.name"
                                :to="{ path: item.link }"
                            >
                                {{ item.name }}
                                <v-icon right>
                                    {{ item.icon }}
                                </v-icon>
                            </v-tab>
                        </v-tabs>
                    </v-col>
                    <v-col class="text-right pt-6">
                        <v-icon>mdi-phone</v-icon>0813-1813-5929 &nbsp;&nbsp;
                        <v-icon>mdi-email</v-icon>marketing.furnix@gmail.com
                    </v-col>
                </v-row>
            </template>

            <router-link
                :to="{ path: '/login' }"
                class="d-none d-sm-flex d-sm-none d-md-flex text-decoration-none"
            >
                <v-btn color="primary" class="text-capitalize">
                    Signin <v-icon>mdi-login</v-icon>
                </v-btn>
            </router-link>

            <v-app-bar-nav-icon
                class="d-lg-none d-xl-flex"
                @click.stop="drawer = !drawer"
            ></v-app-bar-nav-icon>
        </v-app-bar>

        <v-main style="padding-bottom: 0px">
            <router-view></router-view>
        </v-main>

        <v-footer app style="position: static" light padless>
            <v-card elevation="3" class="flex">
                <v-card-title class="light">
                    <v-container>
                        <v-row>
                            <v-col class="col-md-6">
                                <router-link :to="{ path: '/' }">
                                    <v-img
                                        height="auto"
                                        max-width="230"
                                        contain
                                        src="./assets/logo.jpg"
                                    ></v-img
                                ></router-link>
                                <p class="text-left" style="font-size: 15px">
                                    Address :<br />Pergudangan Kamal Muara 2
                                    Blok B No 8 <br />Jl. Pergudangan Kapuk
                                    Kamal Utara, Kamal Muara, <br />
                                    Kec. Penjaringan, Kota Jakarta Utara 14470
                                    <br />Telp: 0813-1813-5929
                                </p>
                            </v-col>

                            <v-col class="text-center col-md-6">
                                <h3 class="text--secondary text-center">
                                    Follow Our Social Media
                                </h3>
                                <v-divider></v-divider>
                                <a
                                    :href="icon.link"
                                    class="text-decoration-none"
                                    target="_blank"
                                    v-for="icon in icons"
                                    :key="icon.name"
                                >
                                    <v-btn class="mx-10 mt-10" light icon>
                                        <v-icon size="70px">
                                            {{ icon.name }}
                                        </v-icon>
                                    </v-btn>
                                </a>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-title>
                <v-card-text class="py-2 white--text text-center blue">
                    &copy; {{ new Date().getFullYear() }}
                    <strong>CV Furnix Furniture All Right Reserved</strong>
                </v-card-text>
            </v-card>
        </v-footer>
    </v-app>
</template>

<script>
import App from "./App.vue";
export default {
    components: { App },
    name: "App",
    mounted() {
        // this.DataPaket();
    },
    data() {
        return {
            fav: true,
            menu: false,
            message: false,
            hints: true,
            itempencarian: "",
            pakets: [],

            statuslogin: this.$cookies.get("token"),
            icons: [
                {
                    name: "mdi-facebook",
                    link: "https://www.instagram.com/furnix-furniture/",
                },
                {
                    name: "mdi-twitter",
                    link: "https://www.instagram.com/furnix-furniture/",
                },
                {
                    name: "mdi-instagram",
                    link: "https://www.instagram.com/furnix-furniture/",
                },
            ],
            drawer: false,
            items: [
                { name: "Home", link: "/", icon: "mdi-home" },
                {
                    name: "Product",
                    link: "product",
                    icon: "mdi-bookmark-multiple-outline",
                },
                {
                    name: "News",
                    link: "news",
                    icon: "mdi-newspaper-variant-multiple-outline",
                },
                {
                    name: "About",
                    link: "about",
                    icon: "mdi-information-outline",
                },
                { name: "Contact", link: "contact", icon: "mdi-phone" },
            ],
        };
    },
    methods: {
        LogOut() {
            this.menu = false;
            this.statuslogin = false;

            this.$root.$emit("PesanLoading", "Proses Logout");
            axios
                .post(
                    "/api/auth/SignOut",
                    {},
                    {
                        headers: {
                            Authorization:
                                "Bearer " + this.$cookies.get("token"),
                        },
                    }
                )
                .then((res) => {
                    if (res.data.status == true) {
                        this.$cookies.remove("name");
                        this.$cookies.remove("email");
                        this.$cookies.remove("level_user");
                        this.$cookies.remove("token");
                        this.$router.replace("/");
                    }
                    this.$root.$emit(
                        "PesanResponse",
                        res.data.message,
                        "primary"
                    );
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                    this.$root.$emit(
                        "PesanResponse",
                        error.response.data.message,
                        "red"
                    );
                });
        },
        DetailPaket() {
            if (this.itempencarian) {
                this.$router.push({
                    path: "pencarian",
                    query: { search: this.itempencarian },
                });
            } else {
                this.$root.$emit(
                    "PesanResponse",
                    "Hara Masukan Kata Kunci terlebih dahulu",
                    "primary"
                );
            }
        },
        DataPaket() {
            axios
                .get("/api/DataPaketPencarian")
                .then((res) => {
                    this.pakets = res.data.data;
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                });
        },
        isLoginPage() {
            var path = this.$route.path.split("/")[1];
            if (path != "DashboardPerizinan") {
                return true;
            }
            return false;
        },
    },
    watch: {
        group() {
            this.drawer = false;
        },
    },
};
</script>

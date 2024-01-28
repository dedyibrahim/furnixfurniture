<template>
    <v-app id="inspire">
        <v-app-bar color="white" app height="70">
            <v-spacer></v-spacer>
            <v-btn @click="LogOut()" class="red text-capitalize">
                SignOut
                <v-icon>mdi-logout-variant</v-icon>
            </v-btn>

            <v-app-bar-nav-icon
                class="d-lg-none d-xl-flex"
                @click.stop="drawer = !drawer"
            ></v-app-bar-nav-icon>
        </v-app-bar>

        <v-navigation-drawer v-model="drawer" app>
            <v-sheet color="blue" class="pa-4">
                <v-avatar
                    class="mb-4"
                    color="grey darken-1"
                    size="64"
                ></v-avatar>

                <div class="white--text">Administrator</div>
            </v-sheet>

            <v-divider></v-divider>

            <v-list>
                <router-link
                    class="text-decoration-none"
                    v-for="[icon, text, url] in links"
                    :key="icon"
                    :to="{ path: url }"
                >
                    <v-list-item link>
                        <v-list-item-icon>
                            <v-icon>{{ icon }}</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>{{ text }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item></router-link
                >
            </v-list>
        </v-navigation-drawer>

        <v-main>
            <v-container class="py-8 px-6" fluid>
                <router-view></router-view>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
export default {
    mounted() {
        if (!this.$cookies.get("token")) {
            this.$root.$emit(
                "PesanResponse",
                "Sesi Telah Habis Silahkan Login Kembali",
                "primary"
            );
            this.$router.push("/");
        }
    },
    data: () => ({
        drawer: null,
        links: [
            ["mdi-book-account", "Buku Tamu", "/Dashboard"],
            ["mdi-notebook", "Data Produk", "/Dashboard/data-produk"],
            [
                "mdi-dots-horizontal",
                "Data Kategori",
                "/Dashboard/data-kategori",
            ],
            [
                "mdi-newspaper-variant-multiple-outline",
                "Berita",
                "/Dashboard/data-berita",
            ],
            ["mdi-image-area", "Banner", "/Dashboard/data-banner"],
        ],
    }),
    methods: {
        LogOut() {
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
    },
};
</script>

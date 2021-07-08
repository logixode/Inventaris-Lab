   

<template>
  <div>
    <div class="row">
      <router-link to="/category" class="btn btn-primary"
        >Semua Kategori
      </router-link>
    </div>

    <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Update Kategori</h1>
                  </div>

                  <form class="user" @submit.prevent="categoryUpdate">
                    <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-6">
                          <label for="exampleFormControlTextarea1"
                            ><b>Nama Kategori </b></label
                          >
                          <input
                            type="text"
                            class="form-control"
                            id="exampleInputFirstName"
                            placeholder="Enter Your Category Name"
                            v-model="form.nama_kategori"
                          />
                          <small
                            class="text-danger"
                            v-if="errors.nama_kategori"
                          >
                            {{ errors.nama_kategori[0] }}
                          </small>
                        </div>

                        <div class="col-md-6">
                          <label for="exampleFormControlTextarea1"
                            ><b>Kategori Inti </b></label
                          >
                          <select
                            class="form-control"
                            id="exampleFormControlSelect1"
                            v-model="form.kategori_inti"
                          >
                            <option selected disabled :value="null">
                              Pilih Kategori
                            </option>
                            <option
                              v-for="data in kategori_inti"
                              :value="data.id"
                              :key="data.id"
                            >
                              {{ data.value }}
                            </option>
                          </select>
                          <small
                            class="text-danger"
                            v-if="errors.kategori_inti"
                          >
                            {{ errors.kategori_inti[0] }}
                          </small>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-6">
                          <label for="exampleFormControlTextarea1"
                            ><b>Keterangan </b></label
                          >
                          <input
                            type="text"
                            class="form-control"
                            id="exampleInputFirstName1"
                            placeholder="Enter Your Kategori"
                            v-model="form.keterangan"
                          />
                          <small class="text-danger" v-if="errors.keterangan">
                            {{ errors.keterangan[0] }}
                          </small>
                        </div>

                        <div class="col-md-6">
                          <label for="exampleFormControlTextarea1"
                            ><b>Gambar </b></label
                          >
                          <div class="row justify-content-between">
                            <div class="col-9 d-flex">
                              <input
                                type="file"
                                accept="image/*"
                                id="customFile"
                                class="input-file w-full"
                                @change="onFileSelected"
                              />
                              <div
                                class="
                                  input-image
                                  bg-primary
                                  border
                                  rounded-lg
                                  border-secondary
                                  d-flex
                                "
                              >
                                <p class="m-auto">Pilih Gambar</p>
                              </div>
                            </div>

                            <div class="col-3 d-flex justify-content-end">
                              <img
                                v-if="form.gambar"
                                :src="form.gambar"
                                alt=""
                                srcset=""
                                class="input-image-preview bg-gray-dark"
                              />
                              <div
                                v-if="!form.gambar"
                                src="/"
                                alt=""
                                srcset=""
                                class="input-image-preview default-image"
                              >
                                <i class="fas fa-image fa-fw"></i>
                              </div>
                            </div>
                          </div>
                          <small class="text-danger" v-if="errors.gambar">
                            {{ errors.gambar[0] }}
                          </small>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block">
                        Update
                      </button>
                    </div>
                  </form>
                  <hr />
                  <div class="text-center"></div>
                  <div class="text-center"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>



<script type="text/javascript">
export default {
  created() {
    if (!User.loggedIn()) {
      this.$router.push({ name: "/" });
    }

    // axios
    //   .get("/api/category/" + id)
    //   .then(({ data }) => (this.form = data))
    //   .catch(console.log("error"));
  },
  mounted() {
    let localData = localStorage.getItem("categories") || [];
    this.localData = JSON.parse(localData);

    let id = this.$route.params.id;
    this.form = this.localData[id];
  },

  data() {
    return {
      form: {
        nama_kategori: "",
        keterangan: "",
        gambar: "",
        kategori_inti: null,
      },
      kategori_inti: [
        {
          id: 0,
          value: "Perkakas",
        },
        {
          id: 1,
          value: "Jaringan",
        },
      ],

      errors: {},
      localData: [],
    };
  },

  methods: {
    onFileSelected(event) {
      let file = event.target.files[0];
      if (file.size > 1048770) {
        Notification.image_validation();
      } else {
        // let reader = new FileReader();
        // reader.onload = (event) => {
        //   this.form.gambar = event.target.result;
        //   // console.log(event.target.result);
        // };
        // reader.readAsDataURL(file);
      }
    },
    categoryUpdate() {
      let id = this.$route.params.id;
      // axios
      //   .patch("/api/category/" + id, this.form)
      //   .then(() => {
      //     this.$router.push({ name: "category" });
      //     Notification.success();
      //   })
      //   .catch((error) => (this.errors = error.response.data.errors));

      this.localData[id] = this.form;
      let categories = JSON.stringify(this.localData);

      localStorage.setItem("categories", categories);

      setTimeout(() => {
        Notification.success();
        this.$router.push({ name: "category" });
      }, 1000);
    },
  },
};
</script>


<style type="text/css">
</style>
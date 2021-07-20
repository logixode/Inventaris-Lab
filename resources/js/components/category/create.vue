<template>
  <div>
    <div class="row">
      <router-link to="/category" class="btn btn-primary"
        >All Category
      </router-link>
    </div>

    <edit-category
      :modal_edit_kategori="modal_edit_kategori"
      :kategori_inti="kategori_inti"
      @modalClosed="modal_edit_kategori = $event"
    />
    <add-category
      :modal_add_kategori="modal_add_kategori"
      @addCategory="addCategoryChild"
      @modalClosed="modal_add_kategori = $event"
    />

    <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Tambah Kategori</h1>
                  </div>

                  <form class="user" @submit.prevent="categoryInsert">
                    <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-8">
                          <label for="exampleFormControlTextarea1"
                            ><b>Nama Kategori </b></label
                          >
                          <input
                            type="text"
                            class="form-control"
                            id="exampleInputFirstName"
                            placeholder="Masukkan Nama Kategori"
                            v-model="form.nama_kategori"
                            required
                          />
                          <small
                            class="text-danger"
                            v-if="errors.nama_kategori"
                          >
                            {{ errors.nama_kategori[0] }}
                          </small>

                          <label for="exampleFormControlTextarea1" class="mt-3">
                            <b>Kategori Inti </b>
                          </label>
                          <div class="d-flex">
                            <div class="flex-grow-1">
                              <select
                                class="form-control"
                                id="exampleFormControlSelect1"
                                v-model="form.id_kategori_inti"
                                required
                              >
                                <option selected disabled :value="null">
                                  Pilih Kategori Inti
                                </option>
                                <option
                                  v-for="data in kategori_inti"
                                  :value="data.id"
                                  :key="data.id"
                                >
                                  {{ data.kategori_inti }}
                                </option>
                              </select>
                              <small
                                class="text-danger"
                                v-if="errors.id_kategori_inti"
                              >
                                {{ errors.id_kategori_inti[0] }}
                              </small>
                            </div>
                            <div class="pl-2">
                              <button
                                type="button"
                                class="btn btn-primary h-100"
                                @click="modal_add_kategori = true"
                              >
                                <i class="fas fa-plus fa-fw"></i>
                              </button>
                            </div>
                            <div class="pl-2">
                              <button
                                type="button"
                                class="btn btn-warning h-100"
                                @click="modal_edit_kategori = true"
                              >
                                <i class="fas fa-edit fa-fw"></i>
                              </button>
                            </div>
                          </div>

                          <label for="exampleFormControlTextarea1" class="mt-3">
                            <b>Keterangan </b>
                            </label>
                          <input
                            type="text"
                            class="form-control"
                            id="exampleInputFirstName1"
                            placeholder="Masukkan keterangan"
                            v-model="form.keterangan"
                            required
                          />
                          <small class="text-danger" v-if="errors.keterangan">
                            {{ errors.keterangan[0] }}
                          </small>
                        </div>

                        <div class="col-md-4">
                          <label for="exampleFormControlTextarea1">
                            <b>Gambar </b>
                          </label>
                          <div class="d-flex justify-content-center">
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
                          <div class="d-flex justify-content-between">
                            <div class="w-full mt-1">
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

                            
                          </div>
                          <small class="text-danger" v-if="errors.gambar">
                            {{ errors.gambar[0] }}
                          </small>
                        </div>
                      </div>
                    </div>
                    

                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block">
                        Submit
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
  async created() {
    if (!User.loggedIn()) {
      this.$router.push({ name: "/" });
    }

    let { data } = await axios.get("/api/kategori_inti");
    this.kategori_inti = data;
  },
  mounted() {
    // let kategori = localStorage.getItem("kategori");
    // let kategori_inti = localStorage.getItem("kategori_inti");
    // this.kategori = JSON.parse(kategori) || [];
    // this.kategori_inti = JSON.parse(kategori_inti) || [
    //   {
    //     id: 0,
    //     value: "Perkakas",
    //   },
    //   {
    //     id: 1,
    //     value: "Jaringan",
    //   },
    // ];
  },

  data() {
    return {
      form: {
        nama_kategori: "",
        id_kategori_inti: null,
        keterangan: "",
        gambar: "",
      },
      kategori_inti: [],

      modal_add_kategori: false,
      modal_edit_kategori: false,

      errors: {},
      kategori: [],
    };
  },

  methods: {
    onFileSelected(event) {
      let file = event.target.files[0];
      if (file.size > 1048770) {
        Notification.image_validation();
      } else {
        let reader = new FileReader();
        reader.onload = (event) => {
          this.form.gambar = event.target.result;
          // console.log(event.target.result);
        };
        reader.readAsDataURL(file);
      }
    },
    async categoryInsert() {
      let error;
      await axios.post("/api/category", this.form).catch((err) => {
        error = err;
        this.errors = err.response.data.errors;
      });
      if (!error) {
        Notification.success();
        setTimeout(() => {
          this.$router.push({ name: "category" });
        }, 500);
      }
    },
    addCategoryChild(val) {
      this.modal_add_kategori = val.modal_add_kategori;
      this.kategori_inti.push(val.kategori_inti);
      this.form.id_kategori_inti = val.kategori_inti.id;
    },
  },
};
</script>


<style>
</style>
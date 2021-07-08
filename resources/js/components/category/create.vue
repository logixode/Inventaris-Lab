<template>
  <div>
    <div class="row">
      <router-link to="/category" class="btn btn-primary"
        >All Category
      </router-link>
    </div>

    <div class="modal fade show" v-if="modal_add_kategori" id="exampleModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              Tambah Kategori Inti
            </h5>
          </div>
          <div class="modal-body">
            <form>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label"
                  >Kategori Inti Baru:</label
                >
                <input
                  type="text"
                  class="form-control"
                  id="recipient-name"
                  v-model="add_kategori"
                />
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              @click="modal_add_kategori = false"
            >
              Close
            </button>
            <button type="button" @click="addCategory" class="btn btn-primary">
              Send message
            </button>
          </div>
        </div>
      </div>
    </div>

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
                        <div class="col-md-6">
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
                        </div>

                        <div class="col-md-6">
                          <label for="exampleFormControlTextarea1">
                            <b>Kategori Inti </b>
                          </label>
                          <div class="d-flex">
                            <div class="flex-grow-1">
                              <select
                                class="form-control"
                                id="exampleFormControlSelect1"
                                v-model="form.kategori_inti"
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
                            <div class="pl-2">
                              <button
                                type="button"
                                class="btn btn-primary h-100"
                                @click="modal_add_kategori = true"
                              >
                                +
                              </button>
                            </div>
                          </div>
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
                            placeholder="Masukkan keterangan"
                            v-model="form.keterangan"
                            required
                          />
                          <small class="text-danger" v-if="errors.keterangan">
                            {{ errors.keterangan[0] }}
                          </small>
                        </div>

                        <div class="col-md-6">
                          <label for="exampleFormControlTextarea1">
                            <b>Gambar </b>
                          </label>
                          <div class="d-flex justify-content-between">
                            <div class="flex-grow-1 mr-2">
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

                            <div class="d-flex justify-content-end">
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
  created() {
    if (!User.loggedIn()) {
      this.$router.push({ name: "/" });
    }
  },
  mounted() {
    let kategori = localStorage.getItem("kategori");
    let kategori_inti = localStorage.getItem("kategori_inti");

    this.kategori = JSON.parse(kategori) || [];
    this.kategori_inti = JSON.parse(kategori_inti) || [
      {
        id: 0,
        value: "Perkakas",
      },
      {
        id: 1,
        value: "Jaringan",
      },
    ];
  },

  data() {
    return {
      form: {
        nama_kategori: "",
        kategori_inti: null,
        keterangan: "",
        gambar: "",
      },
      kategori_inti: [],

      add_kategori: "",
      modal_add_kategori: false,

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
    categoryInsert() {
      // axios
      //   .post("/api/category", this.form)
      //   .then(() => {
      //     this.$router.push({ name: "category" });
      //     Notification.success();
      //   })
      //   .catch((error) => (this.errors = error.response.data.errors));

      this.kategori.push(this.form);
      let kategori = JSON.stringify(this.kategori);

      localStorage.setItem("kategori", kategori);

      setTimeout(() => {
        Notification.success();
        this.$router.push({ name: "category" });
      }, 1000);
    },
    addCategory() {
      let randomId = Math.floor(Math.random() * 100);
      this.kategori_inti.push({
        id: randomId,
        value: this.add_kategori,
      });
      this.form.kategori_inti = randomId;

      localStorage.setItem("kategori_inti", JSON.stringify(this.kategori_inti));

      this.modal_add_kategori = false;
    },
  },
};
</script>


<style>
</style>
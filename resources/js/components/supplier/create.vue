 

<template>
  <div>
    <div class="row">
      <router-link to="/supplier" class="btn btn-primary"
        >All Supplier
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
                    <h1 class="h4 text-gray-900 mb-4">Add Supplier</h1>
                  </div>

                  <form
                    class="user"
                    @submit.prevent="supplierInsert"
                    enctype="multipart/form-data"
                  >
                    <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-6">
                          <input
                            type="text"
                            class="form-control"
                            id="exampleInputFirstName"
                            placeholder="Enter Your Full Name"
                            v-model="form.nama"
                          />
                          <small class="text-danger" v-if="errors.nama">
                            {{ errors.nama[0] }}
                          </small>
                        </div>

                        <div class="col-md-6">
                          <input
                            type="email"
                            class="form-control"
                            id="exampleInputFirstName"
                            placeholder="Enter Your Email"
                            v-model="form.email"
                          />
                          <small class="text-danger" v-if="errors.email">
                            {{ errors.email[0] }}
                          </small>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-6">
                          <input
                            type="text"
                            class="form-control"
                            id="exampleInputFirstName"
                            placeholder="Enter Your Address"
                            v-model="form.alamat"
                          />
                          <small class="text-danger" v-if="errors.alamat">
                            {{ errors.alamat[0] }}
                          </small>
                        </div>

                        <div class="col-md-6">
                          <input
                            type="text"
                            class="form-control"
                            id="exampleInputFirstName"
                            placeholder="Enter Your Shop Name"
                            v-model="form.nama_toko"
                          />
                          <small class="text-danger" v-if="errors.nama_toko">
                            {{ errors.nama_toko[0] }}
                          </small>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-6">
                          <input
                            type="text"
                            class="form-control"
                            id="exampleInputFirstName"
                            placeholder="Enter Your phone Number"
                            v-model="form.no_telp"
                          />
                          <small class="text-danger" v-if="errors.no_telp">
                            {{ errors.no_telp[0] }}
                          </small>
                        </div>

                        <div class="col-md-6"></div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-6">
                          <input
                            type="file"
                            class="custom-file-input"
                            id="customFile"
                            @change="onFileSelected"
                          />

                          <small class="text-danger" v-if="errors.foto">
                            {{ errors.foto[0] }}
                          </small>
                          <label class="custom-file-label" for="customFile"
                            >Choose file</label
                          >
                        </div>

                        <div class="col-md-6">
                          <img
                            :src="form.foto"
                            style="height: 40px; width: 40px"
                          />
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

  data() {
    return {
      form: {
        nama: null,
        email: null,
        no_telp: null,
        nama_toko: null,
        alamat: null,
        foto: null,
      },
      errors: {},
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
          this.form.foto = event.target.result;
          console.log(event.target.result);
        };
        reader.readAsDataURL(file);
      }
    },
    supplierInsert() {
      axios
        .post("/api/supplier", this.form)
        .then(() => {
          this.$router.push({ name: "supplier" });
          Notification.success();
        })
        .catch((error) => (this.errors = error.response.data.errors));
    },
  },
};
</script>


<style type="text/css">
</style>
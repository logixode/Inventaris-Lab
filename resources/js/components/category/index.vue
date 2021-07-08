<template>
  <div>
    <div class="row">
      <router-link to="/store-category" class="btn btn-primary"
        >Tambah Kategori
      </router-link>
    </div>
    <br />
    <input
      type="text"
      v-model="searchTerm"
      class="form-control"
      style="width: 300px"
      placeholder="Cari sesuatu..."
    />
    <div class="alert alert-danger" role="alert" v-if="error">
      {{ error }}
    </div>

    <br />

    <div class="row">
      <div class="col-lg-12 mb-4">
        <!-- Simple Tables -->
        <div class="card">
          <div
            class="
              card-header
              py-3
              d-flex
              flex-row
              align-items-center
              justify-content-between
            "
          >
            <h6 class="m-0 font-weight-bold text-primary">Data Kategori</h6>
          </div>
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th>No.</th>
                  <th>Nama Kategori</th>
                  <th>Kategori Inti</th>
                  <th>Gambar</th>
                  <th>Keterangan</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(category, i) in filtersearch" :key="i">
                  <td>{{ i + 1 }}</td>
                  <td>{{ category.nama_kategori }}</td>
                  <td>{{ getKategoriInti(category.kategori_inti) }}</td>
                  <td>
                    <img :src="category.gambar" alt="" height="50px" />
                  </td>
                  <td>{{ category.keterangan }}</td>

                  <td>
                    <router-link
                      :to="{
                        name: 'edit-category',
                        params: { id: i },
                      }"
                      class="btn btn-sm btn-primary"
                      >Edit</router-link
                    >

                    <a @click="deleteCategory(i)" class="btn btn-sm btn-danger"
                      ><font color="#ffffff">Hapus</font></a
                    >
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="card-footer"></div>
        </div>
      </div>
    </div>
    <!--Row-->
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
      kategori: [],
      searchTerm: "",
      text_red: "red",

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
      error: "",
    };
  },
  computed: {
    filtersearch() {
      return this.kategori.filter((category) => {
        return category.nama_kategori.match(this.searchTerm);
      });
    },
  },

  methods: {
    allCategory() {
      // axios
      //   .get("/api/category/")
      //   .then(({ data }) => (this.kategori = data))
      //   .catch((error) => (this.error = error));

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
    deleteCategory(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.value) {
          // axios
          //   .delete("/api/category/" + id)
          //   .then(() => {
          //     this.kategori = this.kategori.filter((category) => {
          //       return category.id != id;
          //     });
          //   })
          //   .catch(() => {
          //     this.$router.push({ name: "category" });
          //   });

          let kategori = this.kategori.splice(id, 1);

          localStorage.setItem("kategori", JSON.stringify(kategori));

          Swal.fire("Deleted!", "Your file has been deleted.", "success");
        }
      });
    },
    getKategoriInti(val) {
      let i = this.kategori_inti.findIndex((x) => x.id === val);
      return this.kategori_inti[i].value;
    },
  },
  created() {
    this.allCategory();
  },
};
</script>

<style type="text/css">
#em_photo {
  height: 40px;
  width: 40px;
}
</style>

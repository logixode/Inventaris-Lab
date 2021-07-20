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
                  <td>{{ category.data_relation.kategori_inti }}</td>
                  <!-- <td>{{ category.id_kategori_inti }}</td> -->
                  <td>
                    <img :src="category.gambar" alt="" height="50px" />
                  </td>
                  <td>{{ category.keterangan }}</td>

                  <td>
                    <router-link
                      :to="{
                        name: 'edit-category',
                        params: { id: category.id },
                      }"
                      class="btn btn-sm btn-primary"
                      >Edit</router-link
                    >

                    <a
                      @click="deleteCategory(category.id)"
                      class="btn btn-sm btn-danger"
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
    this.allCategory();
  },
  data() {
    return {
      kategori: [],
      searchTerm: "",
      text_red: "red",

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
    async allCategory() {
      let { data } = await axios.get("/api/category/");
      this.kategori = data;
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
      }).then(async (result) => {
        if (result.value) {
          await axios.delete("/api/category/" + id);
          this.kategori = this.kategori.filter((category) => category.id != id);
          this.$router.push({ name: "category" });

          Swal.fire("Deleted!", "Your file has been deleted.", "success");
        }
      });
    },
    getKategoriInti(val) {
      let i = this.kategori_inti.findIndex((x) => x.id === val);
      return this.kategori_inti[i].value;
    },
  },
};
</script>

<style type="text/css">
#em_photo {
  height: 40px;
  width: 40px;
}
</style>

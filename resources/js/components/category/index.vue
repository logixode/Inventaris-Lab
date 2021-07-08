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
                  <th>Nama Kategori</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="category in filtersearch" :key="category.id">
                  <td>{{ category.nama_kategori }}</td>

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
  },
  data() {
    return {
      categories: [],
      searchTerm: "",
      text_red: "red",
      error: "",
    };
  },
  computed: {
    filtersearch() {
      return this.categories.filter((category) => {
        return category.nama_kategori.match(this.searchTerm);
      });
    },
  },

  methods: {
    allCategory() {
      axios
        .get("/api/category/")
        .then(({ data }) => (this.categories = data))
        .catch((error) => (this.error = error));
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
          axios
            .delete("/api/category/" + id)
            .then(() => {
              this.categories = this.categories.filter((category) => {
                return category.id != id;
              });
            })
            .catch(() => {
              this.$router.push({ name: "category" });
            });
          Swal.fire("Deleted!", "Your file has been deleted.", "success");
        }
      });
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

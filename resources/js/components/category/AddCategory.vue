<template>
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
              <small class="text-danger" v-if="errors.kategori_inti">
                {{ errors.kategori_inti[0] }}
              </small>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            @click="$emit('modalClosed', false)"
          >
            Tutup
          </button>
          <button type="button" @click="addCategory" class="btn btn-primary">
            Tambah
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["modal_add_kategori"],
  data: () => ({
    errors: {},
  }),
  methods: {
    async addCategory() {
      let error;
      let { data } = await axios
        .post("/api/kategori_inti", { kategori_inti: this.add_kategori })
        .catch((err) => {
          error = err;
          this.errors = err.response.data.errors;
        });
      if (!error) {
        this.$emit("addCategory", {
          kategori_inti: data,
          modal_add_kategori: false,
        });
      }
    },
  },
};
</script>

<style>
</style>
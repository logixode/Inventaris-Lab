<template>
  <div class="modal fade show" v-if="modal_edit_kategori" id="exampleModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Kategori Inti</h5>
        </div>
        <div class="modal-body">
          <div
            v-for="(data, i) in kategori_inti"
            :key="i"
            class="w-100 d-flex my-2 p-1 bg-gray rounded"
          >
            <div
              class="
                flex-grow-1
                pl-3
                align-self-center align-items-center
                d-flex
              "
            >
              <span>{{ i + 1 }}.&nbsp;</span>
              <span v-if="form_active != i">
                {{ data.kategori_inti }}
              </span>
              <div class="ml-2 w-100" v-else-if="form_active == i">
                <input
                  type="text"
                  class="form-control"
                  id="exampleInputFirstName"
                  placeholder="Masukkan Kategori"
                  v-model="form.kategori_inti"
                  required
                />
                <small class="text-danger" v-if="errors.kategori_inti">
                  {{ errors.kategori_inti[0] }}
                </small>
              </div>
            </div>
            <button
              class="btn btn-primary ml-3"
              v-if="form_active == i"
              @click="saveChanges(i)"
            >
              <i class="fas fa-check fa-fw"></i>
            </button>
            <div v-else>
              <button class="btn btn-warning" @click="editData(i)">
                <i class="fas fa-edit fa-fw"></i>
              </button>
              <button class="btn btn-danger ml-2" @click="deleteData(i)">
                <i class="fas fa-trash fa-fw"></i>
              </button>
            </div>
          </div>

          <small class="text-danger" v-if="delete_error">
            {{ delete_error }}
          </small>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            @click="$emit('modalClosed', false)"
          >
            Tutup
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["modal_edit_kategori", "kategori_inti"],
  data: () => ({
    form: {
      id: null,
      kategori_inti: "",
    },
    form_active: null,
    errors: {},
    delete_error: "",
  }),
  methods: {
    async editCategory(id) {
      let error;
      let { data } = await axios
        .put("/api/kategori_inti/" + id, { kategori_inti: this.add_kategori })
        .catch((err) => {
          error = err;
          this.errors = err.response.data.errors;
        });
      if (!error) {
        this.$emit("editCategory", {
          kategori_inti: data,
          modal_edit_kategori: false,
        });
      }
    },
    editData(i) {
      this.form = this.kategori_inti[i];
      this.form_active = i;
    },
    async saveChanges(i) {
      this.form_active = null;
      let error;
      let { data } = await axios
        .patch("/api/kategori_inti/" + this.kategori_inti[i].id, this.form)
        .catch((err) => {
          error = err;
          this.errors = err.response.data.errors;
        });
      if (!error) {
        this.kategori_inti[i].kategori_inti = data.kategori_inti;
        Notification.success();

        console.log(this.kategori_inti[i].id, "edited");
      }
    },
    async deleteData(i) {
      this.delete_error = "";
      let error;
      await axios
        .delete("/api/kategori_inti/" + this.kategori_inti[i].id)
        .catch((err) => {
          error = err;
          this.delete_error = err.response.data.error;
        });
      if (!error) {
        this.kategori_inti.splice(i, 1);
        Notification.success();
        console.log(this.kategori_inti[i].id, "deleted");
      }
    },
  },
};
</script>

<style>
</style>
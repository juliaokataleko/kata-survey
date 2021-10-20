<template>
  <div>
    <div class="card">
      <div
        class="
          card-header
          d-flex
          flex-direction-row
          justify-content-between
          align-items-center
        "
      >
        <h5>{{ title }}</h5>
        <router-link class="btn btn-primary" :to="{ name: 'Home' }">
          <i class="fa fa-arrow-left"></i> Voltar</router-link
        >
      </div>
      <div class="card-body">
        <div class="alert alert-success" v-if="loading">
          <i class="fas fa-circle-notch fa-spin"></i> Carregando
        </div>
        <form @submit.prevent="saveSurvey()">
          <div class="form-group">
            <label for="title">Título</label>
            <input
              type="text"
              class="form-control"
              name="title"
              id="title"
              v-model="form.title"
              placeholder="Título da Enquete"
            />
          </div>
          <div class="form-group">
            <label for="about">Descrição</label>
            <textarea
              name="about"
              id="about"
              v-model="form.about"
              class="form-control"
              placeholder="Sobre a Enquete"
            ></textarea>
          </div>

          <div class="form-group">
            <div
              class="
                d-flex d-flex
                justify-content-between
                align-items-center
                mb-2
              "
            >
              <label>Opções De Respostas</label>
              <button
                type="button"
                v-on:click="addOption()"
                class="btn-primary btn-sm"
              >
                Add
              </button>
            </div>

            <div
              class="d-flex mb-2"
              v-for="option in form.options"
              :key="option.number"
            >
              <input
                type="text"
                class="form-control form-control-sm"
                name="options[]"
                v-model="option.title"
                :placeholder="'Resposta ' + option.number"
              />
              <button
                type="button"
                v-on:click="deleteOption(option)"
                class="btn ml-2 btn-sm btn-danger"
              >
                x
              </button>
            </div>
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data: function () {
    return {
      title: "Nova enquente",
      form: {
        uuid: "",
        title: "",
        about: "",
        options: [
          {
            number: 1,
            title: "",
          },
          {
            number: 2,
            title: "",
          },
        ],
      },
      loading: false,
    };
  },
  created() {
    if (this.$route.params.id) {
      this.getSurvey();
      this.title = `Editar a enquete "${this.form.title}"`;
    }
  },
  methods: {
    addOption() {
      if (this.form.options.length < 10) {
        let number = this.form.options.length + 1;
        this.form.options.push({
          number,
          title: "",
        });
      }
    },
    saveSurvey() {
      this.loading = true;

      if (this.$route.params.id) {
        axios
          .put(`/surveys/${this.form.id}`, this.form)
          .then((res) => {
            console.log(res);
            this.loading = false;
            alert("Enquete salva.");
            this.$router.push("/");
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        axios
          .post(`/surveys`, this.form)
          .then((res) => {
            console.log(res);
            this.loading = false;
            alert("Enquete salva.");
            this.$router.push("/");
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    getSurvey() {
      axios
        .get("/surveys/" + this.$route.params.id)
        .then((res) => {
          this.form = res.data.data[0];
          this.title = `Editar a enquete "${this.form.title}"`;
          console.log(res);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    deleteOption(option) {
      if (
        option.title == "" ||
        option.title == undefined ||
        option.title == null
      ) {
        this.form.options = this.arrayRemove(this.form.options, option);

        // if has id, delete in DB
        if (typeof option.id !== "undefined") {
          axios
            .delete("/survey-options/" + option.id)
            .then((res) => {
              alrt("Opção deletada.");
              console.log(res);
            })
            .catch((error) => {
              console.log(error);
            });
        }
      } else {
        if (confirm("Tens certeza?")) {
          console.log(option);
          this.loading = true;
          this.form.options = this.arrayRemove(this.form.options, option);

          // if has id, delete in DB
          if (typeof option.id !== "undefined") {
            axios
              .delete("/survey-options/" + option.id)
              .then((res) => {
                alrt("Opção deletada.");
                console.log(res);
              })
              .catch((error) => {
                console.log(error);
              });
          }

          this.loading = false;
        }
      }
    },
    arrayRemove(arr, value) {
      return arr.filter(function (ele) {
        return ele != value;
      });
    },
  },
};
</script>
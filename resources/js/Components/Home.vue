<template>
  <div>
    <div
      class="
        d-flex
        flex-direction-row
        justify-content-between
        align-items-center
      "
    >
      <h1>{{ title }}</h1>
      <router-link class="btn btn-primary" :to="{ name: 'SurveyForm' }"
        >Nava Enquete</router-link
      >
    </div>
    <hr />
    <div class="card mb-4" v-for="survey in surveys" :key="survey.uuid">
      <div
        class="
          card-header
          d-flex
          flex-direction-row
          justify-content-between
          align-items-center
          bg-white
          text-dark
        ">
        <h4>{{ survey.title }}</h4>
        <div>
          <button
            v-on:click="deleteSurvey(survey)"
            class="btn btn-sm btn-danger"
          >
            Excluir
          </button>
          <router-link
            class="btn btn-success btn-sm"
            :to="{ name: 'SurveyFormEdit', params: { id: survey.uuid } }"
            >Editar</router-link
          >
          <button
            v-on:click="survey.open = !survey.open"
            class="btn btn-sm btn-primary"
          >
            Detalhes
          </button>
        </div>
      </div>
      <div class="card-body">
        
        <p class="text-primary">
          <a :href="linkFull + '/surveys/play/' + survey.uuid">
          {{ linkFull + '/surveys/play/' + survey.uuid }}
          </a>
        </p>
        
        <ul v-if="survey.open" class="list-group list-group list-group-flush">
          <li
            class="
              list-group-item
              d-flex
              justify-content-between
              align-items-center
            "
            v-for="option in survey.options"
            :key="option.id"
          >
            {{ option.title }}
            <span class="badge-dark badge-pill">
              ({{ option.votes }}/{{ option.total_votes }})
              {{ option.percent }}%</span
            >
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>
<script>

export default {
  data: function () {
    return {
      title: "Minhas enquetes",
      surveys: {},
      loading: false,
      linkFull: "http://localhost:8000"
    };
  },
  created() {
    this.getSurveys();
  },
  methods: {
    getSurveys() {
      axios
        .get(`/surveys`, this.form)
        .then((res) => {
          this.surveys = res.data.data;

          this.surveys.forEach(function (item, indice, array) {
            item.options.sort("percent");

            item.options.sort(compare);

            console.log(elemitement.options);
          });

        })
        .catch((error) => {
          console.log(error);
        });
    },
    compare(a, b) {
      if (a.percent < b.percent) {
        return -1;
      }
      if (a.percent > b.percent) {
        return 1;
      }
      return 0;
    },
    deleteSurvey(survey) {
      if(confirm("Tens certeza?")) {
        this.loading = true; 
        axios
        .delete(`/surveys/${survey.id}`)
        .then((res) => {
            console.log(res);
            this.loading = false;
            alert("Enquete excluída.");
            this.getSurveys();
        })
        .catch((error) => {
          console.log(error);
        });

      }
    }
  },
};
</script>